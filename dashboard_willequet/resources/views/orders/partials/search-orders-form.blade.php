<div class="pt-2 relative mx-auto text-gray-600 w-auto	text-end">
  <div>
    
  </div>
    <form action="{{ route('orders.search') }}" method="GET">
        @csrf
        <input onfocus="this.showPicker()" onchange='this.form.submit()' class="border-2 border-gray-300 bg-white h-10 !pr-24  rounded-lg text-sm focus:outline-none"
        type="date" name="search" placeholder="Search" value="{{Request::get('search')}}">
      

    </form>
   
  </div>

 