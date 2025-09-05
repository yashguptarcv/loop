@extends('admin::layouts.app')

@section('title', 'Order Statuses')

@section('content')
@include('admin::components.common.back-button', ['route' => route('admin.settings.index'), 'name' => 'Order Statuses'])
<x-data-view :data="$lists" title="" url="" />

@endsection

