@extends('admin::layouts.app')

@section('title', 'Meeting Details')
@section('content')

    @include('admin::components.common.back-button', ['route' => route('admin.meetings.index'), 'name' =>  'Meetings Details'])

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex items-center">
                <span class="event-dot" style="background-color: {{ $meeting->color ?? '#3b82f6' }}"></span>
                <h2 class="text-xl font-semibold text-gray-800 ml-2">{{ $meeting->title }}</h2>
            </div>
        </div>
        
        <div class="px-6 py-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Details</h3>
                    <div class="space-y-4">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Date</p>
                            <p class="mt-1 text-sm text-gray-900">{{ $meeting->start_time->format('l, F j, Y') }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Time</p>
                            <p class="mt-1 text-sm text-gray-900">
                                {{ $meeting->start_time->format('g:i A') }} - {{ $meeting->end_time->format('g:i A') }}
                                ({{ $meeting->start_time->diffInHours($meeting->end_time) }} hours)
                            </p>
                        </div>
                        @if($meeting->location)
                        <div>
                            <p class="text-sm font-medium text-gray-500">Location</p>
                            <p class="mt-1 text-sm text-gray-900">{{ $meeting->location }}</p>
                        </div>
                        @endif
                    </div>
                </div>
                
                <div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Description</h3>
                    <div class="prose max-w-none text-sm text-gray-900">
                        {!! nl2br(e($meeting->description)) ?? '<span class="text-gray-400">No description</span>' !!}
                    </div>
                </div>
            </div>
        </div>
        
        <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex justify-end">
            <form action="{{ route('admin.meetings.destroy', $meeting->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-4 py-2 bg-red-600 text-white-200 rounded-md hover:bg-red-700" 
                        onclick="return confirm('Are you sure you want to delete this meeting?')">
                    Delete Meeting
                </button>
            </form>
        </div>
    </div>

@endsection

@section('styles')
<style>
    .event-dot {
        width: 12px;
        height: 12px;
        border-radius: 50%;
        display: inline-block;
    }
</style>
@endsection