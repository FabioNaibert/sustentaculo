<template>
    <div
        @click="clickGame"
        @mouseover="() => showEditHistory = true"
        @mouseleave="() => showEditHistory = false"
        class="card bg-white shadow-sm sm:rounded-lg"
        :class="{'element--hover': hoverHistory}"
    >
        <div class="c-text p-6 text-gray-900">
            <div class="text">
                <h3 :class="{'element--hover': hoverTitle}" v-if="!editMode">
                    {{ history.title }}
                    <EditButton
                        class="edit--title"
                        v-if="showEditHistory && !userPlayer"
                        :style="{position: 'absolute'}"
                        @click.stop="editTitle"
                        @mouseover="() => hoverTitle = true"
                        @mouseleave="() => hoverTitle = false"
                        tooltip="Editar título"
                    />
                </h3>
                <TextInput
                    v-if="editMode && !userPlayer"
                    ref="nameInput"
                    v-model="history.title"
                    type="text"
                    class="mt-1 block input__name"
                    placeholder="Título da história"
                    @keyup.enter="saveEdition"
                    @keyup.esc="exitEdition"
                    autofocus
                    @focusout="exitEdition"
                    @click.stop
                />
                <p>{{ firstChapter }}</p>
            </div>
            <span v-if="userPlayer">
                <b>Mestre:</b>{{history.master.name}}
            </span>
        </div>
        <EditButton
            class="edit--history"
            v-if="showEditHistory && !userPlayer"
            :style="{position: 'absolute'}"
            @click.stop="enterHistory"
            @mouseover="() => hoverHistory = true"
            @mouseleave="() => hoverHistory = false"
            tooltip="Editar história"
        />
    </div>

    <Modal :show="showModal && userPlayer" @close="closeModal">
        <div class="p-6">
            <div class="mt-6 c-new__player">
                <div>
                    <TextInput
                        ref="nameInput"
                        v-model="storePlayer.name"
                        type="text"
                        class="mt-1 block input__name"
                        placeholder="Nome do personagem"
                    />
                </div>

                <div>
                    PONTOS INICIAIS: {{ storePlayer.pointsDistribution }}
                </div>

                <div v-for="attribute in storePlayer.attributes" :key="attribute.id" class="input__default">
                    <label class="label__default">{{ attribute.name }}:</label>

                    <input
                        class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                        :value="attribute.totalPoints"
                        ref="input"
                        :title="'Valor mínimo: 0'"
                        :min="minValue"
                        disabled
                        style="width: 6rem;"
                    />

                    <CustomButton @click="() => subPoint(attribute.totalPoints) ? attribute.totalPoints-=1 : null" class="custom-buttom">
                        <img src="../../svg/minus.svg">
                    </CustomButton>
                    <CustomButton @click="() => sumPoint() ? attribute.totalPoints+=1 : null" class="custom-buttom">
                        <img src="../../svg/plus.svg">
                    </CustomButton>
                </div>
            </div>

            <div class="mt-6 flex justify-end">
                <SecondaryButton @click="closeModal"> FECHAR </SecondaryButton>

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
import { sumBy } from 'lodash';
import { Link } from '@inertiajs/vue3';
import { useForm } from '@inertiajs/vue3';
import EditButton from '@/Atoms/EditButton.vue';
import TextInput from '@/Components/TextInput.vue';
import Modal from '@/Components/Modal.vue';
import IntInput from '@/Atoms/IntInput.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import CustomButton from '@/Atoms/CustomButton.vue';
import Points from '@/Molecules/Points.vue';

export default {
    name: 'Card',

    props: ['history'],

    components: {
        Link,
        EditButton,
        TextInput,
        Modal,
        IntInput,
        PrimaryButton,
        SecondaryButton,
        CustomButton,
        Points
    },

    data() {
        return {
            showEditHistory: false,
            showEditTitle: false,
            hoverTitle: false,
            hoverHistory: false,
            defaultTitle: null,
            editMode: false,
            showModal: false,
            minValue: 0,
            limitPointsDistribution: null
        }
    },

    created() {
        this.defaultTitle = this.history.title
        if (this.userPlayer) {
            this.limitPointsDistribution = this.storePlayer.pointsDistribution
        }
    },

    computed: {
        firstChapter: function() {
            if (this.history.first_chapter) {
                return this.history.first_chapter.text
            }

            return 'Este mundo ainda está em construção...'
        },

        userPlayer: function() {
            return this.history.hasOwnProperty('master')
        },

        storePlayer: function() {
            return this.history.player
        },

        routeEnterGame: function() {
            if (this.userPlayer) {
                return route('game.mobile.get') + '/' + this.history.player.id
            }

            return route('game.desktop.get') + '/' + this.history.id
        }
    },

    methods: {
        editTitle: function() {
            this.editMode = true
        },

        exitEdition: function() {
            this.editMode = false
            this.history.title = this.defaultTitle
            this.hoverTitle = this.hoverHistory = false
        },

        saveEdition: function() {
            axios.post(route('history.edit.title'), {
                history_id: this.history.id,
                title: this.history.title,
            })
            .then((response) => {
                this.history.title = this.defaultTitle = response.data
            })
            .catch((error) => {
                console.error(error)
                this.history.title = this.defaultTitle
            })
            .finally(() => {
                this.editMode = false
                this.hoverTitle = this.hoverHistory = false
            })
        },

        enterHistory: function() {
            const form = useForm({});

            form.get(route('history.get') + '/' + this.history.id, {
                // onSuccess: () => closeModal(),
                onError: (error) => console.error(error),
                onFinish: () => form.reset(),
            });
        },

        clickGame: function() {;
            if (this.userPlayer) {
                this.firstTimePlayer()
            } else {
                this.enterGame()
            }
        },

        firstTimePlayer: function() {
            console.log(this.storePlayer)
            if (this.storePlayer.firstAccess) {
                this.openModal()
            } else {
                this.enterGame()
            }
        },

        enterGame: function() {
            const form = useForm({});

            form.get(this.routeEnterGame, {
                // onSuccess: () => closeModal(),
                onError: (error) => console.error(error),
                onFinish: () => form.reset(),
            });
        },

        openModal: function() {
            this.showModal = true
        },

        closeModal: function() {
            this.showModal = false
        },

        sumPoint: function() {
            if (this.storePlayer.pointsDistribution > 0) {
                this.storePlayer.pointsDistribution -= 1
                return true
            }

            return false
        },

        subPoint: function(totalPoints) {
            if (this.limitPointsDistribution >= this.sumAttributes() && totalPoints > 0) {
                this.storePlayer.pointsDistribution += 1
                return true
            }

            return false
        },

        sumAttributes: function() {
            return sumBy(this.storePlayer.attributes, function(attribute) {
                return attribute.totalPoints
            })
        },

        updatePlayer: function() {
            axios.post(route('player.update'), {player: this.storePlayer})
            .then(() => {
                this.enterGame()
            })
            .catch((error) => {
                console.error(error)
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
    position: relative;
    min-height: 2rem;
    display: flex;
    justify-content: center;
    align-items: center;
}

.card {
    width: 100%;
    min-width: 15rem;
    max-width: 22rem;
    height: 16rem;
    overflow: hidden;
    cursor: pointer;
    position: relative;
}

.c-text {
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    gap: 0.5rem;
    height: 100%;
}

.text {
    display: flex;
    flex-direction: column;
    justify-content: space-around;
    gap: 1rem;
}

p {
    display: -webkit-box;
    -webkit-line-clamp: 7;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

span {
    display: flex;
    justify-content: flex-end;
    gap: 0.2rem;
}

.edit--title {
    z-index: 99;
    left: calc(100% - 0.5rem);
    top: 0;
    bottom: 0;
}

.edit--history {
    z-index: 99;
    right: 0;
    bottom: 0;
}

.element--hover {
    background-color: #8080803b;
    color: #fff;
    border-radius: 8px;
}







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
