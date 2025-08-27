@extends('admin::layouts.app')

@section('title', 'Pages')

@section('content')
    <x-data-view :data="$lists" title="Pages" url="" />   
@endsection

