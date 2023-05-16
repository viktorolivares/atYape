<template>
    <div>

        <!-- ============================================================== -->
        <!-- Start Page Content here -->
        <!-- ============================================================== -->

        <Sidebar :route="route" :permissions="permissions"></Sidebar>

        <div class="content-page">
            <div class="content">
                <Navbar :route="route" :user="authUser" :permissions="permissions"></Navbar>
                <div class="container-fluid">
                    <router-view v-slot="{ Component }">
                        <Transition name="slide-fade" mode="out-in">
                            <component :is="Component"  :route="route" :user="user"/>
                        </Transition>
                    </router-view>
                </div>
            </div>
        </div>

        <Footer></Footer>

        <!-- ============================================================== -->
        <!-- End Page content -->
        <!-- ============================================================== -->
    </div>
</template>

<script>
import Navbar from './template/Navbar.vue';
import Footer from './template/Footer.vue';
import Sidebar from './template/Sidebar.vue';

export default {
    name: "App",
    props: ['route', 'user'],
    components: { Navbar, Footer, Sidebar },

    data() {
        return {
            authUser : this.user,
            permissions : []
        }
    },

    mounted() {

        this.permissions = JSON.parse(localStorage.getItem('permissions'));

        this.$eventBus.$on('verifyAuth', data => {
            this.authUser = data
            console.log(data)
        })

        this.$eventBus.$on('updatePermissions', data => {
            this.permissions = data
            console.log(data)
        })

    },
}
</script>
