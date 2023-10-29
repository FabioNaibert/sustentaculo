<template>
    <div class="c-chapter">
        <div class="title">
            <TextInput
                ref="nameInput"
                v-model="storeChapter.title"
                type="text"
                class="mt-1 block input__title"
                placeholder="Título do capítulo"
            />
        </div>

        <div class="text-history">
            <textarea
                v-model="storeChapter.text"
                placeholder="Escreva a história do seu capítulo aqui"
                class="input__text-history border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
            />
        </div>

        <div class="c-commands">
            <div class="single__button single__button--left">
                <CustomButton @click="deleteChapter" :disabled="firstChapter"><img src="../../svg/trash.svg" /></CustomButton>
            </div>

            <div class="commands">
                <CustomButton @click="changeChapter(storeRoutePrevious)" :disabled="firstChapter">
                    <img src="../../svg/arrow-left.svg" />
                </CustomButton>
                <CustomButton @click="addNewInTheMiddle" :disabled="firstChapter">
                    <img src="../../svg/plus-lg.svg" />
                </CustomButton>
                <CustomButton @click="routeNextChapter()" v-if="!storeChapter.has_multi_routes" :style="{'background-color': !storeChapter.has_next ? 'rgb(23 151 158 / 75%)': null}">
                    <img src="../../svg/arrow-right.svg" />
                </CustomButton>
                <div class="possible-routes" v-else>
                    <CustomButton @click="setShowMultiRoutes()">
                        <img src="../../svg/arrow-split.svg" :style="{transform: 'rotate(90deg)'}"/>
                    </CustomButton>
                    <ul class="route__options border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" :style="{display: showMultiRoutes ? 'flex' : 'none'}">
                        <li
                            v-for="option in storeChapter.possible_routes"
                            :key="option.id"
                            @click="changeChapter(this.storeRouteNext, option.id)"
                        >
                            {{option.title}}
                        </li>
                    </ul>
                </div>
            </div>

            <div class="single__button single__button--right">
                <Link @click="endEdition" :href="route('dashboard')">
                    <CustomButton>SAIR DA EDIÇÃO</CustomButton>
                </Link>
            </div>
        </div>
    </div>
</template>

<script>
import TextInput from '@/Components/TextInput.vue';
import CustomButton from '@/Atoms/CustomButton.vue';
import { Link } from '@inertiajs/vue3';
import SelectWithoutLabel from '@/Atoms/SelectWithoutLabel.vue'

export default {
    name: 'Chapter',

    components: {
        TextInput,
        CustomButton,
        Link,
        SelectWithoutLabel
    },

    data() {
        return {
            titleChapter: '',
            textChapter: '',
            selectedComponent: null,
            showMultiRoutes: false,
            options: [
                {
                    id: '1',
                    title: 'teste1'
                },
                {
                    id: '2',
                    title: 'teste2'
                },
                {
                    id: '3',
                    title: 'teste3'
                },
                {
                    id: '4',
                    title: 'teste4'
                }
            ]
        }
    },

    computed: {
        storeChapter: function() {
            return this.$store.getters.chapter
        },

        firstChapter: function() {
            return !this.storeChapter.previous_id
        },

        storeRouteNext: function() {
            return route('chapter.next')
        },

        storeRoutePrevious: function() {
            return route('chapter.previous')
        }
    },

    methods: {
        setShowMultiRoutes: function() {
            this.showMultiRoutes = !this.showMultiRoutes
        },

        routeNextChapter: function() {
            return this.storeChapter.has_next ? this.changeChapter(this.storeRouteNext) : this.addNewAtTheEnd()
        },

        addNewAtTheEnd: function() {
            const data = {
                current: {
                    id: this.storeChapter.id,
                    title: this.storeChapter.title,
                    text: this.storeChapter.text,
                },

                new_data: {
                    history_id: this.storeChapter.history_id,
                    previous_id: this.storeChapter.id,
                }
            }

            console.log(data)

            this.add(data)
        },

        addNewInTheMiddle: function() {
            const data = {
                current: {
                    id: this.storeChapter.id,
                    title: this.storeChapter.title,
                    text: this.storeChapter.text,
                },

                new_data: {
                    history_id: this.storeChapter.history_id,
                    previous_id: this.storeChapter.previous_id,
                }
            }

            console.log(data)
            this.add(data)
        },

        add: function(data) {
            axios.post(route('chapter.add'), data)
            .then((response) => {
                this.$store.commit('setHistory', response.data.history)
            })
            .catch((error) => {
                console.error(error)
            })
        },

        edit: function() {
            const data = {
                chapter_id: this.storeChapter.id,
                title: this.storeChapter.title,
                text: this.storeChapter.text,
            }

            axios.post(route('chapter.edit'), data)
            .then((response) => {
                this.$store.commit('updateChapters', this.response.chapters)
            })
            .catch((error) => {
                console.error(error)
            })
        },

        changeChapter: function(route, nextId = null) {
            const data = {
                current: {
                    id: this.storeChapter.id,
                    title: this.storeChapter.title,
                    text: this.storeChapter.text,
                },

                next_id: nextId
            }

            axios.post(route, data)
            .then((response) => {
                this.$store.commit('setHistory', response.data.history)
            })
            .catch((error) => {
                console.error(error)
            })
            .finally(() => {
                this.showMultiRoutes = false
            })
        },

        deleteChapter: function() {
            const data = {
                id: this.storeChapter.id,
            }

            axios.post(route('chapter.remove'), data)
            .then((response) => {
                this.$store.commit('setHistory', response.data.history)
            })
            .catch((error) => {
                console.error(error)
            })
        },

        endEdition: function() {
            const data = {
                current: {
                    id: this.storeChapter.id,
                    title: this.storeChapter.title,
                    text: this.storeChapter.text,
                },
            }

            axios.post(route('chapter.edit'), data)
            .then((response) => {
                console.log('salvou')
                // this.$store.commit('setHistory', response.data.history)
            })
            .catch((error) => {
                console.error(error)
            })
            axios.get(route('dashboard'))
        }
    }
}
</script>

<style scoped>
.c-chapter {
    width: 100%;
    display: flex;
    padding: 2rem;
    flex-direction: column;
    align-items: center;
    gap: 1rem;
}

.title, .text-history, .input__text-history {
    width: 100%;
}

.text-history, .input__text-history {
    height: 100%;
}

.input__title {
    width: 100%;
}

.c-commands {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: nowrap;
    width: 100%;
}

.commands {
    display: flex;
    justify-content: center;
    gap: 0.5rem;
    align-items: center;
    flex-wrap: nowrap;
    width: 100%;
}

.single__button {
    display: flex;
    align-items: center;
    flex-wrap: nowrap;
    width: 100%;
}

.single__button--left {
    justify-content: flex-start;
}

.single__button--right {
    justify-content: flex-end;
}

.possible-routes {
    position: relative;
}

.route__options {
    position: absolute;
    left: 100%;
    bottom: 0;
    flex-direction: column;
    background-color: #fff;
    overflow: hidden;
    border: 1px solid #bdbcbc;
}

li {
    padding: 0 0.5rem;
    white-space: nowrap;
    text-overflow: ellipsis;
    max-width: 22rem;
    overflow: hidden;
    cursor: pointer;
}

li:hover {
    background: rgb(135 41 255 / 75%);
}
</style>
