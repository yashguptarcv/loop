<!-- Discount Rules -->
<div class="bg-white rounded-lg shadow p-6 space-y-4 mt-6">
    <div class="flex justify-between items-center">
        <h3 class="text-lg font-medium text-gray-900">Discount Rules</h3>
        
        <x-button type="button"                     
            class="primary" 
            label="Add Rule" 
            icon=''
            id="add-rule-btn"
            name="button" 
        />
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-100">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Rule Type
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Target
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Condition
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Value
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action
                    </th>
                </tr>
            </thead>
            <tbody id="rules-container" class="bg-white divide-y divide-gray-100">
                @if(isset($discount) && $discount->rules)
                    @foreach($discount->rules as $rule)
                        <tr>
                            <!-- Rule Type -->
                            <td class="px-3 py-2 md:px-6 md:py-4 whitespace-nowrap">
                                <select data-base-name="rule_type" class="input-field rule-type-select w-full">
                                    <option value="product" @selected($rule->rule_type == 'product')>Product</option>
                                    <!-- <option value="category" @selected($rule->rule_type == 'category')>Category</option> -->
                                    <option value="subtotal" @selected($rule->rule_type == 'subtotal')>Subtotal</option>
                                    <option value="quantity" @selected($rule->rule_type == 'quantity')>Quantity</option>
                                </select>
                            </td>

                            <!-- Target -->
                             <!-- 'category' -->
                            <td class="px-3 py-2 md:px-6 md:py-4 whitespace-nowrap target-cell">
                                @if(in_array($rule->rule_type, ['product']))
                                    <select data-base-name="rule_id" class="input-field rule-target-select py-2 w-full">
                                        <option value="{{ $rule->rule_id }}" selected>
                                            {{ $rule->rule_name ?? 'Selected Target' }}
                                        </option>
                                    </select>
                                @else
                                    <input type="hidden" data-base-name="rule_id" value="">
                                @endif
                            </td>

                            <!-- Condition -->
                            <td class="px-3 py-2 md:px-6 md:py-4 whitespace-nowrap">
                                <select data-base-name="condition_type" class="input-field w-full">
                                    <option value="equals" @selected($rule->condition_type == 'equals')>Equals</option>
                                    <option value="not_equals" @selected($rule->condition_type == 'not_equals')>Not Equals
                                    </option>
                                    <option value="greater_than" @selected($rule->condition_type == 'greater_than')>Greater Than
                                    </option>
                                    <option value="less_than" @selected($rule->condition_type == 'less_than')>Less Than</option>
                                </select>
                            </td>

                            <!-- Value -->
                            <td class="px-3 py-2 md:px-6 md:py-4 whitespace-nowrap">
                                <input type="text" data-base-name="rule_value" class="input-field w-full"
                                    value="{{ $rule->rule_value }}">
                            </td>

                            <!-- Remove -->
                            <td class="px-3 py-2 md:px-6 md:py-4 whitespace-nowrap text-center">
                                <button type="button" class="remove-rule text-red-600 hover:text-red-800">
                                    <span class="material-icons-outlined">delete</span>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>

    <!-- Template for new rules -->
    <template id="rules-template">
        <tr>
            <td class="px-3 py-2 md:px-6 md:py-4 whitespace-nowrap">
                <select data-base-name="rule_type" class="input-field rule-type-select w-full">
                    <option value="product">Product</option>
                    <!-- <option value="category">Category</option> -->
                    <option value="subtotal">Subtotal</option>
                    <option value="quantity">Quantity</option>
                </select>
            </td>
            <td class="px-3 py-2 md:px-6 md:py-4 whitespace-nowrap target-cell">
                <input type="hidden" data-base-name="rule_id" value="">
            </td>
            <td class="px-3 py-2 md:px-6 md:py-4 whitespace-nowrap">
                <select data-base-name="condition_type" class="input-field w-full">
                    <option value="equals">Equals</option>
                    <option value="not_equals">Not Equals</option>
                    <option value="greater_than">Greater Than</option>
                    <option value="less_than">Less Than</option>
                </select>
            </td>
            <td class="px-3 py-2 md:px-6 md:py-4 whitespace-nowrap">
                <input type="text" data-base-name="rule_value" class="input-field w-full">
            </td>
            <td class="px-3 py-2 md:px-6 md:py-4 whitespace-nowrap text-center">
                <button type="button" class="remove-rule text-red-600 hover:text-red-800">
                    <span class="material-icons-outlined">delete</span>
                </button>
            </td>
        </tr>
    </template>
</div>




<script>
    document.addEventListener('DOMContentLoaded', function () {
        const ruleContainer = document.getElementById('rules-container');
        const ruleTemplate = document.getElementById('rules-template');

        function updateRuleIndexes() {
            ruleContainer.querySelectorAll('tr').forEach((tr, index) => {
                tr.querySelectorAll('[data-base-name]').forEach(el => {
                    const base = el.getAttribute('data-base-name');
                    el.name = `rules[${index}][${base}]`;
                });
            });
        }

        function attachRuleRemoveHandlers() {
            ruleContainer.querySelectorAll('.remove-rule').forEach(btn => {
                btn.onclick = () => {
                    const tr = btn.closest('tr');
                    const select = tr.querySelector('.rule-target-select');
                    if (select && $(select).data('select2')) {
                        $(select).select2('destroy');
                    }
                    tr.remove();
                    updateRuleIndexes();
                };
            });
        }

        function prefillSelect2(selectEl) {
            const selectedOpt = selectEl.querySelector('option[selected]') || selectEl.options[selectEl.selectedIndex];
            if (!selectedOpt) return;

            const id = selectedOpt.value;
            const text = selectedOpt.text;

            if (id && text) {
                // If not already in DOM, inject option
                if (!selectEl.querySelector(`option[value="${id}"]`)) {
                    const opt = new Option(text, id, true, true);
                    selectEl.add(opt);
                }
                $(selectEl).val(id).trigger('change');
            }
        }

        function initRuleSelect2(tr) {
            const ruleTypeSelect = tr.querySelector('.rule-type-select');
            let targetSelect = tr.querySelector('.rule-target-select');

            function setupSelect2() {
                const td = tr.querySelector('.target-cell');
                // 'category'
                const needsTarget = ['product'].includes(ruleTypeSelect.value);

                if (needsTarget) {

                    if (!targetSelect) {
                        td.innerHTML = `<select data-base-name="rule_id" class="input-field rule-target-select w-full"></select>`;
                        targetSelect = td.querySelector('.rule-target-select');
                    }

                    // Reset old Select2
                    if ($(targetSelect).data('select2')) {
                        $(targetSelect).select2('destroy');
                    }

                    const url = '{{ route("api.admin.products.search") }}';

                    // const url = ruleTypeSelect.value === 'category'
                    //     ? '{{ route("api.admin.categories.search") }}'
                    //     : '{{ route("api.admin.products.search") }}';

                    $(targetSelect).select2({
                        placeholder: 'Select Target...',
                        ajax: {
                            url,
                            dataType: 'json',
                            delay: 250,
                            data: params => ({
                                q: params.term,
                                page: params.page || 1
                            }),
                            processResults: (data, params) => {
                                params.page = params.page || 1;
                                return {
                                    results: data.items.map(item => ({
                                        id: item.id,
                                        text: item.text
                                    })),
                                    pagination: {
                                        more: (params.page * 10) < data.total_count
                                    }
                                };
                            },
                            cache: true
                        },
                        minimumInputLength: 1,
                        width: '100%',


                    });

                    prefillSelect2(targetSelect);

                } else {
                    // no target
                    if (targetSelect && $(targetSelect).data('select2')) {
                        $(targetSelect).select2('destroy');
                    }
                    td.innerHTML = `<input type="hidden" data-base-name="rule_id" value="">`;
                    targetSelect = null;
                }

                updateRuleIndexes();
            }

            setupSelect2();
            ruleTypeSelect.addEventListener('change', setupSelect2);
        }

        document.getElementById('add-rule-btn').addEventListener('click', function () {
            const clone = ruleTemplate.content.cloneNode(true).querySelector('tr');
            ruleContainer.appendChild(clone);
            updateRuleIndexes();
            attachRuleRemoveHandlers();
            initRuleSelect2(clone);
        });

        ruleContainer.querySelectorAll('tr').forEach(tr => {
            initRuleSelect2(tr);
        });

        updateRuleIndexes();
        attachRuleRemoveHandlers();
    });

</script>