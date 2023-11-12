<template>
    <AddButton @click="openModal" tooltip="Adicionar áudio" />

    <Modal :show="showModal" @close="closeModal">
        <div class="p-6">
            <h1>Novo Áudio</h1>
            <p style="margin: 1rem 0;">Os áudios estão ligados ao capítulo. Aqui você pode pesquisar por trilhas, sons de ambientes ou sons de animais para reproduzir durante capítulo.</p>
            <p><em>Ao trocar de capítulo, a lista de áudios atualizará.</em></p>
            <em>Para pesquisar, insira alguma palavra-chave para encontrar o áudio.</em>
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
                            <div class="option__functions">
                                <audio controls controlslist="nodownload">
                                    <source :src="sound.content" type="audio/mpeg">
                                    Seu navegador não suporta elementos de áudio
                                </audio>
                                <button class="add__user"
                                    title="Adicionar jogador"
                                    @click="add(sound.id)"
                                >
                                    <img src="../../svg/plus-lg.svg" />
                                </button>
                            </div>
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

        add: function(id) {
            axios.post(route('sound.add'), {
                sound_id: id,
                chapter_id: this.storeChapterId
            })
            .then((response) => {
                this.sounds = null
                this.name = ''
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

.option__functions {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 0.3rem;
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

audio {
    width: 15rem;
}
</style>
