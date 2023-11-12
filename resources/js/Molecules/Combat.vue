<template>
    <CombatButton @click.stop="openModal" />

    <Arena
        :showModal="storeShowModal"
        :opponents="[]"
        :player="null"
        @close_modal="closeModal"
    />
</template>

<script>
import PrimaryButton from '@/Components/PrimaryButton.vue';
import axios from 'axios';
import CombatButton from '@/Atoms/CombatButton.vue';
import Arena from '@/Molecules/Arena.vue';


export default {
    name: 'Combat',

    // props: ['image'],

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
        }
    },

    methods: {
        openModal: function() {
            this.showModal = true;
            this.listShare = []
        },

        closeModal: function() {
            this.showModal = false
        },

        setOpponents: function() {

        },

        shareResource: function() {
            axios.post(route('image.share'), {
                list_share: this.listShare,
                image_id: this.image.id
            })
            .then((response) => {
                this.$store.commit('updateResources', response.data)
            })
            .catch((error) => {
                console.error(error)
            })
            .finally(() => {
                this.closeModal()
            })
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
