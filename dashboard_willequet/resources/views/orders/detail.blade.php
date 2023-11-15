@extends('layouts.table-layout')
@section('createForm')
<button form="amount-form" type="submit"  class="bg-blue-700 hover:bg-blue-900 text-white font-bold py-2 px-4 rounded flex">
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
        <path stroke-linecap="round" stroke-linejoin="round" d="M19 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zM4 19.235v-.11a6.375 6.375 0 0112.75 0v.109A12.318 12.318 0 0110.374 21c-2.331 0-4.512-.645-6.374-1.766z" />
    </svg>
    <p class="ml-4">Opslaan</p>
  </button>
@endsection

    @section('content')
    <thead>
    <tr class="text-left print:hidden">
        <th>Naam</th>
        <th>Aantal per persoon</th>
        <th>Aantal personen</th>
        <th>Totaal aantal</th>
        <th>Bakjes</th>
    </tr>
    </thead>
    <tbody>
        
        @foreach ($clients as $item)
        {{$item}}
        <td id="printTable">
                <p style="background-color: {{$item->clients[0]->color ?? ''}}" id="nameColor" class="inline-block h-6 w-6 border-2 mr-4"></p><span class="print:z-0">{{$item->clients[0]->name ?? ''}}</span>
            
        </td>
        <td id="printTable">
            <form id="amount-form"  method="post" action="{{ route('orders.save', request()->id)}}">
                @csrf
                @method('post')
                @include('orders.partials.add-person', ['data' =>$item])
            </form>
        </td>
        <td>{{$item->clientsOrders[0]->pivot->persons}}</td>
        <td>{{$item->clientsOrders[0]->pivot->totalAmount}}</td>
        <td>{{$item->clientsOrders[0]->pivot->cups}}</td>
    @endforeach


    </tbody>
    @endsection
