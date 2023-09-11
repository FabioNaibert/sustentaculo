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

const confirmingNewHistory = ref(false);
const titleInput = ref(null);

const form = useForm({
    title: '',
});

const confirmNewHistory = () => {
    confirmingNewHistory.value = true;

    nextTick(() => titleInput.value.focus());
};

const newHistory = () => {
    form.post(route('history.store'), {
        preserveScroll: true,
        onSuccess: () => closeModal(),
        onError: () => titleInput.value.focus(),
        onFinish: () => form.reset(),
    });
};

const closeModal = () => {
    confirmingNewHistory.value = false;

    form.reset();
};
</script>

<template>
    <AddButton @click="confirmNewHistory" />

    <Modal :show="confirmingNewHistory" @close="closeModal">
        <div class="p-6">
            <h2 class="text-lg font-medium text-gray-900">
                Como se chama sua história?
            </h2>

            <p class="mt-1 text-sm text-gray-600">
                Defina um nome para sua história. Ele será exibido na sua página inicial e na página inicial dos jogadores escolhidos por você.
            </p>

            <div class="mt-6">
                <InputLabel for="title" value="Título" class="sr-only" />

                <TextInput
                    id="title"
                    ref="titleInput"
                    v-model="form.title"
                    type="text"
                    class="mt-1 block w-3/4"
                    placeholder="Título"
                    @keyup.enter="newHistory"
                />

                <!-- <InputError :message="form.errors.password" class="mt-2" /> -->
            </div>

            <div class="mt-6 flex justify-end">
                <SecondaryButton @click="closeModal"> Cancel </SecondaryButton>

                <PrimaryButton
                    class="ml-3"
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                    @click="newHistory"
                >
                    SALVAR
                </PrimaryButton>
            </div>
        </div>
    </Modal>
</template>
