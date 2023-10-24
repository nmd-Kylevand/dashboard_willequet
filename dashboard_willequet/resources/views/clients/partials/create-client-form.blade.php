
<!-- Modal toggle -->

<button data-modal-target="createModal" data-modal-toggle="createModal" class="bg-blue-700 hover:bg-blue-900 text-white font-bold py-2 px-4 rounded flex">
    
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
        <path stroke-linecap="round" stroke-linejoin="round" d="M19 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zM4 19.235v-.11a6.375 6.375 0 0112.75 0v.109A12.318 12.318 0 0110.374 21c-2.331 0-4.512-.645-6.374-1.766z" />
    </svg>
    <p class="ml-4">Nieuwe klant</p>
  </button>
  <!-- Main modal -->
  <div id="createModal" data-modal-backdrop="static" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
      <div class="relative w-full max-w-2xl max-h-full">
          <!-- Modal content -->
          <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
              <!-- Modal header -->
              <div class="flex items-start justify-between p-4 border-b rounded-t dark:border-gray-600">
                  <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                      Klant aanmaken
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
                  <form method="post" action="{{ route('clients.create')}}" class="mt-6 space-y-6">
                    @csrf
                    @method('post')
                    <div>
                        <x-input-error class="mt-2" :messages="$errors->get('color')" />
                        <x-input-label for="color" :value="__('Kleur')"/>
                        <select name="color" id="color" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm'" autofocus>
                            <option value="" disabled selected>Kies een kleur</option>
                            <option value="#E7F05A">Geel</option>
                            <option value="#7D7D7D">Grijs</option>
                            <option value="#4A7937">Groen</option>
                            <option value="#45CEE6">Lichtblauw</option>
                            <option value="#6FE21B">Lichtgroen</option>
                            <option value="#E89A17">Oranje</option>
                            <option value="#BA9FD2">Paars</option>
                            <option value="#C93434">Rood</option>
                            <option value="#E655CA">Roze</option>
                            <option value="#F7FAFC">Wit</option>
                        </select>   
                    </div>
                    <div>
                        <x-input-label for="name" :value="__('Naam')" />
                        <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name')"  autofocus autocomplete="name" />
                        <x-input-error class="mt-2" :messages="$errors->get('name')" />
                    </div>
            
                    <div>
                        <x-input-label for="email" :value="__('Email')" />
                        <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email')"  autocomplete="email" />
                        <x-input-error class="mt-2" :messages="$errors->get('email')" />
                    </div>
                    
                    <div>
                        <x-input-label for="address" :value="__('Adres')" />
                        <x-text-input id="address" name="address" type="text" class="mt-1 block w-full" :value="old('address')"  autocomplete="address" />
                        <x-input-error class="mt-2" :messages="$errors->get('address')" />
                    </div>

                    <div>
                        <x-input-label for="type" :value="__('Type')" />
                        <x-text-input id="type" name="type" type="text" class="mt-1 block w-full" :value="old('type')"  autocomplete="type" />
                        <x-input-error class="mt-2" :messages="$errors->get('type')" />
                    </div>


                    <div>
                        <x-input-label for="telephone" :value="__('Telefoonnr')" />
                        <x-text-input id="telephone" name="telephone" type="text" class="mt-1 block w-full" :value="old('telephone')"  autocomplete="telephone" />
                        <x-input-error class="mt-2" :messages="$errors->get('telephone')" />
                
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
  