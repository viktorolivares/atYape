<template>
    <div>
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="#">DNI</a></li>
                            <li class="breadcrumb-item active">Consulta de DNI</li>
                        </ol>
                    </div>
                    <h4 class="page-title">DNI</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body">
                        <ul class="nav nav-pills bg-nav-pills mb-3">
                            <li class="nav-item">
                                <a href="#bordered-tabs-query" data-bs-toggle="tab" aria-expanded="false"
                                    class="nav-link rounded-0 active">
                                    API Consultas de DNI
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#bordered-tabs-control" data-bs-toggle="tab" aria-expanded="true"
                                    class="nav-link rounded-0">
                                    Control Menores de Edad y Fallecidos
                                </a>
                            </li>
                        </ul> <!-- end nav-->
                        <div class="tab-content">
                            <div class="tab-pane show active" id="bordered-tabs-query">
                                <div class="mt-1">
                                    <p class="text-primary font-12 mb-4">
                                        <i class="uil-info-circle"></i>
                                        Servicio de consulta DNI (nombres y apellidos) en tiempo real desde el padrón
                                        reducido
                                        SUNAT y scraping de datos publicos
                                        <button class="btn btn-sm btn-info float-end" data-bs-toggle="modal"
                                            data-bs-target="#modal-info">
                                            <i class="uil-info-circle"></i>
                                            Consideraciones
                                        </button>
                                    </p>
                                </div>
                                <ul class="nav nav-tabs mb-3">
                                    <li class="nav-item">
                                        <a href="#individual1" data-bs-toggle="tab" aria-expanded="false"
                                            class="nav-link active">
                                            <i class="mdi mdi-home-variant d-md-none d-block"></i>
                                            <span class="d-none d-md-block">Consulta Individual</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#massive1" data-bs-toggle="tab" aria-expanded="true" class="nav-link">
                                            <i class="mdi mdi-account-circle d-md-none d-block"></i>
                                            <span class="d-none d-md-block">Reporte Masivo</span>
                                        </a>
                                    </li>
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane show active" id="individual1">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="p-2 mt-2">
                                                    <form>
                                                        <div class="form-group mb-3">
                                                            <label for="dni-1">Número de DNI:
                                                                <span class="text-danger">*</span>
                                                            </label>
                                                            <input type="text" id="dni-1" class="form-control"
                                                                maxlength="8">
                                                        </div>
                                                        <div class="form-group mb-3">
                                                            <button class="btn btn-primary" type="button">
                                                                <i class="uil-search"></i>
                                                                Buscar
                                                            </button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                            <div class="col-md-8">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="massive1">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="p-2 mt-2">
                                                    <form>
                                                        <div class="form-group mb-3">
                                                            <label for="massive-1">Lista de DNIs:
                                                                <span class="text-danger">*</span>
                                                            </label>
                                                            <textarea class="form-control" id="massive-1" cols="30"
                                                                rows="10"></textarea>
                                                        </div>
                                                        <div class="form-group mb-3">
                                                            <button class="btn btn-primary" type="button">
                                                                <i class="uil-search"></i>
                                                                Buscar
                                                            </button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                            <div class="col-md-8">

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="bordered-tabs-control">
                                <div class="mt-1">
                                    <p class="text-primary font-12 mb-4">
                                        <i class="uil-info-circle"></i>
                                        Validación confiable y segura de DNI para verificar menores de edad y el estado
                                        vital de personas mediante RENIEC.
                                        <button class="btn btn-sm btn-info float-end" data-bs-toggle="modal"
                                            data-bs-target="#modal-info2">
                                            <i class="uil-info-circle"></i>
                                            Consideraciones
                                        </button>
                                    </p>
                                </div>
                                <ul class="nav nav-tabs mb-3">
                                    <li class="nav-item">
                                        <a href="#individual2" data-bs-toggle="tab" aria-expanded="false"
                                            class="nav-link active">
                                            <i class="mdi mdi-home-variant d-md-none d-block"></i>
                                            <span class="d-none d-md-block">DNI individual</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#massive2" data-bs-toggle="tab" aria-expanded="true" class="nav-link">
                                            <i class="mdi mdi-account-circle d-md-none d-block"></i>
                                            <span class="d-none d-md-block">Control Masivo</span>
                                        </a>
                                    </li>
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane show active" id="individual2">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="p-2 mt-2">
                                                    <form>
                                                        <div class="form-group mb-3">
                                                            <label for="dni-1">Número de DNI:
                                                                <span class="text-danger">*</span>
                                                            </label>
                                                            <input type="text" id="dni-1" class="form-control"
                                                                maxlength="8">
                                                        </div>
                                                        <div class="form-group mb-3">
                                                            <button class="btn btn-primary" type="button">
                                                                <i class="uil-search"></i>
                                                                Buscar
                                                            </button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                            <div class="col-md-8">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="massive2">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="p-2 mt-2">
                                                    <form>
                                                        <div class="form-group mb-3">
                                                            <label for="massive-1">Lista de DNIs:
                                                                <span class="text-danger">*</span>
                                                            </label>
                                                            <textarea class="form-control" id="massive-1" cols="30"
                                                                rows="10"></textarea>
                                                        </div>
                                                        <div class="form-group mb-3">
                                                            <button class="btn btn-primary" type="button">
                                                                <i class="uil-search"></i>
                                                                Buscar
                                                            </button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                            <div class="col-md-8">

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end tab-content-->
                    </div>
                    <!-- end card-body -->
                </div>
                <!-- end card-->
            </div>
            <!-- end col -->
        </div>
        <!-- end row -->

        <!-- Info modal -->
        <div id="modal-info" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modal-infoLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header modal-colored-header bg-primary">
                        <h4 class="modal-title" id="primary-header-modalLabel">Información</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                    </div>
                    <div class="modal-body">
                        <div class="list-group">
                            <a href="#" class="list-group-item list-group-item-action">
                                Este servicio no se conecta con RENIEC
                            </a>
                            <a href="#" class="list-group-item list-group-item-action">
                                El origen de datos depende del padrón reducido SUNAT y otras fuentes públicas.
                            </a>
                            <a href="#" class="list-group-item list-group-item-action">
                                El padrón reducido SUNAT no devuelve datos de menores de edad, dirección, fecha nacimiento,
                                sexo.
                            </a>
                            <a href="#" class="list-group-item list-group-item-action">
                                En algunos casos no se obtendrá resultado de la consulta debido a la información de las
                                fuentes
                                públicas, esto no debe considerarse como falla o error del servicio.
                            </a>

                        </div>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->

        <!-- Info modal -->
        <div id="modal-info2" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modal-info2Label"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header modal-colored-header bg-primary">
                        <h4 class="modal-title" id="primary-header-modalLabel">Información</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                    </div>
                    <div class="modal-body">
                        <div class="list-group">
                            <a href="#" class="list-group-item list-group-item-action">
                                Nuestro sistema utiliza datos provenientes de la Reniec (Registro Nacional de Identificación y Estado Civil).
                            </a>
                            <a href="#" class="list-group-item list-group-item-action">
                                Estas consultas no proporciona datos como nombres, apellidos, sexo o fecha de nacimiento.
                            </a>
                            <a href="#" class="list-group-item list-group-item-action">
                                Para garantizar la autenticidad de las consultas, RENIEC incorpora un sistema de validación captcha en nuestro proceso de obtención de datos.
                            </a>
                            <a href="#" class="list-group-item list-group-item-action">
                                Cada consulta se realiza con un intervalo de 2/3 segundos para evitar bloqueos, esto garantiza disponibilidad equitativa y fomenta un uso responsable de la plataforma.
                            </a>

                        </div>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->
    </div>
</template>

<script>

export default {

};

</script>
