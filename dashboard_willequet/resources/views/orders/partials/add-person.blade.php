
    <div>
        <x-text-input id="ingredientId" name="ingredientId" type="number" class="hidden" :value="$data->ingredient_id ?? ''"/>
    </div>
    <div>
        <x-text-input id="clientId" name="clientId[]" type="number" class="hidden" :value="$data->clients_id ?? ''"/>
    </div>
    <div>
        <x-text-input id="amountPerPerson" name="amountPerPerson[]" type="number" class="hidden" :value="$amountPerPerson ?? ''"/>
    </div>
    <div>
        <x-text-input id="date" name="date" type="date" class="hidden" :value="$data->date ?? ''"/>
    </div>
    <div class="justify-end  flex	">
        <x-text-input id="amount" min="1" step="1" name="persons[]"  type="number" class="mt-1 block w-1/4 mr-5" :value="$data->persons"  autofocus autocomplete="persons" />
        <x-input-error class="mt-2" :messages="$errors->get('persons')" />
        
    </div>       
