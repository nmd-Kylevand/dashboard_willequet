@extends('layouts.search-table-layout')
@section('searchTitle')
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
      {{ __($client->name) }}
    </h2>
@endsection
@section('goBack')
<a href="/amounts/{{$client->id}}" class="bg-blue-700 hover:bg-blue-900 text-white font-bold py-2 px-4 rounded flex" id="button">
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
      <path stroke-linecap="round" stroke-linejoin="round" d="M9 15L3 9m0 0l6-6M3 9h12a6 6 0 010 12h-3" />
    </svg>
    
        Terug naar klantoverzicht
   </a>
@endsection
@section('searchForm')
  @include('amounts.partials.search-amount-form', [
    'clientId' => $client->id
  ])


@endsection
@section('content')
<thead>
  <tr class="print:hidden">
    <th class="text-left" >Ingredient</th>
    <th class="text-end">Hoeveelheid per persoon</th>
  </tr>
</thead>
<tbody>
   
    @foreach ($ingredientSearch as $ingredient)
        <tr>
            <td class="print:hidden ">{{$ingredient->name}}</td>
            <td class="print:hidden ">
                 <form  method="post" action="{{ route('amounts.assign')}}">
                        @csrf
                        @method('post')
                        <div>
                            <x-text-input id="amount" name="ingredientId" type="number" class="hidden" :value="$ingredient->id"/>
                        </div>
                        <div>
                            <x-text-input id="amount" name="clientId" type="number" class="hidden" :value="$client->id"/>
                        </div>

                        <div class="justify-end  flex	">
                            <x-text-input id="amount" min="0.001" step="0.001" name="amount"  type="number" class="mt-1 block w-1/4 mr-5" :value="old('amount')"  autofocus autocomplete="amount" />
                            <x-input-error class="mt-2" :messages="$errors->get('amount')" />
                            <button  class="bg-blue-700 hover:bg-blue-900 text-white font-bold py-2 px-4 rounded">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                                  </svg>
                                  
                                
                            </button>
                        </div>       
                    </form>                                    
            </td>
            
        </tr> 
     @endforeach
</tbody>
@endsection