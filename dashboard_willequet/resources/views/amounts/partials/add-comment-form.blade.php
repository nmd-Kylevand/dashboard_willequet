<!-- Modal toggle -->

<button data-modal-target="staticModal{{$data->id}}" data-modal-toggle="staticModal{{$client->id}}" class="bg-blue-700 hover:bg-blue-900 text-white font-bold py-2 px-4 rounded">
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
        <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
      </svg>
      
  </button>
  <!-- Main modal -->
  <div id="staticModal{{$data->id}}" data-modal-backdrop="static" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
      <div class="relative w-full max-w-2xl max-h-full">
          <!-- Modal content -->
          <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
              <!-- Modal header -->
              <div class="flex items-start justify-between p-4 border-b rounded-t dark:border-gray-600">
                  <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                      Commentaar toevoegen
                  </h3>
                  <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="staticModal{{$client->id}}">
                      <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                          <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                      </svg>
                      <span class="sr-only">Sluiten</span>
                  </button>
              </div>
              <!-- Modal body -->
              <div class="p-6 space-y-6">
                  <form method="post" action="{{ route('amounts.assign') }}" class="mt-6 space-y-6">
                    @csrf
                    @method('post')
                    <div>
                        <x-text-input id="amount" name="ingredientId" type="number" class="hidden" :value="$data->id"/>
                    </div>
                    <div>
                        <x-text-input id="amount" name="clientId" type="number" class="hidden" :value="request()->route('id')"/>
                        </div>
                    <div>
                        <x-input-label for="comment" :value="__('Naam')" />
                        <x-text-input id="comment" name="comment" type="text" class="mt-1 block w-full" :value="old('comment', $data->comment)"  autofocus autocomplete="name" />
                        <x-input-error class="mt-2" :messages="$errors->get('comment')" />
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
  