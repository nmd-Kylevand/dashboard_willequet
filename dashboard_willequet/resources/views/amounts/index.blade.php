@extends('layouts.table-layout')
@section('title')
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ __('Aantallen') }}
    </h2>
@endsection

@section('searchForm')
  @include('amounts.partials.search-amount-client-form')

@endsection
@section('content')
<thead>
  <tr class="text-left print:hidden">
    <th>Naam</th>
    
  </tr>
</thead>
<tbody>
    @foreach ($clients as $client)
          <tr class="cursor-pointer hover:bg-slate-400">

              <td id="printTable"><a href="{{ url('amounts/'. $client->id) }}"><p style="background-color: {{$client->color}}" id="nameColor" class="inline-block h-6 w-6 border-2 mr-4"></p><span class="print:z-0">{{$client->name}}</span></a></td>
          

          </tr>
    
    @endforeach
    {{-- @foreach ($amounts as $amount)
    {{$amount->name}}
    @foreach ( $amount->ingredients as $ingredients )
        {{ $ingredients->name }}
    @endforeach --}}
        {{-- <tr>
            <td id="printTable"><p style="background-color: {{$client->color}}" id="nameColor" class="inline-block h-6 w-6 border-2 mr-4"></p><span class="print:z-0">{{$client->name}}</span></td>
            <td class="print:hidden">{{$client->telephone}}</td>
            <td class="print:hidden">{{$client->email}}</td>
            <td class="print:hidden">
              @include('clients.partials.update-client-form')                                       
            </td>
            <td class="print:hidden">
              <x-delete-modal :data=$client>
              </x-delete-modal>
            </td>
        </tr> --}}
    {{-- @endforeach --}}
</tbody>
@endsection