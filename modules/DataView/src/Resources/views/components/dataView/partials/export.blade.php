<div class="flex items-center space-x-2 px-4 py-6">
  <!-- Export format dropdown -->
  
    <select class="w-full bg-white border border-gray-300 text-gray-700 py-2 px-4 pr-8 rounded-md leading-tight">
      <option value="csv">CSV</option>
      <option value="xls">Excel</option>
      <option value="xml">XML</option>
    </select>

  <!-- Export button -->
   <x-button type="button"    
    as="a"
    href="{{ route('admin.meetings.sync') }}"
    class="blue" 
    label="<span class='material-icons-outlined mr-1'>file_upload</span>" 
    icon=''
    name="button" 
/>
</div>