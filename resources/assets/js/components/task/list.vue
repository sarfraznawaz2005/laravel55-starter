<template>
    <div class="container">
        <loading :active.sync="isLoading" :can-cancel="false"></loading>

        <table class="table table-bordered table-hover">
            <thead>
            <tr>
                <th style="text-align: center;">ID</th>
                <th>Description</th>
                <th style="text-align: center;">Created At</th>
                <th style="text-align: center;">Action</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="task in tasks.data">
                <td style="text-align: center;" width="50">{{task.id}}</td>
                <td>{{task.description}}</td>
                <td style="text-align: center;" width="150">{{task.created_at}}</td>
                <td style="text-align: center;" width="100">
                    <button type="button"
                            @click="editTask(task)"
                            data-placement="top"
                            data-tooltip
                            data-original-title="Edit"
                            class="btn btn-primary">
                        <i class="fa fa-pencil"></i>
                    </button>

                    <button type="button"
                            @click="deleteTask(task.id)"
                            data-placement="top"
                            data-tooltip
                            data-original-title="Delete"
                            class="btn btn-danger">
                        <i class="fa fa-trash"></i>
                    </button>
                </td>
            </tr>
            </tbody>
        </table>

        <pagination :data="tasks" v-on:pagination-change-page="getTasks"></pagination>
    </div>
</template>

<style scoped>

</style>

<script>
    Vue.component('pagination', require('laravel-vue-pagination'));

    import swal from 'sweetalert2';
    import Loading from 'vue-loading-overlay';
    import 'vue-loading-overlay/dist/vue-loading.min.css';

    export default {
        data() {
            return {
                tasks: {},
                description: '',
                errors: [],
                isLoading: false,
            };
        },
        components: {
            Loading
        },
        mounted() {
            this.errors = [];
            this.success = '';
            this.isLoading = false;

            this.getTasks();

            window.vm.$on('refreshTasks', this.getTasks);

            //setTimeout(this.afterDataLoaded, 1000);
        },
        methods: {
            getTasks(page) {
                page = page || 1;

                this.isLoading = true;

                axios
                    .get('api/tasks?page=' + page)
                    .then(response => {
                        this.tasks = response.data;
                        this.isLoading = false;
                    })
                    .catch(error => {
                        this.isLoading = false;
                        this.errors = error.response.data;
                    })
            },
            editTask(task) {
                this.$router.push({path: 'tasks_edit', query: {id: task.id}})
            },
            deleteTask(id) {

                swal({
                    title: 'Are you sure?',
                    text: "",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it',
                    cancelButtonText: 'No, cancel',
                    confirmButtonClass: 'btn btn-success',
                    cancelButtonClass: 'btn btn-danger',
                    buttonsStyling: true,
                    reverseButtons: true,
                    showLoaderOnConfirm: true,
                    preConfirm: function () {
                        return new Promise(function (resolve) {
                            setTimeout(function () {
                                resolve()
                            }, 2000)
                        })
                    }
                }).then((result) => {
                    if (result.value) {
                        this.isLoading = true;

                        axios
                            .post('api/tasks/' + id, {'_method': 'DELETE'})
                            .then(response => {

                                swal({
                                    type: 'success',
                                    title: 'Success',
                                    text: 'Deleted Successfully'
                                });

                                this.isLoading = false;

                                this.getTasks();
                            })
                            .catch(error => {
                                this.isLoading = false;
                                this.errors = error.response.data;
                            });
                    }
                })
            },
            afterDataLoaded() {
                // BTS Tooltips
                window.$('[data-tooltip]').tooltip();
            }
        }
    }
</script>
