@extends('admin::layouts.app')

@section('title', 'Currency Management')

@section('content')
   @include('admin::components.common.back-button', ['route' => route('admin.settings.index'), 'name' => 'Currency Management'])
   <x-data-view :data="$lists" title="" url="" />
@endsection

