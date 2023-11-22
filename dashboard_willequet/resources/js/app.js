import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();
$(document).ready(function() {
    $('.client_select').select2();
});

