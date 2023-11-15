<x-app-layout>
    <x-slot name="header">
        @yield('searchTitle')

        
    </x-slot>
    <div id="clientsButtons" class="print:hidden max-w-7xl mx-auto sm:px-6 lg:px-8 mt-4 flex">
      

        <a href="/ingredients" class="bg-blue-700 hover:bg-blue-900 text-white font-bold py-2 px-4 rounded flex" id="button">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 15L3 9m0 0l6-6M3 9h12a6 6 0 010 12h-3" />
          </svg>
          
              Terug naar overzicht
         </a>
      
       @yield('searchForm')

    </div>
    
    <div class="print:py-0 py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 print:max-w-none print:sm:px-0 print:lg:px-0">
            <div class=" bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <table id="printTable" class="table-auto w-full  border-seperate border-spacing-y-6">
                        @yield('content')

                        
                      </table>
                    
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
