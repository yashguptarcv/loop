<div id="global-delete-modal" class="fixed inset-0 bg-black/70 flex items-center justify-center z-50 hidden transition-opacity duration-300 ease-out">
    <div class="bg-blue-100 p-8 rounded-2xl shadow-[0_4px_20px_var(--color-shadow)] w-full max-w-md transform transition-all duration-300 ease-out scale-95 hover:scale-100">
        <div class="flex items-center gap-3 mb-4">
            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <h2 class="text-2xl font-semibold text-blue-600">Confirm Deletion</h2>
        </div>
        <p class="mb-6 text-black-600 text-base leading-relaxed">Are you sure you want to delete this item? This action is permanent and cannot be undone.</p>

        <form id="status-form" class="form-ajax" method="POST">
            @csrf
            <input type="hidden" name="status" id="status-value" value="">
            <div class="flex justify-end gap-4">
                <x-button type="button"                     
                    class="blue" 
                    label="Cancel" 
                    icon=''
                    id='status-cancel-btn'
                    />   

                <x-button type="submit"                     
                    class="blue" 
                    label="Change" 
                    icon=''
                    name="button" 
                />
            </div>
        </form>
    </div>
</div>



