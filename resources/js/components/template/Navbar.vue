<template>
    <div>
        <!-- Topbar Start -->
        <div class="navbar-custom">
            <ul class="list-unstyled topbar-menu float-end mb-0">
                <template
                    v-if="permissions.includes('yape.business') || permissions.includes('yape.televentas') || permissions.includes('yape.mulfood') || permissions.includes('yape.teleservicios')">

                    <li class="dropdown notification-list topbar-dropdown">
                        <a class="nav-link dropdown-toggle arrow-none" data-bs-toggle="dropdown" href="#" role="button"
                            aria-haspopup="false" aria-expanded="false">
                            <img :src="route + '/assets/images/yape.png'" alt="Yape!" class="me-0 me-sm-2" height="40">
                            <i class="mdi mdi-chevron-down d-none d-sm-inline-block align-middle"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end dropdown-menu-animated topbar-dropdown-menu">
                            <!-- item-->

                            <template v-if="permissions.includes('yape.business')">
                                <router-link class="dropdown-item notify-item" :to="{ name: 'yape.business' }">
                                    <i class="mdi mdi-circle mx-1 text-success"></i>
                                    <span class="align-middle">Business</span>
                                </router-link>
                            </template>
                            <!-- item-->
                            <template v-if="permissions.includes('yape.televentas')">
                                <router-link class="dropdown-item notify-item" :to="{ name: 'yape.televentas' }">
                                    <i class="mdi mdi-circle mx-1 text-primary"></i>
                                    Televentas
                                </router-link>
                            </template>
                            <!-- item-->
                            <template v-if="permissions.includes('yape.mulfood')">
                                <router-link class="dropdown-item notify-item" :to="{ name: 'yape.mulfood' }">
                                    <i class="mdi mdi-circle mx-1 text-warning"></i>
                                    Mulfood
                                </router-link>
                            </template>
                            <!-- item-->
                            <template v-if="permissions.includes('yape.teleservicios')">
                                <router-link class="dropdown-item notify-item" :to="{ name: 'yape.teleservicios' }">
                                    <i class="mdi mdi-circle mx-1 text-danger"></i>
                                    Teleservicios
                                </router-link>
                            </template>
                        </div>
                    </li>
                </template>
                <li class="dropdown notification-list">
                    <a class="nav-link dropdown-toggle nav-user arrow-none me-0" data-bs-toggle="dropdown" href="#"
                        role="button" aria-haspopup="false" aria-expanded="false">
                        <span class="account-user-avatar">

                            <template v-if="!user.file_id">
                                <img :src="route + '/default.png'" alt="user-image" class="rounded-circle">
                            </template>
                            <template v-else>
                                <img :src="route + `/${user.file.path}`" alt="user-image" class="rounded-circle">
                            </template>
                        </span>
                        <span>
                            <span class="account-user-name">{{ user.firstname }}</span>
                            <span class="account-position">{{ user.email }}</span>
                        </span>
                    </a>
                    <div
                        class="dropdown-menu dropdown-menu-end dropdown-menu-animated topbar-dropdown-menu profile-dropdown">
                        <!-- item-->
                        <div class=" dropdown-header noti-title">
                            <h6 class="text-overflow m-0">Welcome !</h6>
                        </div>
                        <!-- item-->
                        <router-link class="dropdown-item notify-item" :to="{ name: 'users.profile' }">
                            <i class="mdi mdi-account-circle me-1"></i>
                            <span>Mi perfil</span>
                        </router-link>
                        <!-- item-->
                        <button type="button" @click.prevent="logout" class="dropdown-item notify-item">
                            <i class="mdi mdi-logout me-1"></i>
                            <span>Logout</span>
                        </button>
                    </div>
                </li>
            </ul>
            <button class="button-menu-mobile open-left">
                <i class="mdi mdi-menu"></i>
            </button>
            <div class="app-search dropdown d-none d-lg-block">
            </div>
        </div>
        <!-- end Topbar -->
    </div>
</template>

<script>

import toastMixin from "../modules/mixins/toastMixin";

export default {

    props: ['route', 'user', 'permissions'],

    mixins: [toastMixin],

    methods: {
        logout() {
            axios.post('/logout')
                .then(response => {
                    if (response.data === 204) {
                        this.showToast("¡Hasta Pronto!", {
                            position: "top-center",
                            type: 'info'
                        });

                        setTimeout(() => {
                            localStorage.clear();
                            window.location.href = "/login";
                        }, 2000);
                    }
                })
                .catch(error => console.log(error));
        },
    },

}
</script>

