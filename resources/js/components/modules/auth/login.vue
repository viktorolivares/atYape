<template>
    <div>
        <div class="account-pages pt-2 pt-sm-5 pb-4 pb-sm-5">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-xxl-4 col-lg-5">
                        <Transition name="slide-fade" mode="out-in">
                            <div class="card" v-if="showCard">
                                <div class="row g-0 align-items-center">
                                    <div class="col-md-8">
                                        <div class="card-body">
                                            <h4 class="card-title">Recuperación de contraseña</h4>
                                            <p class="card-text font-12">No te preocupes, a todos nos pasa.
                                                Para recuperar tu contraseña, por favor comunícate con el administrador.</p>
                                            <button class="btn btn-primary btn-sm my-2 scale-up-center"
                                                @click="showLoginForm">
                                                <i class="mdi mdi-arrow-left"></i>
                                                Volver
                                            </button>
                                            <p class="card-text text-muted font-10 mt-2">
                                                Equipo de Prevención de Fraude
                                            </p>
                                        </div> <!-- end card-body-->
                                    </div> <!-- end col -->
                                    <div class="col-md-4">
                                        <img :src="route + '/assets/images/at.jpg'" class="card-img" alt="Login" />
                                    </div>
                                </div> <!-- end row-->
                            </div> <!-- end card-->
                            <div class="card" v-else>
                                <!-- Logo -->
                                <div class="card-header pt-3 pb-3 text-center bg-dark">
                                    <img :src="route + '/assets/images/logo_2.png'" alt="Login" height="40" />
                                </div>
                                <div class="card-body p-3">
                                    <div class="text-center w-75 m-auto">
                                        <h4 class="text-dark-50 text-center pb-3 fw-bold">Inicio de Sesión</h4>
                                    </div>
                                    <form class="needs-validation" @submit.prevent="login" novalidate>
                                        <div class="mb-3">
                                            <label for="email" class="form-label">Email</label>
                                            <input :class="['form-control', emailError ? 'is-invalid' : '']" v-model="email"
                                                type="email" id="email" required autofocus />
                                            <span v-if="emailError" class="invalid-feedback" role="alert">
                                                {{ emailError }}
                                            </span>
                                        </div>
                                        <div class="mb-3">
                                            <a href="#" class="text-primary float-end" @click.prevent="showCard = true">
                                                <small>Olvidaste tu contraseña</small>
                                            </a>

                                            <label for="password" class="form-label">Contraseña</label>
                                            <div class="input-group input-group-merge">
                                                <input :type="showPassword ? 'text' : 'password'" id="password"
                                                    v-model="password"
                                                    :class="['form-control', passwordError ? 'is-invalid' : '']" required />
                                                <div class="input-group-text" @click="togglePasswordVisibility">
                                                    <span class="mdi"
                                                        :class="showPassword ? 'mdi-eye-off' : 'mdi-eye'"></span>
                                                </div>
                                                <span v-if="passwordError" class="invalid-feedback" role="alert">
                                                    {{ passwordError }}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" v-model="remember"
                                                    id="remember" />
                                                <label class="form-check-label" for="remember">Recuérdame</label>
                                            </div>
                                        </div>
                                        <div class="mb-2 mt-4 text-center d-grid gap-2">
                                            <button type="submit" :disabled="processing"
                                                class="btn btn-primary btn-block px-4">
                                                {{ processing ? "Espere por favor..." : "Login" }}
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </transition>
                        <!-- End card -->
                    </div>
                    <!-- End col -->
                </div>
                <!-- End row -->
            </div>
            <!-- End container -->
        </div>
        <!-- end page -->
    </div>
</template>

<script>

import toastMixin from "../mixins/toastMixin.js";

export default {

    name: "Login",
    props: ['route'],
    mixins: [toastMixin],

    data() {
        return {
            email: "",
            password: "",
            remember: false,
            emailError: false,
            passwordError: false,
            showPassword: false,
            processing: false,
            showCard: false
        };
    },

    methods: {

        async login() {
            this.processing = true
            try {
                const response = await axios.post("/login", {
                    email: this.email,
                    password: this.password,
                    remember: this.remember,
                });
                if (response.status === 200) {

                    const user = response.data.authUser

                    this.getRolePermissions(user);

                    var toastDuration = 2000;
                    this.showToast("¡Bienvenido!", {
                        type: "success",
                        duration: toastDuration,
                        theme: 'colored',
                    });

                    setTimeout(() => {
                        window.location.href = "/";
                        this.processing = false;
                    }, toastDuration);
                }
            } catch (error) {
                if (error.response && error.response.status === 422) {
                    this.processing = false

                    this.showToast(error.response.data.message, { type: "error" });

                    const errors = error.response.data.errors;
                    this.emailError = errors.email ? errors.email[0] : false;
                    this.passwordError = errors.password ? errors.password[0] : false;

                } else {
                    console.error(error);
                    this.processing = false
                }
            }
        },

        async getRolePermissions(authUser) {
            try {
                const response = await axios.get("/admin/users/roles/permissions", {
                    params: {
                        "userId": authUser.id
                    }
                })
                if (response.status === 200) {
                    localStorage.setItem('permissions', JSON.stringify(response.data));
                    localStorage.setItem('authUser', JSON.stringify(authUser))
                }
            } catch (error) {
                console.log(error)
            }
        },

        togglePasswordVisibility() {
            this.showPassword = !this.showPassword;
        },

        showLoginForm() {
            this.showCard = false;
        }
    },
};

</script>
