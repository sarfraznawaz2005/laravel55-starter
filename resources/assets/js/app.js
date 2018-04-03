require('./bootstrap');

window.Vue = require('vue');

Vue.component('example-component', require('./components/ExampleComponent.vue'));
Vue.component('tasks-component', require('./components/TasksComponent.vue'));

const app = new Vue({
    el: '#app'
});

/////////////////////////////////////////////////////////////////////////////
// CUSTOM IMPORTS
/////////////////////////////////////////////////////////////////////////////

window.swal = require('sweetalert2');
window.isMobile = require('ismobilejs');

// DataTables
require('datatables.net');
require('datatables.net-bs4');
require('datatables.net-responsive');
require('datatables.net-responsive-bs4');

require('datatables.net-buttons');
require('datatables.net-buttons-bs4');
require('datatables.net-buttons/js/buttons.colVis.js');
require('datatables.net-buttons/js/buttons.html5.js');
require('datatables.net-buttons/js/buttons.flash.js');
require('datatables.net-buttons/js/buttons.print.js');

require('select2');
require('summernote');
require('jquery-toast-plugin');
require('@faridaghili/bootstrap-filestyle');
require('bootstrap-validator');