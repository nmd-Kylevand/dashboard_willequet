
<!-- Modal toggle -->

<button data-modal-target="createModal" data-modal-toggle="createModal" class="bg-blue-700 hover:bg-blue-900 text-white font-bold py-2 px-4 rounded flex mx-4 ">
    
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
        <path stroke-linecap="round" stroke-linejoin="round" d="M19 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zM4 19.235v-.11a6.375 6.375 0 0112.75 0v.109A12.318 12.318 0 0110.374 21c-2.331 0-4.512-.645-6.374-1.766z" />
    </svg>
    <p class="ml-4">Nieuw</p>
  </button>
  <!-- Main modal -->
  <div id="createModal" data-modal-backdrop="static" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
      <div class="relative w-full max-w-2xl max-h-full">
          <!-- Modal content -->
          <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
              <!-- Modal header -->
              <div class="flex items-start justify-between p-4 border-b rounded-t dark:border-gray-600">
                  <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                      Nieuwe bestelling 
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
                  <form method="post" action="{{ route('orders.create')}}" class="mt-6 space-y-6">
                    @csrf
                    @method('post')
                    <div>
                        <x-input-label for="date" :value="__('Datum')" />
                        <x-text-input id="date" name="date" type="date" class="mt-1 block w-full" :value="request()->query('search')"  autofocus autocomplete="date" />
                        <x-input-error class="mt-2" :messages="$errors->get('date')" />
                    </div>
            
                    <div>
                        <x-input-error class="mt-2" :messages="$errors->get('ingredient')" />
                        <x-input-label for="ingredient" :value="__('Ingrediënt')"/>
                        <select   style="width: 100%;" name="ingredient" id="ingredient" class="mt-1 block w-full border-gray-300  focus:border-indigo-500 focus:ring-indigo-500  rounded-md shadow-sm client_select2" autofocus>
                            <option value="" disabled selected>Kies een Ingredient</option>
                            @foreach ($ingredients as $ingredient)
                                <option value="{{$ingredient->id}}">{{$ingredient->name}}</option>
                            @endforeach
                            
                        </select>   
                    </div>
                   
                    
                    <div>
                        <x-input-error class="mt-2" :messages="$errors->get('client')" />
                        <x-input-label for="client" :value="__('Klant')"/>
                        <select  style="width: 100%; " name="client" class="client_select2" autofocus>
                            <option value="" disabled selected>Kies een klant</option>
                            @foreach ($clients as $client)
                                <option value="{{$client->id}}">{{$client->name}}</option>
                            @endforeach
                        </select>   
                    </div>
                    
                    
                    <div>
                        <p>of</p>
                    </div>
                    <div>
                        <x-input-error class="mt-2" :messages="$errors->get('categories')" />
                        <x-input-label for="categories" :value="__('Kies een categorie')"/>
                        <select  name="categories" id="categories" class="mt-1 block w-full border-gray-300  focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" autofocus>
                            <option value="" disabled selected>Kies een categorie</option>
                            <option value="scholen">Scholen</option>
                            <option value="speelscholen">Speelscholen</option>
                            <option value="oud">Oud</option>
                            <option value="overig">Overig</option>
                        </select>   
                    </div>
                    

                   
                    <div class="flex items-center p-6 space-x-2 border-t border-gray-200 rounded-b ">
                        <x-primary-button>{{ __('Aanmaken') }}</x-primary-button>
                    </div>
                </form>
              </div>
              <!-- Modal footer -->
          </div>
      </div>
  </div>
  