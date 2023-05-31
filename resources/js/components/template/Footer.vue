<template>
    <div>
        <!-- Footer Start -->
        <footer class="footer">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-6">
                        <small>2023 © apuestatotal.com</small>
                    </div>
                    <div class="col-md-6">
                        <div class="text-md-end footer-links d-none d-md-block">
                            <a href="#">
                                <small>Laravel version: {{ laravelVersion}} | PHP version: {{ phpVersion }} | Version vue: {{ vueVersion }}</small>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
        <!-- End Footer -->
    </div>
</template>

<script>

import { createApp } from 'vue';

export default {
    data() {
        return {
            laravelVersion: '',
            phpVersion: '',
            vueVersion: '',
        };
    },

    mounted() {
        this.fetchVersions();
    },

    methods: {
        fetchVersions() {
            fetch('/admin/version')
                .then(response => response.json())
                .then(data => {
                    this.laravelVersion = data.laravel;
                    this.phpVersion = data.php;
                    this.vueVersion = createApp().version;
                })
                .catch(error => {
                    console.error('Error fetching versions:', error);
                });
        },
    },
};
</script>
