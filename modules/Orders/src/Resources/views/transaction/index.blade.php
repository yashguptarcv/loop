@extends('admin::layouts.app')

@section('title', 'Transactions')

@section('content')
<x-data-view :data="$lists" title="Transactions" url="" />   
@endsection

