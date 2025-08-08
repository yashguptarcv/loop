@extends('admin::layouts.app')

@section('title', 'User Management')

@section('content')
<x-data-view :data="$lists" title="User Management" url="" />
   
@endsection

