<template>
        <div class="c-info">
            <h3>
                <b class="name">
                    {{ storeGameMobile.player.name }}
                    <img src="../../svg/exclamation.svg" class="exclamation" v-if="storeGameMobile.player.pointsDistribution > 0">
                </b>
            </h3>

            <div class="info__attribute">
                <div
                    v-for="attribute in storePlayer.attributes"
                    :key="attribute.id"
                >
                    <div class="attribute">
                        <p>{{ attribute.name }}</p>
                        <AttributeBar v-if="showAttributeBar(attribute.currentPoints)"
                            :totalPoints="attribute.totalPoints"
                            :currentPoints="attribute.currentPoints"
                            :color="attribute.representationColor"
                        />
                        <div v-else class="attribute__points">{{attribute.totalPoints}}</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="c-options">
            <Dice />
            <CustomButton
                v-if="storeGameMobile.player.pointsDistribution > 0"
                class="custom-button"
                @click="openModal()"
            >
                PONTOS
            </CustomButton>
            <CustomButton
                class="custom-button"
                @click="inventory()"
            >
                INVENTÁRIO
            </CustomButton>
            <CustomButton
                class="custom-button"
                @click="openArenaModal()"
                :disabled="!storePlayer.active || storeIsDead"
            >
                AÇÕES
            </CustomButton>
        </div>

        <Modal :show="showModal" @close="closeModal">
            <Points :player="storePlayer" @close_modal="closeModal"/>
        </Modal>
        <Arena
            :showModal="storeShowArenaModal"
            :player="storePlayer"
            @close_modal="closeArenaModal"
        />
</template>

<script>
import { findLast } from 'lodash';
import AttributeBar from '@/Atoms/AttributeBar.vue';
import NavLink from '@/Components/NavLink.vue';
import CustomButton from '@/Atoms/CustomButton.vue';
import Modal from '@/Components/Modal.vue';
import Points from '@/Molecules/Points.vue';
import Arena from '@/Molecules/Arena.vue';
import Dice from '@/Molecules/Dice.vue';

export default {
    name: 'GameMaster',

    emits: ['inventory'],

    components: {
        AttributeBar,
        NavLink,
        CustomButton,
        Modal,
        Points,
        Arena,
        Dice
    },

    data() {
        return {
            showModal: false,
            showArenaModal: false
        }
    },

    computed: {
        storeGameMobile: function() {
            return this.$store.getters.gameMobile
        },

        storePlayer: function() {
            return this.storeGameMobile.player
        },

        storeShowArenaModal: function() {
            return this.showArenaModal
        },

        storeIsDead: function() {
            const attributeLifeId = 1;
            const attribute = findLast(this.storePlayer.attributes, function(attribute) {
                return attribute.id === attributeLifeId
            })

            return attribute.currentPoints <= 0
        },
    },

    methods: {
        showAttributeBar: function(current) {
            return current !== null && current !== undefined
        },

        inventory: function() {
            this.$emit('inventory')
        },

        openModal: function() {
            this.showModal = true
        },

        closeModal: function() {
            this.showModal = false
        },

        openArenaModal: function() {
            this.showArenaModal = true;
        },

        closeArenaModal: function() {
            this.showArenaModal = false
        },
    }
}
</script>

<style scoped>
.attribute {
    display: flex;
    align-items: center;
    flex-wrap: nowrap;
    gap: 1rem;
}

.info__attribute {
    flex-grow: 2;
}

p {
    min-width: 4.5rem;
}

.attribute__points {
    text-align: left;
}

.c-info {
    display: flex;
    justify-content: space-between;
    gap: 1rem;
    flex-direction: column;
    position: absolute;
    bottom: 3.5rem;
    margin-left: 1.5rem;
    width: 45%;
}

.c-options {
    display: flex;
    flex-direction: column;
    gap: 0.3rem;

    position: absolute;
    bottom: 3.5rem;
    right: 0;
    margin-right: 1.5rem;
    align-items: flex-end;
}

.custom-button {
    flex-grow: 2;
    width: 100%;
}

.name {
    position: relative;
    display: flex;
    width: fit-content;
}

.exclamation {
    position: absolute;
    left: 100%;
    top: 0;
}
</style>
