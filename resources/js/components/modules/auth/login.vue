<template>
    <div>
        <div class="account-pages pt-2 pt-sm-5 pb-2 pb-sm-5">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-xxl-4 col-lg-5">
                        <div class="card">
                            <!-- Logo -->
                            <div class="card-header pt-3 pb-3 text-center bg-dark">
                                <a href="#">
                                    <span>
                                        <img :src="route + '/assets/images/logo_2.png'" alt="Login" height="40" />
                                    </span>
                                </a>
                            </div>

                            <div class="card-body p-3">
                                <div class="text-center w-75 m-auto">
                                    <h4 class="text-dark-50 text-center pb-3 fw-bold">Login</h4>
                                </div>

                                <form class="needs-validation" @submit.prevent="performLogin" novalidate>
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email</label>
                                        <input :class="['form-control', emailError ? 'is-invalid' : '']" v-model="email"
                                            type="email" id="email" required autofocus />
                                        <span v-if="emailError" class="invalid-feedback" role="alert">
                                            {{ emailError }}
                                        </span>
                                    </div>
                                    <div class="mb-3">
                                        <a href="#" class="text-primary float-end">
                                            <small>Olvidaste tu contraseña</small>
                                        </a>

                                        <label for="password" class="form-label">Password</label>
                                        <div class="input-group input-group-merge">
                                            <input :type="showPassword ? 'text' : 'password'" id="password"
                                                v-model="password"
                                                :class="['form-control', passwordError ? 'is-invalid' : '']" required />
                                            <div class="input-group-text" @click="togglePasswordVisibility">
                                                <span class="mdi" :class="showPassword ? 'mdi-eye-off' : 'mdi-eye'"></span>
                                            </div>
                                            <span v-if="passwordError" class="invalid-feedback" role="alert">
                                                {{ passwordError }}
                                            </span>
                                        </div>

                                    </div>

                                    <div class="mb-3 mb-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" v-model="remember"
                                                id="remember" />
                                            <label class="form-check-label" for="remember">Remember Me</label>
                                        </div>
                                    </div>

                                    <div class="mb-3 mb-0 text-center">
                                        <button type="submit" :disabled="processing" class="btn btn-primary btn-block px-4">
                                            {{ processing ? "Please wait" : "Login" }}
                                        </button>
                                    </div>

                                </form>
                            </div>
                            <!-- End card-body -->
                        </div>
                        <!-- End card -->
                    </div>
                    <!-- End col -->
                </div>
                <!-- End row -->
            </div>
            <!-- End container -->
        </div>
    </div>
</template>

<script>

import toastMixin from "../mixins/toastMixin.js";
import { mapActions } from 'vuex';


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
        };
    },

    methods: {

        ...mapActions(['login']),

        async performLogin() {
            this.processing = true;

            const credentials = {
                email: this.email,
                password: this.password,
                remember: this.remember,
            };

            try {
                const response = await this.login(credentials);


                console.log(response)

                this.getRolePermissions(response);
                this.createActivityLog('connection', response.email);

                var toastDuration = 2000;
                this.processing = false;

                this.showToast("¡Bienvenido!", {
                    type: "success",
                    duration: toastDuration,
                    theme: 'colored',
                });

                setTimeout(() => {
                    window.location.href = "/";
                }, toastDuration);

            } catch (error) {

                if (error.response && error.response.status === 422) {
                    this.processing = false;
                    console.log(error.response);

                    this.showToast(error.response.data.message, {
                        type: 'error',
                        position: 'top-center',
                        theme: 'colored',
                    });

                    const errors = error.response.data.errors;
                    this.emailError = errors.email ? errors.email[0] : false;
                    this.passwordError = errors.password ? errors.password[0] : false;
                } else {
                    console.error(error);
                    this.processing = false;
                }
            }
        },


        async getRolePermissions(authUser) {
            try {
                const response = await axios.get("/api/users/roles/permissions", {
                    params: {
                        "userId": authUser.id
                    }
                });
                if (response.status === 200) {

                    console.log(response.data)
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

        createActivityLog(type, email) {
            axios.post('/api/logs', { type: type, email: email })
                .then(response => {
                    console.log(response.data)
                })
                .catch(error => {
                    console.log(error)
                });
        },

    },

};

</script>
