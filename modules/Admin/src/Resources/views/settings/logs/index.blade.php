@extends('admin::layouts.app')

@section('title', 'Logs')

@section('content')
@include('admin::components.common.back-button', ['route' => route('admin.settings.index'), 'name' => 'Logs'])
<x-data-view :data="$lists" title="" url="" />
   
@endsection

