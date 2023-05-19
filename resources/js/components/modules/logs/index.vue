<!-- 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 -->
<template>
    <div>
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="#">Transacciones</a></li>
                            <li class="breadcrumb-item active">Listado de Transacciones</li>
                        </ol>
                    </div>
                    <h4 class="page-title">Transacciones</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <!-- Tabla de Resultados -->
        <div class="row">
            <div class="col-md-9">

            </div>
            <div class="col-md-3">
                <div class="card mt-3" v-if="Object.keys(languages).length > 0">
                    <div class="card-body">
                        <h5 class="card-title">Lenguajes</h5>
                        <div class="progress">
                            <div v-for="(percentage, language) in languagePercentages" :key="language"
                                :class="getProgressBarClasses(language)" :style="{ width: percentage + '%' }"
                                role="progressbar" :aria-valuenow="percentage" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <ul class="nav justify-content-start">
                            <li class="nav-item" v-for="(percentage, language) in languagePercentages" :key="language">
                                <a href="#" class="nav-link">
                                    <span :class="getIconClasses(language)"></span>
                                    {{ language }}: {{ percentage }}%
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <p class="mt-3" v-else>No se encontraron lenguajes.</p>
                <div v-if="showMoreInfo">
                    <div class="card mt-3">
                        <div class="card-body">
                            <h5 class="card-title">Más información sobre los lenguajes</h5>
                            <ul class="list-group">
                                <li class="list-group-item" v-for="(value, key) in moreInfo" :key="key">
                                    {{ key }}: {{ value }}
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>
</template>


<script>
import axios from 'axios';

export default {
    data() {
        return {
            languages: {},
            showMoreInfo: false,
            moreInfo: {},
        };
    },
    mounted() {
        this.fetchLanguages();
    },
    computed: {
        languagePercentages() {
            const totalBytes = Object.values(this.languages).reduce((sum, value) => sum + value, 0);

            return Object.entries(this.languages).reduce((percentages, [language, bytes]) => {
                const percentage = ((bytes / totalBytes) * 100).toFixed(2);
                return { ...percentages, [language]: percentage };
            }, {});
        },
    },
    methods: {
        async fetchLanguages() {
            try {
                const response = await axios.get('/api/logs/github');
                this.languages = response.data.data;

                if (response.headers['link']) {
                    const linkHeader = response.headers['link'];
                    const languagesUrl = this.extractLanguagesUrl(linkHeader);
                    if (languagesUrl) {
                        await this.fetchMoreInfo(languagesUrl);
                    }
                }
            } catch (error) {
                console.error(error);
            }
        },
        async fetchMoreInfo(url) {
            try {
                const response = await axios.get(url);
                this.showMoreInfo = true;
                this.moreInfo = response.data;
            } catch (error) {
                console.error(error);
            }
        },
        getProgressBarClasses(language) {
            switch (language.toLowerCase()) {
                case 'vue':
                    return 'progress-bar bg-success';
                case 'php':
                    return 'progress-bar';
                case 'blade':
                    return 'progress-bar bg-danger';
                case 'javascript':
                    return 'progress-bar bg-warning';
                case 'css':
                    return 'progress-bar bg-info';
                case 'scss':
                    return 'progress-bar bg-pink';
                default:
                    return 'progress-bar bg-primary';
            }
        },
        getIconClasses(language) {
            switch (language.toLowerCase()) {
                case 'vue':
                    return 'mdi mdi-checkbox-blank-circle text-success';
                case 'php':
                    return 'mdi mdi-checkbox-blank-circle';
                case 'blade':
                    return 'mdi mdi-checkbox-blank-circle text-danger';
                case 'javascript':
                    return 'mdi mdi-checkbox-blank-circle text-warning';
                case 'css':
                    return 'mdi mdi-checkbox-blank-circle text-info';
                case 'scss':
                    return 'mdi mdi-checkbox-blank-circle text-pink';
                default:
                    return 'mdi mdi-checkbox-blank-circle text-primary';
            }
        },
    }
};
</script>

<style>
.text-pink {
    color: pink !important;
}

.bg-purple {
    background-color: purple !important;
}

.bg-pink {
    background-color: pink !important;
}
</style>
