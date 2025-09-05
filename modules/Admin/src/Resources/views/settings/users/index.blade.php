@extends('admin::layouts.app')

@section('title', 'User Management')

@section('content')
@include('admin::components.common.back-button', ['route' => route('admin.settings.index'), 'name' => 'User Management'])
<x-data-view :data="$lists" title="" url="" />
   
@endsection

