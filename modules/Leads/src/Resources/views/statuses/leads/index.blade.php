@extends('admin::layouts.app')

@section('title', 'Lead Statuses')

@section('content')
@include('admin::components.common.back-button', ['route' => route('admin.settings.index'), 'name' => 'Lead Statuses'])
<x-data-view :data="$lists" title="" url="" />
   
@endsection

