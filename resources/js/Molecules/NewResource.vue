<template>
    <AddButton @click="openModal" />

    <Modal :show="showModal" @close="closeModal">
        <div class="p-6">
            <div class="mt-6 c-new__player">
                <div class="input__default">
                    <label class="label__default">TIPO:</label>
                    <Select
                        @selectedOption="(option) => selectedComponent = option"
                        :placeholder="'Selecione um tipo'"
                        :options="options"
                    />
                </div>
            </div>

            <component
                :is="selectedComponent.component"
                v-bind="selectedComponent.props"
                v-if="selectedComponent"
                @closeModal="closeModal"
            ></component>
        </div>
    </Modal>
</template>

<script>
import AddButton from '@/Atoms/AddButton.vue'
import Modal from '@/Components/Modal.vue';
import Select from '@/Atoms/Select.vue';
import { shallowRef } from 'vue';
import NewWeapon from '@/Molecules/NewWeapon.vue';
import NewImage from '@/Molecules/NewImage.vue';



export default {
    name: 'NewResource',

    components: {
        AddButton,
        Modal,
        Select,
        NewWeapon,
        NewImage
    },

    props: [
        'history_id',
        'chapter_id',
        'allAttributes',
    ],

    data() {
        return {
            showModal: false,
            selectedComponent: null,
            options: [
                {
                    component: shallowRef(NewWeapon),
                    name: 'Arma',
                },
                {
                    component: shallowRef(NewImage),
                    name: 'Imagem',
                }
            ]
        }
    },

    methods: {
        openModal: function() {
            this.showModal = true;
        },

        closeModal: function() {
            this.showModal = false
            this.selectedComponent = null
        },
    }
}
</script>

<style scoped>
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
