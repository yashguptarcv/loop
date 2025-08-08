@extends('admin::layouts.app')

@section('title', 'Lead Statuses')

@section('content')
<x-data-view :data="$lists" title="Lead Statuses" url="" />
   
@endsection

