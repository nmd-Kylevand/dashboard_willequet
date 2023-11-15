@extends('layouts.table-layout')
@section('title')
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ __('Ingrediënten') }}
    </h2>
@endsection
@section('createForm')
  @include('ingredients.partials.create-ingredient-form')
@endsection
@section('printButton')
<x-print-button/>
@endsection
@section('searchForm')
  @include('ingredients.partials.search-ingredient-form')
@endsection
@section('content')

<thead>
    <tr class="text-left print:hidden">
      <th>Naam</th>
      <th>Verlies</th>
    </tr>
  </thead>
  <tbody>
      @foreach ($ingredients as $ingredient)
          <tr>
              <td id="printTable"><span class="print:z-0">{{$ingredient->name}}</span></td>
              <td class="print:hidden">{{$ingredient->loss}}</td>
              <td class="print:hidden">
                @include('ingredients.partials.update-ingredient-form')                                       
              </td>
              <td class="print:hidden">
                <x-delete-modal :data=$ingredient>
                </x-delete-modal>
                
              </td>
          </tr>
      @endforeach
  </tbody>
@endsection