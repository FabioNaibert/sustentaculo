<template>
    <CombatButton @click.stop="openModal" title="Batalhar" />

    <Arena
        :showModal="storeShowModal"
        :player="storePlayer"
        @close_modal="closeModal"
    />
</template>

<script>
import PrimaryButton from '@/Components/PrimaryButton.vue';
import CombatButton from '@/Atoms/CombatButton.vue';
import Arena from '@/Molecules/Arena.vue';


export default {
    name: 'Combat',

    props: ['player'],

    components: {
        PrimaryButton,
        CombatButton,
        Arena
    },

    data() {
        return {
            showModal: false,
            opponents: [],
        }
    },

    computed: {
        storeShowModal: function() {
            return this.showModal
        },

        storePlayer: function() {
            return this.player
        },

        storeMasterId: function() {
            return this.$store.getters.historyMasterId
        },
    },

    methods: {
        openModal: function() {
            this.showModal = true;
        },

        closeModal: function() {
            this.showModal = false
        },
    }
}
</script>

<style scoped>
h1 {
    text-align: center;
    position: relative;
    min-height: 2rem;
    display: flex;
    justify-content: center;
    align-items: center;
    font-size: 1.5rem;
}

.c-options {
    display: flex;
    flex-direction: column;
    gap:1rem;
}

.option {
    display: flex;
    flex-wrap: nowrap;
    gap:0.5rem;
    align-items: center;
}
</style>
