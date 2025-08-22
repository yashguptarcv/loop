<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Left Column (2/3 width) -->
    <div class="lg:col-span-2 space-y-6">
        <!-- Basic Information -->
        <div class="bg-white rounded-lg shadow p-6 space-y-4">
            <h3 class="text-lg font-medium text-gray-900">Basic Information</h3>

            <div>
                <label class="custom-label">Name <span class="text-red-500">*</span></label>
                <input type="text" name="name" value="{{ old('name', $discount->name ?? '') }}"
                    class="input-field" required>
            </div>

            <div>
                <label class="custom-label">Description</label>
                <textarea name="description" editor="true" rows="3" class="input-field">{{ old('description', $discount->description ?? '') }}</textarea>
            </div>
        </div>

        <!-- Discount Configuration -->
        <div class="bg-white rounded-lg shadow p-6 space-y-4">
            <h3 class="text-lg font-medium text-gray-900">Discount Configuration</h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="custom-label">Discount Type</label>
                    <select name="type" id="discount-type" class="input-field" required>
                        @foreach(\Modules\Discounts\Enums\DiscountType::cases() as $type)
                        <option value="{{ $type->value }}" @selected(old('type', $discount->type ?? '') == $type->value)>
                            {{ $type->label() }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="custom-label">Apply To</label>
                    <select name="apply_to" class="input-field" required>
                        @foreach(\Modules\Discounts\Enums\DiscountApplyTo::cases() as $applyTo)
                        <option value="{{ $applyTo->value }}" @selected(old('apply_to', $discount->apply_to ?? '') == $applyTo->value)>
                            {{ $applyTo->label() }}
                        </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div id="discount-value-container">
                <label class="custom-label">Discount Value <span class="text-xs text-gray-500" id="value-type-label">(%)</span></label>
                <input type="number" step="0.01" name="amount" value="{{ old('amount', $discount->amount ?? 0) }}"
                    class="input-field" placeholder="Enter discount value" required>
            </div>
        </div>
    </div>

    <!-- Right Column (1/3 width) -->
    <div class="space-y-6">
        <!-- Status & Settings -->
        <div class="bg-white rounded-lg shadow p-6 space-y-4">
            <h3 class="text-lg font-medium text-gray-900">Status & Settings</h3>

            <div>
                <label class="custom-label">Status</label>
                <select name="is_active" class="input-field">
                    <option value="1" @selected(old('is_active', $discount->is_active ?? true) == true)>Active</option>
                    <option value="0" @selected(old('is_active', $discount->is_active ?? false) == false)>Inactive</option>
                </select>
            </div>

            <div>
                <label class="custom-label">Priority</label>
                <input type="number" name="priority" value="{{ old('priority', $discount->priority ?? 0) }}"
                    class="input-field" placeholder="Higher numbers have higher priority">
                <p class="text-xs text-gray-500 mt-1">Used when multiple discounts apply</p>
            </div>
        </div>

        <!-- Validity Period -->
        <div class="bg-white rounded-lg shadow p-6 space-y-4">
            <h3 class="text-lg font-medium text-gray-900">Validity Period</h3>

            <div>
                <label class="custom-label">Start Date</label>
                <input type="datetime-local" name="starts_at"
                    value="{{ old('starts_at', isset($discount->starts_at) ? $discount->starts_at->format('Y-m-d\TH:i') : '') }}"
                    class="input-field">
            </div>

            <div>
                <label class="custom-label">End Date</label>
                <input type="datetime-local" name="expires_at"
                    value="{{ old('expires_at', isset($discount->expires_at) ? $discount->expires_at->format('Y-m-d\TH:i') : '') }}"
                    class="input-field">
            </div>
        </div>
    </div>
</div>