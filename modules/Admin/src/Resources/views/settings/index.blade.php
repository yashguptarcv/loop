@extends('admin::layouts.app')

@section('title', 'Settings')

@section('page_title')
    Settings
@endsection

@section('content')
    <div class="flex flex-col w-full min-h-screen bg-[var(--color-bg)] p-6">
        {{-- Settings Cards Grid --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @php
                $settings = [
                    [
                        'title' => 'General Settings',
                        'description' => 'Configure store name, contact information, and basic preferences.',
                        'route' => '#',
                        'icon' => 'settings',
                        'permission' => ''
                    ],
                    [
                        'title' => 'Payment Methods',
                        'description' => 'Set up payment gateways like PayPal, Stripe, and others.',
                        'route' => '#',
                        'icon' => 'payments',
                        'permission' => ''
                    ],
                   
                    [
                        'title' => 'Taxes',
                        'description' => 'Set up tax rules and VAT settings.',
                        'route' => '#',
                        'icon' => 'receipt',
                        'permission' => ''
                    ],
                   
                    [
                        'title' => 'Logs',
                        'description' => 'View system activity logs and error reports.',
                        'route' => '#',
                        'icon' => 'list_alt',
                        'permission' => ''
                    ],
                   
                    [
                        'title' => 'Statuses',
                        'description' => 'Manage Lead / Payments / Order / Customers statuses',
                        'route' => route('admin.settings.statuses.leads.index'),
                        'icon' => 'flag',
                        'permission' => 'admin.settings.statuses.leads.index'
                    ],
                    
                    [
                        'title' => 'Currencies',
                        'description' => 'Configure accepted currencies and exchange rates.',
                        'route' => '#',
                        'icon' => 'currency_exchange',
                        'permission' => ''
                    ],
                    [
                        'title' => 'Countries',
                        'description' => 'Manage countries where you operate and ship to.',
                        'route' => '#',
                        'icon' => 'public',
                        'permission' => ''
                    ],
                    [
                        'title' => 'States',
                        'description' => 'Manage states/regions for tax and shipping calculations.',
                        'route' => '#',
                        'icon' => 'map',
                        'permission' => ''
                    ],
                    [
                        'title' => 'Roles & Permissions',
                        'description' => 'Assign roles and permissions to users.',
                        'route' => route('admin.settings.roles.index'),
                        'icon' => 'admin_panel_settings',
                        'permission' => 'admin.settings.roles.index'
                    ],
                    [
                        'title' => 'Users',
                        'description' => 'Manage onboarding and settings for new users.',
                        'route' => route('admin.settings.users.index'),
                        'icon' => 'people',
                        'permission' => 'admin.settings.users.index'
                    ],
                ];
            @endphp

            @foreach ($settings as $setting)
                @if (!isset($setting['permission']) || bouncer()->hasPermission($setting['permission']))
                    <div class="bg-[var(--color-white)] rounded-xl shadow-sm border border-[var(--color-border)] overflow-hidden transition-all hover:shadow-md hover:border-[var(--color-primary)] group">
                        <a href="{{ $setting['route'] }}" class="block h-full">
                            <div class="p-5 h-full flex flex-col">
                                <div class="flex items-center mb-4">
                                    <div class="p-3 rounded-lg bg-[var(--color-primary-100)] text-[var(--color-primary)]">
                                        <span class="material-icons-outlined">{{ $setting['icon'] }}</span>
                                    </div>
                                    <h3 class="ml-3 text-lg font-semibold text-[var(--color-text-primary)]">
                                        {{ $setting['title'] }}
                                    </h3>
                                </div>
                                <p class="text-sm text-[var(--color-text-secondary)] mb-4 flex-grow">
                                    {{ $setting['description'] }}
                                </p>
                                <div class="flex items-center text-[var(--color-primary)] group-hover:text-[var(--color-primary-dark)] transition-colors">
                                    <span class="text-sm font-medium">Configure</span>
                                    <span class="material-icons-outlined ml-1 text-base">chevron_right</span>
                                </div>
                            </div>
                        </a>
                    </div>
                @endif
            @endforeach
        </div>
    </div>
@endsection