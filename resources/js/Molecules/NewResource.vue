<template>
    <AddButton @click="openModal" />

    <Modal :show="showModal" @close="closeModal">
        <div class="p-6">
            <div class="mt-6 c-new__player">
                <div class="input__default">
                    <label class="label__default">TIPO:</label>
                    <Select
                        :placeholder="'Selecione um tipo'"
                        :options="options"
                    />
                </div>

                <div v-for="attribute in allAttributes" :key="attribute.id" class="input__default">
                    <label class="label__default">{{ attribute.name }}:</label>
                    <IntInput
                        :tooltip="'placeHolder'"
                        ref="intInput"
                        type="number"
                        class="mt-1 block"
                        v-model="attribute.totalPoints"
                        :minValue="minValue"
                        @change="setValue"
                    />
                </div>
                <!-- <input type="file" id="myfile" name="myfile"> -->
                <!-- <ImageInput
                    v-model="image"
                    tooltip="'placeHolder'"
                /> -->
                <!-- :tooltip="'placeHolder'"
                    ref="imageInput"
                    class="mt-1 block"
                    v-model="image" -->

                <div class="c-image">
                    <label
                        class="custom-file-upload"
                        for="input-image"
                    >
                        IMAGEM:
                    </label>
                    <input
                        id="input-image"
                        type="file"
                        @input="image = $event.target.files[0]"
                    >
                </div>
            </div>

            <div class="mt-6 flex justify-end">
                <SecondaryButton @click="closeModal"> FECHAR </SecondaryButton>

                <PrimaryButton
                    class="ml-3"
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                    @click="addWeapon"
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
import Select from '@/Atoms/Select.vue';
import ImageInput from '@/Atoms/ImageInput.vue';
import { useForm } from '@inertiajs/vue3';
import { nextTick, ref } from 'vue';
import axios from 'axios';



export default {
    name: 'NewResource',

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
        Select,
        ImageInput
    },

    props: [
        'history_id',
        'allAttributes',
    ],

    emits: [
        "newResources"
    ],

    data() {
        return {
            showModal: false,
            timer: null,
            name: '',
            form: useForm({name: ''}),
            minValue: 0,
            defaultPoints: null,
            placeHolder: null,
            image: null,
            options: [
                'Arma',
                'Imagem'
            ]
        }
    },

    created() {
        // this.defaultPoints = this.minValue
        // this.placeHolder = `Valor padrão: ${this.minValue}`
    },

    watch: {
        image(newI) {
            console.log(newI)
        }
    },

    methods: {
        openModal: function() {
            this.showModal = true;
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

        addWeapon: function() {
            // const formData = new FormData()
            // formData.append("file", this.image)

            const data = {
                all_attributes: this.allAttributes,
                history_id: this.history_id,
                image: this.image
            }

            const config = {
                headers: {
                    "content-type": "multipart/form-data"
                }
            }

            axios.post(route('weapon.add'), data, config)
            .then((response) => {
                console.log('aquiiiii', response.data)
                // this.name = ''
                this.$emit('newResources', response.data)
                this.closeModal()
            })
        },

        closeModal: function() {
            this.showModal = false

            // this.resetPoints()
            // this.form.reset()
            // this.name = ''
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





.c-image {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

input::file-selector-button {
    --tw-text-opacity: 1;
    --tw-bg-opacity: 1;

    color: rgb(255 255 255 / var(--tw-text-opacity));
    letter-spacing: 0.1em;
    font-size: 0.75rem;
    line-height: 1rem;
    background-color: rgb(31 41 55 / var(--tw-bg-opacity));
    border-width: 1px;
    border-color: transparent;
    border-radius: 0.375rem;
    cursor: pointer;
}

input:focus {
    outline: none;
}
</style>
