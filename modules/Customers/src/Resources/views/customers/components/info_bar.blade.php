<!-- Customer Header -->
@php
list($initial, $classes) = fn_get_name_placeholder($customer->name);
@endphp
<div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
    <div>
        <div class="flex items-center gap-4">
            <div class=" rounded-full bg-blue-100 flex items-center justify-center">
                <span class="text-blue-600 text-2xl font-medium p-3 rounded rounded-full {{$classes}}">{{$initial}}</span>
            </div>
            <div>
                <h1 class="text-2xl md:text-3xl font-bold text-gray-900">{{$customer->name}}</h1>
                <div class="flex flex-wrap items-center gap-2 mt-1">
                    <span class="px-2 py-1 rounded-full bg-green-100 text-green-800 text-xs font-medium">
                        <i class="fas fa-check-circle mr-1"></i> Active Customer
                    </span>

                </div>
            </div>
        </div>
    </div>
    <div class="flex flex-wrap gap-2">
        <button class="px-4 py-2 rounded-md bg-blue-100 text-blue-600 hover:text-blue-300 transition flex items-center gap-2 text-sm font-medium">
            <i class="fas fa-envelope"></i> Send Email
        </button>
        <button class="px-4 py-2 rounded-md bg-blue-100 text-blue-600 hover:text-blue-300 transition flex items-center gap-2 text-sm font-medium">
            <i class="fas fa-edit"></i> Edit Profile
        </button>
    </div>
</div>