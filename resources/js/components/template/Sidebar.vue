<template>
    <div>
        <!-- ========== Left Sidebar Start ========== -->
        <div class="leftside-menu">
            <!-- LOGO -->
            <a href="index.html" class="logo text-center logo-dark">
                <span class="logo-lg">
                    <img :src="route + '/assets/images/logo_1.png'" alt="" height="26">
                </span>
                <span class="logo-sm">
                    <img :src="route + '/assets/images/logo_sm_dark.png'" alt="" height="16">
                </span>
            </a>
            <!-- LOGO -->
            <a :href="route" class="logo text-center logo-light">
                <span class="logo-lg">
                    <img :src="route + '/assets/images/logo_2.png'" alt="" height="30">
                </span>
                <span class="logo-sm">
                    <img :src="route + '/assets/images/logo_sm.png'" alt="" height="16">
                </span>
            </a>
            <div class="h-100" id="leftside-menu-container" data-simplebar>
                <!--- Sidemenu -->
                <ul class="side-nav">
                    <!-- Dashboard -->
                    <template v-if="permissions.includes('dashboard.index')">
                        <li class="side-nav-title side-nav-item">Home</li>
                        <li :class="['side-nav-item', { 'menuitem-active': isActiveRoute('dashboard.index') }]">
                            <router-link class="side-nav-link" :to="{ name: 'dashboard.index' }">
                                <i class="uil-dashboard"></i>
                                <span>Dashboard</span>
                            </router-link>
                        </li>
                    </template>
                    <!-- Transacciones + APK -->
                    <template v-if="permissions.includes('transactions.index')">
                        <li class="side-nav-title side-nav-item">APP</li>
                        <template v-if="permissions.includes('transactions.index')">
                            <li class="side-nav-item">
                                <router-link class="side-nav-link" :to="{ name: 'transactions.index' }">
                                    <i class="uil-bill"></i>
                                    <span>Transacciones</span>
                                </router-link>
                            </li>
                        </template>
                        <!-- <li class="side-nav-item">
                            <a class="side-nav-link">
                                <i class="uil-mobile-vibrate"></i>
                                <span>APK</span>
                            </a>
                        </li> -->
                    </template>
                    <!-- Gestión de Usuarios -->
                    <template v-if="permissions.includes('users.index') || permissions.includes('roles.index')">
                        <li class="side-nav-title side-nav-item">Admin</li>
                        <li class="side-nav-item">
                            <a data-bs-toggle="collapse" href="#users" aria-expanded="false" aria-controls="utilities"
                                class="side-nav-link">
                                <i class="uil-store"></i>
                                <span> Gestión de Usuarios </span>
                                <span class="menu-arrow"></span>
                            </a>
                            <div class="collapse" id="users"
                                :class="{ 'show': isActiveRoute(['users.index', 'roles.index']) }">
                                <ul class="side-nav-second-level">
                                    <template v-if="permissions.includes('users.index')">
                                        <li :class="{ 'menuitem-active': isActiveRoute('users.index') }">
                                            <router-link :to="{ name: 'users.index' }">
                                                <i class="uil-user"></i>
                                                <span>&nbsp;Usuarios</span>
                                            </router-link>
                                        </li>
                                    </template>
                                    <template v-if="permissions.includes('roles.index')">
                                        <li :class="{ 'menuitem-active': isActiveRoute('roles.index') }">
                                            <router-link :to="{ name: 'roles.index' }">
                                                <i class="uil-user-square"></i>
                                                <span>&nbsp;Roles</span>
                                            </router-link>
                                        </li>
                                    </template>
                                </ul>
                            </div>
                        </li>
                    </template>
                    <!-- Utilidades -->
                    <template
                        v-if="permissions.includes('dni.index') || permissions.includes('ip.index') || permissions.includes('domain.index') || permissions.includes('logs.index')">
                        <li class="side-nav-title side-nav-item">Tasks</li>
                        <li class="side-nav-item">
                            <a data-bs-toggle="collapse" href="#utilities" aria-expanded="false" aria-controls="utilities"
                                class="side-nav-link">
                                <i class="uil-store"></i>
                                <span> Utilidades </span>
                                <span class="menu-arrow"></span>
                            </a>
                            <div class="collapse" id="utilities" :class="{ 'show': isActiveRoute(['dni.index', 'domain.index', 'logs.index', 'ip.index']) }">
                                <ul class="side-nav-second-level">
                                    <template v-if="permissions.includes('dni.index')">
                                        <li :class="{ 'menuitem-active': isActiveRoute('dni.index') }">
                                            <router-link :to="{ name: 'dni.index' }">
                                                <i class="uil-file-check"></i>
                                                &nbsp;<span>Validar DNI</span>
                                            </router-link>
                                        </li>
                                    </template>
                                    <template v-if="permissions.includes('domain.index')">
                                        <li :class="{ 'menuitem-active': isActiveRoute('domain.index') }">
                                            <router-link :to="{ name: 'domain.index' }">
                                                <i class="uil-globe"></i>
                                                &nbsp;<span>Dominios</span>
                                            </router-link>
                                        </li>
                                    </template>
                                    <template v-if="permissions.includes('logs.index')">
                                        <li :class="{ 'menuitem-active': isActiveRoute('logs.index') }">
                                            <router-link :to="{ name: 'logs.index' }">
                                                <i class="uil-file-info-alt"></i>
                                                &nbsp;<span>Logs</span>
                                            </router-link>
                                        </li>
                                    </template>
                                    <template v-if="permissions.includes('ip.index')">
                                        <li :class="{ 'menuitem-active': isActiveRoute('ip.index') }">
                                            <router-link :to="{ name: 'ip.index' }">
                                                <i class="uil-map-marker-info"></i>
                                                &nbsp;<span>IP</span>
                                            </router-link>
                                        </li>
                                    </template>

                                </ul>
                            </div>
                        </li>
                    </template>
                </ul>
                <!-- Users online -->
                <div class="help-box text-white text-center mt-3">
                    <img :src="route + '/assets/images/rocket.svg'" height="40" alt="Helper Icon Image">
                    <h5 class="mt-3">🔌Usuarios conectados</h5>
                    <div v-if="isLoading" class="spinner-border text-light" role="status"></div>
                    <ul class="list-group text-start">
                        <li v-for="user in connectedUsers" :key="user.id" class="list-group-item p-1">
                          <div class="row align-items-center">
                            <div class="col-1">
                              <i class="mdi mdi-checkbox-blank-circle text-success"></i>
                            </div>
                            <div class="col-10">
                              {{ user.id === this.user.id ? 'Tú' : user.name }}
                            </div>
                          </div>
                        </li>
                      </ul>
                    <p class="mt-3">Desarrollado por Prevención de Fraude [Online]⚡</p>
                </div>
                <!-- end Users online -->
                <!-- End Sidebar -->
                <div class="clearfix"></div>
            </div>
            <!-- Sidebar -left -->
        </div>
        <!-- Left Sidebar End -->
    </div>
</template>

<script>
import toastMixin from "../modules/mixins/toastMixin";

export default {

    mixins: [toastMixin],
    props: ['route', 'permissions', 'user'],

    data() {
        return {
            connectedUsers: [],
            isLoading: true
        };
    },

    created() {
        this.fetchUsersOnline();
    },

    methods: {
        fetchUsersOnline() {
            window.Echo.join('users-online')
                .here((users) => {
                    this.connectedUsers = users;
                    this.isLoading = false;
                })
                .joining((user) => {
                    this.connectedUsers.push(user);
                    this.isLoading = false;
                })
                .leaving((user) => {
                    const index = this.connectedUsers.findIndex(u => u.id === user.id);
                    if (index !== -1) {
                        this.connectedUsers.splice(index, 1);
                    }
                    this.isLoading = false;
                });
        },

        isActiveRoute(routeName) {
            return this.$route.name === routeName || (Array.isArray(routeName) && routeName.includes(this.$route.name));
        }
    },
};
</script>

