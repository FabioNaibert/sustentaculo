<template>
    <ShareButton @click="openModal" />

    <Modal :show="showModal" @close="closeModal">
        <div class="p-6">
            <h1 class="text-gray-500">Compartilhar Recurso</h1>
            <p class="mt-6 text-gray-500">Selecione o jogador que você quer disponibilizar a arma <b>"{{ storeWeapon.name }}"</b>.</p>
            <div class="mt-6 c-options">
                <ul>
                    <li
                        class="option"
                        v-for="player in storePlayers"
                        :key="player.id"
                    >
                        <input type="radio" :id="player.id" :value="player.id" v-model="sharePlayer">
                        <label :for="player.id">{{ player.name }}</label>
                    </li>
                </ul>

            </div>

            <div class="mt-6 flex justify-end">
                <SecondaryButton @click="closeModal"> FECHAR </SecondaryButton>

                <PrimaryButton
                    class="ml-3"
                    @click="shareResource"
                >
                    SALVAR
                </PrimaryButton>
            </div>
        </div>
    </Modal>
</template>

<script>
import Modal from '@/Components/Modal.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import axios from 'axios';
import ShareButton from '@/Atoms/ShareButton.vue';


export default {
    name: 'ShareWeapon',

    props: ['weapon'],

    components: {
        Modal,
        SecondaryButton,
        PrimaryButton,
        ShareButton
    },

    data() {
        return {
            showModal: false,
            sharePlayer: null,
        }
    },

    computed: {
        storeWeapon: function() {
            return this.weapon
        },

        storePlayers: function() {
            return this.$store.getters.players
        },

        storeChapter: function() {
            return this.$store.getters.chapter
        },
    },

    methods: {
        openModal: function() {
            this.sharePlayer = this.storeWeapon.playerId
            this.showModal = true;
        },

        closeModal: function() {
            this.showModal = false
        },

        shareResource: function() {
            axios.post(route('weapon.share'), {
                share_player_id: this.sharePlayer,
                weapon_id: this.storeWeapon.id,
                chapter_id: this.storeChapter.id
            })
            .then((response) => {
                this.$store.commit('updateResources', response.data)
            })
            .catch((error) => {
                console.error(error)
            })
            .finally(() => {
                this.sharePlayer = null
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
