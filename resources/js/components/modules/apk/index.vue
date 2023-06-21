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
                        <ul class="nav nav-pills bg-nav-pills nav-justified mb-3">
                            <li class="nav-item">
                                <a href="#install" data-bs-toggle="tab" aria-expanded="false" class="nav-link rounded-0 active">
                                    <i class="mdi mdi-cellphone-android font-22"></i>
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
                                        </div>
                                        <!-- end .border-->
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
                                            Si nuestra aplicación deja de enviar notificaciones después de un tiempo, es posible que tu smartphone esté bloqueando las notificaciones que se ejecutan en segundo plano, o que estés utilizando aplicaciones de limpieza de RAM o de aumento de velocidad. Para restaurar las notificaciones, es necesario realizar algunos ajustes en la configuración del teléfono y cambiar la configuración de optimización de batería. Este paso es crucial para resolver el problema de manera permanente.
                                        </p>
                                        <div class="row">
                                            <div class="col-sm-3 mb-2 mb-sm-0">
                                                <div class="nav flex-column nav-pills" id="config-mobile" role="tablist" aria-orientation="vertical">
                                                  <a class="nav-link active show" id="xiaomi" data-bs-toggle="pill" href="#xiaomi-home" role="tab" aria-controls="xiaomi-home"
                                                    aria-selected="true" @click="changeImage('xiaomi')">
                                                    <i class="mdi mdi-home-variant d-md-none d-block"></i>
                                                    <span class="d-none d-md-block">XIAOMI</span>
                                                  </a>
                                                  <a class="nav-link" id="samsung" data-bs-toggle="pill" href="#samsung-home" role="tab" aria-controls="samsung-home"
                                                    aria-selected="false" @click="changeImage('samsung')">
                                                    <i class="mdi mdi-account-circle d-md-none d-block"></i>
                                                    <span class="d-none d-md-block">SAMSUNG</span>
                                                  </a>
                                                  <a class="nav-link" id="huawei" data-bs-toggle="pill" href="#huawei-home" role="tab" aria-controls="huawei-home"
                                                    aria-selected="false" @click="changeImage('huawei')">
                                                    <i class="mdi mdi-settings-outline d-md-none d-block"></i>
                                                    <span class="d-none d-md-block">HUAWEI</span>
                                                  </a>
                                                </div>
                                            </div>
                                            <div class="col-sm-9 shadow-sm">
                                                <div class="tab-content" id="config-mobileContent">
                                                    <div class="tab-pane fade active show" id="xiaomi-home" role="tabpanel" aria-labelledby="xiaomi">
                                                        <p class="mt-2 mb-0 text-primary">
                                                            Debe realizar algunos cambios en la configuración del telefóno para evitar que MIUI elimine aplicaciones que se ejecuten en segundo plano.
                                                        </p>

                                                        <div class="mt-3">
                                                            <ul class="list-group">
                                                                <li class="list-group-item active"><i class="uil-wrench"></i> Cambio 1</li>
                                                                <li class="list-group-item">
                                                                    <i class="uil-lock me-1"></i>
                                                                    Abra <b>Configuración</b> del teléfono.
                                                                </li>
                                                                <li class="list-group-item">
                                                                    <i class="uil-mobile-android me-1"></i>
                                                                    Haz clic en aplicaciones.
                                                                </li>
                                                                <li class="list-group-item">
                                                                    <i class="uil-bell me-1"></i>
                                                                    Elije Notification Listener
                                                                </li>
                                                                <li class="list-group-item">
                                                                    <i class="uil-power me-1"></i>
                                                                    Seleccione Inicio Automático.
                                                                </li>
                                                            </ul>
                                                        </div>
                                                        <div class="my-3">
                                                            <ul class="list-group">
                                                                <li class="list-group-item active"><i class="uil-wrench"></i> Cambio 2</li>
                                                                <li class="list-group-item">
                                                                    <i class="uil-cog me-1"></i>
                                                                    Abra <b>Configuración</b> del teléfono.
                                                                </li>
                                                                <li class="list-group-item">
                                                                    <i class="uil-battery-empty me-1"></i>
                                                                    Haz clic en <b>Batería.</b>
                                                                </li>
                                                                <li class="list-group-item">
                                                                    <i class="uil-bell me-1"></i>
                                                                    Elije Notification Listener
                                                                </li>
                                                                <li class="list-group-item">
                                                                    <i class="uil-unlock me-1"></i>
                                                                    Establezca en <b>Sin restricciones</b>.
                                                                </li>
                                                            </ul>
                                                        </div>
                                                        <div class="my-3">
                                                            <ul class="list-group">
                                                                <li class="list-group-item active"><i class="uil-wrench"></i> Cambio 3</li>
                                                                <li class="list-group-item">
                                                                    <i class="uil-cog me-1"></i>
                                                                    Abra <b>Configuración</b> del teléfono.
                                                                </li>
                                                                <li class="list-group-item">
                                                                    <i class="uil-mobile-android me-1"></i>
                                                                    Haz clic en aplicaciones.
                                                                </li>
                                                                <li class="list-group-item">
                                                                    <i class="uil-bell me-1"></i>
                                                                    Elije Notification Listener
                                                                </li>
                                                                <li class="list-group-item">
                                                                    <i class="uil-lock me-1"></i>
                                                                    Toca en <b>Otros permisos</b>
                                                                </li>
                                                                <li class="list-group-item">
                                                                    <i class=" uil-focus-add me-1"></i>
                                                                    Habilite iniciar en segundo plano.
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <div class="tab-pane fade" id="samsung-home" role="tabpanel" aria-labelledby="samsung">
                                                        <p class="mt-2 mb-0 text-primary">
                                                            En los últimos dispositivos de Samsung, se agrega una nueva función llamada Sleeping Apps. Las aplicaciones que se incluyen en esta lista de "Aplicaciones suspendidas" nunca se ejecutarán en segundo plano. Primero debe asegurarse de que la APK no se agregue en esa lista.
                                                        </p>
                                                        <div class="my-3">
                                                            <ul class="list-group">
                                                                <li class="list-group-item active"><i class="uil-mobile-android"></i>
                                                                    APK en segundo plano</li>
                                                                <li class="list-group-item">
                                                                    <i class="uil-cog me-1"></i>
                                                                    Ve a <b>Ajustes</b> del teléfono.
                                                                </li>
                                                                <li class="list-group-item">
                                                                    <i class="uil-plug me-1"></i>
                                                                    Abra <b>Cuidado batería y dispositivo</b>
                                                                </li>
                                                                <li class="list-group-item">
                                                                    <i class="uil-battery-empty me-1"></i>
                                                                    Toca <b>Batería.</b>
                                                                </li>
                                                                <li class="list-group-item">
                                                                    <i class="uil-auto-flash me-1"></i>
                                                                    Desactiva el ahorro de energía
                                                                </li>
                                                                <li class="list-group-item">
                                                                    <i class="uil-suitcase me-1"></i>
                                                                    Haga clic en <b>limites de uso en segundo plano.</b>
                                                                </li>
                                                                <li class="list-group-item">
                                                                    <i class="uil-list-ul me-1"></i>
                                                                    Aqui tienes que deshabilitar o quitar la APK de la lista.
                                                                    <ol>
                                                                        <li>Aplicaciones suspendidas</li>
                                                                        <li>Aplicaciones en suspensión profunda</li>
                                                                    </ol>
                                                                </li>
                                                                <li class="list-group-item">
                                                                    <i class="uil-shield-check me-1"></i>
                                                                    Añadir a la APK a "Aplicaciones sin suspensión"
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <div class="tab-pane fade" id="huawei-home" role="tabpanel" aria-labelledby="huawei">
                                                        <p class="mt-2 mb-0 text-primary">
                                                            A partir de EMUI 9, Huawei agregó una nueva aplicación llamada <b>PowerGenie</b> que eliminará todas las aplicaciones a menos que esté incluida en la lista blanca de la aplicación <b>PowerGenie</b>
                                                        </p>

                                                        <div class="my-3">
                                                            <ul class="list-group">
                                                                <li class="list-group-item active"><i class="uil-mobile-android"></i>
                                                                    Optimización de batería</li>
                                                                <li class="list-group-item">
                                                                    <i class="uil-cog me-1"></i>
                                                                    Abra Ajustes del teléfono
                                                                </li>
                                                                <li class="list-group-item">
                                                                    <i class="uil-battery-empty me-1"></i>
                                                                    Clic en <b>Batería.</b>
                                                                </li>
                                                                <li class="list-group-item">
                                                                    <i class="uil-auto-flash me-1"></i>
                                                                    Abra Inicio de la aplicaciones
                                                                </li>
                                                                <li class="list-group-item">
                                                                    <i class="uil-suitcase me-1"></i>
                                                                    Configure su aplicación en "Administrar manualmente" y asegúrese de que todo esté encendido.
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div> <!-- end tab-content-->
                                            </div>
                                            <!-- end col-->
                                        </div>
                                        <!-- end row-->
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="border p-3 mt-4 mt-lg-0 rounded text-center">
                                            <img :src="currentImage" alt="..." class="img-fluid shadow" width="300">
                                        </div>
                                        <!-- end .border-->
                                    </div>
                                    <!-- end col -->
                                </div>
                                <!-- end row-->
                            </div>
                            <div class="tab-pane" id="errors">
                                <div class="row">
                                    <div class="col-lg-8">
                                        <h4 class="mt-2 p-2">
                                            <i class="uil-info-circle"></i>
                                            Errores frecuentes:
                                        </h4>
                                        <p class="text-muted mb-4 text-justify p-2">
                                            Si no se guardan nuevas notificaciones, por favor deshabilite el permiso de Acceso a Notificaciones y vuelve a habilitarlo despues de 30 segundos.
                                        </p>

                                        <ul class="list-group">
                                            <li class="list-group-item">
                                                A. Si se encuentra en el listado de transacciones, vuelva a la pantalla de inicio de la APK, caso contrario omitir este paso.
                                            </li>
                                            <li class="list-group-item">
                                                B. Clic en detener aplicación, a continuación dirigase al menú de la parte superior.
                                            </li>
                                            <li class="list-group-item">
                                                C. Clic en permisos
                                            </li>
                                            <li class="list-group-item">
                                                D. Desactive los permisos, espere unos 30 segundos y vuelva a habilitarlos.
                                            </li>
                                            <li class="list-group-item">
                                                E. Vuelva a la pantalla de inicio y vuelva a inicar la captura de datos.
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="border p-3 mt-4 mt-lg-0 rounded text-center">
                                            <img :src="route + '/assets/images/errors.gif'" alt="..." class=" img-fluid shadow" width="300">
                                        </div>
                                    </div>
                                    <!-- end col -->
                                </div>
                                <!-- end row-->
                            </div>
                        </div>
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
    props: ['route'],

    data() {
        return {
            currentImage: this.route + '/assets/images/xiaomi.gif'
        };
    },
    methods: {
        changeImage(id) {
            // Cambiar la ruta de la imagen según el ID seleccionado
            if (id === 'xiaomi') {
                this.currentImage = this.route + '/assets/images/xiaomi.gif';
            } else if (id === 'samsung') {
                this.currentImage = this.route + '/assets/images/samsung.gif';
            } else if (id === 'huawei') {
                this.currentImage = this.route + '/assets/images/huawei.gif';
            }
        }
    }
}
</script>
