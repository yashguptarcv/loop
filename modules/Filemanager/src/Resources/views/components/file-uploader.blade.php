<!-- Main Content -->
 @php
    $image      = fn_get_image($object_type, $object_id);
    
    $image_path = $image['url'] ?? $image['default'];
    $image_alt  = $image['original_name'] ?? '';
    $image_id   = $image['id'] ?? 0;
    $input_name = $name ?? 'image';
 @endphp
<div class="flex flex-col md:flex-row gap-8">
    <!-- Current Logo Preview -->
    <div class="flex justify-center items-center gap-6 p-4">
        <div class="">

            <div class="bg-white rounded-lg border border-gray-300 flex items-center h-[120px] w-[160px] justify-center">
                <img src="{{$image_path}}" id="preview" class="h-full w-full object-contain" alt="{{$image_alt}}">
            </div>
            <div class="mt-4  w-[160px]">
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-gray-500">
                        <i class="fas fa-info-circle"></i>
                    </div>
                    <input type="text" id="altText" name="alt_text" class="pl-10 w-full px-4 py-2 border border-gray-300 rounded-lg"
                        value="{{$image_alt}}" placeholder="Enter alternative text">
                </div>
            </div>
        </div>

        <div class="mb-5">
            <div id="image_name">
                @if(!empty($image_id))
                <div class="flex flex-col md:flex-row gap-2 mb-3">
                    <div class="image-name">
                        <span>{{$image_alt}}</span>
                    </div>
                    @if($image_id)
                    <a href="#" title="Remove image"><i class="fas fa-times"></i></a>
                    @endif
                </div>
                @endif
            </div>
            <div class="btn-group flex space-x-2 mb-5 border border-gray-300 rounded-lg">
                <input type="file" name="{{$input_name}}" id="image" class="btn flex-1 py-2 px-4 bg-white text-gray-700 font-medium hover:bg-gray-50 active:bg-blue-50 active:text-blue-700 active:border-blue-300 border-r border-gray-300">
                
                <button class="btn flex-1 py-2 px-4 bg-white text-gray-700 font-medium hover:bg-gray-50 active:bg-blue-50 active:text-blue-700 active:border-blue-300">
                    Filemanager
                </button>
            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const fileInput = document.getElementById('image');
        const imageNameContainer = document.getElementById('image_name');
        const preview = document.getElementById('preview');
        const altTextInput = document.getElementById('altText');
        const defaultIcon = document.querySelector('.default-icon');
        const defaultText = document.querySelector('.default-text');

        // Handle file selection
        fileInput.addEventListener('change', function() {
            if (this.files && this.files[0]) {

                imageNameContainer.innerHTML = '';
                const file = this.files[0];

                // Create preview
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                    defaultIcon.style.display = 'none';
                    defaultText.style.display = 'none';

                    // Set filename as default alt text
                    altTextInput.value = file.name;
                }
                reader.readAsDataURL(file);

                // Add to image list
                addImageToList(file);
            }
        });

        // Add image to the list with remove functionality
        function addImageToList(file) {
            const imageItem = document.createElement('div');
            imageItem.className = 'flex flex-col md:flex-row gap-2 mb-3';

            // Create filename element
            const fileName = document.createElement('span');
            fileName.textContent = file.name;

            // Create remove button
            const removeBtn = document.createElement('span');
            removeBtn.className = 'remove-btn';
            removeBtn.innerHTML = '<i class="fas fa-times"></i>';
            removeBtn.title = 'Remove image';

            // Add click event to remove image
            removeBtn.addEventListener('click', function() {
                // Remove from DOM
                imageItem.remove();

                // Clear preview if this was the last image
                if (imageNameContainer.children.length === 0) {
                    preview.style.display = 'none';
                    defaultIcon.style.display = 'block';
                    defaultText.style.display = 'block';
                    altTextInput.value = '';
                }
            });

            // Add click event to show this image in preview
            imageItem.addEventListener('click', function(e) {
                if (e.target !== removeBtn && !removeBtn.contains(e.target)) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        preview.src = e.target.result;
                        preview.style.display = 'block';
                        defaultIcon.style.display = 'none';
                        defaultText.style.display = 'none';
                        altTextInput.value = file.name;
                    };
                    reader.readAsDataURL(file);
                }
            });

            // Assemble the element
            const nameContainer = document.createElement('div');
            nameContainer.className = 'image-name';
            nameContainer.appendChild(fileName);

            imageItem.appendChild(nameContainer);
            imageItem.appendChild(removeBtn);

            // Add to container
            imageNameContainer.appendChild(imageItem);
        }

        // Update alt text when input changes
        altTextInput.addEventListener('input', function() {
            preview.alt = this.value || 'Image preview';
        });
    });
</script>