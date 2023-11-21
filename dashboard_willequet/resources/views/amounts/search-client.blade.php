@extends('layouts.search-table-layout')
@section('searchTitle')
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
      {{ __('Aantallen') }}
    </h2>
@endsection
@section('goBack')
<a href="/amounts" class="bg-blue-700 hover:bg-blue-900 text-white font-bold py-2 px-4 rounded flex" id="button">
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
      <path stroke-linecap="round" stroke-linejoin="round" d="M9 15L3 9m0 0l6-6M3 9h12a6 6 0 010 12h-3" />
    </svg>
    
        Terug naar klanten
   </a>
@endsection
@section('searchForm')
  @include('amounts.partials.search-amount-client-form')


@endsection
@section('content')
<thead>
  <tr class="print:hidden">
    <th>Naam</th>
  </tr>
</thead>
<tbody>
   
    @foreach ($clientSearch as $client)
    <tr class="cursor-pointer hover:bg-slate-400">

        <td id="printTable"><a href="{{ url('amounts/'. $client->id) }}"><p style="background-color: {{$client->color}}" id="nameColor" class="inline-block h-6 w-6 border-2 mr-4"></p><span class="print:z-0">{{$client->name}}</span></a></td>
    </tr>

     @endforeach
</tbody>
@endsection