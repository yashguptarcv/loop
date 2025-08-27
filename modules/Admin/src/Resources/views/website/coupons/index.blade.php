@extends('admin::layouts.app')

@section('title', 'Coupons')

@section('content')
    <x-data-view :data="$lists" title="Coupons" url="" />   
@endsection

