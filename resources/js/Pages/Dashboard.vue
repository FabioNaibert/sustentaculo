<template>
    <Head title="Dashboard" />
    <AuthenticatedLayout>
        <div class="c-desktop"><HistoriesDesktop /></div>

        <div class="c-mobile"><HistoriesMobile /></div>
    </AuthenticatedLayout>

</template>

<script>
import { Head } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import HistoriesDesktop from '@/Organisms/HistoriesDesktop.vue';
import HistoriesMobile from '@/Organisms/HistoriesMobile.vue';

export default {
  components: { HistoriesDesktop },
    name: 'Dashboard',

    components: {
        AuthenticatedLayout,
        HistoriesDesktop,
        HistoriesMobile,
        Head,
    },
}
</script>

<style scoped>
.c-desktop {
    display: block;
}

.c-mobile {
    display: none;
}

@media screen and (max-width: 430px) {
    .c-desktop {
        display: none;
    }

    .c-mobile {
        display: block;
    }
}
</style>
