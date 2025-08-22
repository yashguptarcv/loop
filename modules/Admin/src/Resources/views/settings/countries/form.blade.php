
        <form id="userForm" class="form-ajax" method="POST" 
              action="@isset($country) {{ route('admin.settings.countries.update', $country->id) }} @else {{ route('admin.settings.countries.store') }} @endisset">
            @csrf
            @isset($country) @method('PUT') @endisset

            <div class="">
                <!-- Code Field -->
                <div class="mb-2">
                    <label class="custom-label required">Code</label>
                    <input type="text" name="code" id="code" 
                           value="{{ $country->code ?? old('code') }}"
                         class="input-field"  >
                </div>
                <!-- Country Name Field  -->
                <div class="mb-2">
                    <label class="custom-label required">Country</label>
                    <input type="text" name="name" id="name" 
                           value="{{ $country->name ?? old('name') }}"
                         class="input-field"  >
                </div>
              
            </div>

            <div class="mt-8 flex justify-end space-x-3">
                <x-button type="submit"  class="blue" label="Save" icon='' name='button'/> 
            </div>
        </form>
 