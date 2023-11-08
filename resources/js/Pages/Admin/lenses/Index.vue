<template>

    <head>
        <title>Админ панель | Линзы</title>
    </head>
    <AdminLayout>
        <template #breadcrumbs>
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Линзы тізімі</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a :href="route('admin.index')">
                                <i class="fas fa-dashboard"></i>
                                Басты бет
                            </a>
                        </li>
                        <li class="breadcrumb-item active">
                            Линзы тізімі
                        </li>
                    </ol>
                </div>
            </div>
        </template>
        <template #header>
            <div class="buttons d-flex align-items-center">
                <Link class="btn btn-primary mr-2" :href="route('admin.lenses.create')">
                <i class="fa fa-plus"></i> Қосу
                </Link>

                <Link class="btn btn-danger" :href="route('admin.lenses.index')">
                <i class="fa fa-trash"></i> Фильтрді тазалау
                </Link>
                <div class=" ml-3">
                    <div class="custom-control custom-switch">
                        <input type="checkbox" v-model="type_list" class="custom-control-input" id="customSwitch2" true-value=1 false-value=0 />
                        <label class="custom-control-label" for="customSwitch2">Включить список</label>
                    </div>
                    <validation-error :field="'active'" />
                </div>
                <div v-if="loading" class="spinner-border text-primary mx-3" role="status">
                    <span class="sr-only">Loading...</span>
                </div>

            </div>
        </template>
        <div class="container-fluid">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <table class="table table-hover table-bordered table-striped dataTable dtr-inline">
                                <thead>
                                    <tr role="row">
                                        <th>№</th>
                                        <th>Аты</th>
                                        <th>Типі</th>
                                        <th>Деоптерия</th>
                                        <th>Описания</th>
                                        <th>Әрекет</th>
                                    </tr>
                                    <tr class="filters">
                                        <td></td>
                                        <td>
                                            <input v-model="filter.name" class="form-control" placeholder="Аты" @keyup.enter="search" />
                                        </td>
                                        <td>
                                            <select class="form-control" @change.prevent="search" v-model="filter.type_id" placeholder="Белсенді">
                                                <option :value="null">
                                                    Барлығы
                                                </option>
                                                <option v-for="type in types" :key="'type' + type.id" :value="type.id">
                                                    {{type.name}}
                                                </option>
                                            </select>
                                        </td>
                                        <td>
                                            <input v-model="filter.dpt" class="form-control" placeholder="Деоптерия" @keyup.enter="search" />
                                        </td>
                                        
                                        <td></td>
                                        <td></td>
                                    </tr>
                                </thead>
                                <tbody v-if="type_list == 1">
                                    <tr class="odd" v-for="(
                                            lens, index
                                        ) in lenses.data" :key="'lens' + lens.id">
                                        <td>
                                            {{
                                                lenses.from
                                                    ? lenses.from +
                                                      index
                                                    : index + 1
                                            }}
                                        </td>
                                        <td>{{ lens.name }}</td>
                                        <td>{{ lens.lens_type.name }}</td>
                                        <td>{{ lens.dpt }}</td>
                                        <td>{{ lens.description }}</td>
                                        <td>
                                            <div class="btn-group btn-group-sm">
                                                <Link :href="
                                                        route(
                                                            'admin.lenses.edit',
                                                            lens
                                                        )
                                                    " class="btn btn-primary" title="Изменить">
                                                <i class="fas fa-edit"></i>
                                                </Link>

                                                <button @click.prevent="
                                                        deleteData(
                                                            lens.id
                                                        )
                                                    " class="btn btn-danger" title="Удалить">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <template v-if="type_list == 0">
                            <div v-for="lens in lenses.data" :key="'lens' + lens.id" class="col-md-3 imageBlock ripple" :style="'background-image: url(/storage/lenses/'+lens.img+');'">
                                <div>
                                    <div class="mask" style="background-color: hsla(0, 0%, 0%, 0.1)">
                                        <div class="hover-overlay">
                                            <div class="mask" style="background-color: hsla(0, 0%,98%, 0.4)"></div>
                                        </div>
                                        <div class="d-flex justify-content-center align-items-end h-100">
                                            <p class="mb-2 cst_buttons">
                                            <div class="btn-group btn-group-sm">
                                                <Link :href="route('admin.lenses.edit',lens)" class="btn btn-primary" title="Изменить">
                                                <i class="fas fa-edit"></i>
                                                </Link>
                                                <button @click.prevent="
                                                        deleteData(
                                                            lens.id
                                                        )
                                                    " class="btn btn-danger" title="Удалить">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </div>
                                            </p>
                                        </div>
                                    </div>

                                </div>
                            </div>

                        </template>
                    </div>
                    <Pagination :links="lenses.links" />
                </div>
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
    export default {
        components: {
            AdminLayout,
            Link,
            Pagination,
            Head
        },
        props: ["lenses", "types"],
        data() {
            return {
                filter: {
                    name: route().params.name ? route().params.name : null,
                    type_id: route().params.type_id ? route().params.type_id : null,
                    dpt: route().params.dpt ? route().params.dpt : null,
                },
                loading: 0,
                type_list: 0,
            };
        },
        methods: {
            deleteData(id) {
                Swal.fire({
                    title: "Жоюға сенімдісіз бе?",
                    text: "Қайтып қалпына келмеуі мүмкін!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Иә, жоямын!",
                    cancelButtonText: "Жоқ",
                }).then((result) => {
                    if (result.isConfirmed) {
                        this.$inertia.delete(route("admin.lenses.destroy", id));
                    }
                });

            },
            search() {
                this.loading = 1
                const params = this.clearParams(this.filter);
                this.$inertia.get(route("admin.lenses.index"), params);
            },
        },
    };

</script>
<style lang="scss">
    .imageBlock {
        padding-top: 25%;
        background-size: cover;
        background-position: 50% 50%;
    }

    .mask:hover {
        .cst_buttons {
            opacity: 1;
            transform: translateY(0px);

        }
    }

    .cst_buttons {
        opacity: 0;
        transition: 0.3s;
        position: absolute;
        transform: translateY(15px);
    }

</style>
