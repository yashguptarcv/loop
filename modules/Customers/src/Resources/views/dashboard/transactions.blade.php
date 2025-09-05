@extends('customers::dashboard.layouts.app')

@section('title', 'Transactions')

@section('content')



<!-- Payments Page -->
<div>
    <div class="md:flex md:items-center md:justify-between mb-6">
        @include('customers::dashboard.common.info', ['title' => 'Transactions', 'text' => 'View your payment transactions and invoices'])
    </div>

    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
        <div class="px-4 py-5 sm:px-6 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white">Transaction History</h3>
            <p class="mt-1 max-w-2xl text-sm text-gray-500 dark:text-gray-400">All your payment transactions and order history.</p>
        </div>
        <div class="px-4 py-5 sm:p-6">
            <div class="flex flex-col">
                <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                        @if($transactions->isEmpty())
                        <div class="text-center py-4 text-gray-500 dark:text-gray-400">
                            No transactions found.
                        </div>
                        @else
                        <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg dark:border-gray-700">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead class="bg-gray-50 dark:bg-slate-700">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-300">Date</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-300">Order #</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-300">Transaction #</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-300">Amount</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-300">Type</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-300">Status</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200 dark:divide-gray-700">
                                    @foreach($transactions as $transaction)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                            {{ $transaction->created_at->format('M d, Y') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-blue-400">
                                            @if($transaction->order)
                                            {{ $transaction->order->order_number ?? 'N/A' }}
                                            @else
                                            N/A
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-blue-600  dark:text-gray-400">
                                            <a href="{{ route('customer.transactions.show', $transaction->id) }}" class="hover:underline">
                                                {{ $transaction->transaction_number }}
                                            </a>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                            {{ $transaction->currency }} {{ number_format($transaction->amount, 2) }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                            {{ ucfirst($transaction->type) }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @php
                                            $statusClasses = [
                                            'completed' => 'bg-green-100 text-green-800 dark:bg-green-900/20 dark:text-green-400',
                                            'pending' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/20 dark:text-yellow-400',
                                            'failed' => 'bg-red-100 text-red-800 dark:bg-red-900/20 dark:text-red-400',
                                            'reversed' => 'bg-blue-100 text-blue-800 dark:bg-blue-900/20 dark:text-blue-400',
                                            'default' => 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300'
                                            ];
                                            $status = strtolower($transaction->status);
                                            $statusClass = $statusClasses[$status] ?? $statusClasses['default'];
                                            @endphp
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusClass }}">
                                                {{ ucfirst($status) }}
                                            </span>
                                        </td>
                                        <!-- <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            @php
                                            $actions = [
                                            [
                                            'title' => 'View Details',
                                            'label' => 'View Details',
                                            'icon' => 'visibility',
                                            'url' => route('customer.transactions.show', $transaction->id),
                                            'method' => 'GET'
                                            ]
                                            ];
                                            @endphp

                                            @include('dataview::components.dataView.components.actions-dropdown', [
                                            'actions' => $actions,
                                            'id' => $transaction->id
                                            ])

                                        </td> -->
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        @if($transactions->hasPages())
                        <div class="mt-4">
                            {{ $transactions->links() }}
                        </div>
                        @endif
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection