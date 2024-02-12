<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        <link href="{{ asset('vendor/bladewind/css/animate.min.css') }}" rel="stylesheet" />

        <link href="{{ asset('vendor/bladewind/css/bladewind-ui.min.css') }}" rel="stylesheet" />
x
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

        @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/css/print.css', 'resources/js/printout.js'])
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js" defer></script>

        <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/ms-dropdown@4.0.3/dist/css/dd.min.css" />
        <script src="https://cdn.jsdelivr.net/npm/ms-dropdown@4.0.3/dist/js/dd.min.js"></script>

        <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
        <script type="text/javascript" src="https://cdn.rawgit.com/prashantchaudhary/ddslick/master/jquery.ddslick.min.js" ></script>
        
        <link href="https://printjs-4de6.kxcdn.com/print.min.css" rel="stylesheet" />
        <script src="  https://printjs-4de6.kxcdn.com/print.min.js"></script>

        <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.8.1/flowbite.min.css" rel="stylesheet" />

    </head>
    <body class="font-sans antialiased">
       
        <div id="bg" class="min-h-screen  bg-gray-100 dark:bg-gray-900">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white print:hidden dark:bg-gray-800 shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.8.1/flowbite.min.js"></script>
        <script>
            (function (root, factory) {
    if (typeof define === 'function' && define.amd) {
        define([], factory);
    } else if (typeof module === 'object' && module.exports) {
        module.exports = factory();
    } else {
        root.printout = factory();
    }
}(this, function () {
    return function (e, options) {
        let defaults = {
            pageTitle: window.document.title, // Title of the page
            importCSS: true, // Import parent page css
            inlineStyle: true, // If true it takes inline style tag 
            autoPrint: true, // Print automatically when the page is open
            autoPrintDelay: 1000, // Delay in milliseconds before printing
            closeAfterPrint: true, // Close the window after printing
            header: null, // String or element this will be appended to the top of the printout
            footer: null, // String or element this will be appended to the bottom of the printout
            noPrintClass: 'no-print' // Class to remove the elements that should not be printed
        }

        let config = Object.assign({}, defaults, options),
            element = null; // The element to print

        const isDomEntity = entity => typeof entity === 'object' && entity.nodeType !== undefined;

        element = isDomEntity(e) ? e : document.querySelector(e);

        if (config.header != null && isDomEntity(config.header)) {
            config.header = config.header.outerHTML;
        }

        if (config.footer != null && isDomEntity(config.footer)) {
            config.footer = config.footer.outerHTML;
        }

        let win = window.open('', ''),
            head = '<meta charset="UTF-8"><title>' + config.pageTitle + '</title>';

        // Converting style relative path to absolute path and return a corrected link tag
        const getLink = (link) => {
            let clone = link.cloneNode(true);
            clone.href = (new URL(clone.href, location)).href
            return clone.outerHTML;
        };

        // Get all the link tags and append them to the head
        if (config.importCSS) {
            let links = document.querySelectorAll('link');
            for (let i = 0; i < links.length; i++) {
                head += getLink(links[i]);
            }
        }

        // Get all the style tags and append them to the head if inlineStyle is true
        if (config.inlineStyle) {
            let styles = document.querySelectorAll('style');
            for (let i = 0; i < styles.length; i++) {
                head += styles[i].outerHTML;
            }
        }

        // Set new document direction to main document direction
        win.document.documentElement.setAttribute('dir', document.documentElement.getAttribute('dir'))

        win.document.head.innerHTML = head;
        // Set header
        win.document.body.innerHTML = config.header;

        // Get the element and remove the noPrintClass then append it to the body
        element = element.cloneNode(true);
        let noPrint = element.querySelectorAll('.' + config.noPrintClass);
        for (let i = 0; i < noPrint.length; i++) {
            noPrint[i].remove();
        }
        win.document.body.appendChild(element);

        // Set footer
        if (config.footer != null) {
            win.document.body.insertAdjacentHTML('beforeend', config.footer);
        }

        if (config.autoPrint) {
            // Allow stylesheets time to load
            win.setTimeout(() => {
                win.print();
                if (config.closeAfterPrint) {
                    win.close();
                }
            }, config.autoPrintDelay);
        }
    };
}));

        </script>
      <script src="{{ asset('vendor/bladewind/js/helpers.js') }}" type="text/javascript"></script>
    </body>
    @yield('script')

</html>
