<template>
    <div>
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="#">Usuarios</a></li>
                            <li class="breadcrumb-item active">Perfil de Usuarios</li>
                        </ol>
                    </div>
                    <h4 class="page-title">Perfil de Usuario</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->
        <div class="row">
            <div class="col-xl-4 col-lg-5">
                <div class="card text-center">
                    <div class="card-body">
                        <img :src="formData.file ? route + `/${formData.file.path}` : route + '/default.png'" class="rounded-circle avatar-lg img-thumbnail" alt="profile-image">
                        <h4 class="mb-0 mt-2">{{ formData.fullname }}</h4>
                        <p class="text-muted font-14">
                            <span class=" list-unstyled" v-for="role in formData.roles" :key="role.id">
                                [{{ role.name }}]
                            </span>
                        </p>
                        <div class="text-start mt-3">
                            <h4 class="font-13 text-uppercase">Sobre mi:</h4>
                            <p class="text-muted mb-2 font-13">
                                <strong>Nombre completo : </strong>
                                <span class="ms-2">{{ formData.firstname + ' ' + formData.lastname }}</span>
                            </p>
                            <p class="text-muted mb-2 font-13">
                                <strong>Email :</strong>
                                <span class="ms-2 ">{{ formData.email }}</span>
                            </p>
                        </div>

                        <img :src=" route + '/assets/images/logo_1.png'" class="mt-4" alt="profile-image" width="200">

                    </div> <!-- end card-body -->
                </div> <!-- end card -->
            </div> <!-- end col-->

            <div class="col-xl-8 col-lg-7">
                <div class="card">
                    <div class="card-body">
                        <div class="tab-content mt-lg-2">
                            <div class="tab-pane show active" id="settings">
                                    <form class="needs-validation" @submit.prevent="updateUser" novalidate>
                                    <h5 class="mb-4 text-uppercase"><i class="mdi mdi-account-circle me-1"></i> Personal
                                        Info</h5>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="firstname" class="form-label">Nombres</label>
                                                <input type="text" class="form-control" id="firstname"
                                                    placeholder="Nombres" v-model="formData.firstname" required>
                                                <div class="invalid-feedback">Por favor, ingrese un nombre válido.</div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="lastname" class="form-label">Apellidos</label>
                                                <input type="text" class="form-control" id="lastname"
                                                    placeholder="Apellidos" v-model="formData.lastname" required>
                                                <div class="invalid-feedback">Por favor ingrese un apellido válido.</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="current_confirmation" class="form-label">Contraseña actual:</label>
                                            <div class="input-group">
                                                <input :type="showConfirmPassword ? 'text' : 'password'"
                                                    id="current_confirmation" class="form-control"
                                                    v-model="formData.currentPassword"/>
                                                <div class="input-group-text" @click="toggleConfirmPassword">
                                                    <span class="mdi" :class="showConfirmPassword ? 'mdi-eye-off' : 'mdi-eye'"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="password" class="form-label">Nueva Contraseña:</label>
                                            <div class="input-group">
                                                <input :type="showPassword ? 'text' : 'password'" id="password"
                                                    class="form-control" :class="{ 'is-invalid': errors.password }"
                                                    v-model="formData.password" />
                                                <div class="input-group-text" @click="togglePassword">
                                                    <span class="mdi" :class="showPassword ? 'mdi-eye-off' : 'mdi-eye'"></span>
                                                </div>
                                                <div class="invalid-feedback" v-if="errors.password">
                                                    {{ errors.password[0] }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="my-4">
                                                <label for="password_confirmation" class="form-label">Confirmar
                                                    contraseña:</label>
                                                <div class="input-group">
                                                    <input :type="showConfirmPassword ? 'text' : 'password'"
                                                        id="password_confirmation" class="form-control"
                                                        v-model="formData.password_confirmation" />
                                                    <div class="input-group-text" @click="toggleConfirmPassword">
                                                        <span class="mdi" :class="showConfirmPassword ? 'mdi-eye-off' : 'mdi-eye'"></span>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="my-4">
                                                <label for="image" class="form-label">Seleccione una imagen</label>
                                                <div class="d-flex flex-wrap bg-success-lighten">
                                                    <span v-for="image  in preloadedImages" :key="image.filename"
                                                        class="card m-1 avatar-sm" style="cursor: pointer;"
                                                        :class="{ 'border border-success border-4': selectedImage && selectedImage.url === image.url }"
                                                        @click="selectedImage = image">
                                                        <img :src="image.url" class="card-img-top" :alt="image.filename" />
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-end">
                                        <button type="submit" class="btn btn-success mt-2">
                                            <i class="mdi mdi-content-save"></i>
                                            Guardar
                                        </button>
                                    </div>
                                </form>
                            </div>
                            <!-- end settings content-->
                        </div>
                        <!-- end tab-content -->
                    </div>
                    <!-- end card body -->
                </div>
                <!-- end card -->
            </div>
            <!-- end col -->
        </div>
        <!-- end row-->
    </div>
</template>

<script>
import axios from 'axios';
import toastMixin from "../mixins/toastMixin.js";

export default {

    mixins: [toastMixin],

    props: ['route', 'userId'],

    data() {
        return {
            formData: {
                id: null,
                firstname: '',
                lastname: '',
                email: '',
                password: '',
                password_confirmation: '',
                file: null,
            },
            showPassword: false,
            showConfirmPassword: false,
            currentPassword: '',
            errors: {},
            preloadedImages: [],
            selectedImage: null,

        };
    },

    created() {
        this.loadUserData();
    },

    methods: {

        async loadUserData() {
            try {
                const response = await axios.get(`/api/users/profile`);
                this.formData = response.data;

                if (this.formData.file) {
                    const preloadedImage = this.formData.file.path;
                    this.selectedImage = preloadedImage || null;
                }

            } catch (error) {
                console.error(error);
            }
        },

        async updateUser() {
            try {

                if (this.selectedImage) {
                    this.formData.selected_image = this.selectedImage.filename;
                    this.formData.selected_image_path = this.selectedImage.path;
                }

                this.formData.current_password = this.formData.currentPassword;

                const response = await axios.put('/api/users/profile', this.formData);
                this.onUserUpdatedOrCreate(response.data);

                this.getAuthUser();

            } catch (error) {

                if (error.response && error.response.status === 422) {
                    this.errors = error.response.data.errors;
                } else {
                    console.error("Error al actualizar el usuario:", error.message);
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
                location.reload()
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

        async getAuthUser(){
            try {
                const response = await axios.get('/api/refresh/auth');
                console.log(response.data)
                this.$eventBus.$emit('verifyAuth', response.data);

            } catch (error) {
                console.error(error);
            }
        },

        resetForm() {
            this.formData = {
                firstname: '',
                lastname: '',
                password: '',
                password_confirmation: '',
                currentPassword: '',
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
        this.getPreloadedImages();
    },

}
</script>
