@extends('admin::layouts.app')

@section('title', 'Orders')

@section('content')
<x-data-view :data="$lists" title="Orders" url="" />   
@endsection

