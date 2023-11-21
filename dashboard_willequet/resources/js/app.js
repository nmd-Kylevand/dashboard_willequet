import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

$("select").on("focus", function(){
    this.size = 5;
});

$("select").on("change", function(){
    this.blur();
});

$("select").on("blur", function(){
    this.size = 1;
    this.blur();
});