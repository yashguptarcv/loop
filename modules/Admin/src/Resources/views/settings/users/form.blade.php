@extends('admin::layouts.app')

@section('title', 'Users Management')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-[var(--color-text-primary)]">
            @isset($user) Edit User @else Create User @endisset
        </h1>
        <x-back :route="route('admin.settings.users.index')" title="Back to Users"/>    
    </div>

    <div class="bg-[var(--color-white)] rounded-xl shadow-sm border border-[var(--color-border)] p-6">
        <form id="userForm" class="form-ajax" method="POST" 
              action="@isset($user) {{ route('admin.settings.users.update', $user->id) }} @else {{ route('admin.settings.users.store') }} @endisset">
            @csrf
            @isset($user) @method('PUT') @endisset

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Name Field -->
                <div class="col-span-1">
                    <label class="custom-label">Name</label>
                    <input type="text" name="name" id="name" 
                           value="{{ $user->name ?? old('name') }}"
                         class="input-field"  required>
                </div>

                <!-- Email Field -->
                <div class="col-span-1">
                    <label class="custom-label">Email</label>
                    <input type="email" name="email" id="email" 
                           value="{{ $user->email ?? old('email') }}"
                          class="input-field"  required>
                </div>

                <!-- Role Field -->
                <div class="col-span-1">
                    <label class="custom-label">Role</label>
                    <select name="role_id" id="role_id" 
                           class="input-field"  required>
                        @foreach($roles as $role)
                            <option value="{{ $role->id }}" 
                                @isset($user) @if($user->role_id == $role->id) selected @endif @endisset
                                @if(old('role_id') == $role->id) selected @endif>
                                {{ $role->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Password Field -->
                <div class="col-span-1">
                    <label class="custom-label">
                        Password @isset($user) (Leave blank to keep current) @endisset
                    </label>
                    <input type="password" name="password" id="password"
                          class="input-field"   @empty($user) required @endempty>
                </div>
            </div>

            <div class="mt-8 flex justify-end space-x-3">
                <a href="{{ route('admin.settings.users.index') }}" 
                   class="btn btn-secondary px-4 py-2">
                   Cancel
                </a>
                <button type="submit" name="button"
                        class="btn btn-primary px-4 py-2">
                    @isset($user) Update User @else Create User @endisset
                </button>
            </div>
        </form>
    </div>
</div>
@endsection