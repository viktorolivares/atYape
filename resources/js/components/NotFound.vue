<template>
    <div>
        <div class="row justify-content-center mt-5">
            <div class="col-lg-4 mt-5">
                <div class="text-center mt-4">
                    <img :src="route + '/assets/images/file-searching.svg'" height="90" alt="File not found Image">
                    <h1 class="text-error mt-4">404</h1>
                    <h4 class="text-uppercase text-danger mt-3">Página no encontrada</h4>
                    <p class="text-muted mt-3">¡Error 404! Parece que este camino está bloqueado. Pero no te preocupes, hay muchas otras rutas para explorar. ¿Te gustaría intentar otra vez?</p>
                    <a class="btn btn-info mt-3" href="/"><i class="mdi mdi-reply"></i> Regresar al inicio</a>
                </div> <!-- end /.text-center-->
            </div> <!-- end col-->
        </div>
        <!-- end row -->
    </div>
</template>
<script>
export default {
    props: ['route'],
}
</script>
