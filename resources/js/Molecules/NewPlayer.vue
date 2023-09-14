<script setup>
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

const showModal = ref(false);
const titleInput = ref(null);

const form = useForm({
    name: '',
});

const openModal = () => {
    showModal.value = true;

    nextTick(() => titleInput.value.focus());
};

const data = () => {
    console.log('teste')
    // form.post(route('history.store'), {
    //     preserveScroll: true,
    //     onSuccess: () => closeModal(),
    //     onError: () => titleInput.value.focus(),
    //     onFinish: () => form.reset(),
    // });
};

// import { router } from '@inertiajs/vue3'

// router.post('/users', data, {
//   onCancelToken: (cancelToken) => (this.cancelToken = cancelToken),
// })

// // Cancel the visit...
// this.cancelToken.cancel()

const closeModal = () => {
    showModal.value = false;

    form.reset();
};
</script>

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
                    id="title"
                    ref="titleInput"
                    v-model="form.name"
                    type="text"
                    class="mt-1 block w-3/4"
                    placeholder="Usuário"
                    @keyup.enter="data"
                    @keyup="data"
                />

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
