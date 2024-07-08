@extends('layouts.table-layout')
@section('title')
<h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
    {{ __($client->name) }}
</h2>
    
@endsection
@section('goBack')
<a href="/amounts" class="bg-blue-700 hover:bg-blue-900 text-white font-bold py-2 px-4 rounded flex" id="button">
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
      <path stroke-linecap="round" stroke-linejoin="round" d="M9 15L3 9m0 0l6-6M3 9h12a6 6 0 010 12h-3" />
    </svg>
    
        Terug naar overzicht
   </a>
@endsection
@section('searchForm')
  @include('amounts.partials.search-amount-form', [
    'clientId' => request()->id
  ])

@endsection
@section('content')
<thead>
  <tr class="print:hidden">
    <th class="text-left">Ingredient</th>
  </tr>
</thead>
<tbody>
   @foreach ($allIngredients as $igr)
   <tr>
    <td class="print:hidden ">{{$igr->name}}</td>
    
    </td>
    <td class="print:hidden ">
         <form  method="post" action="{{ route('amounts.assign')}}">
                @csrf
                @method('post')
                <div>
                    <x-text-input id="amount" name="ingredientId" type="number" class="hidden" :value="$igr->id"/>
                </div>
                <div>
                    <x-text-input id="amount" name="clientId" type="number" class="hidden" :value="$client->id"/>
                </div>
                <div>
                    <x-input-label for="comment" :value="__('Commentaar')" />
                    <x-text-input id="comment" name="comment" type="text" class="mt-1 block w-full" :value="$igr->pivot->comment ?? '' "  autofocus autocomplete="name" />
                    <x-input-error class="mt-2" :messages="$errors->get('comment')" />
                </div>
                <div class="mt-5">
                    <x-input-label for="amount" :value="__('Hoeveelheid')" />
                    <div class="flex">
                    <input name="amount"  type="number" step="any"  class="mt-1 block mr-10 !w-2/4 border-gray-300  focus:border-indigo-500 focus:ring-indigo-500  rounded-md shadow-sm" value="{{$igr->pivot->amount ?? ""}}" >

                    {{-- <x-text-input id="amount"  step="any" name="amount"  type="number" class="mt-1 block !w-2/4 " :value="$assignedIngredient->pivot->amount"  autofocus autocomplete="amount" /> --}}
                    <x-input-error class="mt-2" :messages="$errors->get('amount')" />
                    <button  class="bg-blue-700 hover:bg-blue-900 text-white font-bold py-2 px-4 rounded">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                          </svg>
                          
                        
                    </button>
                    </div>
                    
                </div>       
            </form>                                    
    </td>
    
</tr> 
   @endforeach
    
     <div class="mb-5">
        {{$allIngredients->links()}}
    
      </div>
</tbody>
@endsection