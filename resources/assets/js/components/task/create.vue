<template>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <transition name="fade">
                    <div class="alert alert-success" v-if="success.length">
                        {{success}}

                        <button type="button"
                                class="close"
                                data-dismiss="alert"
                                aria-hidden="true"
                        >&times;
                        </button>
                    </div>
                </transition>

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
    export default {
        data() {
            return {
                tasks: {},
                description: '',
                success: '',
                errors: [],
            };
        },
        mounted() {

        },
        methods: {
            saveTask() {
                this.errors = [];
                this.success = '';

                axios
                    .post('api/tasks', {
                        'description': this.description
                    })
                    .then(response => {
                        this.success = 'Added Successfully';
                        this.description = '';
                        this.tasks = response.data;
                    })
                    .catch(error => {
                        this.errors = error.response.data;
                    })
            },
        }
    }
</script>
