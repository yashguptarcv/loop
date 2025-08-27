<form action="{{ route('admin.payments.store') }}" method="POST">
    @csrf

    <input type="radio" name="tab" id="tab-general" class="hidden" checked>
    <input type="radio" name="tab" id="tab-config" class="hidden">

    <!-- Tab buttons (labels toggle the radios) -->
    <div class="border-b border-gray-200 mb-4">
        <div class="flex space-x-6">
            <label for="tab-general" class="cursor-pointer pb-2 px-1 border-b-2 font-medium text-sm text-gray-500 hover:text-gray-700">
                General
            </label>

            <label for="tab-config" class="cursor-pointer pb-2 px-1 border-b-2 font-medium text-sm text-gray-500 hover:text-gray-700">
                Configuration
            </label>
        </div>
    </div>

    <!-- Tab contents wrapper -->
    <div class="tab-contents">
        <!-- General content (hidden by default; shown when #tab-general is checked) -->
        <div class="tab-general space-y-4 p-1">
            <div>
                <label class="block text-sm font-medium text-gray-700">Name</label>
                <input type="text" name="name" value="{{ old('name') }}"
                       class="mt-1 block w-full border border-gray-300 rounded-lg p-2">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Processor</label>
                <select name="processor" class="mt-1 block w-full border border-gray-300 rounded-lg p-2">
                    <option value="">-- Select Processor --</option>
                    @foreach($processors as $processor)
                        <option value="{{ $processor->code }}" {{ old('processor') == $processor->code ? 'selected' : '' }}>
                            {{ $processor->name }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <!-- Configuration content (hidden by default; shown when #tab-config is checked) -->
        <div class="tab-config space-y-4 p-1"></div>
    </div>

    <div class="mt-6">
        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg">Save Payment</button>
    </div>
</form>
<!-- Small CSS controlling which .tab-* is visible -->
<style>
  /* default hide both (in case of Tailwind interference) */
  .tab-contents .tab-general,
  .tab-contents .tab-config { display: none; }

  /* show General when its radio is checked */
  #tab-general:checked ~ .tab-contents .tab-general { display: block; }

  /* show Config when its radio is checked */
  #tab-config:checked  ~ .tab-contents .tab-config  { display: block; }
</style>
