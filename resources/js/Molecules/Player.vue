<template>
    <div class="card bg-white shadow-sm sm:rounded-lg">
        <div class="c-text text-gray-900" @click="openModal">
            <h3>{{ player.name }}</h3>
            <div class="c-info">
                <div class="info__attribute">
                    <div
                        v-for="attribute in storeAttributes"
                        :key="attribute.id"
                    >
                        <div class="attribute" v-if="showAttributeBar(attribute.currentPoints) || showAll">
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
                <RemoveButton
                    v-show="storeEditMode"
                    @click="removePlayer"
                    :tooltip="tooltip"
                />
                <Toggle
                    :player="player"
                    @click.stop
                />
            </div>
        </div>
        <AccordionButton @click="showAllAttributes()" :rotate="showAll" :identifier="player.id"/>
    </div>

    <Modal :show="showModal" @close="cancelModal">
        <div class="p-6">
            <div class="c-text--modal text-gray-900">
                <h3 style="margin-bottom: 1rem;">{{ player.name }}</h3>
                <p><b>Diminua</b> ou <b>aumente</b> os pontos atuais dos atributos do personagem.</p>
                <p v-if="allCurrentPointsNull">Entretando o jogador ainda não usou os pontos iniciais. Peça para o jogador distribuir os seus pontos de atributo.</p>
                <div class="c-info">
                    <div class="info__attribute" style="margin: 1rem 0;" v-if="!allCurrentPointsNull">
                        <div
                            v-for="attribute in storeAttributes"
                            :key="attribute.id"
                        >
                            <div class="attribute" v-if="showAttributeBar(attribute.currentPoints)">
                                <p>{{ attribute.name }}</p>
                                <AttributeBar
                                    :totalPoints="attribute.totalPoints"
                                    :currentPoints="attribute.currentPoints"
                                    :color="attribute.representationColor"
                                />
                                <input
                                    type="range"
                                    min="0"
                                    :max="attribute.totalPoints"
                                    step="1"
                                    v-model="attribute.currentPoints"
                                    :disabled="attribute.totalPoints === 0"
                                />
                                <p>{{ attribute.currentPoints }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <p v-if="!isEnemy" style="margin: 2.5rem 0 0.5rem;">Aumente o <b>nível</b> do jogador dando mais pontos de atributos para ele usar.</p>
                <div class="input__default" v-if="!isEnemy">
                    <label class="label__default">PONTOS PARA ATRIBUTOS:</label>
                    <IntInput tooltip="Valor padrão: 0"
                        ref="intInput"
                        type="number"
                        class="mt-1 block"
                        placeholder="Valor padrão: 0"
                        v-model="player.pointsDistribution"
                        :minValue="0"
                        @change="setValue"
                    />
                </div>
            </div>
            <div class="mt-6 flex justify-end">
                <SecondaryButton @click="cancelModal"> FECHAR </SecondaryButton>

                <PrimaryButton
                    class="ml-3"
                    @click="updatePlayer"
                >
                    SALVAR
                </PrimaryButton>
            </div>
        </div>
    </Modal>
</template>

<script>
import { orderBy, every, cloneDeep } from 'lodash'
import AttributeBar from "@/Atoms/AttributeBar.vue";
import RemoveButton from "@/Atoms/RemoveButton.vue";
import AccordionButton from "@/Atoms/AccordionButton.vue";
import Modal from '@/Components/Modal.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import IntInput from '@/Atoms/IntInput.vue';
import Toggle from '@/Atoms/Toggle.vue';

export default {
    name: 'Player',

    components: {
        AttributeBar,
        RemoveButton,
        AccordionButton,
        Modal,
        PrimaryButton,
        SecondaryButton,
        IntInput,
        Toggle
    },

    props: [
        'player',
    ],

    data() {
        return {
            tooltip: 'Excluir inimigo',
            showAll: false,
            showModal: false,
            oldAttributes: null,
        }
    },

    computed: {
        storeAttributes: function() {
            return orderBy(this.player.attributes, ['id'])
        },

        storeHistoryId: function() {
            return this.$store.getters.historyId
        },

        storeEditMode: function() {
            return this.$store.getters.editMode
        },

        storeMasterId: function() {
            return this.$store.getters.historyMasterId
        },

        isEnemy: function() {
            return this.storeMasterId === this.player.userId
        },

        allCurrentPointsNull: function() {
            return every(this.storeAttributes, function(attribute) {
                return attribute.currentPoints == null || attribute.currentPoints == undefined
            })
        }
    },

    methods: {
        showAttributeBar: function(current) {
            return current !== null && current !== undefined
        },

        removePlayer: function() {
            axios.post(route('enemy.remove'), {
                player_id: this.player.id,
                history_id: this.storeHistoryId
            })
            .then((response) => {
                this.$store.commit('updateEnemies', response.data)
            })
        },

        showAllAttributes: function() {
            this.showAll = !this.showAll
        },

        openModal: function() {
            this.oldAttributes = cloneDeep(this.storeAttributes)

            this.showModal = true
        },

        cancelModal: function() {
            this.player.attributes = this.oldAttributes

            this.closeModal()
        },

        closeModal: function() {
            this.showModal = false
        },

        setValue: function() {
            if (isNaN(parseInt(this.player.pointsDistribution))) {
                return this.player.pointsDistribution = 0
            }

            if (this.player.pointsDistribution < 0 || this.player.pointsDistribution == null || this.player.pointsDistribution == undefined) {
                return this.player.pointsDistribution = 0
            }

            this.player.pointsDistribution = parseInt(this.player.pointsDistribution)
        },

        updatePlayer: function() {
            axios.post(route('player.update'), {player: this.player})
            .then(() => {
            })
            .catch((error) => {
                console.error(error)
                this.cancelModal()
            })
            .finally(() => {
                this.closeModal()
            })
        }
    }

}
</script>

<style scoped>
h3 {
    text-align: center;
}

p {
    min-width: 4.5rem;
}

.card {
    width: 100%;
    overflow: hidden;
}

.c-text, .c-text--modal{
    padding: 0.2rem 1.5rem;
}

.c-text {
    cursor: pointer;
}

.attribute {
    display: flex;
    align-items: center;
    flex-wrap: nowrap;
    gap: 1rem;
}

.c-info {
    display: flex;
    justify-content: space-between;
    gap: 1rem;
    align-items: center;
}

.info__attribute {
    flex-grow: 2;
}

.attribute__points {
    text-align: left;
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
</style>
