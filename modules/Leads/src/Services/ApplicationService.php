<?php

namespace Modules\Leads\Services;

use App\Models\User;
use Exception;
use Illuminate\Support\Str;
use Modules\Leads\Models\Application;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Modules\Leads\Mail\ApplicationCreated;
use Modules\Leads\Models\LeadModel;

class ApplicationService
{
    public function createApplication(array $data, $leadId, $adminId)
    {
        try {
            $password = Str::random(12); // Generate random password
            
            // Check if user exists with this email
            $user = User::where('email', $data['email'])->first();

            if (!$user) {
                // Create new user
                
                $user = User::create([
                    'name' => $data['full_name'],
                    'email' => $data['email'],
                    'password' => Hash::make($password),
                    'phone' => $data['mobile'],
                ]);
                
                LeadModel::find($leadId)->notes()->create([
                    'admin_id'  => auth('admin')->id(),
                    'note'      => "Customer created Email: ". $user->email . ", Password: ". $password,
                    'created'   => now()
                ]);
            }

            // Create the application
            $application = Application::create([
                'full_name' => $data['full_name'],
                'mobile' => $data['mobile'],
                'email' => $data['email'],
                'alternate_contact' => $data['alternate_contact'] ?? null,
                'organization' => $data['organization'],
                'designation' => $data['designation'],
                'billing_address' => $data['billing_address'],
                'lead_id'  => $leadId,
                // 'user_id'  => $user->id,
                'admin_id' => $adminId,
            ]);

            // Attach award categories if needed
            if (isset($data['award_categories'])) {
                $application->awardCategories()->sync($data['award_categories']);
            }

            LeadModel::find($leadId)->notes()->create([
                'admin_id'  => auth('admin')->id(),
                'note'      => "Application sended to customer Email",
                'created'   => now()
            ]);

            return ['success' => true, 'data' =>  $application, 'user' => $user, 'password' => $password];
        } catch(Exception $e) {
            return ['success' => false, 'response' => $e->getMessage()];
        }
    }
}