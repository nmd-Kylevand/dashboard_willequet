@extends('layouts.table-layout')
@section('title')
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ __('Planning') }}
    </h2>
@endsection
@section('searchForm')
  @include('orders.partials.search-orders-form')
@endsection
@section('createForm')
    @include('orders.partials.create-order-form', ['clients' => $clients, 'ingredients' => $ingredients])
@endsection

@section('content')
<thead>
  <tr class="text-left print:hidden">
    <th>Ingredient</th>
    <th>Datum</th>
    <th>Totaal aantal personen</th>
    <th>Totale hoeveelheid</th>
    <th>Bestelhoeveelheid</th>
  </tr>
</thead>
<tbody>
    @foreach ($orderSearch as $order)
        <tr>
            <td>{{$order->name  ?? 'Add a client'}}</td>
             
                <td id="printTable">{{request()->query('search')  ?? 'Add a client'}}</td>
                <td>{{$order->clientsOrders()->sum('persons')}}</td>
                <td>{{$order->clientsOrders()->sum('totalAmount')}}</td>
               
                <td><a class="bg-blue-700 hover:bg-blue-900 text-white font-bold py-2 px-4 rounded " href="{{ url('orders/'. $order->clientsOrders[0]->pivot->ingredient_id . '-' .request()->query('search') ) }}">Detail</a></td>
                <td>@include('orders.partials.make-copy', ['order' => $order])</td>
        </tr>
            

        
        
@endforeach

</tbody>
@endsection