require('./bootstrap');
window.Vue = require('vue');

/////////////////////////////////////////////////////////////////////////////
// CUSTOM IMPORTS START
/////////////////////////////////////////////////////////////////////////////
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

// Select2
require('select2');

// Summernote
require('summernote');

// SweetAlert2
window.swal = require('sweetalert2');

// jQuery Toast
require('jquery-toast-plugin');

// isMobile
window.isMobile = require('ismobilejs');

// fileStyle
require('@faridaghili/bootstrap-filestyle');

// bootstrap validator
require('bootstrap-validator');
/////////////////////////////////////////////////////////////////////////////
// CUSTOM IMPORTS END
/////////////////////////////////////////////////////////////////////////////

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('example-component', require('./components/ExampleComponent.vue'));
Vue.component('tasks-component', require('./components/TasksComponent.vue'));

const app = new Vue({
    el: '#app'
});
