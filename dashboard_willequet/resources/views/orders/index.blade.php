@extends('layouts.table-layout')
@section('title')
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ __('Planning') }}
    </h2>
@endsection
@section('createForm')
    @include('orders.partials.create-order-form', ['clients' => $clients, 'ingredients' => $ingredients])
@endsection
@section('searchForm')
  @include('orders.partials.search-orders-form')
@endsection
