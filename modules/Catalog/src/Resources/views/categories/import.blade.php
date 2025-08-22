@extends('admin::layouts.app')

@section('title', 'Import Categories')

@section('content')
    
        @include('admin::components.common.back-button', ['route' => route('admin.catalog.categories.index'), 'name' => 'Import Categories'])

        <div class="bg-white rounded-lg shadow-md p-6 mt-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Import Categories</h2>
            
            <div class="space-y-6">
                <!-- Step 1: File Upload -->
                <div id="step-upload" class="step-content">
                    <div class="border-2 border-dashed border-gray-300 rounded-lg p-8 text-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">Upload CSV/Excel File</h3>
                        <p class="mt-1 text-xs text-gray-500">File should contain category data with headers</p>
                        <div class="mt-4">
                            <input type="file" id="import-file" accept=".csv,.xlsx,.xls" class="hidden">
                            <button type="button" onclick="document.getElementById('import-file').click()" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm bg-blue-100 text-white-600 hover:bg-[var(--color-hover)]-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Select File
                            </button>
                        </div>
                        <p id="file-name" class="mt-2 text-sm text-gray-500 hidden">No file selected</p>
                    </div>
                    
                    <div class="mt-6">
                        <a href="{{ asset('sample/category_import_sample.csv') }}" class="text-indigo-600 hover:text-indigo-800 text-sm font-medium inline-flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                            </svg>
                            Download Sample CSV
                        </a>
                    </div>
                </div>

                <!-- Step 2: Field Mapping -->
                <div id="step-mapping" class="step-content hidden">
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Map CSV Columns to Database Fields</h3>
                        
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-100">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">CSV Column</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Database Field</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Sample Data</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200" id="mapping-fields">
                                    <!-- Will be populated by JavaScript -->
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="mt-4">
                            <label class="inline-flex items-center">
                                <input type="checkbox" id="skip-header" checked class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                <span class="ml-2 text-sm text-gray-600">First row contains headers</span>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Step 3: Validation & Import -->
                <div id="step-import" class="step-content hidden">
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Review & Import</h3>
                        
                        <div id="validation-results" class="mb-6">
                            <!-- Validation results will be shown here -->
                        </div>
                        
                        <div class="flex items-center">
                            <input type="checkbox" id="confirm-import" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            <label for="confirm-import" class="ml-2 text-sm text-gray-600">I confirm that I've reviewed the data and want to proceed with the import</label>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Navigation Buttons -->
            <div class="mt-8 flex justify-between">
                <button id="btn-prev" type="button" class="hidden inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Previous
                </button>
                <button id="btn-next" type="button" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm bg-blue-100 text-white-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Next
                </button>
                <button id="btn-import" type="button" class="hidden inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm bg-blue-100 text-white-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                    Start Import
                </button>
            </div>
        </div>
    
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    let currentStep = 1;
    let fileData = null;
    let headers = [];
    let sampleData = [];
    let fieldMappings = {};
    
    // Available database fields with labels and sample values
    const dbFields = {
        'name': { label: 'Name', required: true, sample: 'Electronics' },
        'slug': { label: 'Slug', required: false, sample: 'electronics' },
        'parent_id': { label: 'Parent ID', required: false, sample: '1' },
        'description': { label: 'Description', required: false, sample: 'All electronic items' },
        'image': { label: 'Image Path', required: false, sample: 'categories/electronics.jpg' },
        'status': { label: 'Status (1/0)', required: false, sample: '1' },
        'position': { label: 'Position', required: false, sample: '1' },
        'meta_title': { label: 'Meta Title', required: false, sample: 'Electronics - Best Deals' },
        'meta_description': { label: 'Meta Description', required: false, sample: 'Shop for best electronics' },
        'meta_keywords': { label: 'Meta Keywords', required: false, sample: 'electronics, gadgets' }
    };
    
    // File input change handler
    document.getElementById('import-file').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            document.getElementById('file-name').textContent = file.name;
            document.getElementById('file-name').classList.remove('hidden');
            
            // Here you would parse the file (CSV/Excel)
            // For demo purposes, we'll simulate parsing
            simulateFileParse(file);
        }
    });
    
    // Navigation buttons
    document.getElementById('btn-next').addEventListener('click', function() {
        if (validateStep(currentStep)) {
            showStep(currentStep + 1);
        }
    });
    
    document.getElementById('btn-prev').addEventListener('click', function() {
        showStep(currentStep - 1);
    });
    
    document.getElementById('btn-import').addEventListener('click', function() {
        if (document.getElementById('confirm-import').checked) {
            startImport();
        } else {
            alert('Please confirm the import by checking the box');
        }
    });
    
    function validateStep(step) {
        switch(step) {
            case 1:
                if (!document.getElementById('import-file').files.length) {
                    alert('Please select a file to import');
                    return false;
                }
                return true;
            case 2:
                // Check if required fields are mapped
                const requiredFields = Object.keys(dbFields).filter(field => dbFields[field].required);
                const mappedFields = Object.values(fieldMappings);

                console.log(mappedFields);
                
                for (const field of requiredFields) {
                    if (!mappedFields.includes(field)) {
                        alert(`Please map all required fields (${dbFields[field].label})`);
                        return false;
                    }
                }
                return true;
            default:
                return true;
        }
    }
    
    function showStep(step) {
        // Hide all steps
        document.querySelectorAll('.step-content').forEach(el => {
            el.classList.add('hidden');
        });
        
        // Show current step
        document.getElementById(`step-${getStepName(step)}`).classList.remove('hidden');
        
        // Update button visibility
        document.getElementById('btn-prev').classList.toggle('hidden', step === 1);
        document.getElementById('btn-next').classList.toggle('hidden', step === 3);
        document.getElementById('btn-import').classList.toggle('hidden', step !== 3);
        
        // Update button text on last step
        if (step === 3) {
            document.getElementById('btn-next').textContent = 'Next';
        }
        
        currentStep = step;
        
        // Special handling for each step
        if (step === 2) {
            setupMappingStep();
        } else if (step === 3) {
            setupImportStep();
        }
    }
    
    function getStepName(step) {
        switch(step) {
            case 1: return 'upload';
            case 2: return 'mapping';
            case 3: return 'import';
            default: return 'upload';
        }
    }
    
    function simulateFileParse(file) {
        // In a real app, you would use a library like PapaParse for CSV
        // or SheetJS for Excel files to parse the actual content
        
        // Simulate parsing delay
        setTimeout(() => {
            // Mock data - in reality this would come from parsing the file
            headers = ['Category Name', 'Parent Category', 'Description', 'Image', 'Active'];
            sampleData = ['Electronics', 'Root', 'All electronic items', 'electronics.jpg', '1'];
            
            // Auto-advance to mapping step if file is selected
            showStep(2);
        });
    }
    
    function setupMappingStep() {
        const mappingContainer = document.getElementById('mapping-fields');
        mappingContainer.innerHTML = '';
        
        headers.forEach((header, index) => {
            const row = document.createElement('tr');
            
            // CSV Column cell
            const headerCell = document.createElement('td');
            headerCell.className = 'px-6 py-4 whitespace-nowrap text-sm text-gray-500';
            headerCell.textContent = header;
            
            // Database Field cell (dropdown)
            const dbFieldCell = document.createElement('td');
            dbFieldCell.className = 'px-6 py-4 whitespace-nowrap';
            
            const select = document.createElement('select');
            select.className = 'mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md';
            select.dataset.csvIndex = index;
            
            // Add empty option
            const emptyOption = document.createElement('option');
            emptyOption.value = '';
            emptyOption.textContent = '-- Skip this column --';
            select.appendChild(emptyOption);
            
            // Add database field options
            Object.keys(dbFields).forEach(field => {
                const option = document.createElement('option');
                option.value = field;
                option.textContent = dbFields[field].label;
                
                // Simple auto-matching (in real app you might have more sophisticated matching)
                if (header.toLowerCase().includes(field)) {
                    option.selected = true;
                    fieldMappings[field] = index;
                }
                
                select.appendChild(option);
            });
            
            select.addEventListener('change', function() {
                const csvIndex = parseInt(this.dataset.csvIndex);
                const dbField = this.value;
                
                if (dbField) {
                    fieldMappings[dbField] = csvIndex;
                } else {
                    // Remove mapping if it exists
                    Object.keys(fieldMappings).forEach(key => {
                        if (fieldMappings[key] === csvIndex) {
                            delete fieldMappings[key];
                        }
                    });
                }
            });
            
            dbFieldCell.appendChild(select);
            
            // Sample Data cell
            const sampleCell = document.createElement('td');
            sampleCell.className = 'px-6 py-4 whitespace-nowrap text-sm text-gray-500';
            sampleCell.textContent = sampleData[index] || '-';
            
            row.appendChild(headerCell);
            row.appendChild(dbFieldCell);
            row.appendChild(sampleCell);
            
            mappingContainer.appendChild(row);
        });
    }
    
    function setupImportStep() {
        const validationContainer = document.getElementById('validation-results');
        validationContainer.innerHTML = `
            <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Import Summary</h3>
                    <p class="mt-1 text-sm text-gray-500">Review the data before importing</p>
                </div>
                <div class="px-4 py-5 sm:p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <h4 class="text-sm font-medium text-gray-500">Total Records</h4>
                            <p class="mt-1 text-sm text-gray-900">25</p>
                        </div>
                        <div>
                            <h4 class="text-sm font-medium text-gray-500">Fields to Import</h4>
                            <p class="mt-1 text-sm text-gray-900">${Object.keys(fieldMappings).map(f => dbFields[f].label).join(', ')}</p>
                        </div>
                    </div>
                    
                    <div class="mt-6">
                        <h4 class="text-sm font-medium text-gray-500 mb-2">Sample Import Data</h4>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        ${Object.keys(fieldMappings).map(f => `<th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">${dbFields[f].label}</th>`).join('')}
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <tr>
                                        ${Object.keys(fieldMappings).map(f => `<td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${sampleData[fieldMappings[f]] || '-'}</td>`).join('')}
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    
                    <div class="mt-6 p-4 bg-yellow-50 rounded-md">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-yellow-800">Important Note</h3>
                                <div class="mt-2 text-sm text-yellow-700">
                                    <p>Parent categories must exist before their children can be imported. If you're importing parent-child relationships, make sure parent categories are either already in the database or appear earlier in the import file.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        `;
    }
    
    function startImport() {
        // In a real app, you would send the file and mappings to the server
        // Here we'll simulate an AJAX call
        
        const btnImport = document.getElementById('btn-import');
        btnImport.disabled = true;
        btnImport.innerHTML = `
            <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            Importing...
        `;
        
        // Simulate import delay
        setTimeout(() => {
            alert('Import completed successfully!');
            window.location.href = "{{ route('admin.catalog.categories.index') }}";
        }, 2000);
    }
});
</script>
@endsection