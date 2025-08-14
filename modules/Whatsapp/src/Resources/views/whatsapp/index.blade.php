@extends('admin::layouts.app')

@section('title', 'Whatsapp Templates')

@section('content')
<x-data-view :data="$lists" title="Whatsapp Templates" url="" />   
@endsection

