<!-- Customer Header -->
@php
list($initial, $classes) = fn_get_name_placeholder($customer->name);
@endphp
<div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
    <div>
        <div class="flex items-center gap-4">
            @include('customers::dashboard.common.profile-icon', ['name' => $customer->name])
        </div>
    </div>
    <div class="flex flex-wrap gap-2">
        <a href="#" class="px-4 py-2 rounded-md bg-primary-100 text-amber-100 hover:text-amber-200 transition flex items-center gap-2 text-sm font-medium">
            Lead Detail
        </a>
        <button class="px-4 py-2 rounded-md bg-primary-100 text-amber-100 hover:text-amber-200 transition flex items-center gap-2 text-sm font-medium">
            Send Email
        </button>
        <x-modal 
            buttonText='Edit Profile' 
            type='link'
            modalTitle="Edit Profile"
            id="edit_profile"
            ajaxUrl="{{route('admin.customers.edit', $customer->id)}}"
            buttonClass="px-4 py-2 rounded-md bg-primary-100 text-amber-100 hover:text-amber-200 transition flex items-center gap-2 text-sm font-medium"
            modalSize="3xl" />

                
        <!-- <a href="{{ route('admin.customers.edit', $customer->id) }}" class="px-4 py-2 rounded-md bg-blue-100 text-blue-600 hover:bg-blue-200 transition flex items-center gap-2 text-sm font-medium">
            <i class="fas fa-edit"></i> Edit Profile
        </a> -->
    </div>
</div>