@extends('layouts.table-layout')

@section('title')
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ __('Planning') }}
    </h2>
@endsection

@section('searchForm')
    @include('orders.partials.search-orders-form')
@endsection

@section('createForm')
    @include('orders.partials.create-order-form', ['clients' => $clients, 'ingredients' => $ingredients])
@endsection

@section('printButton')
    <x-print-button />


    <button class="bg-blue-700 hover:bg-blue-900 text-white font-bold py-2 px-4 mx-4  rounded flex"
        onclick="printout('#etiquet');" id="button1">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
            class="w-6 h-6">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0110.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0l.229 2.523a1.125 1.125 0 01-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0021 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 00-1.913-.247M6.34 18H5.25A2.25 2.25 0 013 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 011.913-.247m10.5 0a48.536 48.536 0 00-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5zm-3 0h.008v.008H15V10.5z" />
        </svg>
        Etiquetten
    </button>

    @include('orders.partials.amounts', [
        'clients' => $clientsForCreate,
        'currentDate' => request()->query('search'),
    ])
@endsection

@section('content')
    <thead>
        <tr class="text-left print:hidden">
            <th>Ingredient</th>
            <th>Datum</th>
            <th>Totaal aantal personen</th>
            <th>Totale hoeveelheid</th>
        </tr>
    </thead>
    <tbody class="print:hidden">
        @foreach ($formattedResults as $order)
            {{-- @dd($order['clients']) --}}

            @if ($order)
                <tr>
                    <td>{{ $order['ingredientName'] ?? 'Add a client' }}</td>

                    <td id="printTable">{{ date("d-m-Y", strtotime(request()->query('search'))) ?? 'Add a client' }}</td>
                    <td>{{ $order['totalPersons'] }}</td>
                    <td>{{ $order['totalAmount'] }}</td>

                    <td><a class="bg-blue-700 hover:bg-blue-900 text-white font-bold py-2 px-4 rounded "
                            href="{{ url('orders/' . $order['clients'][0]->id . '-' . request()->query('search')) }}">Detail</a>
                    </td>
                    <td>@include('orders.partials.make-copy', ['order' => $order])</td>
                </tr>
            @endif
        @endforeach
    </tbody>
    <div id="lijst" class="orderDetailprint   !print:inline hidden">
        @foreach ($formattedResults as $client)
            <h1 class="w-full" id="orderDetailTitle">{{ date("d-m-Y", strtotime(request()->query('search')))
            
             }}: {{ $client['ingredientName'] }}</h1>

            <ul>
                @foreach ($client['clients'] as $item)
                    <li>
                        <div>
                            {{ $item->persons ?? 0 }}
                            <span style="background-color: {{ $item->color ?? '' }}"
                                class="print:z-0 ">{{ Str::upper($item->name) ?? '' }}</span>
                        </div>
                        <div class="mt-2 mr-2">
                            @switch($item->cups)
                                @case('1cup')
                                    <img class="w-4" src="{{ asset('/images/1cup.svg') }}">
                                @break

                                @case('2cups')
                                    <img class="w-4" src="{{ asset('/images/2cups.svg') }}">
                                @break

                                @case('2cups1small1big')
                                    <img class="w-4" src="{{ asset('/images/1small1big.svg') }}">
                                @break

                                @case('3cups')
                                    <img class="w-4" src="{{ asset('/images/3cups.svg') }}">
                                @break

                                @case('4cups')
                                    <img class="w-4" src="{{ asset('/images/4cups.svg') }}">
                                @break

                                @case('6cups')
                                    <img class="w-4" src="{{ asset('/images/6cups.svg') }}">
                                @break

                                @default
                            @endswitch
                        </div>
                        <div>
                            <p>totaal: {{ $item->totalAmount }} - {{ number_format($item->amount, 3, '.', ',') }}pp</span>
                            </p>
                        </div>
                        @if ($item->comment)
                            <div>
                                <p> - </p>
                            </div>
                        @endif
                        <div>
                            <p>{{ $item->comment ?? '' }}</p>
                        </div>

                    </li>
                @endforeach
            </ul>
            <div style="page-break-after: always;"></div>
            <div>&nbsp;
            </div>
        @endforeach
    </div>
    
    @php
    $previousIngredient = null;
@endphp

<ul id="etiquet" class="orderDetailEtiq hidden">
    <div id="etiquetDetail" class="grid grid-cols-2">
        @foreach ($orderSearchEtiq as $index => $client)
            @if ($previousIngredient !== null && $client->ingredientName !== $previousIngredient)
                <!-- Close the previous group and start a new page/section -->
    </div>
    <div id="etiquetDetail" class="grid grid-cols-2" style="page-break-before: always;">
            @endif

            <div class="sticker flex flex-col w-full">
                <p>
                    <span style="background-color: {{ $client->color ?? '' }}"
                        class="text-base print:z-0">{{ Str::upper($client->name) ?? '' }}</span> -
                    {{ date('d-m', strtotime($client->date)) }}<br />{{ $client->ingredientName }}
                </p>
                <div>
                    <div class="flex items-center">
                        <div class="flex items-center">
                            <span class="mr-2">{{ $client->totalAmount ?? 0 }}</span>
                            @switch($client->cups)
                                @case('1cup')
                                    <img class="w-4" src="{{ asset('/images/1cup.svg') }}">
                                    @break
                                @case('2cups')
                                    <img class="w-4" src="{{ asset('/images/2cups.svg') }}">
                                    @break
                                @case('2cups1small1big')
                                    <img class="w-4" src="{{ asset('/images/1small1big.svg') }}">
                                    @break
                                @case('3cups')
                                    <img class="w-4" src="{{ asset('/images/3cups.svg') }}">
                                    @break
                                @case('4cups')
                                    <img class="w-4" src="{{ asset('/images/4cups.svg') }}">
                                    @break
                                @case('6cups')
                                    <img class="w-4" src="{{ asset('/images/6cups.svg') }}">
                                    @break
                                @default
                                    <!-- No image -->
                            @endswitch
                            <p class="ml-12" style="font-size: 12px">
                                <span class="bg-yellow-200">{{ $client->comment }}</span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            @php
                $previousIngredient = $client->ingredientName;
            @endphp
        @endforeach
    </div>
</ul>

   @endsection