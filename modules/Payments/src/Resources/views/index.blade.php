@extends('admin::layouts.app')

@section('title', 'Payments')

@section('content')
<x-data-view :data="$lists" title="Payments" url="" />
   
@endsection

