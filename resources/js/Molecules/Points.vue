<template>
    <div class="p-6">
        <div class="mt-6 c-new__player">
            <div>
                <TextInput
                    ref="nameInput"
                    v-model="storePlayer.name"
                    type="text"
                    class="mt-1 block input__name"
                    placeholder="Nome do personagem"
                    disabled
                />
            </div>

            <div>
                PONTOS DISPONÍVEIS: {{ storePlayer.pointsDistribution }}
            </div>

            <div v-for="attribute in storePlayer.attributes" :key="attribute.id" class="input__default">
                <label class="label__default">{{ attribute.name }}:</label>

                <input
                    class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                    :value="attribute.totalPoints"
                    ref="input"
                    :title="'Valor mínimo: 0'"
                    :min="attributes[attribute.id].totalPoints"
                    disabled
                    style="width: 6rem;"
                />

                <CustomButton @click="() => subPoint(attribute.totalPoints, attributes[attribute.id].totalPoints) ? attribute.totalPoints-=1 : null" class="custom-buttom">
                    <img src="../../svg/minus.svg">
                </CustomButton>
                <CustomButton @click="() => sumPoint() ? attribute.totalPoints+=1 : null" class="custom-buttom">
                    <img src="../../svg/plus.svg">
                </CustomButton>
            </div>
        </div>

        <div class="mt-6 flex justify-end">
            <!-- <SecondaryButton @click="closeModal"> FECHAR </SecondaryButton> -->

            <PrimaryButton
                class="ml-3"
                @click="updatePlayer"
            >
                SALVAR
            </PrimaryButton>
        </div>
    </div>
</template>

<script>
import { sumBy, cloneDeep, mapKeys } from 'lodash';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import CustomButton from '@/Atoms/CustomButton.vue';
import TextInput from '@/Components/TextInput.vue';

export default {
    name: 'Points',

    props: ['player'],

    emits: ['close_modal'],

    components: {
        PrimaryButton,
        SecondaryButton,
        CustomButton,
        TextInput
    },

    data() {
        return {
            minValue: 0,
            attributes: null,
            limitPointsDistribution: null
        }
    },

    created() {
        console.log('mounted')
        this.limitPointsDistribution = this.storePlayer.pointsDistribution
        this.attributes = mapKeys(cloneDeep(this.storePlayer.attributes), function(attribute, key) {
            return attribute.id
        })
    },

    computed: {
        storePlayer: function() {
            return this.player


            // return this.$store.getters.gameMobile.player
        }
    },

    methods: {
        sumPoint: function() {
            if (this.storePlayer.pointsDistribution > 0) {
                this.storePlayer.pointsDistribution -= 1
                return true
            }

            return false
        },

        subPoint: function(totalPoints, minPoints) {
            if (this.limitPointsDistribution >= this.sumAttributes() && totalPoints > minPoints) {
                this.storePlayer.pointsDistribution += 1
                return true
            }

            return false
        },

        sumAttributes: function() {
            const newTotal = sumBy(this.storePlayer.attributes, function(attribute) {
                return attribute.totalPoints
            })

            const oldTotal = sumBy(Object.values(this.attributes), function(attribute) {
                return attribute.totalPoints
            })

            return newTotal - oldTotal
        },

        updatePlayer: function() {
            axios.post(route('player.update'), {player: this.storePlayer})
            .then(() => {
            })
            .catch((error) => {
                console.error(error)
            })
            .finally(() => {
                this.$emit('close_modal')
            })
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
    flex-grow: 2;
}

.c-new__player {
    display: flex;
    flex-direction: column;
    gap:1rem;
}

.custom-buttom {
    width: 2.5rem;
}
</style>
