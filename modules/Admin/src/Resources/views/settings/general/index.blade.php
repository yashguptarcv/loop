@extends('admin::layouts.app')

@section('title', 'Settings')

@section('content')
@include('admin::components.common.back-button', ['route' => route('admin.settings.index'), 'name' => 'Settings'])

    <!-- Tabs -->
    <div class="border-b border-gray-200">
        <nav class="flex -mb-px space-x-8">
            <a href="#" class="whitespace-nowrap py-4 px-2 border-b-2 border-indigo-500 font-medium text-sm text-indigo-600">General</a>
            <a href="#" class="whitespace-nowrap py-4 px-2 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300">Company</a>
            <a href="#" class="whitespace-nowrap py-4 px-2 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300">Email</a>
            <a href="#" class="whitespace-nowrap py-4 px-2 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300">Security</a>
            <a href="#" class="whitespace-nowrap py-4 px-2 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300">API</a>
        </nav>
    </div>

    <!-- Configuration Form -->
    <div class="mt-8 bg-white shadow rounded-lg overflow-hidden">
        
        <div class="px-6 py-6">
            <div class="space-y-6">
                <!-- Timezone -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="md:col-span-1">
                        <label for="timezone" class="block text-sm font-medium text-gray-700">Default Timezone</label>
                        <p class="mt-1 text-sm text-gray-500">Set the default timezone for your organization.</p>
                    </div>
                    <div class="md:col-span-2">
                        <select id="timezone" name="timezone" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                            <option>(UTC-12:00) International Date Line West</option>
                            <option selected>(UTC-05:00) Eastern Time (US & Canada)</option>
                            <option>(UTC-04:00) Atlantic Time (Canada)</option>
                            <option>(UTC+00:00) Greenwich Mean Time</option>
                        </select>
                    </div>
                </div>

                <!-- Date Format -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 pt-6 border-t border-gray-200">
                    <div class="md:col-span-1">
                        <label class="block text-sm font-medium text-gray-700">Date Format</label>
                        <p class="mt-1 text-sm text-gray-500">How dates should be displayed throughout the system.</p>
                    </div>
                    <div class="md:col-span-2">
                        <div class="flex space-x-4">
                            <div class="flex items-center">
                                <input id="date-format-1" name="date-format" type="radio" checked class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300">
                                <label for="date-format-1" class="ml-3 block text-sm font-medium text-gray-700">MM/DD/YYYY</label>
                            </div>
                            <div class="flex items-center">
                                <input id="date-format-2" name="date-format" type="radio" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300">
                                <label for="date-format-2" class="ml-3 block text-sm font-medium text-gray-700">DD/MM/YYYY</label>
                            </div>
                            <div class="flex items-center">
                                <input id="date-format-3" name="date-format" type="radio" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300">
                                <label for="date-format-3" class="ml-3 block text-sm font-medium text-gray-700">YYYY-MM-DD</label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Default Currency -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 pt-6 border-t border-gray-200">
                    <div class="md:col-span-1">
                        <label for="currency" class="block text-sm font-medium text-gray-700">Default Currency</label>
                        <p class="mt-1 text-sm text-gray-500">Set the default currency for financial values.</p>
                    </div>
                    <div class="md:col-span-2">
                        <select id="currency" name="currency" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                            <option>USD - US Dollar</option>
                            <option selected>EUR - Euro</option>
                            <option>GBP - British Pound</option>
                            <option>JPY - Japanese Yen</option>
                        </select>
                    </div>
                </div>

                <!-- System Notifications -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 pt-6 border-t border-gray-200">
                    <div class="md:col-span-1">
                        <label class="block text-sm font-medium text-gray-700">System Notifications</label>
                        <p class="mt-1 text-sm text-gray-500">Configure which system notifications are enabled.</p>
                    </div>
                    <div class="md:col-span-2">
                        <div class="space-y-4">
                            <div class="flex items-start">
                                <div class="flex items-center h-5">
                                    <input id="new-lead" name="new-lead" type="checkbox" checked class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded">
                                </div>
                                <div class="ml-3 text-sm">
                                    <label for="new-lead" class="font-medium text-gray-700">New lead notifications</label>
                                    <p class="text-gray-500">Receive alerts when new leads are created.</p>
                                </div>
                            </div>
                            <div class="flex items-start">
                                <div class="flex items-center h-5">
                                    <input id="task-reminders" name="task-reminders" type="checkbox" checked class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded">
                                </div>
                                <div class="ml-3 text-sm">
                                    <label for="task-reminders" class="font-medium text-gray-700">Task reminders</label>
                                    <p class="text-gray-500">Get reminders for upcoming tasks.</p>
                                </div>
                            </div>
                            <div class="flex items-start">
                                <div class="flex items-center h-5">
                                    <input id="system-updates" name="system-updates" type="checkbox" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded">
                                </div>
                                <div class="ml-3 text-sm">
                                    <label for="system-updates" class="font-medium text-gray-700">System updates</label>
                                    <p class="text-gray-500">Receive notifications about system maintenance and updates.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Data Retention -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 pt-6 border-t border-gray-200">
                    <div class="md:col-span-1">
                        <label for="data-retention" class="block text-sm font-medium text-gray-700">Data Retention Period</label>
                        <p class="mt-1 text-sm text-gray-500">How long should inactive records be kept?</p>
                    </div>
                    <div class="md:col-span-2">
                        <div class="flex items-center">
                            <input type="number" id="data-retention" name="data-retention" value="365" class="block w-24 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            <span class="ml-3 text-sm text-gray-700">days</span>
                        </div>
                        <p class="mt-2 text-sm text-gray-500">Records marked as inactive will be automatically archived after this period.</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex justify-end">
            
            <x-button type="submit"                     
                class="blue" 
                label="Save" 
                icon=''
                name="button" 
            />
        </div>
    </div>



@endsection
</script>