@extends('admin::layouts.app')

@section('title', 'Discounts')

@section('content')
<x-data-view :data="$lists" title="Discounts" url="" />   
@endsection

