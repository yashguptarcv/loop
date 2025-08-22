
        <form id="userForm" class="form-ajax" method="POST" 
              action="@isset($user) {{ route('admin.settings.users.update', $user->id) }} @else {{ route('admin.settings.users.store') }} @endisset">
            @csrf
            @isset($user) @method('PUT') @endisset

            
                <!-- Name Field -->
                <div class="mb-2">
                    <label class="custom-label required">Name</label>
                    <input type="text" name="name" id="name" 
                           value="{{ $user->name ?? old('name') }}"
                         class="input-field"  >
                </div>

                <!-- Email Field -->
                <div class="mb-2">
                    <label class="custom-label required">Email</label>
                    <input type="email" name="email" id="email" 
                           value="{{ $user->email ?? old('email') }}"
                          class="input-field"  >
                </div>

                <!-- Role Field -->
                <div class="mb-2">
                    <label class="custom-label required">Role</label>
                    <select name="role_id" id="role_id" 
                           class="input-field"  >
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
                <div class="mb-2">
                    <label class="custom-label required">
                        Password @isset($user) (Leave blank to keep current) @endisset
                    </label>
                    <input type="password" name="password" id="password"
                          class="input-field"   @empty($user)  @endempty>
                </div>

            <div class="mt-8 flex justify-end space-x-3">
                
                <x-button type="submit"  class="blue" label="Save" icon='' name='button'/> 
            </div>
        </form>
    