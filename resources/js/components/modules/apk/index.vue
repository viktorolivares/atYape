<template lang="">
    <div>
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="#">Notification Listener</a></li>
                            <li class="breadcrumb-item active">APK</li>
                        </ol>
                    </div>
                    <h4 class="page-title">Notification Listener</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                        <!-- Checkout Steps -->
                        <ul class="nav nav-pills bg-nav-pills nav-justified mb-3">
                            <li class="nav-item">
                                <a href="#install" data-bs-toggle="tab" class="nav-link rounded-0 active">
                                    <i class="uil-mobile-android font-22"></i>
                                    <span class="d-none d-lg-block">Instalación</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#config" data-bs-toggle="tab" class="nav-link rounded-0">
                                    <i class="uil-cog font-22"></i>
                                    <span class="d-none d-lg-block">Configuración</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#errors" data-bs-toggle="tab" class="nav-link rounded-0">
                                    <i class="uil-exclamation-triangle font-22"></i>
                                    <span class="d-none d-lg-block">Resolución de errores</span>
                                </a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane show active" id="install">
                                <div class="row">
                                    <div class="col-lg-8">
                                        <h4 class="mt-2 p-2">
                                            <i class="uil-info-circle"></i>
                                            Acerca de está de aplicación:
                                        </h4>
                                        <p class="text-muted mb-4 text-justify p-2">
                                            El registro de notificaciones aprovecha el Servicio de Escucha de Notificaciones oficial, disponible en el sistema operativo Android, para capturar y almacenar las notificaciones que se reciben. Esta aplicación captura todas las notificaciones de Yape! enviandolas a traves de un servicio a la base de datos de la web <a href="https://control.teleservicios.at/login">wwww.control.teleservicios.at</a>
                                        </p>
                                        <div class="card shadow">
                                            <div class="card-header">
                                                INSTALACIÓN
                                            </div>
                                            <div class="card-body">
                                                <ul class="list-group">
                                                    <li class="list-group-item">
                                                        A. Habilitar permiso para instalar aplicaciones de fuentes desconocidas.
                                                        <ol>
                                                            <li>
                                                                Abra la aplicación Configuración en su dispositivo Android.
                                                            </li>
                                                            <li>
                                                                Desplácese hacia abajo y toque la opción "Seguridad" o "Privacidad".
                                                            </li>
                                                            <li>
                                                                Activa la opción “Fuentes desconocidas”. Esto le permitirá instalar aplicaciones de fuentes distintas a Google Play Store.
                                                            </li>
                                                        </ol>
                                                    </li>
                                                    <li class="list-group-item">
                                                        B. Abre la aplicación para completar el proceso, dale click al botón <b>Solicitar Permisos</b>, busca y selecciona la aplicación <b>Notification Listener</b> en tu dispositivo Android.
                                                    </li>
                                                    <li class="list-group-item">
                                                        C. Asegúrate de activar todos los permisos necesarios, ya que la aplicación requiere acceso completo a las notificaciones. Verifica que todos los permisos estén activados correctamente.
                                                    </li>
                                                    <li class="list-group-item">
                                                        D. Regresa a la pantalla de inicio de la aplicación y selecciona el yape de la lista desplegable. Notarás que los botones "Iniciar" y "Detener" están ahora habilitados.
                                                    </li>
                                                    <li class="list-group-item">
                                                        E. Dale lick en el botón Iniciar para capturar las notificaciones de Yape, esto enviará al listados de los últimos Yapes almacenados del día.
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="col-lg-4">
                                        <div class="border p-3 mt-4 mt-lg-0 rounded text-center">
                                            <img :src="route + '/assets/images/apk.gif'" alt="..." class=" img-fluid shadow" width="300">
                                        </div> <!-- end .border-->
                                    </div> <!-- end col -->
                                </div> <!-- end row-->
                            </div>
                            <div class="tab-pane" id="errors">
                                <div class="row">
                                    <div class="col-lg-8">
                                        <h4 class="mt-2 p-2">
                                            <i class="uil-info-circle"></i>
                                            Acerca de está de aplicación:
                                        </h4>
                                        <p class="text-muted mb-4 text-justify p-2">
                                            El registro de notificaciones aprovecha el Servicio de Escucha de Notificaciones oficial, disponible en el sistema operativo Android, para capturar y almacenar las notificaciones que se reciben.
                                            <br>
                                            Esta aplicación captura todas las notificaciones de Yape! enviandolas a traves de un servicio a la base de datos de la web <a href="https://control.teleservicios.at/login">wwww.control.teleservicios.at</a>
                                        </p>

                                    </div>
                                    <div class="col-lg-4">

                                    </div>
                                    <!-- end col -->
                                </div>
                                <!-- end row-->
                            </div>
                            <div class="tab-pane" id="config">
                                <div class="row">
                                    <div class="col-lg-8">
                                        <h4 class="mt-2 p-2">
                                            <i class="uil-info-circle"></i>
                                            Configuración recomendada:
                                        </h4>
                                        <p class="text-muted mb-4 text-justify p-2">
                                            Si nuestra aplicación deja de enviar notificaciones después de un tiempo, es posible que tu smartphone esté bloqueando las notificaciones que se ejecutan en segundo plano, o que estés utilizando aplicaciones de limpieza de RAM o de aumento de velocidad.
                                            <br>
                                            Para restaurar las notificaciones, es necesario realizar algunos ajustes en la configuración del teléfono y cambiar la configuración de optimización de batería. Este paso es crucial para resolver el problema de manera permanente.
                                        </p>
                                        <div class="row">
                                            <div class="col-sm-3 mb-2 mb-sm-0">
                                                <div class="nav flex-column nav-pills" id="config-mobile" role="tablist" aria-orientation="vertical">
                                                    <a class="nav-link active show" id="xiaomi" data-bs-toggle="pill" href="#xiaomi-home" role="tab" aria-controls="xiaomi-home"
                                                        aria-selected="true">
                                                        <i class="mdi mdi-home-variant d-md-none d-block"></i>
                                                        <span class="d-none d-md-block">XIAOMI</span>
                                                    </a>
                                                    <a class="nav-link" id="samsung" data-bs-toggle="pill" href="#samsung-home" role="tab" aria-controls="samsung-home"
                                                        aria-selected="false">
                                                        <i class="mdi mdi-account-circle d-md-none d-block"></i>
                                                        <span class="d-none d-md-block">SAMSUNG</span>
                                                    </a>
                                                    <a class="nav-link" id="huawei" data-bs-toggle="pill" href="#huawei-home" role="tab" aria-controls="huawei-home"
                                                        aria-selected="false">
                                                        <i class="mdi mdi-settings-outline d-md-none d-block"></i>
                                                        <span class="d-none d-md-block">HUAWEI</span>
                                                    </a>
                                                </div>
                                            </div> <!-- end col-->

                                            <div class="col-sm-9">
                                                <div class="tab-content" id="config-mobileContent">
                                                    <div class="tab-pane fade active show" id="xiaomi-home" role="tabpanel" aria-labelledby="xiaomi">
                                                        <p class="mb-0">...</p>
                                                    </div>
                                                    <div class="tab-pane fade" id="samsung-home" role="tabpanel" aria-labelledby="samsung">
                                                        <p class="mb-0">...</p>
                                                    </div>
                                                    <div class="tab-pane fade" id="huawei-home" role="tabpanel" aria-labelledby="huawei">
                                                        <p class="mb-0">...</p>
                                                    </div>
                                                </div> <!-- end tab-content-->
                                            </div> <!-- end col-->
                                        </div>
                                        <!-- end row-->
                                    </div>
                                    <div class="col-lg-4">
                                        <ul class="nav nav-pills bg-nav-pills nav-justified mb-3">
                                            <li class="nav-item">
                                                <a href="#xiaomi-home" data-bs-toggle="tab" aria-expanded="false" class="nav-link rounded-0 active">
                                                    <i class="mdi mdi-home-variant d-md-none d-block"></i>
                                                    <span class="d-none d-md-block">XIAOMI</span>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="#samsung-home" data-bs-toggle="tab" aria-expanded="true" class="nav-link rounded-0">
                                                    <i class="mdi mdi-account-circle d-md-none d-block"></i>
                                                    <span class="d-none d-md-block">SAMSUNG</span>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="#huawei-home" data-bs-toggle="tab" aria-expanded="false" class="nav-link rounded-0">
                                                    <i class="mdi mdi-settings-outline d-md-none d-block"></i>
                                                    <span class="d-none d-md-block">HUAWEI</span>
                                                </a>
                                            </li>
                                        </ul>

                                        <div class="tab-content">
                                            <div class="tab-pane show active" id="xiaomi-home">
                                                <p>...</p>
                                            </div>
                                            <div class="tab-pane" id="samsung-home">
                                                <p>...</p>
                                            </div>
                                            <div class="tab-pane" id="huawei-home">
                                                <p>...</p>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end col -->
                                </div>
                                <!-- end row-->
                            </div>
                        </div>
                        <!-- end tab content-->
                    </div>
                    <!-- end card-body-->
                </div>
                <!-- end card-->
            </div>
            <!-- end col -->
        </div>
        <!-- end row-->
    </div>
</template>
<script>
export default {
    props: ['route']
}
</script>¿
