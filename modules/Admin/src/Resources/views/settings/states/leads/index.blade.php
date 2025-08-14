@extends('admin::layouts.app')

@section('title', 'States')

@section('content')
@include('admin::components.common.back-button', ['route' => route('admin.settings.index'), 'name' => 'States'])
<x-data-view :data="$lists" title="" url="" />

@endsection

