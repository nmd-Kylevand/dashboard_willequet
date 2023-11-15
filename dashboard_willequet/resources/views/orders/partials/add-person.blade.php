    
    <div>
        <x-text-input id="ingredientId" name="ingredientId" type="number" class="hidden" :value="$data->id ?? ''"/>
    </div>
    <div>
        <x-text-input id="clientId" name="clientId" type="number" class="hidden" :value="$data->clients[0]->id ?? ''"/>
    </div>
    <div>
        <x-text-input id="date" name="date" type="date" class="hidden" :value="$data->clientsOrders[0]->pivot->date ?? ''"/>
           {{ $data->clientsOrders[0]->pivot->date}}
    </div>
    {{$data}}
    <div class="justify-end  flex	">
        <x-text-input id="amount" min="0.01" step="0.01" name="persons"  type="number" class="mt-1 block w-1/4 mr-5" :value="old('persons')"  autofocus autocomplete="persons" />
        <x-input-error class="mt-2" :messages="$errors->get('persons')" />
        
    </div>       
