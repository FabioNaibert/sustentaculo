<template>
    <Modal :show="showModal" @close="closeModal">
        <div class="p-6">
            <h1 class="text-gray-500">Arena de Combate</h1>
            <p class="mt-6 text-gray-500">Selecione o tipo de ataque e o(s) inimigo(s) que leverá(ão) o ataque.</p>
            <div class="c-attacks">
                <AttackButton
                    @click="setTypeAttack(normalAttack)"
                    :active="normalAttack == selectedAttack"
                >
                    ATAQUE NORMAL
                </AttackButton>
                <AttackButton
                    @click="setTypeAttack(areaAttack)"
                    :active="areaAttack == selectedAttack"
                >
                    ATAQUE EM ÁREA
                </AttackButton>
                <AttackButton
                    @click="setTypeAttack(magicAttack)"
                    :active="magicAttack == selectedAttack"
                >
                    ATAQUE MÁGICO
                </AttackButton>
            </div>
            <p class="mt-6 text-gray-500" v-show="magicAttack == selectedAttack">Ataques de mana consomem 20% da mana total, mas aumentam o dano final em 50%.</p>
            <div class="mt-6 c-options">
                <div class="option--all text-gray-500" v-if="!singleTarget">
                    <input v-if="!singleTarget" type="checkbox" id="todos" value="null" @change="setTargetAllOpponent" v-model="targetAllOpponent">
                    <label for="todos">Todos</label>
                </div>
                <div
                    v-for="opponent in storeOpponents"
                    :key="opponent.id"
                >
                    <div class="option">
                        <input v-if="!singleTarget" type="checkbox" :id="opponent.id" :value="opponent.id" v-model="targetOpponent">
                        <input v-if="singleTarget" type="radio" :id="opponent.id" :value="opponent.id" v-model="targetOpponent">
                        <Opponent :opponent="opponent"/>
                    </div>
                </div>
            </div>
            <!-- <Dice /> -->
            <PrimaryButton class="ml-3 attack c-dice" >
                <img src="../../svg/dice.svg">{{ storeResultDice }}<img src="../../svg/dice.svg" style="transform: scaleX(-1);">
            </PrimaryButton>

            <div class="mt-6 flex justify-end">
                <SecondaryButton @click="closeModal"> FECHAR </SecondaryButton>

                <PrimaryButton
                    class="ml-3 attack"
                    @click="attack"
                >
                    <img src="../../svg/dice.svg">ROLAR DADO E ATACAR
                </PrimaryButton>
            </div>
        </div>
    </Modal>
</template>

<script>
import { findLast, isNumber, ceil } from 'lodash';
import Modal from '@/Components/Modal.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import axios from 'axios';
import CombatButton from '@/Atoms/CombatButton.vue';
import AttackButton from '@/Atoms/AttackButton.vue';
import Opponent from '@/Molecules/Opponent.vue';
import Dice from '@/Molecules/Dice.vue';


export default {
    name: 'Arena',

    props: [
        'showModal',
        'player',
    ],

    emits: ['close_modal'],

    components: {
        Modal,
        SecondaryButton,
        PrimaryButton,
        CombatButton,
        AttackButton,
        Opponent,
        Dice
    },

    data() {
        return {
            selectedAttack: false,
            normalAttack: 1,
            areaAttack: 2,
            magicAttack: 3,
            targetOpponent: [],
            targetAllOpponent: false,
            resultDice: null,
        }
    },

    mounted() {
        this.selectedAttack = this.normalAttack
    },

    computed: {
        storeIsPlayer: function() {
            return this.$store.getters.isPlayer
        },

        storeOpponents: function() {
            if (this.storeIsPlayer) return this.$store.getters.opponentsMobile

            return this.$store.getters.opponents
        },

        storeShowModal: function() {
            return this.showModal
        },

        singleTarget: function() {
            return this.normalAttack === this.selectedAttack || this.magicAttack === this.selectedAttack
        },

        storeResultDice: function() {
            return this.resultDice ? this.resultDice : "?"
        }
    },

    watch: {
        targetOpponent() {
            if (isNumber(this.targetOpponent)){
                return this.targetAllOpponent = false
            }

            this.targetAllOpponent = this.storeOpponents.every((opponent) => this.targetOpponent.includes(opponent.id))
        }
    },

    methods: {
        closeModal: function() {
            this.$emit('close_modal')
            this.setTypeAttack(this.normalAttack)
        },

        setTypeAttack: function(typeAttack) {
            this.targetOpponent = []
            this.selectedAttack = typeAttack
        },

        setTargetAllOpponent: function() {
            if (this.targetAllOpponent) {
                return this.targetOpponent = this.storeOpponents.map((opponent) => opponent.id)
            }

            return this.targetOpponent = []
        },

        calcNormalAttack: function() {
            const attributeAttackId = 3;
            const attribute = findLast(this.player.attributes, function(attribute) {
                return attribute.id === attributeAttackId
            })

            return Math.floor(Math.random() * attribute.totalPoints) + 1;
        },

        calcMagicAttack: function() {
            const attributeAttackId = 3;
            const attribute = findLast(this.player.attributes, function(attribute) {
                return attribute.id === attributeAttackId
            })

            const attack = ceil(attribute.totalPoints * 1.5)
            return Math.floor(Math.random() * attack) + 1;
        },

        attack: function() {
            let resultDice

            if (this.magicAttack === this.selectedAttack) {
                resultDice = this.calcMagicAttack()
            } else {
                resultDice = this.calcNormalAttack()
            }

            console.log(resultDice)

            if (isNumber(this.targetOpponent)){
                this.targetOpponent = [this.targetOpponent]
            }

            this.resultDice = resultDice

            axios.post(route('combat.attack'), {
                opponents_ids: this.targetOpponent,
                hit: resultDice,
                magic_attack: this.magicAttack == this.selectedAttack,
                player_id: this.player.id
            })
            .then((response) => {
                // this.$store.commit('updateResources', response.data)
            })
            .catch((error) => {
                console.error(error)
            })
            .finally(() => {
                // this.closeModal()
            })
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
    font-size: 1.5rem;
}

.c-options {
    display: flex;
    flex-direction: column;
    gap:1rem;
}

.option, .option--all {
    display: flex;
    flex-wrap: nowrap;
    gap:0.5rem;
    align-items: center;
}

.option--all {
    margin: 1rem 0;
    font-size: 1.4rem;
    font-weight: 800;
}

.c-attacks {
    display: flex;
    gap: 0.5rem;
    justify-content: space-around;
    margin: 1rem 0;
}

.attack {
    display: flex;
    justify-content: space-between;
    gap: 0.5rem;
    align-items: center;
}

.c-dice {
    margin: 1rem auto;
    font-size: 1.5rem;
}
</style>
