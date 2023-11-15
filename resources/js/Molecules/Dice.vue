<template>
    <Modal :show="storeShow" @close="closeModal">
        <div class="c-info-dice">
            <h1 class="text-gray-500">DANO</h1>
            <div class="c-dice">
                <div class="value">
                    {{ value }}
                </div>
                <img class="dice" src="../../svg/dice-ded.svg">
            </div>
        </div>
    </Modal>
</template>

<script>
import Modal from '@/Components/Modal.vue';

export default {
    name: 'Dice',

    props: ['showDice'],

    components: {
        Modal
    },

    computed: {
        storeShow: function() {
            return this.showDice
        }
    },

    watch: {
        showDice(show) {
            if (show) {
                return this.openModal()

            }

            this.closeModal()
        }
    },

    data() {
        return {
            value: 20,
            showDice: false
        }
    },

    methods: {
        closeModal: function() {
            this.$emit('close_modal_dice')
        },
    }
}
</script>

<style scoped>
h1 {
    text-align: center;
    position: relative;
    min-height: 2rem;
    display: flex;
    justify-content: center;
    align-items: center;
    font-size: 2rem;
    margin: 1rem;
}

.c-info-dice {
    width: fit-content;
}

.c-dice {
    position: relative;
    width: 20rem;
    height: 20rem;
    display: flex;
    justify-content: center;
    align-items: center;
}
.dice {
    position: absolute;
    width: 20rem;
    animation: rotating 50s linear infinite;
}

.value {
    z-index: 99;
    top: 50%;
    left: 50%;
    font-size: 2rem;
    font-weight: 800;
    color: #fff;
    font-family: monospace;
}

@keyframes rotating {
    from {
        -ms-transform: rotate(0deg);
        -moz-transform: rotate(0deg);
        -webkit-transform: rotate(0deg);
        -o-transform: rotate(0deg);
        transform: rotate(0deg);
    }
    to {
        -ms-transform: rotate(360deg);
        -moz-transform: rotate(360deg);
        -webkit-transform: rotate(360deg);
        -o-transform: rotate(360deg);
        transform: rotate(360deg);
    }
}
</style>
