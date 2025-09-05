@extends('admin::layouts.app')

@section('title', 'Users Country')

@section('content')
    @include('admin::components.common.back-button', ['route' => route('admin.settings.index'), 'name' => 'Countries'])
    <x-data-view :data="$lists" title="" url="" />
   
@endsection

