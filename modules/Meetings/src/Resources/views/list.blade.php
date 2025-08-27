@extends('admin::layouts.app')

@section('title', 'All Meetings')
@section('content')

    @include('admin::components.common.back-button', ['route' => route('admin.meetings.index'), 'name' =>  'Meetings Lists'])
    <x-data-view :data="$lists" title="" url="" is_export="true" />

@endsection

@section('styles')

@endsection