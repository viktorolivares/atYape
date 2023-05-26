<template>
    <div>
        <div class="account-pages pt-2 pt-sm-5 pb-4 pb-sm-5">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-xxl-4 col-lg-5">
                        <div class="card">
                            <!-- Logo -->
                            <div class="card-header pt-4 pb-4 text-center">
                                <a href="#">
                                    <span>
                                        <img :src="route + '/assets/images/logo_1.png'" alt="..." height="40"/>
                                    </span>
                                </a>
                            </div>
                            <div class="card-body p-4">
                                <div class="text-center w-75 m-auto">
                                    <h5 class="text-dark-50 text-center mt-0 fw-bold">
                                        ¡Oops! Sesión cerrada por inactividad
                                    </h5>
                                    <p class="text-success font-13 my-4">
                                        Lo siento, parece que te has desconectado por un período de inactividad. Inicia sesión nuevamente para continuar.
                                    </p>
                                </div>
                                <div class="logout-icon m-auto">
                                    <img :src="route + '/assets/images/logout.svg'" alt="..."/>
                                </div> <!-- end logout-icon-->

                            </div> <!-- end card-body-->
                        </div> <!-- end card-->

                        <div class="row mt-3">
                            <div class="col-12 text-center">
                                <p class="font-18">
                                    <router-link to="/login" class="text-light ms-1">
                                        <span class="mdi mdi-chevron-double-left"></span>
                                        <b> Volver al Inicio de sesión</b>
                                    </router-link>
                                </p>
                            </div> <!-- end col -->
                        </div>
                        <!-- end row -->
                    </div> <!-- end col -->
                </div>
                <!-- end row -->
            </div>
            <!-- end container -->
        </div>
        <!-- end page -->
        <footer class="footer footer-alt">
            2023 © AT - apuestatotal.com
        </footer>

    </div>
</template>
<script>
export default {

    props: ['route'],

}
</script>
