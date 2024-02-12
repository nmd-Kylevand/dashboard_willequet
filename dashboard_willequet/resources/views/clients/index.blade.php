@extends('layouts.table-layout')
@section('title')
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ __('Klanten') }}
    </h2>
@endsection
@section('createForm')
  @include('clients.partials.create-client-form')
@endsection
@section('printButton')
<x-print-button/>
@endsection
@section('searchForm')
  @include('clients.partials.search-client-form')

@endsection
@section('content')
<thead>
  <tr class="text-left print:hidden">
    <th>Naam</th>
    <th>Categorie</th>
    <th>Telefoon</th>
    <th>Email</th>
  </tr>
</thead>
<tbody>
    @foreach ($clients as $client)
        <tr>
            <td id="printTable"><p style="background-color: {{$client->color}}" id="nameColor" class="inline-block h-6 w-6 border-2 mr-4"></p><span class="print:z-0">{{$client->name}}</span></td>
            <td class="print:hidden">{{$client->category}}</td>
            <td class="print:hidden">{{$client->telephone}}</td>
            <td class="print:hidden">{{$client->email}}</td>
            <td class="print:hidden">
              @include('clients.partials.update-client-form')                                       
            </td>
            <td class="print:hidden">
              <x-delete-modal :data=$client>
              </x-delete-modal>
            </td>
        </tr>
    @endforeach
    <div class="mb-5">
      {{$clients->links()}}
    
    </div>
</tbody>

@endsection
