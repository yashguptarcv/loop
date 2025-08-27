@extends('admin::layouts.app')

@section('title', 'Customers')

@section('content')
<x-data-view :data="$lists" title="Customers" url="" />   
@endsection

