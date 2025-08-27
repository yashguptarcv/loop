@extends('admin::layouts.app')

@section('title', 'Catalog | Categories')

@section('content')
   <x-data-view :data="$lists" title="Categories" url="" />
@endsection