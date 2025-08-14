@extends('admin::layouts.app')

@section('title', 'Roles Management')

@section('content')
   @include('admin::components.common.back-button', ['route' => route('admin.settings.index'), 'name' => 'Roles Management'])
   <x-data-view :data="$lists" title="" url="" />
@endsection