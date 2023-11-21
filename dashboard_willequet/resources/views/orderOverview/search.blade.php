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
    @foreach ($orderOverview as $order)
    <tr>
        <td>{{$firstdayOfWeek}}</td>
        <td>{{$order->name}}</td>
        <td>{{$order->loss ?? 0}}</td>
        <td>{{$order->totalAmount}}</td>
        <td>
            @if($order->loss)
                {{$order->totalAmount + $order->totalAmount*($order->loss/100)}}
            @else
                {{$order->totalAmount}}
            @endif
        </td>
    </tr>
    @endforeach
  </tbody>
@endsection
