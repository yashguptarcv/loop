@extends('admin::layouts.app')

@section('title', 'My Meetings')
@section('styles')

@endsection
@section('content')

    <!-- Calendar Header -->
    <div class="flex items-center justify-between mb-6">
        <div class="flex items-center space-x-4">
            <h1 class="text-2xl font-bold text-gray-800">Meetings Calendar</h1>
            <button class="px-3 py-1 bg-blue-100 text-blue-600 rounded-md hover:bg-blue-200 transition">
                Today
            </button>
            <div class="flex items-center space-x-2">
                <button class="p-1 rounded-full hover:bg-gray-200">
                    <i class="fas fa-chevron-left text-gray-600"></i>
                </button>
                <span class="text-lg font-medium text-gray-700" id="monthDisplay">{{ now()->format('M, Y') }}</span>
                <button class="p-1 rounded-full hover:bg-gray-200">
                    <i class="fas fa-chevron-right text-gray-600"></i>
                </button>
            </div>
        </div>

        <div class="flex items-center space-x-2">     
            @if(auth('admin')->user()->google_access_token)
                <x-button type="button"    
                    as="a"
                    href="#"
                    class="blue" 
                    label="Connected" 
                    icon=''
                    name="button" 
                />
            @else
                <x-button type="button"    
                    as="a"
                    href="{{ route('admin.meetings.google.oauth') }}"
                    class="green" 
                    label="Connect" 
                    icon=''
                    name="button" 
                />
            @endif

            @if(bouncer()->hasPermission('admin.meetings.new-meeting'))
            <!-- Add Meeting Modal Trigger -->

            <x-modal 
                buttonText='New Meeting'
                modalTitle="New Meeting"
                id='new-meeting'
                ajaxUrl="{{route('admin.meetings.new-meeting')}}"
                color="blue"
                modalSize="lg"
            />
            @endif

            @if(bouncer()->hasPermission('admin.meetings.sync'))
                <x-button type="button"    
                    as="a"
                    href="{{ route('admin.meetings.sync') }}"
                    class="green" 
                    label="<span class='material-icons-outlined mr-1'>history</span>" 
                    icon=''
                    name="button" 
                />
            @endif
            
            @if(bouncer()->hasPermission('admin.meetings.share-calander'))
            <!-- Public Share Button -->
            <x-modal 
                buttonText="<span class='material-icons-outlined mr-1'>share</span>"
                modalTitle="Share Your Calendar"
                id='share_calender'
                ajaxUrl="{{route('admin.meetings.share-calander')}}"
                color="purple"
                modalSize="lg"
            />
            @endif
            
        </div>
    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <!-- Day Names -->
        <div class="grid grid-cols-7 border-b">
            @foreach(['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'] as $day)
                <div class="py-2 text-center text-sm font-medium text-gray-500">{{ $day }}</div>
            @endforeach
        </div>

        <!-- Calendar Days -->
        <div class="grid grid-cols-7 divide-x divide-y divide-gray-200" id="meetings_calendar"></div>

    </div>

@endsection
@section('scripts')
<script>
@if(bouncer()->hasPermission('admin.meetings.my-meeting'))
$(document).ready(function() {
    let currentMonth = "{{ now()->format('m') }}";
    let currentYear = "{{ now()->format('Y') }}";

    // Load calendar on page load
    loadCalendar(currentMonth, currentYear);

    // Previous month button
    $('.fa-chevron-left').closest('button').on('click', function() {
        currentMonth--;
        if (currentMonth < 1) {
            currentMonth = 12;
            currentYear--;
        }
        loadCalendar(currentMonth, currentYear);
    });

    // Next month button
    $('.fa-chevron-right').closest('button').on('click', function() {
        currentMonth++;
        if (currentMonth > 12) {
            currentMonth = 1;
            currentYear++;
        }
        loadCalendar(currentMonth, currentYear);
    });

    // Today button
    $('button:contains("Today")').on('click', function() {
        const today = new Date();
        currentMonth = today.getMonth() + 1;
        currentYear = today.getFullYear();
        loadCalendar(currentMonth, currentYear);
    });

    function loadCalendar(month, year) {
        
        ceAjax('get', '{{ route("admin.meetings.my-meeting") }}', {
            loader:true,
            data: {
                month: parseInt(month),
                year: parseInt(year)
            },
            result_ids: 'meetings_calendar,monthDisplay', // This will update the calendar container directly
            caching: false,
            beforeSend: function() {
                // Add loading indicator
                $('#meetings_calendar').html('<div class="col-span-7 py-8 text-center">Loading calendar...</div>');
            },
            errorCallback: function(xhr) {
                $('#meetings_calendara').html('<div class="col-span-7 py-8 text-center text-red-500">Error loading calendar data</div>');
            }
        });
    }
});
@endif
</script>
@endsection