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
            <div class="h-100" id="leftside-menu-container" data-simplebar="">
                <!--- Sidemenu -->
                <ul class="side-nav">

                    <template v-if="permissions.includes('dashboard.index')">
                        <li class="side-nav-title side-nav-item">Home</li>
                        <li class="side-nav-item">
                            <router-link class="side-nav-link" :to="'/'">
                                <i class="uil-dashboard"></i>
                                <span>Dashboard</span>
                            </router-link>
                        </li>
                    </template>

                    <template v-if="permissions.includes('transactions.index')">
                        <li class="side-nav-title side-nav-item">APP</li>
                        <template v-if="permissions.includes('transactions.index')">
                            <li class="side-nav-item">
                                <router-link class="side-nav-link" :to="'/transactions'">
                                    <i class="uil-bill"></i>
                                    <span>Transacciones</span>
                                </router-link>
                            </li>
                        </template>
                    </template>

                    <template v-if="permissions.includes('dni.index') || permissions.includes('ip.index') || permissions.includes('domain.index')">

                        <li class="side-nav-title side-nav-item">Utilidades</li>

                        <template v-if="permissions.includes('dni.index')">
                            <li class="side-nav-item">
                                <router-link class="side-nav-link" :to="'/dni'">
                                    <i class="uil-file-check"></i>
                                    <span>Validar DNI</span>
                                </router-link>
                            </li>
                        </template>

                        <template v-if="permissions.includes('ip.index')">
                            <li class="side-nav-item">
                                <router-link class="side-nav-link" :to="'/ip'">
                                    <i class="uil-map-marker-info"></i>
                                    <span>IP</span>
                                </router-link>
                            </li>
                        </template>

                        <template v-if="permissions.includes('domain.index')">
                            <li class="side-nav-item">
                                <router-link class="side-nav-link" :to="'/domain'">
                                    <i class="uil-globe"></i>
                                    <span>Dominios</span>
                                </router-link>
                            </li>
                        </template>

                    </template>

                    <template v-if="permissions.includes('users.index') || permissions.includes('roles.index')">
                        <li class="side-nav-title side-nav-item">Admin</li>
                        <template v-if="permissions.includes('users.index')">
                            <li class="side-nav-item">
                                <router-link class="side-nav-link" :to="'/users'">
                                    <i class="uil-user"></i>
                                    <span>Usuarios</span>
                                </router-link>
                            </li>
                        </template>
                        <template v-if="permissions.includes('roles.index')">
                            <li class="side-nav-item">
                                <router-link class="side-nav-link" :to="'/roles'">
                                    <i class="uil-user-square"></i>
                                    <span>Roles</span>
                                </router-link>
                            </li>
                        </template>
                    </template>
                </ul>
            <!-- End Sidebar -->
            <div class="clearfix"></div>
        </div>
        <!-- Sidebar -left -->
        </div>
    <!-- Left Sidebar End -->
    </div>
</template>

<script>
export default {
    props: ['route', 'permissions'],
}
</script>


