<template>
    <div>
        <!-- Topbar Start -->
        <div class="navbar-custom">
            <ul class="list-unstyled topbar-menu float-end mb-0">
                <li class="dropdown notification-list">
                    <a class="nav-link dropdown-toggle arrow-none" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                        <i class="dripicons-bell noti-icon"></i>
                        <span class="noti-icon-badge"></span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end dropdown-menu-animated dropdown-lg">

                        <!-- item-->
                        <div class="dropdown-item noti-title">
                            <h5 class="m-0">
                                <span class="float-end">
                                    <a href="javascript: void(0);" class="text-dark">
                                        <small>Clear All</small>
                                    </a>
                                </span>Notification
                            </h5>
                        </div>

                        <div style="max-height: 230px;" data-simplebar="">
                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item notify-item">
                                <div class="notify-icon bg-primary">
                                    <i class="mdi mdi-comment-account-outline"></i>
                                </div>
                                <p class="notify-details">Caleb Flakelar commented on Admin
                                    <small class="text-muted">1 min ago</small>
                                </p>
                            </a>
                        </div>

                        <!-- All-->
                        <a href="javascript:void(0);" class="dropdown-item text-center text-primary notify-item notify-all">
                            View All
                        </a>

                    </div>
                </li>

                <li class="notification-list">
                    <a class="nav-link end-bar-toggle" href="javascript: void(0);">
                        <i class="dripicons-gear noti-icon"></i>
                    </a>
                </li>

                <li class="dropdown notification-list">
                    <a class="nav-link dropdown-toggle nav-user arrow-none me-0" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
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
                            <span class="account-position">{{ user.email  }}</span>
                        </span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end dropdown-menu-animated topbar-dropdown-menu profile-dropdown">
                        <!-- item-->
                        <div class=" dropdown-header noti-title">
                            <h6 class="text-overflow m-0">Welcome !</h6>
                        </div>

                        <!-- item-->

                        <router-link class="dropdown-item notify-item" :to="{name: 'users.profile'}">
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
        </div>
        <!-- end Topbar -->
    </div>
</template>

<script>

import toastMixin from "../modules/mixins/toastMixin";

export default {

    props: ['route', 'user'],
    mixins: [toastMixin],

    methods: {
        logout() {
            axios.post('/api/logout')
                .then(response => {

                    var toastDuration = 2000

                    this.showToast("¡Hasta Pronto!", {
                        position: "top-center",
                        duration: toastDuration,
                        type: "success"
                    });

                    setTimeout(() => {
                        window.location.href = "/login";
                    }, toastDuration);

                    localStorage.clear();
                })
                .catch(error => console.log(error))
        }
    }
}
</script>

