@extends('admin::layouts.app')

@section('title', 'Tax Management')

@section('content')
   @include('admin::components.common.back-button', ['route' => route('admin.settings.taxes.index'), 'name' => 'Tax Management'])
   <x-data-view :data="$lists" title="" url="" />
@endsection

