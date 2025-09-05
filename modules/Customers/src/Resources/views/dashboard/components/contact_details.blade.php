<!-- Contact Details  -->
<div class="lg:col-span-1">
    <div class="bg-gray-50 rounded-lg p-4">
        <div class="flex items-center mb-4">
            <img class="h-20 w-20 rounded-lg object-cover bg-black" src="" alt="image">
            <div class="ml-4">
                <h3 class="text-lg font-semibold text-gray-900">{{ $lead->name ?? 'No Name specified' }}</h3>
                <p class="text-sm text-gray-500">Product Manager</p>
            </div>
        </div>

        <h4 class="text-sm font-semibold text-gray-900 mb-3 flex items-center">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
            </svg>
            Contact Details
        </h4>

        <div class="grid grid-cols-1 lg:grid-cols-2 space-y-3 text-sm">
            <div>
                <span class="text-gray-500">Workplace</span>
                <p class="text-gray-900">{{ $lead->company ?? 'No company specified' }}</p>
            </div>
            <div>
                <span class="text-gray-500">Email</span>
                <p class="text-blue-600">{{ $lead->email ?? 'No email specified' }}</p>
            </div>
            <div>
                <span class="text-gray-500">Request Date</span>
                <p class="text-gray-900">{{ $lead->created_at ?? 'No date specified' }}</p>
            </div>
            <div>
                <span class="text-gray-500">Contact ID</span>
                <p class="text-gray-900">{{ $lead->phone ?? 'No phone specified' }}</p>
            </div>
            <div>
                <span class="text-gray-500">Phone</span>
                <p class="text-gray-900">{{ $lead->phone ?? 'No phone specified' }}</p>
            </div>
            
        </div>

        <!-- <div class="flex items-center space-x-2 mt-6">
            <button class="p-2 bg-gray-100 rounded-lg hover:bg-gray-200">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                </svg>
            </button>
            <button class="p-2 bg-gray-100 rounded-lg hover:bg-gray-200">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                </svg>
            </button>
            <button class="p-2 bg-gray-100 rounded-lg hover:bg-gray-200">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                </svg>
            </button>
        </div> -->
    </div>
</div>