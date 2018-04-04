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
                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="manage">
                                <table class="table table-bordered table-hover">
                                    <thead>
                                    <tr>
                                        <th style="text-align: center;">ID</th>
                                        <th>Description</th>
                                        <th style="text-align: center;">Completed</th>
                                        <th style="text-align: center;">Created At</th>
                                        <th style="text-align: center;">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="task in tasks.data">
                                        <td style="text-align: center;" width="50">{{task.id}}</td>
                                        <td>{{task.description}}</td>
                                        <td style="text-align: center;">{{task.completed}}</td>
                                        <td style="text-align: center;">{{task.created_at}}</td>
                                        <td style="text-align: center;">
                                            <a href="#"
                                               data-placement="top"
                                               data-tooltip
                                               data-original-title="Toggle Complete"
                                               class="btn btn-secondary">
                                                <i class="fa fa-check-square"></i>
                                            </a>

                                            <a href="#"
                                               data-placement="top"
                                               data-tooltip
                                               data-original-title="Edit"
                                               class="btn btn-primary">
                                                <i class="fa fa-pencil"></i>
                                            </a>

                                            <a href="#"
                                               data-placement="top"
                                               data-tooltip
                                               data-original-title="Delete"
                                               class="btn btn-danger">
                                                <i class="fa fa-trash"></i>
                                            </a>
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
                                    <button type="button" class="btn btn-success" @click="saveTask">
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
    </div>
</template>

<script>
    Vue.component('pagination', require('laravel-vue-pagination'));

    export default {
        data() {
            return {
                tasks: {},
                description: ''
            };
        },
        created() {
            this.getTasks();
        },
        methods: {
            getTasks(page) {
                page = page || 1;

                axios
                    .get('api/tasks?page=' + page)
                    .then(response => {
                        this.tasks = response.data;

                        this.afterDataLoaded();
                    })
                    .catch(error => console.log(error.data.error.text))
            },
            saveTask() {
                axios
                    .post('api/tasks', {
                        'description': this.description
                    })
                    .then(response => {
                        this.description = '';
                        this.tasks = response.data;
                        this.afterDataLoaded();
                    })
                    .catch(error => console.log(error))
            },
            afterDataLoaded() {
                // FIXME
                // BTS Tooltips
                window.$('[data-tooltip]').tooltip();
            }
        }
    }
</script>
