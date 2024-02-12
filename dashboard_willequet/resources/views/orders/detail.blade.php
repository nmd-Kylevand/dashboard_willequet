@extends('layouts.table-layout')
@section('title')
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{$ingredientForForm->name}}: {{request()->date}}
    </h2>
@endsection
@section('goBack')
<a href="/orders" class="bg-blue-700 hover:bg-blue-900 text-white font-bold py-2 px-4 rounded flex" id="button">
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
        <path stroke-linecap="round" stroke-linejoin="round" d="M9 15L3 9m0 0l6-6M3 9h12a6 6 0 010 12h-3" />
      </svg>
      
        Terug naar overzicht
   </a>
@endsection
@section('createForm')
@include('orders.partials.add-person-to-ingredient', ['ingredient' => $ingredientForForm, 'clients' => $clientsForForm])
<form  method="post" action="{{ route('orders.delete', ['id' => request()->id, 'date' => request()->date]);}}">
    @csrf
    @method('delete')
    <input type="text" name="ingredientId" value="{{request()->id}}" class="hidden">
    <input type="text" name="date" value="{{request()->date}}" class="hidden">

    <button id="test"  type="submit" class="print:hidden bg-red-700 hover:bg-red-900 text-white font-bold py-2 px-4 mr-5 rounded flex">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
    <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
    </svg>

          
        <p class="ml-4">Verwijder</p>
      </button>
</form>

@endsection
@section('printButton')
<x-print-button/> 

{{-- <button class="bg-blue-700 hover:bg-blue-900 text-white font-bold py-2 px-4 mx-4  rounded flex" onclick="printPage()" id="button">
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
      <path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0110.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0l.229 2.523a1.125 1.125 0 01-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0021 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 00-1.913-.247M6.34 18H5.25A2.25 2.25 0 013 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 011.913-.247m10.5 0a48.536 48.536 0 00-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5zm-3 0h.008v.008H15V10.5z" />
    </svg>
      Etiquetten
 </button> --}}
@endsection
@section('content')
    <button id="test" form="amount-form" type="submit" name="save" value="save"  class="print:hidden bg-blue-700 hover:bg-blue-900 text-white font-bold py-2 px-4 rounded flex">
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
    <tbody class="detailOrderBody print:hidden">
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
                            <input type="hidden" name="hidCflag" id="hidCflag" value="" />

                                {{-- <x-input-error class="mt-2" :messages="$errors->get('category')" /> --}}
                                <select  name="category[]" id="category"  class="category mt-1 block w-full" autofocus>
                                    <option
                                    
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
                                    <option value="1cup" data-imagesrc="{{ asset('/images/1cup.svg')}}"><div class="p-5 m-5" style="background-image:url({{ asset('/images/1cup.svg') }})">1 Bakje<div></option>
                                    <option value="2cups" data-imagesrc="{{ asset('/images/2cups.svg') }}">2 Bakjes</option>
                                    <option value="2cups1small1big" data-imagesrc="{{ asset('/images/1small1big.svg') }}">2 bakjes (1 klein - 1 groot)</option>
                                    <option value="3cups" data-imagesrc="{{ asset('/images/3cups.svg') }}">3 bakjes</option>
                                    <option value="4cups" data-imagesrc="{{ asset('/images/4cups.svg') }}">4 bakjes</option>
                                    <option value="6cups" data-imagesrc="{{ asset('/images/6cups.svg') }}">6 bakjes</option>
                                </select>   
                                @php
                                    $cups= 
                                    [
                                        [
                                            'id' => '1001',
                                            'name' => 'Adam Nsiah',
                                            'picture' => "{{ asset('/images/1cup.svg')}}"
                                        ],
                                        [
                                            'id' => '1005',
                                            'name' => 'Alfred Rowe',
                                            'picture' => "{{ asset('/images/2cups.svg') }}"
                                        ],
                                        [
                                            'id' => '1002',
                                            'name' => 'Abdul Razak Ibrahim',
                                            'picture' => "{{ asset('/images/1small1big.svg') }}"
                                        ],
                                        [
                                            'id' => '1003',
                                            'name' => 'Michael K. Ocansey',
                                            'picture' => "{{ asset('/images/3cups.svg') }}"
                                        ],
                                        [
                                            'id' => '1004',
                                            'name' => 'Michael Sarpong',
                                            'picture' => "{{ asset('/images/4cups.svg') }}"
                                        ],
                                    ]
                                @endphp
                                {{-- <x-bladewind.select
                                    name="cups"
                                    placeholder="Assign task to"
                                    labelKey="name"
                                    valueKey="id"
                                    imageKey="picture"
                                    :data="$cups" /> --}}
                                
                                    
                                    {{-- <x-bladewind.input/> --}}
                        </div> 
                    </td> 
                    
                    <td class="print:hidden">
                        

                        <button type="submit" name="delete" value="{{$client->clients_id}}" class=" bg-red-700 hover:bg-red-900 text-white font-bold py-2 px-4 mr-5 rounded flex"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                            </svg></button>
                       
                      </td>
    
            </tr>
        
        
    @endforeach
</form>
<form method="POST" id="delete-form" action="{{ route('orders.deleteById', ['id' => request()->id, 'date' => request()->date]);}}">
                {{csrf_field()}}
                <input type="hidden" name="_method" value="DELETE">
            </form>

    </tbody>
    <ul class="orderDetailprint print:inline hidden">
        @foreach ($clients as $client)
        
            <li><span style="background-color: {{$client->color ?? ''}}" class="print:z-0 ">{{Str::upper($client->name) ?? ''}}</span> <span class="numbersSpan">{{$client->cups}} totaal: {{$client->totalAmount}} {{$client->amount}}pp</span></li>
        
        @endforeach
    </ul>
@endsection
