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

@section('printButton')
<x-print-button/>
{{-- <button class="bg-blue-700 hover:bg-blue-900 text-white font-bold py-2 px-4 mx-4  rounded flex" onclick="printJS({printable:'etiquet', type:'html', scanStyles: false, style:'#etiquetDetail {display: grid; padding-top: 2rem; grid-template-columns: repeat(2, minmax(0, 1fr)); width: 100%; }'})" id="button">
  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
    <path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0110.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0l.229 2.523a1.125 1.125 0 01-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0021 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 00-1.913-.247M6.34 18H5.25A2.25 2.25 0 013 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 011.913-.247m10.5 0a48.536 48.536 0 00-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5zm-3 0h.008v.008H15V10.5z" />
  </svg>
    Etiquetten
</button>  --}}

<button class="bg-blue-700 hover:bg-blue-900 text-white font-bold py-2 px-4 mx-4  rounded flex" onclick="printout('#etiquet')" id="button1">
  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
    <path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0110.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0l.229 2.523a1.125 1.125 0 01-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0021 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 00-1.913-.247M6.34 18H5.25A2.25 2.25 0 013 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 011.913-.247m10.5 0a48.536 48.536 0 00-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5zm-3 0h.008v.008H15V10.5z" />
  </svg>
    Etiquetten
</button> 
{{-- <button class="bg-blue-700 hover:bg-blue-900 text-white font-bold py-2 px-4 mx-4  rounded flex" onclick="printJS({printable:'etiquet', type:'html', targetStyles:['*'], honorColor: true})" id="button">
  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
    <path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0110.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0l.229 2.523a1.125 1.125 0 01-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0021 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 00-1.913-.247M6.34 18H5.25A2.25 2.25 0 013 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 011.913-.247m10.5 0a48.536 48.536 0 00-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5zm-3 0h.008v.008H15V10.5z" />
  </svg>
    Etiquetten
</button>  --}}

@include('orders.partials.amounts', ['clients' => $clients, 'currentDate' => request()->query('search')])
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
<tbody class="print:hidden">
    @foreach ($orderSearch as $order)
        <tr>
            <td>{{$order->name  ?? 'Add a client'}}</td>
             
                <td id="printTable">{{request()->query('search')  ?? 'Add a client'}}</td>
                <td>{{$order->clientsOrders()->sum('persons')}}</td>
                <td>{{$order->clientsOrders()->sum('totalAmount')}}</td>
               
                <td><a class="bg-blue-700 hover:bg-blue-900 text-white font-bold py-2 px-4 rounded " href="{{ url('orders/'. $order->clientsOrders[0]->pivot->ingredient_id . '-' .request()->query('search') ) }}">Detail</a></td>
                {{-- <td>@include('orders.partials.make-copy', ['order' => $order])</td> --}}
        </tr>
@endforeach
</tbody>
<ul id="lijst" class="orderDetailprint !print:inline hidden">
  @foreach ($orderSearch as $client)
  <h1 class="w-full" id="orderDetailTitle">{{$client->clientsOrders[0]->pivot->date}}: {{$client->name}}</h1>
  @foreach ($client->clientsOrders as $item)
  <li>
    <div>

    <span style="background-color: {{$item->color ?? ''}}" class="print:z-0 ">{{Str::upper($item->name) ?? ''}}</span>
    </div>
    <div class="mt-2 mr-2">
      @switch($item->pivot->cups)
      @case('1cup')
          <img class="w-4" src="{{ asset('/images/1cup.svg')}}">
          @break
      @case('2cups')
          <img class="w-4" src="{{ asset('/images/2cups.svg') }}">
          @break
      @case('2cups1small1big')
          <img class="w-4" src="{{ asset('/images/1small1big.svg') }}">
          @break
      @case('3cups')
          <img class="w-4" src="{{ asset('/images/3cups.svg') }}">
          @break
      @case('4cups')
          <img class="w-4" src="{{ asset('/images/4cups.svg') }}">
          @break
      @case('6cups')
          <img class="w-4" src="{{ asset('/images/6cups.svg') }}">
          @break
      @default
      

    @endswitch
    </div>
    <div>
      <p>totaal: {{$item->pivot->totalAmount}} {{$item->pivot->amount}}pp</span></p>
    </div>
 

  </li>
      
  @endforeach
  
  @endforeach
</ul>
<ul id="etiquet" class="orderDetailEtiq hidden">
  @foreach ($orderSearch as $client)
  <div id="etiquetDetail" class="grid grid-cols-2  w-full">
  @foreach ($client->clientsOrders as $item)
    <div class="flex flex-col w-full p-6 gap-8 ">
      <p class="text-lg">
        <span style="background-color: {{$item->color ?? ''}}" class="print:z-0 p-1">{{Str::upper($item->name) ?? ''}}</span>-{{$client->clientsOrders[0]->pivot->date}}<br/>{{$client->name}}
    </p>
    <div class="flex flex-col gap-2">
      

      <p class="md:text-base">
        {{$item->pivot->persons ?? 0}}

      </p>
    </div>
  </div>
  
  @endforeach
  <div>
  
  @endforeach
</ul>
@endsection