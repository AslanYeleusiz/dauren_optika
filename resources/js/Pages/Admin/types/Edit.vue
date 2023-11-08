<template>

    <head>
        <title>Админ панель | Көзілдірік типін өзгерту</title>
    </head>
    <AdminLayout>
        <template #breadcrumbs>
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Көзілдірік типін өзгерту</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a :href="route('admin.index')">
                                <i class="fas fa-dashboard"></i>
                                Басты бет
                            </a>
                        </li>
                        <li class="breadcrumb-item">
                            <a :href="route('admin.types.index')">
                                <i class="fas fa-dashboard"></i>
                                Көзілдірік типін тізімі
                            </a>
                        </li>
                        <li class="breadcrumb-item active">Көзілдірік типін өзгерту</li>
                    </ol>
                </div>
            </div>
        </template>
        <div class="container-fluid">
            <div class="card card-primary">
                <form method="post" @submit.prevent="submit">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="">Аты</label>
                            <input type="text" class="form-control" v-model="type.name" name="name" placeholder="Аты" />
                            <validation-error :field="'name'" />
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary mr-1">
                            Сақтау
                        </button>
                        <Link :href="route('admin.types.index')">
                            <button type="button" class="btn btn-danger">
                            Артқа
                        </button>
                        </Link>

                    </div>
                </form>
            </div>
        </div>
    </AdminLayout>
</template>
<script>
    import AdminLayout from "../../../Layouts/AdminLayout.vue";
    import {
        Link,
        Head
    } from "@inertiajs/inertia-vue3";
    import Pagination from "../../../Components/Pagination.vue";
    import ValidationError from "../../../Components/ValidationError.vue";
    import ClassicEditor from "@ckeditor/ckeditor5-build-classic";


    export default {
        components: {
            AdminLayout,
            Link,
            Pagination,
            ValidationError,
            Head
        },
        props: ['type'],
        data() {
            return {
                //
            }
        },
        methods: {
            submit() {
                this.$inertia.put(
                    route("admin.types.update", this.type.id),
                    this.type, {
                        onError: () => console.log("An error has occurred"),
                        onSuccess: () =>
                            console.log("The new contact has been saved"),
                    }
                );
            },
        },
    };
</script>
