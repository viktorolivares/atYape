<template>
    <div>
        <router-view v-slot="{ Component }">
            <Transition name="slide-fade" mode="out-in">
                <component :is="Component" :route="route" />
            </Transition>
        </router-view>

    </div>
</template>
<script>
export default {
    name: "Auth",
    props: ['route'],
}
</script>
