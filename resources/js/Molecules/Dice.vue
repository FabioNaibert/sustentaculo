<template>
    <CircleButton @click="openModal"><img style="width: 60%;" src="../../svg/dice.svg"></CircleButton>

    <Modal :show="showModal" @close="closeModal">
        <div class="c-dice p-6">
            <div class="c-info-dice">
                <h1 class="text-gray-900">Faces</h1>
                <FaceDiceButton
                    v-for="face in facesList"
                    :key="face"
                    class="dice-btn"
                    @click="setFaces(face)"
                    :active="faces == face"
                >
                    <img src="../../svg/dice.svg">
                    {{ face }}
                </FaceDiceButton>
                <SecondaryButton @click="clean">
                    Recolher dados
                </SecondaryButton>
            </div>
            <div class="c-calc">
                <div class="c-select">
                    <div class="input__default">
                        <label class="label__default">Quantos dados você quer rolar?</label>
                        <select v-model="selectedOption" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                            <option v-for="option in options" :key="option" :value="option">{{ option }}</option>
                        </select>
                    </div>

                    <CircleButton @click="calc"><img style="width: 60%;" src="../../svg/dice.svg"></CircleButton>
                </div>
                <div class="c-result">
                    <SecondaryButton v-if="storeSum">
                        Soma: {{ storeSum }}
                    </SecondaryButton>
                    <PrimaryButton v-for="result in results" :key="result" class="dice-btn" >
                        <img src="../../svg/dice.svg">
                        {{ result }}
                    </PrimaryButton>

                </div>
            </div>
        </div>
    </Modal>
</template>

<script>
import { sum } from 'lodash';
import Modal from '@/Components/Modal.vue';
import CircleButton from '@/Atoms/CircleButton.vue';
import FaceDiceButton from '@/Atoms/FaceDiceButton.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import Select from '@/Atoms/Select.vue';

export default {
    name: 'Dice',

    components: {
        Modal,
        CircleButton,
        PrimaryButton,
        Select,
        SecondaryButton,
        FaceDiceButton
    },

    computed: {
        storeSum: function() {
            return sum(this.results)
        }
    },

    data() {
        return {
            faces: 4,
            value: 20,
            showModal: false,
            options: [],
            selectedOption: 1,
            results: [],
            facesList: [ 4, 6, 8, 10, 12, 20 ]
        }
    },

    created() {
        for(let i=1; i<=10; i++) {
            this.options.push(i)
        }
    },

    methods: {
        openModal: function() {
            this.showModal = true
        },

        closeModal: function() {
            this.showModal = false
        },

        setFaces: function(faces) {
            this.faces = faces
        },

        calc: function() {
            for(let times = this.selectedOption; times>0; times--) {
                this.results.push(Math.floor(Math.random() * this.faces) + 1)
            }
        },

        clean: function() {
            this.results = []
        }
    }
}
</script>

<style scoped>
h1 {
    text-align: center;
    display: flex;
    justify-content: center;
    align-items: center;
    font-size: 1.5rem;
}

.dice-btn {
    display: flex;
    justify-content: space-between;
    gap: 0.5rem;
    align-items: center;
    font-size: 1.5rem;
    width: 100%;
}

.c-info-dice {
    width: fit-content;
    display: flex;
    flex-direction: column;
    gap: 0.7rem;
}

.c-dice {
    display: flex;
    gap: 1.5rem;
}

.c-calc {
    padding-right: 1.5rem;
}

.c-select {
    display: flex;
    justify-content: space-around;
    align-items: center;
    gap: 1rem;
    flex-wrap: wrap;
}

.c-result {
    padding: 1rem 1.5rem 0;
    width: fit-content;
    margin: auto;
    display: flex;
    flex-direction: column;
    gap: 0.7rem;
}

.input__default {
    text-align: center;
}
</style>
