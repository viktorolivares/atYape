<template>
    <div>
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <h4 class="page-title">Sessions</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->
        <div class="row">

        </div>
        <!-- end row -->
    </div>
</template>

<script>

export default {

    created() {
        this.getSessions()
    },
    methods: {
        async getSessions() {
            try {
                const response = await axios.get("/api/sessions/list");
                if (response.status === 200) {
                    console.log(response.data)
                }
            } catch (error) {
                console.log(error)
            }
        },
    },
};

</script>
