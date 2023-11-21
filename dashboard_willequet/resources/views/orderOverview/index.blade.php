@extends('layouts.table-layout')
@section('title')
<h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
    {{ __('Besteloverzicht') }}
</h2>
@endsection
@section('searchForm')
  @include('orderOverview.partials.search-orders-form')
@endsection
@section('content')
<thead>
    <tr class="text-left print:hidden">
      <th>Week</th>
      <th>Ingredient</th>
      <th>Verlies (%)</th>
      <th>Totale hoeveelheid</th>
      <th>Bestelhoeveelheid</th>
    </tr>
  </thead>
  <tbody>
     
  </tbody>
@endsection
