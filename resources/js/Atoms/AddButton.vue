<template>
    <button :title="tooltip">
        <img src="../../svg/plus-lg.svg" />
    </button>
    <!-- <Link
        :href="route"
        as="button"
        :title="tooltip"
    >
        <img src="../../svg/plus-lg.svg" />
    </Link> -->
</template>


<script>
import { Link } from '@inertiajs/vue3';

export default {
    name: 'AddButton',

    props: ['tooltip'],

    components: {
        Link
    },

    methods: {
    }
}
</script>

<style scoped>
button {
    background: linear-gradient(90deg, rgba(25,130,33,1) 33%, rgba(1,212,175,1) 100%);
    border-radius: 50%;
    width: 3rem;
    height: 3rem;
    display: flex;
    justify-content: center;
    align-items: center;
}

button:hover {
    background: linear-gradient(187deg, rgba(1,212,175,1) 33%, rgba(168,255,240,1) 100%);
}
</style>
