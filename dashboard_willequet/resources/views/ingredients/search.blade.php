@extends('layouts.search-table-layout')
@section('searchTitle')
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ __('Ingrediënten') }}
    </h2>
@endsection
@section('goBack')
<a href="/ingredients" class="bg-blue-700 hover:bg-blue-900 text-white font-bold py-2 px-4 rounded flex" id="button">
  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
    <path stroke-linecap="round" stroke-linejoin="round" d="M9 15L3 9m0 0l6-6M3 9h12a6 6 0 010 12h-3" />
  </svg>
  
      Terug naar overzicht
 </a>
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

  @foreach ($ingredientSearch as $ingredient)
  <tr>
      <td id="printTable"><span class="print:z-0">{{$ingredient->name}}</span></td>
      <td class="print:hidden">{{$ingredient->loss}}</td>
      <td class="print:hidden">
        @include('ingredients.partials.update-ingredient-form')                                       
      </td>
      <td class="print:hidden">
        <form method="post" action="{{ route('ingredients.destroy', ['id' => $ingredient->id]) }}">
              @csrf
              @method('delete')
              <button class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                    </svg>
                </button>
          </form>
      </td>
  </tr>
@endforeach
</tbody>
@endsection