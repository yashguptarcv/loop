@extends('admin::layouts.app')

@section('title', 'Widgets Manager')

@section('styles')

@endsection

@section('content')
<!-- Stats Section -->
@include('admin::components.common.back-button', ['route' => route('admin.widgets.index'), 'name' => 'New Widget'])

<form id="createWidgetForm" 
      action="@if(!empty($widget)){{ route('admin.widgets.update', $widget->id) }} @else {{ route('admin.widgets.store') }} @endif" 
      method="POST" 
      class="space-y-6">
    @csrf

    @if(!empty($widget)) @method('PUT') @endif
    <!-- Title Field -->
    <div class="bg-blue-50 p-4 rounded-lg border border-blue-100">
        <label class="block text-sm font-medium text-blue-800 mb-2">
            <i class="fas fa-heading mr-2"></i>Title
        </label>
        <input name="title" class="w-full border border-blue-200 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"  placeholder="Enter widget title">
    </div>

    <!-- Base Table and Operation -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
            <label class="block text-sm font-medium text-gray-700 mb-2">
                <i class="fas fa-table mr-2"></i>Base Table
            </label>
            <select name="table_name" class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors" >
                <option value="">Select a table</option>
                @foreach($tables as $table)
                    <option value="{{ $table }}">{{ $table }}</option>
                @endforeach
            </select>
        </div>
        <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
            <label class="block text-sm font-medium text-gray-700 mb-2">
                <i class="fas fa-calculator mr-2"></i>Operation
            </label>
            <select name="operation" id="op" class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors" >
                <option value="count">Count</option>
                <option value="sum">Sum</option>
                <option value="avg">Average</option>
                <option value="min">Minimum</option>
                <option value="max">Maximum</option>
                <option value="profit_loss">Profit/Loss</option>
                <option value="month_compare">Month Compare</option>
            </select>
        </div>
    </div>

    <!-- Currency Toggle -->
    <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
        <label class="block text-sm font-medium text-gray-700 mb-2">
            <i class="fas fa-money-bill-wave mr-2"></i>Currency Format
        </label>
        <div class="flex items-center">
            <label class="inline-flex items-center mr-6">
                <input type="radio" name="is_currency" value="Y" class="h-4 w-4 text-blue-600 focus:ring-blue-500">
                <span class="ml-2 text-gray-700">Yes</span>
            </label>
            <label class="inline-flex items-center">
                <input type="radio" name="is_currency" value="N" checked class="h-4 w-4 text-blue-600 focus:ring-blue-500">
                <span class="ml-2 text-gray-700">No</span>
            </label>
        </div>
    </div>

    <!-- Aggregate Column -->
    <div id="aggRow" class="bg-gray-50 p-4 rounded-lg border border-gray-200">
        <label class="block text-sm font-medium text-gray-700 mb-2">
            <i class="fas fa-columns mr-2"></i>Aggregate Column (nullable for count)
        </label>
        <input name="column_name" class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors" placeholder="orders.total_amount or order_items.price">
    </div>

    <!-- Profit/Loss Fields -->
    <div id="plRow" class="hidden grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-green-50 p-4 rounded-lg border border-green-200">
            <label class="block text-sm font-medium text-green-800 mb-2">
                <i class="fas fa-arrow-up mr-2"></i>Revenue Column
            </label>
            <input name="revenue_column" class="w-full border border-green-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors" placeholder="order_items.price">
        </div>
        <div class="bg-red-50 p-4 rounded-lg border border-red-200">
            <label class="block text-sm font-medium text-red-800 mb-2">
                <i class="fas fa-arrow-down mr-2"></i>Cost Column
            </label>
            <input name="cost_column" class="w-full border border-red-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-colors" placeholder="order_items.cost">
        </div>
    </div>

    <!-- Date and Group By Fields -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
            <label class="block text-sm font-medium text-gray-700 mb-2">
                <i class="fas fa-calendar-day mr-2"></i>Date Column
            </label>
            <input name="date_column" class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors" placeholder="orders.created_at">
        </div>
        <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
            <label class="block text-sm font-medium text-gray-700 mb-2">
                <i class="fas fa-filter mr-2"></i>Date Filter
            </label>
            <select name="date_filter" class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                <option value="none">None</option>
                <option value="today">Today</option>
                <option value="week">This Week</option>
                <option value="month" selected>This Month</option>
                <option value="year">This Year</option>
                <option value="custom">Custom Range</option>
            </select>
        </div>
        <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
            <label class="block text-sm font-medium text-gray-700 mb-2">
                <i class="fas fa-layer-group mr-2"></i>Group By
            </label>
            <input name="group_by" class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors" placeholder="DATE(orders.created_at) or orders.country_code">
        </div>
    </div>

    <!-- Custom Date Range -->
    <div id="customDateRange" class="hidden grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-blue-50 p-4 rounded-lg border border-blue-200">
            <label class="block text-sm font-medium text-blue-800 mb-2">
                <i class="fas fa-calendar-start mr-2"></i>From Date
            </label>
            <input type="date" name="date_from" class="w-full border border-blue-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
        </div>
        <div class="bg-blue-50 p-4 rounded-lg border border-blue-200">
            <label class="block text-sm font-medium text-blue-800 mb-2">
                <i class="fas fa-calendar-end mr-2"></i>To Date
            </label>
            <input type="date" name="date_to" class="w-full border border-blue-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
        </div>
    </div>

    <!-- Widget Type -->
    <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
        <label class="block text-sm font-medium text-gray-700 mb-2">
            <i class="fas fa-chart-area mr-2"></i>Widget Type
        </label>
        <select name="widget_type" class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
            <option value="stat">Stat Card</option>
            <option value="line">Line Chart</option>
            <option value="bar">Bar Chart</option>
            <option value="pie">Pie Chart</option>
            <option value="worldmap">World Map</option>
        </select>
    </div>

    <!-- Dynamic Joins -->
    <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
        <label class="block text-sm font-medium text-gray-700 mb-2">
            <i class="fas fa-link mr-2"></i>Joins
        </label>
        <div id="joinsContainer" class="space-y-3 mb-4"></div>
        <button type="button" id="addJoinBtn" class="px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition-colors">
            <i class="fas fa-plus mr-2"></i>Add Join
        </button>
        <input type="hidden" name="joins" id="joinsInput">
    </div>

    <!-- Conditions -->
    <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
        <label class="block text-sm font-medium text-gray-700 mb-2">
            <i class="fas fa-filter mr-2"></i>Conditions
        </label>
        <div id="conditionsContainer" class="space-y-3 mb-4"></div>
        <button type="button" id="addConditionBtn" class="px-4 py-2 bg-purple-500 text-white rounded-lg hover:bg-purple-600 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 transition-colors">
            <i class="fas fa-plus mr-2"></i>Add Condition
        </button>
        <input type="hidden" name="conditions" id="conditionsInput">
    </div>

    <!-- Layout Settings -->
    <div class="bg-blue-50 p-4 rounded-lg border border-blue-200">
        <h3 class="text-lg font-medium text-blue-800 mb-4">
            <i class="fas fa-border-all mr-2"></i>Layout Settings
        </h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-blue-700 mb-2">Position X</label>
                <input type="number" name="pos_x" value="0" class="w-full border border-blue-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
            </div>
            <div>
                <label class="block text-sm font-medium text-blue-700 mb-2">Position Y</label>
                <input type="number" name="pos_y" value="0" class="w-full border border-blue-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
            </div>
            <div>
                <label class="block text-sm font-medium text-blue-700 mb-2">Width</label>
                <input type="number" name="width" value="1" min="1" max="6" class="w-full border border-blue-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
            </div>
            <div>
                <label class="block text-sm font-medium text-blue-700 mb-2">Height</label>
                <input type="number" name="height" value="1" min="1" max="6" class="w-full border border-blue-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
            </div>
        </div>
    </div>

    <!-- Submit Button -->
    <div class="flex justify-end pt-4">
        <x-button type="submit"
        class="primary"
        label="Save"
        icon=''
        name="button" />
    </div>
</form>

@endsection
@section('scripts')
<script>
 document.addEventListener('DOMContentLoaded', function () {
    const joinsContainer = document.getElementById('joinsContainer');
    const joinsInput = document.getElementById('joinsInput');
    const addJoinBtn = document.getElementById('addJoinBtn');
    const conditionsContainer = document.getElementById('conditionsContainer');
    const conditionsInput = document.getElementById('conditionsInput');
    const addConditionBtn = document.getElementById('addConditionBtn');
    const createWidgetForm = document.getElementById('createWidgetForm');

    // -------------------
    // Dynamic Joins UI
    // -------------------
    function createJoinRow(join = {}) {
        const row = document.createElement('div');
        row.className = "grid grid-cols-1 md:grid-cols-5 gap-2 border border-gray-300 p-3 rounded-lg bg-white";

        row.innerHTML = `
            <input class="border border-gray-300 rounded-md px-2 py-2 focus:outline-none focus:ring-1 focus:ring-blue-500" placeholder="Table" value="${join.table || ''}">
            <input class="border border-gray-300 rounded-md px-2 py-2 focus:outline-none focus:ring-1 focus:ring-blue-500" placeholder="Local Column" value="${join.local_column || ''}">
            <input class="border border-gray-300 rounded-md px-2 py-2 focus:outline-none focus:ring-1 focus:ring-blue-500" placeholder="Foreign Column" value="${join.foreign_column || ''}">
            <select class="border border-gray-300 rounded-md px-2 py-2 focus:outline-none focus:ring-1 focus:ring-blue-500">
                <option value="inner" ${join.type === 'inner' ? 'selected' : ''}>Inner</option>
                <option value="left" ${join.type === 'left' ? 'selected' : ''}>Left</option>
                <option value="right" ${join.type === 'right' ? 'selected' : ''}>Right</option>
            </select>
            <button type="button" class="removeJoin bg-red-500 text-white rounded-md px-3 py-2 hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-500 transition-colors">Remove</button>
        `;

        row.querySelector('.removeJoin').addEventListener('click', () => row.remove());
        return row;
    }

    addJoinBtn.addEventListener('click', () => joinsContainer.appendChild(createJoinRow()));

    function collectJoins() {
        const rows = joinsContainer.querySelectorAll('div');
        const joins = [];
        rows.forEach(row => {
            const inputs = row.querySelectorAll('input, select');
            joins.push({
                table: inputs[0].value,
                local_column: inputs[1].value,
                foreign_column: inputs[2].value,
                type: inputs[3].value,
            });
        });
        joinsInput.value = JSON.stringify(joins);
    }

    // -------------------
    // Dynamic Conditions UI
    // -------------------
    function createConditionRow(condition = {}) {
        const row = document.createElement('div');
        row.className = "grid grid-cols-1 md:grid-cols-4 gap-2 border border-gray-300 p-3 rounded-lg bg-white";

        row.innerHTML = `
            <input class="border border-gray-300 rounded-md px-2 py-2 focus:outline-none focus:ring-1 focus:ring-blue-500" placeholder="Column" value="${condition.column || ''}">
            <select class="border border-gray-300 rounded-md px-2 py-2 focus:outline-none focus:ring-1 focus:ring-blue-500">
                <option value="=" ${condition.operator === '=' ? 'selected' : ''}>=</option>
                <option value="!=" ${condition.operator === '!=' ? 'selected' : ''}>!=</option>
                <option value=">" ${condition.operator === '>' ? 'selected' : ''}>></option>
                <option value="<" ${condition.operator === '<' ? 'selected' : ''}><</option>
                <option value=">=" ${condition.operator === '>=' ? 'selected' : ''}>>=</option>
                <option value="<=" ${condition.operator === '<=' ? 'selected' : ''}><=</option>
                <option value="LIKE" ${condition.operator === 'LIKE' ? 'selected' : ''}>LIKE</option>
                <option value="IN" ${condition.operator === 'IN' ? 'selected' : ''}>IN</option>
            </select>
            <input class="border border-gray-300 rounded-md px-2 py-2 focus:outline-none focus:ring-1 focus:ring-blue-500" placeholder="Value" value="${condition.value || ''}">
            <button type="button" class="removeCondition bg-red-500 text-white rounded-md px-3 py-2 hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-500 transition-colors">Remove</button>
        `;

        row.querySelector('.removeCondition').addEventListener('click', () => row.remove());
        return row;
    }

    addConditionBtn.addEventListener('click', () => conditionsContainer.appendChild(createConditionRow()));

    function collectConditions() {
        const rows = conditionsContainer.querySelectorAll('div');
        const conditions = [];
        rows.forEach(row => {
            const inputs = row.querySelectorAll('input, select');
            conditions.push({
                column: inputs[0].value,
                operator: inputs[1].value,
                value: inputs[2].value,
            });
        });
        conditionsInput.value = JSON.stringify(conditions);
    }

    // -------------------
    // Pre-fill existing widget data
    // -------------------
    @if(!empty($widget->joins))
        const existingJoins = @json($widget->joins);
        existingJoins.forEach(join => joinsContainer.appendChild(createJoinRow(join)));
    @endif

    @if(!empty($widget->conditions))
        const existingConditions = @json($widget->conditions);
        existingConditions.forEach(condition => conditionsContainer.appendChild(createConditionRow(condition)));
    @endif

    // -------------------
    // Collect values on submit
    // -------------------
    createWidgetForm.addEventListener('submit', function(e) {
        collectJoins();
        collectConditions();
    });
});

    </script>
@endsection