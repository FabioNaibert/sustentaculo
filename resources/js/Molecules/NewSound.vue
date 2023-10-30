<template>
    <AddButton @click="openModal" />

    <Modal :show="showModal" @close="closeModal">
        <div class="p-6">
            <div class="mt-6 c-new__player">
                <div>
                    <TextInput
                        ref="nameInput"
                        v-model="name"
                        type="text"
                        class="mt-1 block input__name"
                        placeholder="Nome do usuário"
                        @keyup.enter="search"
                        @keyup="search"
                    />

                    <div v-if="sounds != null" class="c-users">
                        <div v-for="sound in sounds" :key="sound.id" class="option">
                            {{ sound.name }}
                            <button class="add__user"
                                title="Adicionar jogador"
                                @click="addUser(sound.id)"
                            >
                                <img src="../../svg/plus-lg.svg" />
                            </button>
                        </div>
                        <div v-if="sounds.length == 0" class="option--empty">
                            Nenhum áudio encontrado
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-6 flex justify-end">
                <SecondaryButton @click="closeModal"> FECHAR </SecondaryButton>
            </div>
        </div>
    </Modal>
</template>

<script>
import IntInput from '@/Atoms/IntInput.vue';
import Modal from '@/Components/Modal.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import AddButton from '@/Atoms/AddButton.vue';
import { nextTick, ref } from 'vue';
import axios from 'axios';


export default {
    name: 'NewSound',

    components: {
        Modal,
        SecondaryButton,
        TextInput,
        AddButton,
        IntInput,
    },

    props: [
        'default_points'
    ],

    data() {
        return {
            showModal: false,
            name: '',
            timer: null,
            sounds: null,
            defaultPoints: this.default_points,
            placeHolder: `Valor padrão: ${this.default_points}`
        }
    },

    watch: {
    },

    computed: {
        storeChapterId: function() {
            return this.$store.getters.chapter.id
        },
    },

    methods: {
        openModal: function() {
            this.showModal = true;

            nextTick(() => this.$refs["nameInput"].focus());
        },

        search: function() {
            if (this.name == '') {
                this.sounds = null
                return
            }

            if (this.timer) {
                clearTimeout(this.timer);
                this.timer = null;
            }

            this.timer = setTimeout(() => {
                axios.post(route('sound.search'), {
                    name: this.name,
                    chapter_id: this.storeChapterId
                })
                .then((response) => {
                    this.sounds = response.data
                })
            }, 800);
        },

        addUser: function(userId) {
            axios.post(route('player.add'), {
                user_id: userId,
                history_id: this.storeHistoryId,
                points: this.defaultPoints,
            })
            .then((response) => {
                this.sounds = null
                this.$store.commit('updateSounds', response.data)
                nextTick(() => this.$refs["nameInput"].focus());
            })
        },

        closeModal: function() {
            this.showModal = false;

            this.name = '';
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
