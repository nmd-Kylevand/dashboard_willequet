
<!-- Modal toggle -->
<button data-modal-target="copy1Modal" data-modal-toggle="copy1Modal" class="bg-blue-700 hover:bg-blue-900 text-white font-bold py-2 px-4 mr-2 rounded flex">
    
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 17.25v3.375c0 .621-.504 1.125-1.125 1.125h-9.75a1.125 1.125 0 01-1.125-1.125V7.875c0-.621.504-1.125 1.125-1.125H6.75a9.06 9.06 0 011.5.124m7.5 10.376h3.375c.621 0 1.125-.504 1.125-1.125V11.25c0-4.46-3.243-8.161-7.5-8.876a9.06 9.06 0 00-1.5-.124H9.375c-.621 0-1.125.504-1.125 1.125v3.5m7.5 10.375H9.375a1.125 1.125 0 01-1.125-1.125v-9.25m12 6.625v-1.875a3.375 3.375 0 00-3.375-3.375h-1.5a1.125 1.125 0 01-1.125-1.125v-1.5a3.375 3.375 0 00-3.375-3.375H9.75" />
      </svg>
      Kopiëer
  </button>
  <!-- Main modal -->
  <div id="copy1Modal" data-modal-backdrop="static" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
      <div class="relative w-full max-w-2xl max-h-full">
          <!-- Modal content -->
          <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
              <!-- Modal header -->
              <div class="flex items-start justify-between p-4 border-b rounded-t dark:border-gray-600">
                  <h2>Maak een kopie naar een andere datum</h2>
                  <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="copy1Modal">
                      <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                          <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                      </svg>
                      <span class="sr-only">Close modal</span>
                  </button>
              </div>
              <!-- Modal body -->
              <div class="p-6 space-y-6">
                  <form method="post" action="{{ route('orders.copyIndividual', ['id' => $ingredientId, 'date' => $currentDate])}}">
                    @csrf

                    <div>
                        <x-text-input id="ingredientId" name="ingredientId" type="text" class="hidden" :value="$ingredientId "  autofocus autocomplete="name" />
                    </div>
                    <div>
                        <x-text-input id="currentDate" name="currentDate" type="text" class="hidden" :value="$currentDate"  autofocus autocomplete="name" />
                    </div>
                    <div>
                        <x-input-error class="mt-2" :messages="$errors->get('client')" />
                        <x-input-label for="client" :value="__('Klant')"/>
                        <select  style="width: 100%; " name="clientsCopy" class="select" autofocus>
                            @foreach ($clients as $client)
                                
                                <option value="{{$client->clients_id}}">{{$client->name}}</option>
                            @endforeach
                        </select>   
                    </div>
                    <div>
                        <x-text-input id="individual" name="individual" type="text" class="hidden"  autofocus autocomplete="individual" />
                    </div>
                    

                    <div>
                        <x-input-label for="date" :value="__('Nieuwe datum')" />
                        <input onfocus="this.showPicker()" class="border-2 border-gray-300 bg-white h-10 !pr-24  rounded-lg text-sm focus:outline-none"
                        type="date" name="date" placeholder="date" value="old('date')">
                    </div>

                    <div class="flex items-center p-6 space-x-2 border-t border-gray-200 rounded-b dark:border-gray-600">
                        <x-primary-button>{{ __('Save') }}</x-primary-button>
                    </div>
                </form>
              </div>
              <!-- Modal footer -->
          </div>
      </div>
  </div>
