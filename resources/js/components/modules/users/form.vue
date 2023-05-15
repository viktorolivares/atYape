<template>
    <div>
        <div>
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        <div class="page-title-right d-flex">
                            <router-link class="btn btn-sm btn-primary" :to="'/users'" aria-label="Ir a lista de usuarios">
                                <i class="mdi mdi-arrow-left"></i>
                                Volver
                            </router-link>
                        </div>
                        <h4 class="page-title">{{ userId ? 'Editar' : 'Crear' }} Usuario</h4>
                    </div>
                </div>
            </div>
            <!-- end page title -->
            <div class="row ">
                <div class="col-md-12 mt-2">
                    <form class="needs-validation" @submit.prevent="createUser" novalidate>
                        <div class="row">
                            <div class="col-md-7">
                                <div class="card">
                                    <div :class="['card-header', userId ? 'bg-success-lighten' : 'bg-primary-lighten']">
                                        <div class="card-title">{{ userId ? 'Editar Usuario' : 'Crear Usuario' }}</div>
                                    </div>
                                    <div class="card-body row g-3">
                                        <div class="col-md-6">
                                            <label for="firstname" class="form-label">Nombre:</label>
                                            <input type="text" id="firstname" class="form-control"
                                                :class="{ 'is-invalid': errors.firstname }" v-model="formData.firstname"
                                                required />
                                            <div class="invalid-feedback" v-if="errors.firstname">
                                                {{ errors.firstname[0] }}
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="lastname" class="form-label">Apellido:</label>
                                            <input type="text" id="lastname" class="form-control"
                                                :class="{ 'is-invalid': errors.lastname }" v-model="formData.lastname"
                                                required />
                                            <div class="invalid-feedback" v-if="errors.lastname">
                                                {{ errors.lastname[0] }}
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="email" class="form-label">Email:</label>
                                            <input type="email" id="email" class="form-control"
                                                :class="{ 'is-invalid': errors.email }" v-model="formData.email" required
                                                :disabled="userId" />
                                            <div class="invalid-feedback" v-if="errors.email">
                                                {{ errors.email[0] }}
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="password" class="form-label">Contraseña:</label>
                                            <div class="input-group">
                                                <input :type="showPassword ? 'text' : 'password'" id="password"
                                                    class="form-control" :class="{ 'is-invalid': errors.password }"
                                                    v-model="formData.password" :required="!userId" />
                                                <div class="input-group-text" @click="togglePassword">
                                                    <span class="mdi"
                                                        :class="showPassword ? 'mdi-eye-off' : 'mdi-eye'"></span>
                                                </div>
                                                <div class="invalid-feedback" v-if="errors.password">
                                                    {{ errors.password[0] }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="password_confirmation" class="form-label">Confirmar
                                                contraseña:</label>
                                            <div class="input-group">
                                                <input :type="showConfirmPassword ? 'text' : 'password'"
                                                    id="password_confirmation" class="form-control"
                                                    v-model="formData.password_confirmation" :required="!userId" />
                                                <div class="input-group-text" @click="toggleConfirmPassword">
                                                    <span class="mdi"
                                                        :class="showConfirmPassword ? 'mdi-eye-off' : 'mdi-eye'"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="roles" class="form-label">Roles</label>
                                            <select v-model="selectedRoles" multiple class="form-select" id="roles"
                                                name="roles" required>
                                                <option v-for="role in allRoles" :key="role.id" :value="role.id">
                                                    {{ role.name }}
                                                </option>
                                            </select>
                                            <div class="invalid-feedback" v-if="errors.roles">
                                                {{ errors.roles[0] }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <button :class="['btn', userId ? 'btn-success' : 'btn-primary',]"
                                            type="submit">{{ userId ? 'Actualizar' : 'Guardar' }}</button>
                                        <button class="btn btn-secondary mx-2" type="button"
                                            @click="resetForm">Reset</button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="card mb-3">
                                    <div class="card-body">
                                        <label for="image" class="form-label">Selecciona una imagen</label>
                                        <div class="d-flex flex-wrap bg-dark-lighten">
                                            <span v-for="image in preloadedImages" :key="image.filename"
                                                class="card mx-1 my-1 avatar-sm" style="cursor: pointer;"
                                                :class="{ 'border border-success border-4': selectedImage && selectedImage.url === image.url }"
                                                @click="selectedImage = image">
                                                <img :src="image.url" class="card-img-top p-1" :alt="image.filename" />
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <!-- end row -->
        </div>
    </div>
</template>


<script>
import axios from 'axios';
import toastMixin from "../mixins/toastMixin.js";

export default {

    mixins: [toastMixin],

    props: ['userId'],

    data() {
        return {
            formData: {
                id: null,
                firstname: '',
                lastname: '',
                email: '',
                password: '',
                roles: '',
                password_confirmation: '',
                file: null,
            },
            showPassword: false,
            showConfirmPassword: false,
            errors: {},
            preloadedImages: [],
            selectedImage: null,
            selectedRoles: [],
            allRoles: [],
        };
    },

    created() {
        this.loadUserData();
    },

    methods: {

        async loadUserData() {
            if (!this.userId) {
                return;
            }

            try {
                const response = await axios.get(`/api/users/${this.userId}`);
                this.formData = response.data;

                if (this.formData.file) {
                    const preloadedImage = this.formData.file.path;
                    this.selectedImage = preloadedImage || null;
                }

                if (this.formData.roles) {
                    this.selectedRoles = this.formData.roles.map(role => role.id);
                }

            } catch (error) {
                console.error(error);
            }
        },

        async loadAllRoles() {
            try {
                const response = await axios.get("/api/roles/all");
                this.allRoles = response.data;
            } catch (error) {
                console.error("Error al cargar roles:", error.message);
            }
        },

        async createUser() {
            try {

                if (this.selectedImage) {
                    this.formData.selected_image = this.selectedImage.filename;
                }

                if (this.selectedRoles) {
                    this.formData.roles = this.selectedRoles;
                }

                let response;

                if (this.userId) {
                    response = await axios.put(`/api/users/${this.userId}`, this.formData);
                    this.onUserUpdatedOrCreate(response.data);

                } else {
                    response = await axios.post('/api/users/save', this.formData);
                    this.onUserUpdatedOrCreate(response.data);
                }
            } catch (error) {

                if (error.response && error.response.status === 422) {
                    this.errors = error.response.data.errors;
                } else {
                    console.error("Error al crear o actualizar el usuario:", error.message);
                }

                this.showToast("Ocurrió un problema!", {
                    type: "error",
                });
            }
        },

        onUserUpdatedOrCreate(userData) {

            const toastDuration = 2000;
            this.showToast("Success, Usuario actualizado con éxito: ", {
                type: "success",
                duration: toastDuration,
            });

            setTimeout(() => {
                this.$router.push("/users");
            }, toastDuration);
        },

        togglePassword() {
            this.showPassword = !this.showPassword;
        },

        toggleConfirmPassword() {
            this.showConfirmPassword = !this.showConfirmPassword;
        },

        onImageChange(event) {
            this.formData.file = event.target.files[0];
        },

        async getPreloadedImages() {
            try {
                const response = await axios.get('/api/files/preloaded');
                this.preloadedImages = response.data;
            } catch (error) {
                console.error('Error al obtener las imágenes precargadas:', error.message);
            }
        },

        resetForm() {
            this.formData = {
                firstname: '',
                lastname: '',
                email: '',
                password: '',
                password_confirmation: '',
                file: null,
            };
            this.errors = {};
            this.selectedImage = null;
            if (this.userId) {
                this.loadUserData();
            }
        },


    },

    mounted() {

        this.$nextTick(() => {
            const forms = this.$el.querySelectorAll('.needs-validation');
            Array.prototype.slice.call(forms).forEach((form) => {
                form.addEventListener(
                    'submit',
                    (event) => {
                        if (!form.checkValidity()) {
                            event.preventDefault();
                            event.stopPropagation();
                        }
                        form.classList.add('was-validated');
                    },
                    false
                );
            });

        });

        this.loadUserData();
        this.loadAllRoles();
        this.getPreloadedImages();
    },
};
</script>
