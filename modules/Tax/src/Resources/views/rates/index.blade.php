@extends('admin::layouts.app')

@section('title', 'Tax Rules')

@section('content')
@include('admin::components.common.back-button', ['route' => route('admin.tax-category.index'), 'name' => 'Tax Rates'])

<x-data-view :data="$lists" title="" url="" />   
@endsection

