@extends('admin::layouts.app')

@section('title', 'Channels Logs')

@section('content')
   @include('admin::components.common.back-button', ['route' => route('admin.settings.index'), 'name' => 'Channels Logs'])
   <x-data-view :data="$lists" title="" url="" />
@endsection