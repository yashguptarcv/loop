@extends('admin::layouts.app')

@section('title', 'All Meetings')
@section('content')

    @include('admin::components.common.back-button', ['route' => route('admin.meetings.index'), 'name' =>  'Meetings Lists'])

    <x-data-view :data="$lists" title="" url="" is_export="true" />

@endsection

@section('styles')
<style>
    .event-dot {
        width: 10px;
        height: 10px;
        border-radius: 50%;
        display: inline-block;
        margin-right: 6px;
    }
</style>
@endsection