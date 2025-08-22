@extends('admin::layouts.app')

@section('title', 'Tax Category')

@section('content')
<x-data-view :data="$lists" title="Tax Category" url="" />   
@endsection

