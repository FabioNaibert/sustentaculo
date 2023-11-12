<template>
    <AddButton @click="openModal" tooltip="Adicionar inimigo"/>

    <Modal :show="showModal" @close="closeModal">
        <div class="p-6">
            <h1>Novo Inimigo</h1>
            <div class="mt-6 c-new__player">
                <p>Aqui você poderá criar um inimigo para desafiar seus jogadores. Durante a partida, você poderá <em>"ressuscitar"</em> os inimigos e jogar com eles novamente.</p>
                <em>Ao trocar de capítulo, a lista de inimigos permanecerá a mesma.</em>
                <div class="input__default">
                    <label class="label__default">NOME:</label>
                    <TextInput
                        ref="nameInput"
                        v-model="name"
                        type="text"
                        class="mt-1 block input__name"
                        placeholder="Nome do inimigo"
                    />
                </div>

                <div v-for="attribute in storeAllAttributes" :key="attribute.id" class="input__default">
                    <label class="label__default">{{ attribute.name }}:</label>
                    <IntInput :tooltip="placeHolder"
                        ref="intInput"
                        type="number"
                        class="mt-1 block"
                        :placeholder="placeHolder"
                        v-model="attribute.totalPoints"
                        :minValue="minValue"
                        @change="setValue"
                    />
                </div>
            </div>

            <div class="mt-6 flex justify-end">
                <SecondaryButton @click="closeModal"> FECHAR </SecondaryButton>

                <PrimaryButton
                    class="ml-3"
                    @click="addEnemy"
                >
                    SALVAR
                </PrimaryButton>
            </div>
        </div>
    </Modal>
</template>

<script>
import IntInput from '@/Atoms/IntInput.vue';
import Modal from '@/Components/Modal.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import AddButton from '@/Atoms/AddButton.vue';
import { nextTick, ref } from 'vue';
import axios from 'axios';


export default {
    name: 'NewEnemy',

    components: {
        Modal,
        SecondaryButton,
        PrimaryButton,
        TextInput,
        AddButton,
        IntInput,
    },

    data() {
        return {
            showModal: false,
            timer: null,
            name: '',
            minValue: 0,
            defaultPoints: null,
            placeHolder: null
        }
    },

    created() {
        this.defaultPoints = this.minValue
        this.placeHolder = `Valor padrão: ${this.minValue}`
    },

    computed: {
        storeHistoryId: function() {
            return this.$store.getters.historyId
        },

        storeAllAttributes: function() {
            return this.$store.getters.allAttributes
        },
    },

    methods: {
        openModal: function() {
            this.showModal = true;

            nextTick(() => this.$refs["nameInput"].focus());
        },

        setValue: function() {
            if (this.defaultPoints < this.minValue){
                return this.defaultPoints = this.minValue
            }

            if (isNaN(parseInt(this.defaultPoints))) {
                return this.defaultPoints = this.minValue
            }

            return this.defaultPoints = parseInt(this.defaultPoints)
        },

        addEnemy: function() {
            const data = {
                name: this.name,
                all_attributes: this.storeAllAttributes,
                history_id: this.storeHistoryId,
            }

            axios.post(route('enemy.add'), data)
            .then((response) => {
                this.closeModal()
                this.$store.commit('updateEnemies', response.data)

            })
        },

        closeModal: function() {
            this.showModal = false

            this.resetPoints()
            this.name = ''
        },

        resetPoints: function() {
            this.storeAllAttributes.forEach(element => {
                element.totalPoints = null
            });
        }
    }
}
</script>

<style scoped>
h1 {
    text-align: center;
    font-size: 2rem;
}

.input__name {
    width: 100%;
    z-index: 99;
    position: relative;
}

.c-users {
    width: 90%;
    margin: auto;
    max-height: 15rem;
    overflow-x: hidden;
    overflow-y: auto;
    border-bottom-left-radius: 8px;
    border-bottom-right-radius: 8px;
    background-color: floralwhite;
}

.option, .option--empty {
    padding: 0.3rem 0.6rem;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.option:hover {
    background-color: darkgray;
}

.add__user {
    background: linear-gradient(90deg, rgba(25,130,33,1) 33%, rgba(1,212,175,1) 100%);
    border-radius: 50%;
    width: 1.2rem;
    height: 1.2rem;
    display: flex;
    justify-content: center;
    align-items: center;
}

.add__user:hover {
    background: linear-gradient(187deg, rgba(1,212,175,1) 33%, rgba(168,255,240,1) 100%);
}

.input__default {
    display: flex;
    align-content: center;
    gap: 0.5rem;
    width: 50%;
}

.label__default {
    white-space: nowrap;
    display: flex;
    align-self: center;
    flex-grow: 2;
}

.c-new__player {
    display: flex;
    flex-direction: column;
    gap:1rem;
}
</style>
