<?php

namespace Modules\Customers\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use Modules\Orders\Models\Order;
use Illuminate\Routing\Controller;
use Modules\Leads\Models\LeadModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Modules\Customers\Models\User;
use Modules\Leads\Models\Application;
use Modules\Orders\Models\Transaction;
use Modules\Orders\Enums\OrderStatus;

class HomeController extends Controller
{

    public function dashboard()
    {
        $user = Auth::guard('customer')->user();
        
        // Get total applications 
        $totalApplications = Application::where('email', $user->email)->count();
        
        // Get approved orders
        $approvedOrders = Order::where('user_id', $user->id)
            ->whereIn('status', [OrderStatus::COMPLETED->value])
            ->count();
            
        // Get in reviews  
        $inReviewApplications = Application::where('email', $user->email)
            ->whereDoesntHave('orders', function($query) {
                $query->whereIn('payment_status', ['paid', 'completed']);
            })
            ->count();
            
        // Get rejected orders 
        $rejectedOrders = Order::where('user_id', $user->id)
            ->whereIn('status', [OrderStatus::CANCELLED->value, OrderStatus::FAILED->value])
            ->count();
            
        // Get recent applications with order items and products
        $recentApplications = Application::with(['order.items.product'])
            ->where('email', $user->email)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get()
            ->each(function($application) {
                $application->product_names = $application->order?->items
                    ->pluck('product_name')
                    ->filter()
                    ->implode(', ') ?? '';
            });
            
         
        $latestApplication = Application::with(['order.items.product'])
            ->where('email', $user->email)
            ->orderBy('created_at', 'desc')
            ->first();
            
        if ($latestApplication) {
            $latestApplication->product_names = $latestApplication->order?->items
                ->pluck('product_name')
                ->filter()
                ->implode(', ') ?? '';
        }
            
        // Calculate progress 
        $progressPercentage = 0;
        $progressSteps = [];
        
        if ($latestApplication && $latestApplication->order) {
            $latestOrder = $latestApplication->order;
            $hasPayment = in_array($latestOrder->status, [
                    OrderStatus::PENDING->value,
                    OrderStatus::PROCESSING->value,
                    OrderStatus::COMPLETED->value
                ]) && 
                in_array($latestOrder->payment_status, ['paid', 'completed']);
    
            $progressSteps = [
                [
                    'name' => 'Application Submitted',
                    'status' => true,
                    'date' => $latestApplication->created_at->format('F j, Y'),
                    'icon' => 'check',
                    'completed' => true,
                    'percentage' => 50
                ],
                [
                    'name' => 'Payment Received',
                    'status' => $hasPayment,
                    'date' => $latestOrder ? $latestOrder->updated_at->format('F j, Y') : 'Pending',
                    'icon' => $hasPayment ? 'check' : 'clock',
                    'completed' => $hasPayment,
                    'percentage' => 100,
                    'isFinal' => true
                ]
            ];
            
            // Calculate progress percentage (0% initially, 50% after application, 100% after payment)
            $progressPercentage = $hasPayment ? 100 : ($latestApplication ? 50 : 0);
        }
        
        return view("customers::dashboard.dashboard", [
            'user' => $user,
            'totalApplications' => $totalApplications,
            'approvedOrders' => $approvedOrders,
            'inReviewApplications' => $inReviewApplications,
            'rejectedOrders' => $rejectedOrders,
            'recentApplications' => $recentApplications,
            'latestApplication' => $latestApplication,
            'progressPercentage' => $progressPercentage,
            'progressSteps' => $progressSteps
        ]);
    }

    public function applicationCustomer(Request $request)
    {    
        // Get applications for the customer 
        $query = Application::with(['order.items'])
            ->where('email', Auth::guard('customer')->user()->email);
            
        // Apply filters
        if ($request->has('status')) {
            $status = $request->input('status');
            if ($status === 'pending') {
                $query->whereNull('order_id')
                    ->orWhereHas('order', function($q) {
                        $q->whereNotIn('status', ['approved', 'completed', 'rejected', 'cancelled', 'declined']);
                    });
            } elseif ($status === 'in_review') {
                $query->whereHas('order', function($q) {
                    $q->where('status', 'review');
                });
            } elseif ($status === 'approved') {
                $query->whereHas('order', function($q) {
                    $q->whereIn('status', ['approved', 'completed']);
                });
            } elseif ($status === 'rejected') {
                $query->whereHas('order', function($q) {
                    $q->whereIn('status', ['rejected', 'cancelled', 'declined']);
                });
            }
        }
        
        $applications = $query->orderBy('created_at', 'desc')
            ->with(['order.items'])
            ->get()
            ->each(function($application) {
                // Add product names to each application
                $application->product_names = $application->order?->items
                    ->pluck('product_name')
                    ->filter()
                    ->unique()
                    ->implode(', ') ?? '';
            $order = $application->order;
            $nextStep = 'Application Submitted';
            
            // Progress steps with proper payment status check
            $progressSteps = [
                [
                    'name' => 'Application Submitted',
                    'completed' => true,
                    'percentage' => 50
                ],
                [
                    'name' => 'Payment Pending',
                    'completed' => (bool)$order && in_array($order->payment_status, ['pending', 'processing', 'paid', 'completed']),
                    'percentage' => 66
                ],
                [
                    'name' => 'Payment Completed',
                    'completed' => (bool)$order && in_array($order->payment_status, ['paid', 'completed']),
                    'percentage' => 100
                ]
            ];
            
            // Calculate overall progress percentage based on completed steps
            $completedSteps = array_filter($progressSteps, function($step) {
                return $step['completed'];
            });
            
            $application->progress = $completedSteps ? 
                end($completedSteps)['percentage'] : 0;
            
            // Set next step based on current status (simplified for two-step process)
            $nextStep = 'Payment Pending';
            if ($order) {
                if (in_array($order->status, [OrderStatus::COMPLETED->value, OrderStatus::CANCELLED->value, OrderStatus::FAILED->value])) {
                    $nextStep = 'Completed';
                } elseif (in_array($order->status, [OrderStatus::PENDING->value, OrderStatus::PROCESSING->value]) && 
                         in_array($order->payment_status, ['paid', 'completed'])) {
                    $nextStep = 'Payment Completed';
                }
            }   
            $application->nextStep = $nextStep;
        });

        return view("customers::dashboard.application", compact('applications'));
    }

    public function detail(Request $request, $id) {
        $application = Application::with([
            'order.items',
            'order' => function($query) {
                $query->withCount('items')
                      ->with(['items' => function($q) {
                          $q->select('id', 'order_id', 'product_name', 'product_id');
                      }]);
            }
        ])
            ->where('id', $id)
            ->where('email', Auth::guard('customer')->user()->email)
            ->firstOrFail();
            
        // payment status 
        $paymentStatus = $application->order ? $application->order->payment_status : 'pending';
        
        // application status based on order status
        $status = 'pending';
        $statusClass = 'bg-blue-100 text-blue-800 dark:bg-blue-900/20 dark:text-blue-400';
        
        if ($application->order) {
            if ($application->order->status === 'completed') {
                $status = 'approved';
                $statusClass = 'bg-green-100 text-green-800 dark:bg-green-900/20 dark:text-green-400';
            } elseif (in_array($application->order->status, ['cancelled', 'failed'])) {
                $status = 'rejected';
                $statusClass = 'bg-red-100 text-red-800 dark:bg-red-900/20 dark:text-red-400';
            } elseif ($application->order->status === 'processing') {
                $status = 'in_review';
                $statusClass = 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/20 dark:text-yellow-400';
            }
        }
        
        // Prepare timeline data
        $timeline = [
            [
                'title' => 'Application Submitted',
                'date' => $application->created_at->format('F j, Y'),
                'completed' => true
            ],
            [
                'title' => 'Payment Received',
                'date' => $application->order && $application->order->paid_at 
                    ? $application->order->paid_at->format('F j, Y')
                    : 'Pending',
                'completed' => $paymentStatus === 'paid'
            ],
            [
                'title' => 'Initial Screening',
                'date' => $application->created_at->addDays(7)->format('F j, Y'),
                'completed' => $status !== 'pending'
            ],
            [
                'title' => 'Expert Review',
                'date' => 'In progress',
                'completed' => $status === 'in_review' || $status === 'approved',
                'current' => $status === 'in_review'
            ],
            [
                'title' => 'Final Decision',
                'date' => 'Pending',
                'completed' => $status === 'approved' || $status === 'rejected',
                'current' => $status === 'approved' || $status === 'rejected'
            ]
        ];
        
        return view('customers::dashboard.application_detail', compact('application', 'status', 'statusClass', 'timeline', 'paymentStatus'));
    }

    public function transactions() {
        $userId = auth('customer')->id();
        $transactions = Transaction::with(['order', 'payment'])
            ->whereHas('order', function($query) use ($userId) {
                $query->where('user_id', $userId);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('customers::dashboard.transactions', compact('transactions'));
    }

    public function profile() {
        $user = Auth::guard('customer')->user();
        return view("customers::dashboard.profile", compact('user'));
    }

    public function showTransaction($id) {
        $transaction = Transaction::with(['order', 'payment'])
            ->where('id', $id)
            ->whereHas('order', function($query) {
                $query->where('user_id', auth('customer')->id());
            })
            ->firstOrFail();
            
        return view('customers::dashboard.transaction-detail', compact('transaction'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::guard('customer')->user();
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $userData = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
        ];

        if ($request->filled('password')) {
            $userData['password'] = Hash::make($request->password);
        }

        // Use the User model to update the record
        $user = User::where('id', $user->id)->update($userData);

        return redirect()->route('customer.profile')
            ->with('success', 'Profile updated successfully');
    }
} 