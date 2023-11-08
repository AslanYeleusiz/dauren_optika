<template>

    <head>
        <title>Админ панель | Линза қосу</title>
    </head>
    <AdminLayout>
        <template #breadcrumbs>
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Линза қосу</h1>
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
                            <a :href="route('admin.lenses.index')">
                                <i class="fas fa-dashboard"></i>
                                Линза тізімі
                            </a>
                        </li>
                        <li class="breadcrumb-item active">Линза қосу</li>
                    </ol>
                </div>
            </div>
        </template>
        <div class="container-fluid">
            <div class="card card-primary">
                <form method="post" @submit.prevent="submit">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="">Аты <span class="red">*</span></label>
                            <input type="text" class="form-control" v-model="lens.name" name="name" placeholder="Аты" />
                            <validation-error :field="'name'" />
                        </div>
                        <div class="form-group">
                            <label for="">Линза типі <span class="red">*</span></label>
                            <select class="form-control" @change.prevent="search" v-model="lens.type_id" placeholder="Белсенді">
                                <option hidden :value="null">
                                    Линза типін таңдаңыз
                                </option>
                                <option v-for="type in types" :key="'type' + type.id" :value="type.id">
                                    {{type.name}}
                                </option>
                            </select>
                            <validation-error :field="'type_id'" />
                        </div>
                        <div class="form-group file-upload">
                            <label for="">Сурет <span class="red">*</span></label>
                            <div class="ml-2">
                                <img v-if="lens.img && !image.file" :src="route('index')  +'/storage/lenses/' +  lens.img" height="300" alt="image" style="padding-bottom: 10px" />
                                <img v-show="image.preview" :src="image.preview" height="300" style="padding-bottom: 10px" />
                                <div class="file-input" style="margin-right: 10px">
                                    <input type="file" hidden name="image" @change="handleImageUpload()" ref="image" accept="image/jpeg,image/png" class="file" id="image" />
                                    <label for="image"> Загрузить </label>
                                </div>
                            </div>
                            <validation-error :field="'img'" />
                        </div>
                        
                        <div class="form-group">
                            <label for="">Деоптерия <span class="red">*</span></label>
                            <input type="string" class="form-control" v-model="lens.dpt" name="dpt" placeholder="Деоптерия" />
                            <validation-error :field="'dpt'" />
                        </div>
                        <div class="form-group">
                            <label for="">Цега <span class="red">*</span></label>
                            <input type="number" class="form-control" v-model="lens.price" name="price" placeholder="Цега (тг)" />
                            <validation-error :field="'price'" />
                        </div>
                        
                        
                        <div class="form-group">
                            <label for="">Саны <span class="red">*</span></label>
                            <input type="text" class="form-control" v-model="lens.value" name="value" placeholder="Саны" />
                            <validation-error :field="'value'" />
                        </div>
                        
                        <div class="form-group">
                            <label for="">Қосымша</label>
                            <textarea type="text" class="form-control" v-model="lens.description" name="description" placeholder="Саны" rows=5 ></textarea>
                            <validation-error :field="'description'" />
                        </div>
                        
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary mr-1">
                            Сақтау
                        </button>
                        <button type="button" class="btn btn-danger" @click.prevent="back()">
                            Артқа
                        </button>
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

    export default {
        components: {
            AdminLayout,
            Link,
            Pagination,
            ValidationError,
            Head
        },
        props: ['types', 'lens'],
        data() {
            return {
                image: {
                    file: "",
                    preview: "",
                },
            }
        },
        methods: {

            submit() {
                if (this.image.file) {
                    this.lens.newImg = this.image.file
                }
                this.lens['_method']='put';
                this.$inertia.post(
                    route("admin.lenses.update", this.lens.id),
                    this.lens, {
                        onError: () => console.log("An error has occurred"),
                        onSuccess: () =>
                            console.log("The new contact has been saved"),
                    }
                );
            },
            handleImageUpload() {
                this.image.file = this.$refs.image.files[0];
                if (this.image.file) {
                    const reader = new FileReader();
                    reader.onloadend = (file) => {
                        this.image.preview = reader.result;
                    };
                    reader.readAsDataURL(this.image.file);
                    this.$refs.image.value = "";
                } else {
                    this.lens.img = "";
                    this.image.file = "";
                    this.image.preview = "";
                }
            },
        },
    };

</script>

<style lang="scss">
    .file-upload {
        .file {
            opacity: 0;
            width: 0.1px;
            height: 0.1px;
        }

        .file-input label {
            width: 158px;
            height: 40px;
            border-radius: 5px;
            border-color: #ddd;
            background: #eee;
            box-shadow: 0 3px 4px rgb(0 0 0 / 40%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #555;
            cursor: pointer;
            transition: transform 0.2s ease-out;
        }

        input:hover+label,
        input:focus+label {
            transform: scale(1.02);
        }
    }

</style>
