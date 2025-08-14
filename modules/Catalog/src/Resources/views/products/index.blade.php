@extends('admin::layouts.app')

@section('title', 'Catalog | Products')

@section('content')
   <x-data-view :data="$lists" title="Products" url="" />
@endsection