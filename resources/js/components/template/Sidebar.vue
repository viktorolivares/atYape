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
                    <template v-if="permissions.includes('dashboard.index')">
                        <li class="side-nav-title side-nav-item">Home</li>
                        <li class="side-nav-item">
                            <router-link class="side-nav-link" :to="{ name: 'dashboard.index' }">
                                <i class="uil-dashboard"></i>
                                <span>Dashboard</span>
                            </router-link>
                        </li>
                    </template>
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
                    </template>
                    <template
                        v-if="permissions.includes('dni.index') || permissions.includes('ip.index') || permissions.includes('domain.index')">
                        <li class="side-nav-title side-nav-item">Utilidades</li>
                        <template v-if="permissions.includes('dni.index')">
                            <li class="side-nav-item">
                                <router-link class="side-nav-link" :to="{ name: 'dni.index' }">
                                    <i class="uil-file-check"></i>
                                    <span>Validar DNI</span>
                                </router-link>
                            </li>
                        </template>
                        <template v-if="permissions.includes('domain.index')">
                            <li class="side-nav-item">
                                <router-link class="side-nav-link" :to="{ name: 'domain.index' }">
                                    <i class="uil-globe"></i>
                                    <span>Dominios</span>
                                </router-link>
                            </li>
                        </template>
                        <template v-if="permissions.includes('ip.index')">
                            <li class="side-nav-item">
                                <router-link class="side-nav-link" :to="{ name: 'ip.index' }">
                                    <i class="uil-map-marker-info"></i>
                                    <span>IP</span>
                                </router-link>
                            </li>
                        </template>
                    </template>
                    <template v-if="permissions.includes('users.index') || permissions.includes('roles.index')">
                        <li class="side-nav-title side-nav-item">Admin</li>
                        <template v-if="permissions.includes('users.index')">
                            <li class="side-nav-item">
                                <router-link class="side-nav-link" :to="{ name: 'users.index' }">
                                    <i class="uil-user"></i>
                                    <span>Usuarios</span>
                                </router-link>
                            </li>
                        </template>
                        <template v-if="permissions.includes('roles.index')">
                            <li class="side-nav-item">
                                <router-link class="side-nav-link" :to="{ name: 'roles.index' }">
                                    <i class="uil-user-square"></i>
                                    <span>Roles</span>
                                </router-link>
                            </li>
                        </template>
                    </template>

                </ul>
                <!-- Help Box -->
                <div class="help-box text-white">
                    <h5 class="mt-3 text-center">Usuarios conectados</h5>
                    <ul class="list-group text-start">
                      <li class="list-group-item" v-for="user in connectedUsers" :key="user.id">
                        <span class="mdi mdi-checkbox-blank-circle text-success"></span>
                        {{ user.name }}
                      </li>
                    </ul>
                </div>
                <!-- end Help Box -->
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

    props: ['route', 'permissions'],

    data() {
        return {
            connectedUsers: [],
        };
    },

    created() {
        this.fetchUsersOnline()
    },

    methods: {
        fetchUsersOnline() {
            window.Echo.join('users-online')
            .here((users) => {
                this.connectedUsers = users
            })
            .joining((user) => {
                this.showToast(`Nuevo usuario conectado: ${user.name}`, {
                    type: "success"
                });
                this.connectedUsers.push(user);
            })
            .leaving((user) => {
                this.showToast(`Usuario desconectado: ${user.name}`, {
                    type: "warning"
                });
                const index = this.connectedUsers.findIndex(u => u.id === user.id);
                if (index !== -1) {
                    this.connectedUsers.splice(index, 1);
                }
            });
        },
    },
}
</script>


