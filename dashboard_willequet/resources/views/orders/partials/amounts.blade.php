
<!-- Modal toggle -->

<button data-modal-target="findAmount" data-modal-toggle="findAmount" class="bg-blue-700 hover:bg-blue-900 text-white font-bold py-2 px-4 rounded flex mx-4 ">
    
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
      </svg>
      
    <p class="ml-4">Zoek op klant</p>
  </button>
  <!-- Main modal -->
  <div id="findAmount" data-modal-backdrop="static" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
      <div class="relative w-full max-w-2xl max-h-full">
          <!-- Modal content -->
          <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
              <!-- Modal header -->
              <div class="flex items-start justify-between p-4 border-b rounded-t dark:border-gray-600">
                  <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                      Vind alle aantallen van een klant en zijn ingrediënten
                  </h3>
                  <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="createModal">
                      <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                          <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                      </svg>
                      <span class="sr-only">Close modal</span>
                  </button>
              </div>
              <!-- Modal body -->
              <div class="p-6 space-y-6">
                <form action="{{ route('orders.searchAmounts') }}" method="get">
                    @csrf
                    <select name="client" class="client_select" style="width: 100%; height: 250px;" id="client" class="mt-1  !w-full border-gray-300  focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm'" autofocus>
                        <option value="" disabled selected>Kies een klant</option>
                        @foreach ($clients as $client)
                            <option value="{{$client->id}}">{{$client->name}}</option>
                        @endforeach
                        
                    </select>   
                    <input type="text" name="currentDate" value="{{$currentDate}}" id="currentDate" class="hidden">
                    <button class="mt-10 bg-blue-700 hover:bg-blue-900 text-white font-bold py-2 px-4 rounded " type="submit">Zoek</button>

                </form>
              </div>
              <!-- Modal footer -->
          </div>
      </div>
  </div>
  