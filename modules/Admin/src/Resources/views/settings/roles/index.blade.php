@extends('admin::layouts.app')

@section('title', 'Roles Management')

@section('content')
   <x-data-view :data="$lists" title="Roles Management" url="" />
@endsection