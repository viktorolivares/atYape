<template>
    <div>
        <iframe :src="getMapUrl(latitude, longitude)" width="465" height="450" style="border:0;" allowfullscreen=""
            loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
    </div>
</template>

<script>
export default {
    props: {
        latitude: {
            type: Number,
            required: true
        },
        longitude: {
            type: Number,
            required: true
        }
    },
    methods: {
        getMapUrl(latitude, longitude) {
            return `https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d63391.56733089555!2d${longitude}!3d${latitude}!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1ses-419!2spe!4v1684396850341!5m2!1ses-419!2spe`;
        }
    }
};
</script>
