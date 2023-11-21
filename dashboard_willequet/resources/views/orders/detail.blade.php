@extends('layouts.table-layout')
@section('title')
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{$ingredientForForm->name}}: {{request()->date}}
    </h2>
@endsection
@section('goBack')
<a href="{{ url()->previous() }}" class="bg-blue-700 hover:bg-blue-900 text-white font-bold py-2 px-4 rounded flex" id="button">
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
      <path stroke-linecap="round" stroke-linejoin="round" d="M9 15L3 9m0 0l6-6M3 9h12a6 6 0 010 12h-3" />
    </svg>
    
        Terug naar overzicht
   </a>
@endsection
@section('createForm')
@include('orders.partials.add-person-to-ingredient', ['ingredient' => $ingredientForForm, 'clients' => $clientsForForm])


@endsection
@section('printButton')
<x-print-button/>
@endsection
@section('content')
    <button id="test" form="amount-form" type="submit"  class="print:hidden bg-blue-700 hover:bg-blue-900 text-white font-bold py-2 px-4 rounded flex">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M11.35 3.836c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m8.9-4.414c.376.023.75.05 1.124.08 1.131.094 1.976 1.057 1.976 2.192V16.5A2.25 2.25 0 0118 18.75h-2.25m-7.5-10.5H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V18.75m-7.5-10.5h6.375c.621 0 1.125.504 1.125 1.125v9.375m-8.25-3l1.5 1.5 3-3.75" />
          </svg>
          
        <p class="ml-4">Aanpassingen opslaan</p>
      </button>
    <h1 id="orderDetailTitle" class="hidden">{{request()->date}}: {{$ingredientForForm->name}}</h1>
    <thead>
    <tr class=" print:hidden">
        <th>Naam</th>
        <th>Aantal per persoon</th>
        <th>Aantal personen</th>
        <th>Totaal aantal</th>
        <th>Bakjes</th>
    </tr>
    </thead>
    <tbody>
        <form id="amount-form"  method="post" action="{{ route('orders.save', ['id' => request()->id, 'date' => request()->date]);}}">
        @foreach ($clients as $client)

            <tr>
                <td id="printTable">
                   <p style="background-color: {{$client->color ?? ''}}" id="nameColor" class="inline-block h-6 w-6 border-2 mr-4"></p><span class="print:z-0">{{$client->name ?? ''}}</span>
                </td>
                    <td>{{$client->amount ?? ""}}</td>
                        <td id="printTable">
                            @csrf
                            @method('post')
                            @include('orders.partials.add-person', ['data' =>$client, 'amountPerPerson' => $client->amount ?? ''])
                    </td> 
                    <td class="text-end">{{$client->totalAmount}}</td>
                    <td>
                        <div>
                                <x-input-error class="mt-2" :messages="$errors->get('category')" />
                                <select form="amount-form" data-child-height=150 name="category[]" id="category" class="category mt-1 block w-full" is="ms-dropdown" autofocus>
                                    <option
                                    @switch($client->cups)
                                        @case('1cup')
                                            data-image="{{ asset('/images/1cup.svg') }}"
                                            @break
                                        @case('2cups')
                                            data-image="{{ asset('/images/2cups.svg') }}"
                                            @break
                                        @case('2cups1small1big')
                                            data-image="{{ asset('/images/1small1big.svg') }}"
                                            @break
                                        @case('3cups')
                                            data-image="{{ asset('/images/3cups.svg') }}"
                                            @break
                                        @case('4cups')
                                            data-image="{{ asset('/images/4cups.svg') }}"
                                            @break
                                        @case('6cups')
                                            data-image="{{ asset('/images/6cups.svg') }}"
                                            @break
                                        @default
                                    @endswitch
                                    value="{{$client->cups}}" selected>@switch($client->cups)
                                        @case('1cup')
                                            1 Bakje
                                            @break
                                        @case('2cups')
                                            2 Bakjes
                                            @break
                                        @case('2cups1small1big')
                                            3 Bakjes
                                            @break
                                        @case('3cups')
                                            3 Bakjes
                                            @break
                                        @case('4cups')
                                            4 Bakjes
                                            @break
                                        @case('6cups')
                                            6 Bakjes
                                            @break
                                        @default
                                        Kies bakjes

                                    @endswitch</option>
                                    <option value="1cup" data-image="{{ asset('/images/1cup.svg') }}">1 Bakje </option>
                                    <option value="2cups" data-image="{{ asset('/images/2cups.svg') }}">2 Bakjes</option>
                                    <option value="2cups1small1big" data-image="{{ asset('/images/1small1big.svg') }}">2 bakjes (1 klein - 1 groot)</option>
                                    <option value="3cups" data-image="{{ asset('/images/3cups.svg') }}">3 bakjes</option>
                                    <option value="4cups" data-image="{{ asset('/images/4cups.svg') }}">4 bakjes</option>
                                    <option value="6cups" data-image="{{ asset('/images/6cups.svg') }}">6 bakjes</option>
                                </select>   
                            
                        </div> 
                    </td> 
                    
                    {{-- <td class="print:hidden">
                        <a style="color:black" href="{{ route('orders.delete', ['id' => $client->id, 'date' => $client->pivot->date]) }}">
                            delete
                        </a>
                      </td> --}}
    
            </tr>
        
        
    @endforeach
</form>


    </tbody>
    @endsection
