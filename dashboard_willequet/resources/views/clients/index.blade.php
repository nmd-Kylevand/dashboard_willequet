<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Klanten') }}
        </h2>
    </x-slot>
    <div>
       @include('clients.partials.create-client-form')
    </div>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <table class="table-auto w-full">
                        <thead>
                          <tr>
                            <th>Naam</th>
                            <th>Gemiddeld aantal</th>
                            <th>Telefoon</th>
                            <th>Email</th>
                          </tr>
                        </thead>
                        <tbody>
                            @foreach ($clients as $client)
                                <tr class="py-24">
                                    <td>{{$client->name}}</td>
                                    <td>{{$client->averageAmount}}</td>
                                    <td>{{$client->telephone}}</td>
                                    <td>{{$client->email}}</td>
                                    <td>
                                      @include('clients.partials.update-client-form')
                                        
                                    </td>
                                    <td>
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
                                    <td>
                                        
                                    </td>
                                </tr>
                                
                            @endforeach
                          <tr>
                            <td>The Sliding Mr. Bones (Next Stop, Pottersville)</td>
                            <td>Malcolm Lockyer</td>
                            <td>1961</td>
                          </tr>
                          <tr>
                            <td>Witchy Woman</td>
                            <td>The Eagles</td>
                            <td>1972</td>
                          </tr>
                          <tr>
                            <td>Shining Star</td>
                            <td>Earth, Wind, and Fire</td>
                            <td>1975</td>
                          </tr>
                        </tbody>
                      </table>
                    
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
