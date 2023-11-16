<template>
    <ShareButton @click.stop="openModal" />

    <Modal :show="showModal" @close="closeModal">
        <div class="p-6">
            <h1 class="text-gray-500">Compartilhar Recurso</h1>
            <p class="mt-6 text-gray-500">Selecione os jogadores que você quer que vejam a imagem <b>"{{ storeImage.name }}"</b>.</p>
            <div class="mt-6 c-options">
                <ul>
                    <li class="option">
                        <input type="checkbox" id="todos" value="null" @change="setListShare" v-model="shareAll">
                        <label for="todos">Todos</label>
                    </li>
                    <li
                        class="option"
                        v-for="player in storePlayers"
                        :key="player.id"
                    >
                        <input type="checkbox" :id="player.id" :value="player.id" v-model="listShare">
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
    name: 'ShareResources',

    props: ['image'],

    components: {
        Modal,
        SecondaryButton,
        PrimaryButton,
        ShareButton
    },

    data() {
        return {
            showModal: false,
            listShare: [],
            shareAll: false
        }
    },

    computed: {
        storeImage: function() {
            return this.image
        },

        storePlayers: function() {
            return this.$store.getters.players
        },
    },

    watch: {
        listShare() {
            this.shareAll = this.storePlayers.every((player) => this.listShare.includes(player.id))
        }
    },

    methods: {
        openModal: function() {
            this.showModal = true;
            this.listShare = this.storeImage.share_players_ids
        },

        closeModal: function() {
            this.showModal = false
        },

        setListShare: function() {
            if (this.shareAll) {
                return this.listShare = this.storePlayers.map((player) => player.id)
            }

            return this.listShare = []
        },

        shareResource: function() {
            axios.post(route('image.share'), {
                list_share: this.listShare,
                image_id: this.storeImage.id
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
