require('./bootstrap');

window.Vue = require('vue');

import VueRouter from 'vue-router'

Vue.use(VueRouter);

/////////////////////////////////////////////////////////////////////////////
// VueJS Components
/////////////////////////////////////////////////////////////////////////////
Vue.component('tasks-component', require('./components/task/view.vue'));
/////////////////////////////////////////////////////////////////////////////

/////////////////////////////////////////////////////////////////////////////
// VueRouter Routes
/////////////////////////////////////////////////////////////////////////////

const router = new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/tasks_list',
            name: 'tasks_list',
            component: require('./components/task/list.vue')
        },
        {
            path: '/tasks_create',
            name: 'tasks_create',
            component: require('./components/task/create.vue')
        },
        {
            path: '/tasks_edit',
            name: 'tasks_edit',
            component: require('./components/task/edit.vue')
        },
        //{path: '/', redirect: '/task_list'},
    ]
});

/////////////////////////////////////////////////////////////////////////////

window.vm = new Vue({
    el: '#app',
    router
});

/////////////////////////////////////////////////////////////////////////////
// CUSTOM LIBRARY IMPORTS
/////////////////////////////////////////////////////////////////////////////

window.swal = require('sweetalert2');
window.isMobile = require('ismobilejs');
window.Noty = require('noty');
window.mojs = require('mo-js');

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
//require('summernote');
//require('bootstrap-validator');