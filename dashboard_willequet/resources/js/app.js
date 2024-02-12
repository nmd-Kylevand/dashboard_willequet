import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();
$(document).ready(function() {
    $('.client_select').select2();
});

// $('#category').ddslick({
//     onSelected: function(data){
//         if(data.selectedIndex > 0) {
//             console.log(data.selectedData.value);
//             $('#hidCflag').val(data.selectedData.value);

//         }   
//     }   
// });