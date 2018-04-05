<template>
    <div class="container">
        <div class="row">
            <div class="col-md-12">

                <div class="card">
                    <div class="card-header">
                        <ul class="nav nav-tabs card-header-tabs">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="tab" href="#manage">Manage</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#create">Create</a>
                            </li>
                        </ul>
                    </div>

                    <div class="card-body">

                        <transition name="fade">
                            <ul class="list-unstyled" v-if="errors.length">
                                <li class="animated shake alert alert-danger" v-for="error in errors">
                                    {{error}}

                                    <button type="button"
                                            class="close"
                                            data-dismiss="alert"
                                            aria-hidden="true"
                                    >&times;
                                    </button>
                                </li>
                            </ul>
                        </transition>

                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="manage">
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
                                                    data-toggle="modal"
                                                    data-target="#editModal"
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
                            </div>

                            <div class="tab-pane fade" id="create">
                                <div class="form-group">
                                    <label for="description">Task Description</label>
                                    <input type="text" id="description" v-model="description" class="form-control">
                                </div>
                                <div class="form-group">
                                    <button type="button" class="btn btn-success" @click="saveTask"
                                            :disabled="description.length < 5">
                                        <i class="fa fa-floppy-o"></i> Save
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer text-muted">
                        <pagination :data="tasks" v-on:pagination-change-page="getTasks"></pagination>
                    </div>
                </div>

            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="editModal"
             tabindex="-1"
             role="dialog"
             aria-hidden="true">

            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header text-white bg-success">
                        <strong class="modal-title">
                            <i class="fa fa-pencil"></i> Edit Task
                        </strong>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">

                        <transition name="fade">
                            <ul class="list-unstyled" v-if="errors.length">
                                <li class="animated shake alert alert-danger" v-for="error in errors">
                                    {{error}}

                                    <button type="button"
                                            class="close"
                                            data-dismiss="alert"
                                            aria-hidden="true"
                                    >&times;
                                    </button>
                                </li>
                            </ul>
                        </transition>

                        <div class="form-group">
                            <label for="descriptionEdit">Task Description</label>
                            <input type="text" id="descriptionEdit" v-model="description" class="form-control">
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" @click="updateTodo" :disabled="description.length < 5">
                            Save
                        </button>
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>

<style scoped>
    .fade-enter-active, .fade-leave-active {
        transition: opacity 1s;
    }

    .fade-enter, .fade-leave-to {
        opacity: 0;
    }
</style>

<script>
    Vue.component('pagination', require('laravel-vue-pagination'));

    import swal from 'sweetalert2'

    export default {
        data() {
            return {
                tasks: {},
                description: '',
                errors: [],
                editTaskRecord: {},
            };
        },
        mounted() {
            this.getTasks();

            setTimeout(this.afterDataLoaded, 1000);
        },
        methods: {
            getTasks(page) {
                page = page || 1;

                axios
                    .get('api/tasks?page=' + page)
                    .then(response => {
                        this.tasks = response.data;
                    })
                    .catch(error => this.errors = error.response.data)
            },
            saveTask() {
                this.errors = [];

                axios
                    .post('api/tasks', {
                        'description': this.description
                    })
                    .then(response => {
                        notify('Added Successfully', 'Success', 'success');

                        this.description = '';
                        this.tasks = response.data;
                    })
                    .catch(error => {
                        this.errors = error.response.data;
                    })
            },
            editTask(task) {
                this.editTaskRecord = task;
                this.description = this.editTaskRecord.description;
            },
            updateTodo() {
                this.errors = [];

                axios
                    .post('api/tasks/' + this.editTaskRecord.id, {
                        description: this.description,
                        '_method': 'put'
                    })
                    .then(response => {
                        notify('Updated Successfully', 'Success', 'success');

                        this.tasks = response.data;
                    })
                    .catch(error => {
                        this.errors = error.response.data
                    });
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
                    preConfirm: function() {
                        return new Promise(function(resolve) {
                            setTimeout(function() {
                                resolve()
                            }, 2000)
                        })
                    }
                }).then((result) => {
                    if (result.value) {
                        axios
                            .post('api/tasks/' + id, {'_method': 'DELETE'})
                            .then(response => {
                                swal({
                                    type: 'success',
                                    title: 'Success',
                                    text: 'Deleted Successfully'
                                });

                                this.tasks = response.data;
                            })
                            .catch(error => {
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
