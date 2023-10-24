<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Klanten') }}
        </h2>
    </x-slot>
    <div id="clientsButtons" class="print:hidden max-w-7xl mx-auto sm:px-6 lg:px-8 mt-4 flex">
      

        <a href="/clients" class="bg-blue-700 hover:bg-blue-900 text-white font-bold py-2 px-4 rounded flex" id="button">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 15L3 9m0 0l6-6M3 9h12a6 6 0 010 12h-3" />
          </svg>
          
              Terug naar overzicht
         </a>
      
       
       @include('clients.partials.search-client-form')

    </div>
    
    <div class="print:py-0 py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 print:max-w-none print:sm:px-0 print:lg:px-0">
            <div class=" bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <table id="printTable" class="table-auto w-full  border-seperate border-spacing-y-6">
                        <thead>
                          <tr class="text-left print:hidden">
                            <th>Naam</th>
                            <th>Telefoon</th>
                            <th>Email</th>
                          </tr>
                        </thead>
                        <tbody>

                            @foreach ($clientsSearch as $client)
                                
                                <tr>
                                    <td id="printTable"><p style="background-color: {{$client->color}}" id="nameColor" class="inline-block h-6 w-6 border-2 mr-4"></p><span class="print:z-0">{{$client->name}}</span></td>
                                    <td class="print:hidden">{{$client->telephone}}</td>
                                    <td class="print:hidden">{{$client->email}}</td>
                                    <td class="print:hidden">
                                      @include('clients.partials.update-client-form')                                       
                                    </td>
                                    <td class="print:hidden">
                                      <form method="post" action="{{ route('clients.destroy', ['id' => $client->id]) }}">
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
                      </table>
                    
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
