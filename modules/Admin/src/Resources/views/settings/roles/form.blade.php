@extends('admin::layouts.app')

@section('title', isset($role) ? 'Edit Role' : 'Create Role')

@section('content')

    @include('admin::components.common.back-button', ['route' => route('admin.settings.roles.index'), 'name' => isset($role) ? 'Edit Role' : 'Create Role'])

    <form id="role-form" method="POST"
        action="{{ isset($role) ? route('admin.settings.roles.update', $role->id) : route('admin.settings.roles.store') }}"
        class="form-ajax ml-auto flex flex-col lg:flex-row gap-6">
        @csrf
        @if(isset($role))
        @method('PUT')
        @endif

        <input type="hidden" name="id" id="role_id" value="{{ $role->id ?? '' }}">
        
            {{-- Left Column: Permissions --}}
            <div class="flex-1">
                <div class="mb-4 flex justify-between items-center">
                    <h3 class="text-lg font-semibold text-gray-800">Permissions</h3>
                    <label class="inline-flex items-center cursor-pointer">
                        <input type="checkbox" id="select-all"
                            class="form-checkbox h-5 w-5 text-primary rounded focus:ring-primary">
                        <span class="ml-2 text-sm font-medium text-gray-700">Select All</span>
                    </label>
                </div>
                <div id="permissions-tree" class="space-y-4">
                    @php $permissions = config('acl::acl'); @endphp
                    @foreach ($permissions as $topGroup => $subGroups)
                    <div class="border border-gray-200 rounded-lg p-4 bg-gray-50">
                        <h3 class="text-base font-bold mb-3 capitalize text-gray-800">{{ ucfirst($topGroup) }}</h3>
                        @foreach ($subGroups as $section => $items)
                        @if (is_array($items))
                        <div class="mb-4">
                            <label class="flex items-center space-x-2 mb-2">
                                <input type="checkbox"
                                    class="section-toggle form-checkbox h-5 w-5 text-primary rounded focus:ring-primary"
                                    data-section="{{ $topGroup }}-{{ $section }}">
                                <span class="text-sm font-semibold text-gray-700 capitalize">{{ ucfirst($section) }}</span>
                            </label>
                            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-3 ml-6">
                                @foreach ($items as $actionGroup => $actionItems)
                                @if (is_array($actionItems))
                                @foreach ($actionItems as $permissionKey => $label)

                                
                                <label class="flex items-center space-x-2">
                                    <input type="checkbox" name="permissions[]" value="{{ $permissionKey }}"
                                        class="permission-checkbox section-{{ $topGroup }}-{{ $section }} form-checkbox h-4 w-4 text-primary rounded focus:ring-primary"
                                        {{ isset($role) && ($role->permission_type === 'all' || in_array($permissionKey, $role->permissions ?? [])) ? 'checked' : '' }}>
                                    <span class="text-sm text-gray-600">{{ $label }}</span>
                                </label>
                                @endforeach
                                @else
                                <label class="flex items-center space-x-2">
                                    <input type="checkbox" name="permissions[]" value="{{ $actionGroup }}"
                                        class="permission-checkbox section-{{ $topGroup }}-{{ $section }} form-checkbox h-4 w-4 text-primary rounded focus:ring-primary"
                                        {{ isset($role) && ($role->permission_type === 'all' || in_array($actionGroup, $role->permissions ?? [])) ? 'checked' : '' }}>
                                    <span class="text-sm text-gray-600">{{ $actionItems }}</span>
                                </label>
                                @endif
                                @endforeach
                            </div>
                        </div>
                        @else
                        <div class="mb-4">
                            <label class="flex items-center space-x-2">
                                <input type="checkbox" name="permissions[]" value="{{ $section }}"
                                    class="form-checkbox h-4 w-4 text-primary rounded focus:ring-primary"
                                    {{ isset($role) && ($role->permission_type === 'all' || in_array($section, $role->permissions ?? [])) ? 'checked' : '' }}>
                                <span class="text-sm text-gray-600">{{ $items }}</span>
                            </label>
                        </div>
                        @endif
                        @endforeach
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- Right Column: Role Details --}}
            <div class="lg:sticky lg:top-6 lg:h-[calc(100vh-3rem)] lg:overflow-y-auto scroll-smooth">
                <div class="bg-white rounded-lg p-6">
                    <div class="mb-4">
                        <label class="custom-label required">Role Name</label>
                        <input type="text" name="name" id="name" class="input-field" required value="{{ $role->name ?? '' }}"
                            placeholder="Enter role name">
                    </div>

                    <div class="mb-4">
                        <label class="custom-label">Description</label>
                        <input type="text" name="description" id="description" class="input-field"
                            value="{{ $role->description ?? '' }}" placeholder="Enter role description">
                    </div>

                    <div class="mb-4">
                        <label class="custom-label">Permission Type</label>
                        <select name="permission_type" id="permission_type" class="input-field">
                            <option value="all" {{ isset($role) && $role->permission_type === 'all' ? 'selected' : '' }}>All
                                Permissions</option>
                            <option value="custom" {{ isset($role) && $role->permission_type === 'custom' ? 'selected' : '' }}>
                                Custom Permissions</option>
                        </select>
                    </div>

                    <div class="mt-6">

                        <x-button type="submit"  class="blue" label="Save Role" icon='' name='button'/>
                    </div>
                </div>
            </div>
        
    </form>

@endsection

@section('scripts')
<script>
    const routes = {
        update: id => @json(route('admin.settings.roles.update', ['role' => 'ROLE_ID'])).replace('ROLE_ID', id),
        store: @json(route('admin.settings.roles.store')),
    };

    document.addEventListener('DOMContentLoaded', () => {
        const form = document.getElementById('role-form');
        const selectAll = document.getElementById('select-all');
        const permissionTypeSelect = document.getElementById('permission_type');
        const roleId = document.getElementById('role_id').value;

        // Select All logic
        selectAll.addEventListener('change', function() {
            const isChecked = this.checked;
            document.querySelectorAll('.permission-checkbox').forEach(cb => cb.checked = isChecked);
            document.querySelectorAll('.section-toggle').forEach(toggle => toggle.checked = isChecked);
            permissionTypeSelect.value = isChecked ? 'all' : 'custom';
        });

        // Section toggles
        document.querySelectorAll('.section-toggle').forEach(toggle => {
            toggle.addEventListener('change', function() {
                const sectionClass = `.section-${this.dataset.section}`;
                document.querySelectorAll(sectionClass).forEach(cb => cb.checked = this.checked);
                updateStates();
            });
        });

        // Individual checkbox changes
        document.querySelectorAll('.permission-checkbox').forEach(cb => {
            cb.addEventListener('change', () => {
                updateStates();
            });
        });

        // Update all toggle/permission type states
        function updateStates() {
            updateSectionToggles();
            updateSelectAllState();
            updatePermissionType();
        }

        function updateSectionToggles() {
            document.querySelectorAll('.section-toggle').forEach(toggle => {
                const sectionClass = `.section-${toggle.dataset.section}`;
                const checkboxes = document.querySelectorAll(sectionClass);
                const all = Array.from(checkboxes).every(cb => cb.checked);
                const some = Array.from(checkboxes).some(cb => cb.checked);
                toggle.checked = all;
                toggle.indeterminate = some && !all;
            });
        }

        function updateSelectAllState() {
            const allCheckboxes = document.querySelectorAll('.permission-checkbox');
            const allChecked = Array.from(allCheckboxes).every(cb => cb.checked);
            const someChecked = Array.from(allCheckboxes).some(cb => cb.checked);
            selectAll.checked = allChecked;
            selectAll.indeterminate = someChecked && !allChecked;
        }

        function updatePermissionType() {
            const allCheckboxes = document.querySelectorAll('.permission-checkbox');
            const allChecked = Array.from(allCheckboxes).every(cb => cb.checked);
            permissionTypeSelect.value = allChecked ? 'all' : 'custom';
        }

        // On load
        updateStates();

    });
</script>
@endsection