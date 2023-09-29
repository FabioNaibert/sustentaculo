<template>
    <AddButton @click="openModal" />

    <Modal :show="showModal" @close="closeModal">
        <div class="p-6">
            <!-- <h2 class="text-lg font-medium text-gray-900">
                Como se chama sua história?
            </h2>

            <p class="mt-1 text-sm text-gray-600">
                Defina um nome para sua história. Ele será exibido na sua página inicial e na página inicial dos jogadores escolhidos por você.
            </p> -->

            <div class="mt-6 c-new__player">
                <div>
                    <TextInput
                        ref="nameInput"
                        v-model="form.name"
                        type="text"
                        class="mt-1 block input__name"
                        placeholder="Nome do inimigo"
                        @keyup.enter="search"
                        @keyup="search"
                    />


                </div>

                <div v-for="attribute in allAttributes" :key="attribute.id" class="input__default">
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
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                >
                    SALVAR
                </PrimaryButton>
            </div>
        </div>
    </Modal>
</template>

<script>
import DangerButton from '@/Components/DangerButton.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import IntInput from '@/Atoms/IntInput.vue';
import Modal from '@/Components/Modal.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import AddButton from '@/Atoms/AddButton.vue';
import { useForm } from '@inertiajs/vue3';
import { nextTick, ref } from 'vue';
import axios from 'axios';


export default {
    name: 'NewEnemy',

    components: {
        DangerButton,
        InputError,
        InputLabel,
        Modal,
        SecondaryButton,
        PrimaryButton,
        TextInput,
        AddButton,
        IntInput,
    },

    props: [
        'history_id',
        'allAttributes',
    ],

    data() {
        return {
            showModal: false,
            timer: null,
            form: useForm({name: ''}),
            minValue: 0,
            defaultPoints: null,
            placeHolder: null
        }
    },

    created() {
        this.defaultPoints = this.minValue
        this.placeHolder = `Valor padrão: ${this.minValue}`
    },

    methods: {
        openModal: function() {
            this.showModal = true;

            nextTick(() => this.$refs["nameInput"].focus());
        },

        search: function() {
            if (this.form.name == '') {
                this.users = null
                return
            }

            if (this.timer) {
                clearTimeout(this.timer);
                this.timer = null;
            }

            this.timer = setTimeout(() => {
                axios.post(route('player.search'), {
                    name: this.form.name,
                    history_id: this.history_id
                })
                .then((response) => {
                    console.log(response.data)
                    this.users = response.data
                })
            }, 800);
        },

        addUser: function(userId) {
            axios.post(route('player.add'), {
                user_id: userId,
                history_id: this.history_id,
                points: this.defaultPoints,
            })
            .then((response) => {
                this.users = null
                this.form.name = ''
                nextTick(() => this.$refs["nameInput"].focus())
            })
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

        closeModal: function() {
            this.showModal = false

            this.resetPoints()
            this.form.reset()
        },

        resetPoints: function() {
            this.allAttributes.forEach(element => {
                element.totalPoints = null
            });
        }
    }
}
</script>

<style scoped>
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
}

.label__default {
    white-space: nowrap;
    display: flex;
    align-self: center;
}

.c-new__player {
    display: flex;
    flex-direction: column;
    gap:1rem;
}
</style>
