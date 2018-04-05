<template>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <ul class="nav nav-tabs card-header-tabs">
                            <li class="nav-item">
                                <a href="#" @click.prevent="goto('tasks_list')" class="nav-link active"
                                   data-toggle="tab">Manage</a>
                            </li>
                            <li class="nav-item">
                                <a href="#" @click.prevent="goto('tasks_create')" class="nav-link" data-toggle="tab">Create</a>
                            </li>
                        </ul>
                    </div>

                    <div class="card-body">
                        <keep-alive>
                            <router-view></router-view>
                        </keep-alive>
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
    export default {
        mounted() {
            // default page
            this.$router.push('tasks_list');
        },
        methods: {
            goto(path) {
                this.$router.push(path);
            }
        }
    }
</script>
