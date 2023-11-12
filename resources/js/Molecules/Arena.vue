<template>
    <Modal :show="showModal" @close="closeModal">
        teste
        <div class="p-6">
            <h1 class="text-gray-500">Arena de Combate</h1>
            <p class="mt-6 text-gray-500">Selecione o tipo de ataque e o(s) inimigo(s) que leverá(ão) o ataque.</p>
            <div class="c-attacks">
                <CustomButton>ATAQUE NORMAL</CustomButton>
                <CustomButton>ATAQUE EM ÁREA</CustomButton>
                <CustomButton>ATAQUE MÁGICO</CustomButton>
            </div>
            <div class="mt-6 c-options">
                <div
                    v-for="opponent in opponents"
                    :key="opponent.id"
                >
                    <Opponent :opponent="opponent"/>
                </div>
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
import CombatButton from '@/Atoms/CombatButton.vue';
import CustomButton from '@/Atoms/CustomButton.vue';
import Opponent from '@/Molecules/Opponent.vue';


export default {
    name: 'Arena',

    props: [
        'showModal',
        'player',
        'opponents'
    ],

    emits: ['close_modal'],

    components: {
        Modal,
        SecondaryButton,
        PrimaryButton,
        CombatButton,
        CustomButton,
        Opponent
    },

    data() {
        return {
            listShare: [],
            shareAll: false
        }
    },

    created() {
        this.defaultPoints = this.minValue
        this.placeHolder = `Valor padrão: ${this.minValue}`
    },

    computed: {
        storePlayers: function() {
            return this.$store.getters.players
        },

        storeShowModal: function() {
            return this.showModal
        }
    },

    watch: {
        listShare() {
            this.shareAll = this.storePlayers.every((player) => this.listShare.includes(player.id))
        }
    },

    methods: {
        openModal: function() {
            this.listShare = []
        },

        closeModal: function() {
            this.$emit('close_modal')
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

.c-attacks {
    display: flex;
    gap: 0.5rem;
    justify-content: space-around;
    margin: 1rem 0;
}
</style>
