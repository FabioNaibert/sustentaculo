<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <div class="c-mobile__content">
            <div class="mobile__content">
                <slot />
            </div>

            <div class="mobile__menu">
                <NavLink
                    class="menu__option"
                    :href="route('game.mobile.get') + '/' + player_id"
                    :active="route().current('game.mobile.get')"
                    :class="{'bg-gray-100': route().current('game.mobile.get')}"
                >
                    <img src="../../svg/info.svg">
                </NavLink>
                <NavLink
                    class="menu__option"
                    :href="route('history.get') + '/9'"
                    :active="route().current('history.get')"
                    :class="{'bg-gray-100': route().current('history.get')}"
                >
                    <img src="../../svg/paper.svg">
                </NavLink>
                <NavLink
                    class="menu__option"
                    :href="route('history.get') + '/9'"
                    :active="route().current('history.get')"
                >
                    <img src="../../svg/team.svg">
                </NavLink>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import NavLink from '@/Components/NavLink.vue';

export default {
    name: 'LayoutMobile',

    props: ['player_id'],

    components: {
        AuthenticatedLayout,
        Head,
        NavLink
    }
}
</script>

<style scoped>
.c-mobile__content {
    position: relative;
    width: 100%;
    min-height: calc(100vh - 8rem);
    display: flex;
}

.mobile__content {
    width: 100%;
    height: 100%;
}

.mobile__menu {
    position: fixed;
    bottom: 0;
    height: 4rem;
    width: 100%;
    background-color: rgb(0 0 0 / 0.1);

    display: flex;
    justify-content: space-between;
}

.menu__option {
    width: 100%;
}

img {
    margin: auto;
    width: 2rem;
}
</style>
