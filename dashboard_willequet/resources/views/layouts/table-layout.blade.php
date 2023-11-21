<x-app-layout>
    <x-slot name="header">
        @yield('title')
        
    </x-slot>
    <div id="clientsButtons" class="print:hidden max-w-7xl mx-auto sm:px-6 lg:px-8 mt-4 flex">
       @yield('createForm')
       @yield('printButton')
       @yield('goBack')
       @yield('searchForm')

    </div>
    
    <div class="print:py-0 py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 print:max-w-none print:sm:px-0 print:lg:px-0">
            <div class=" bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <table id="printTable" class="table-auto w-full  border-seperate border-spacing-y-6 mb-24">
                        @yield('content')
                        
                      </table>
                    
                </div>
            </div>
        </div>
    </div>
      <script>
        function printPage() {
            window.print();
        }
    </script>
</x-app-layout>
