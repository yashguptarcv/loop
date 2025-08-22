@extends('admin::layouts.app')

@section('title', isset($discount) ? 'Edit Discount' : 'Create Discount')

@section('content')
@include('admin::components.common.back-button', ['route' => route('admin.discount.index'), 'name' => isset($discount) ? 'Edit Discount' : 'Create Discount'])

<form class="form-ajax" method="POST"
    action="@isset($discount) {{ route('admin.discount.update', $discount->id) }} @else {{ route('admin.discount.store') }} @endisset"
    enctype="multipart/form-data" id="discountForm">
    @csrf
    @isset($discount) @method('PUT') @endisset

    <!-- Main Tabs Navigation -->
    <div class="border-b border-gray-200 mb-6">
        <nav class="-mb-px flex space-x-8" aria-label="Tabs">
            <button type="button" data-tab="general" class="tab-button active border-indigo-500 text-indigo-600 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                General
            </button>
            <button type="button" data-tab="rules" class="tab-button border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                Rules
            </button>
            <button type="button" data-tab="coupons" class="tab-button border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                Coupons
            </button>
        </nav>
    </div>

    <!-- Tab Contents -->
    <div class="tab-content active" id="general">
        @include('discounts::discount.components.general')
    </div>

    <!-- Rules Tab -->
    <div class="tab-content hidden" id="rules">
        @include('discounts::discount.components.rule')
    </div>

    <!-- Coupons Tab -->
    <div class="tab-content hidden" id="coupons">
        @include('discounts::discount.components.coupons')
    </div>

    <!-- Submit Button -->
    <div class="flex justify-end mt-6">
        <x-button type="submit" class="blue" label="Save" icon='' name="button" />
    </div>
</form>

@endsection

@section('scripts')
@parent
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Toggle discount value field based on type
    const discountType = document.getElementById('discount-type');
    const valueContainer = document.getElementById('discount-value-container');
    const valueLabel = document.getElementById('value-type-label');
    
    function updateDiscountValueDisplay() {
        switch(discountType.value) {
            case 'P':
                valueLabel.textContent = '(%)';
                valueContainer.style.display = 'block';
                break;
            case 'F':
                valueLabel.textContent = '(Fixed Amount)';
                valueContainer.style.display = 'block';
                break;
        }
    }
    
    discountType.addEventListener('change', updateDiscountValueDisplay);
    updateDiscountValueDisplay(); // Initialize on load

    // Tab functionality
    const tabButtons = document.querySelectorAll('.tab-button');
    tabButtons.forEach(button => {
        button.addEventListener('click', function() {
            const tabId = this.getAttribute('data-tab');
            
            // Update active tab button
            tabButtons.forEach(btn => {
                btn.classList.remove('active', 'border-indigo-500', 'text-indigo-600');
                btn.classList.add('border-transparent', 'text-gray-500', 'hover:text-gray-700', 'hover:border-gray-300');
            });
            this.classList.add('active', 'border-indigo-500', 'text-indigo-600');
            this.classList.remove('border-transparent', 'text-gray-500', 'hover:text-gray-700', 'hover:border-gray-300');
            
            // Show corresponding tab content
            document.querySelectorAll('.tab-content').forEach(content => {
                content.classList.add('hidden');
                content.classList.remove('active');
            });
            document.getElementById(tabId).classList.remove('hidden');
            document.getElementById(tabId).classList.add('active');
        });
    });

    // Initialize Select2 for rule target selects
    function initializeSelect2(selector, url, placeholder) {
        $(selector).select2({
            placeholder: placeholder,
            allowClear: true,
            width: '100%',
            minimumInputLength: 1,
            ajax: {
                url: url,
                dataType: 'json',
                delay: 250,
                data: function(params) {
                    return {
                        search: params.term,
                        page: params.page || 1
                    };
                },
                processResults: function(data, params) {
                    params.page = params.page || 1;
                    return {
                        results: data.items,
                        pagination: {
                            more: (params.page * 30) < data.total_count
                        }
                    };
                },
                cache: true
            },
            templateResult: function(item) {
                if (item.loading) return item.text;
                return $(
                    '<div class="flex items-center">' +
                    '<div class="ml-2">' +
                    '<div class="font-medium">' + item.text + '</div>' +
                    (item.description ? '<div class="text-xs text-gray-500">' + item.description + '</div>' : '') +
                    '</div>' +
                    '</div>'
                );
            },
            templateSelection: function(item) {
                return item.text || item.id;
            }
        });
    }

    // Initialize all select2 elements
    function initializeAllSelect2() {
        initializeSelect2('.rule-target-select', '{{ route("api.admin.products.search") }}', 'Select Target...');
    }

    // Initialize on page load
    initializeAllSelect2();

    // Coupon Management
    const addCouponBtn = document.getElementById('add-coupon-btn');
    const couponsContainer = document.getElementById('coupons-container');
    
    addCouponBtn.addEventListener('click', function() {
        const template = document.getElementById('coupons-template');
        const clone = template.cloneNode(true);
        clone.classList.remove('hidden');
        
        // Update all names with new index
        const newIndex = couponsContainer.querySelectorAll('tr:not(.hidden)').length;
        
        // Update all input names with the new index
        clone.querySelectorAll('[name]').forEach(input => {
            const name = input.getAttribute('name').replace(/\[\d+\]/, `[${newIndex}]`);
            input.setAttribute('name', name);
        });
        
        // Add remove functionality
        clone.querySelector('.remove-coupon').addEventListener('click', function() {
            clone.remove();
        });
        
        couponsContainer.appendChild(clone);
    });
    
    // Add remove functionality to existing coupons
    document.querySelectorAll('.remove-coupon').forEach(btn => {
        btn.addEventListener('click', function() {
            this.closest('tr').remove();
        });
    });

    // Rule Management
    const addRuleBtn = document.getElementById('add-rule-btn');
    const rulesContainer = document.getElementById('rules-container');
    
    addRuleBtn.addEventListener('click', function() {
        const template = document.getElementById('rules-template');
        const clone = template.cloneNode(true);
        clone.classList.remove('hidden');
        
        // Update all names with new index
        const newIndex = rulesContainer.querySelectorAll('tr:not(.hidden)').length;
        
        // Update all input names with the new index
        clone.querySelectorAll('[name]').forEach(input => {
            const name = input.getAttribute('name').replace(/\[\d+\]/, `[${newIndex}]`);
            input.setAttribute('name', name);
        });
        
        // Add remove functionality
        clone.querySelector('.remove-rule').addEventListener('click', function() {
            clone.remove();
        });
        
        // Initialize Select2 for the new rule target select
        const select = clone.querySelector('.rule-target-select');
        if (select) {
            $(select).select2({
                placeholder: 'Select Target...',
                allowClear: true,
                width: '100%',
                minimumInputLength: 1,
                ajax: {
                    url: '{{ route("api.admin.products.search") }}',
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        return {
                            search: params.term,
                            page: params.page || 1
                        };
                    },
                    processResults: function(data, params) {
                        params.page = params.page || 1;
                        return {
                            results: data.items,
                            pagination: {
                                more: (params.page * 30) < data.total_count
                            }
                        };
                    },
                    cache: true
                },
                templateResult: function(item) {
                    if (item.loading) return item.text;
                    return $(
                        '<div class="flex items-center">' +
                        '<div class="ml-2">' +
                        '<div class="font-medium">' + item.text + '</div>' +
                        (item.description ? '<div class="text-xs text-gray-500">' + item.description + '</div>' : '') +
                        '</div>' +
                        '</div>'
                    );
                },
                templateSelection: function(item) {
                    return item.text || item.id;
                }
            });
        }
        
        // Handle rule type change to update the target select options
        const ruleTypeSelect = clone.querySelector('.rule-type-select');
        if (ruleTypeSelect) {
            ruleTypeSelect.addEventListener('change', function() {
                const targetSelect = clone.querySelector('.rule-target-select');
                const conditionType = clone.querySelector('.condition-type-select');
                const valueInput = clone.querySelector('input[name$="[rule_value]"]');
                
                const ruleType = this.value;
                
                if (ruleType === 'product') {
                    // Show target select for product/category rules
                    targetSelect.style.display = 'block';
                    conditionType.style.display = 'block';
                    valueInput.style.display = 'block';
                    
                    let url, placeholder;
                    
                    if (ruleType === 'product') {
                        url = '{{ route("api.admin.products.search") }}';
                        placeholder = 'Select Product...';
                    }
                    
                    // Reinitialize Select2 with new options
                    $(targetSelect).select2('destroy');
                    initializeSelect2(targetSelect, url, placeholder);
                } else {
                    // Hide target select for cart rules (subtotal, quantity)
                    targetSelect.style.display = 'none';
                    conditionType.style.display = 'block';
                    valueInput.style.display = 'block';
                }
            });
            
            // Trigger change event to initialize the correct state
            ruleTypeSelect.dispatchEvent(new Event('change'));
        }
        
        rulesContainer.appendChild(clone);
    });
    
    // Add remove functionality to existing rules
    document.querySelectorAll('.remove-rule').forEach(btn => {
        btn.addEventListener('click', function() {
            this.closest('tr').remove();
        });
    });

    // Initialize rule type change handlers for existing rules
    document.querySelectorAll('.rule-type-select').forEach(select => {
        select.addEventListener('change', function() {
            const row = this.closest('tr');
            const targetSelect = row.querySelector('.rule-target-select');
            const conditionType = row.querySelector('.condition-type-select');
            const valueInput = row.querySelector('input[name$="[rule_value]"]');
            
            const ruleType = this.value;
            
            if (ruleType === 'product') {
                // Show target select for product/category rules
                targetSelect.style.display = 'block';
                conditionType.style.display = 'block';
                valueInput.style.display = 'block';
                
                let url, placeholder;
                
                if (ruleType === 'product') {
                    url = '{{ route("api.admin.products.search") }}';
                    placeholder = 'Select Product...';
                }
                
                // Reinitialize Select2 with new options
                $(targetSelect).select2('destroy');
                initializeSelect2(targetSelect, url, placeholder);
            } else {
                // Hide target select for cart rules (subtotal, quantity)
                targetSelect.style.display = 'none';
                conditionType.style.display = 'block';
                valueInput.style.display = 'block';
            }
        });
        
        // Trigger change event to initialize the correct state
        select.dispatchEvent(new Event('change'));
    });
});
</script>
@endsection