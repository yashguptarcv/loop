@extends('admin::layouts.app')

@section('title', isset($discount) ? 'Edit Discount' : 'Create Discount')

@section('content')
    @include('admin::components.common.back-button', ['route' => route('admin.discount.index'), 'name' => isset($discount) ? 'Edit Discount' : 'Create Discount'])

    <form class="form-ajax" method="POST"
        action="@isset($discount) {{ route('admin.discount.update', $discount->id) }} @else {{ route('admin.discount.store') }} @endisset"
        enctype="multipart/form-data" id="discountForm">
        @csrf
        @isset($discount) @method('PUT') @endisset

        <!-- Tabs -->
        <div class="border-b divide-gray-100 mb-6">
            <nav class="-mb-px flex space-x-8" aria-label="Tabs">
                <button type="button" data-tab="general"
                    class="tab-button active border-indigo-500 text-indigo-600 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">General</button>
                <button type="button" data-tab="rules"
                    class="tab-button border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">Rules</button>
                <button type="button" data-tab="coupons"
                    class="tab-button border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">Coupons</button>
            </nav>
        </div>

        <!-- Tab Contents -->
        <div class="tab-content active" id="general">
            @include('discounts::discount.components.general')
        </div>

        <div class="tab-content hidden" id="rules">
            @include('discounts::discount.components.rule')
        </div>

        <div class="tab-content hidden" id="coupons">
            @include('discounts::discount.components.coupons')
        </div>

        <!-- Submit -->
        <!-- Submit & Navigation -->
        <div class="flex space-x-3 mt-4">
            <button type="button" id="prev-button" class="btn btn-accent px-4 py-2 hidden">
                Previous
            </button>
            <button type="button" id="next-button" class="btn btn-outline px-4 py-2">
                Next
            </button>
            <button type="submit" id="save-button" name="button" class="btn btn-primary px-4 py-2 hidden ">
                @isset($discount) Update @else Create @endisset
            </button>
        </div>

    </form>
@endsection

@section('scripts')
    @parent
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script> document.addEventListener('DOMContentLoaded', function () { const tabButtons = document.querySelectorAll('.tab-button'); tabButtons.forEach(btn => btn.addEventListener('click', function () { const tabId = this.getAttribute('data-tab'); tabButtons.forEach(b => b.classList.remove('active', 'border-indigo-500', 'text-indigo-600')); tabButtons.forEach(b => b.classList.add('border-transparent', 'text-gray-500')); this.classList.add('active', 'border-indigo-500', 'text-indigo-600'); document.querySelectorAll('.tab-content').forEach(c => c.classList.add('hidden')); document.getElementById(tabId).classList.remove('hidden'); })); }); </script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const tabButtons = document.querySelectorAll('.tab-button');
            const tabContents = document.querySelectorAll('.tab-content');
            const prevBtn = document.getElementById('prev-button');
            const nextBtn = document.getElementById('next-button');
            const saveBtn = document.getElementById('save-button');

            let currentStep = 0;
            function showStep(index) {
                tabContents.forEach((c, i) => {
                    c.classList.toggle('hidden', i !== index);
                });
                tabButtons.forEach((b, i) => {
                    b.classList.toggle('active', i === index);
                    b.classList.toggle('border-indigo-500', i === index);
                    b.classList.toggle('text-indigo-600', i === index);
                    b.classList.toggle('border-transparent', i !== index);
                    b.classList.toggle('text-gray-500', i !== index);
                });

                // Toggle button visibility
                prevBtn.classList.toggle('hidden', index === 0);
                nextBtn.classList.toggle('hidden', index === tabContents.length - 1);
                saveBtn.classList.toggle('hidden', index !== tabContents.length - 1);
            }

            nextBtn.addEventListener('click', function () {
                if (currentStep < tabContents.length - 1) {
                    currentStep++;
                    showStep(currentStep);
                }
            });

            prevBtn.addEventListener('click', function () {
                if (currentStep > 0) {
                    currentStep--;
                    showStep(currentStep);
                }
            });
            showStep(currentStep);
        });
    </script>

@endsection