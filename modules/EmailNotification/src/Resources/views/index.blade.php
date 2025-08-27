@extends('admin::layouts.app')

@section('title', 'Email Templates')

@section('content')
<x-data-view :data="$lists" title="Email Templates" url="" />   
@endsection

