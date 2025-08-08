@extends('admin::layouts.app')

@section('title', 'Admin Users')

@section('content')
<x-data-view :data="$lists" title="Lead Statuses" url="" />
   
@endsection

