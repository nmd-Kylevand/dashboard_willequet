import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();
$(document).ready(function() {
    $('.client_select').select2({
        dropdownParent: $('#createModal')
    });
    $('.client_select2').select2({
        dropdownParent: $('#createModal')

    });
    $('.select').select2({
        dropdownParent: $('#copy1Modal')

    });
    $('.client_select3').select2();
});

// $('#category').ddslick({
//     onSelected: function(data){
//         if(data.selectedIndex > 0) {
//             console.log(data.selectedData.value);
//             $('#hidCflag').val(data.selectedData.value);

//         }   
//     }   
// });