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

            <div class="mt-6">
                <InputLabel for="title" value="Título" class="sr-only" />

                <TextInput
                    ref="nameInput"
                    v-model="form.name"
                    type="text"
                    class="mt-1 block w-3/4"
                    placeholder="Nome do usuário"
                    @keyup.enter="search"
                    @keyup="search"
                />

                <div v-if="users != null">
                    <div v-for="user in users" :key="user.id">
                        {{ user.name }}
                    </div>
                    <div v-if="users.length == 0">
                        Nenhum usuário encontrado
                    </div>
                </div>

                <!-- <InputError :message="form.errors.password" class="mt-2" /> -->
            </div>

            <div class="mt-6 flex justify-end">
                <SecondaryButton @click="closeModal"> FECHAR </SecondaryButton>

                <!-- <PrimaryButton
                    class="ml-3"
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                    @click="newHistory"
                >
                    SALVAR
                </PrimaryButton> -->
            </div>
        </div>
    </Modal>
</template>

<script>
import DangerButton from '@/Components/DangerButton.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import Modal from '@/Components/Modal.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import AddButton from '@/Atoms/AddButton.vue';
import { useForm } from '@inertiajs/vue3';
import { nextTick, ref } from 'vue';
import axios from 'axios';


export default {
    name: 'NewPlayer',

    components: {
        DangerButton,
        InputError,
        InputLabel,
        Modal,
        SecondaryButton,
        PrimaryButton,
        TextInput,
        AddButton,
    },

    props: [
        'history_id'
    ],

    data() {
        return {
            showModal: false,
            timer: null,
            form: useForm({name: ''}),
            users: null,
        }
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
                axios.get(route('player.search') + '/' + this.form.name)
                    .then((response) => {
                        console.log(response.data)
                        this.users = response.data
                    })
            }, 800);
        },

        closeModal: function() {
            this.showModal = false;

            this.form.reset();
        }
    }
}
</script>

