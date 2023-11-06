<template>
    <div class="c-chapter">
        <div class="title">
            <TextInput
                ref="nameInput"
                v-model="storeChapter.title"
                type="text"
                class="mt-1 block input__title"
                placeholder="O capítulo não foi definido"
                disabled
            />
        </div>

        <div class="text-history">
            <textarea
                v-model="storeChapter.text"
                placeholder="Sua trajetória acaba por aqui..."
                class="input__text-history border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                disabled
            />
        </div>

        <div class="c-commands">
            <div class="commands">
                <CustomButton @click="previousChapter()" :disabled="firstChapter">
                    <img src="../../svg/arrow-left.svg" />
                </CustomButton>
                <CustomButton @click="nextChapter()" v-if="!storeChapter.has_multi_routes" :disabled="hasNextChapter">
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
                            @click="nextChapter(option.id)"
                        >
                            {{option.title}}
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import TextInput from '@/Components/TextInput.vue';
import CustomButton from '@/Atoms/CustomButton.vue';

export default {
    name: 'GameChapter',

    components: {
        TextInput,
        CustomButton,
    },

    data() {
        return {
            showMultiRoutes: false,
        }
    },

    computed: {
        storeChapter: function() {
            return this.$store.getters.chapter
        },

        firstChapter: function() {
            return !this.storeChapter.previous_id
        },

        hasNextChapter: function() {
            return !this.storeChapter.has_next
        },

        storeHistoryId: function() {
            return this.$store.getters.historyId
        }
    },

    methods: {
        setShowMultiRoutes: function() {
            this.showMultiRoutes = !this.showMultiRoutes
        },

        previousChapter: function() {
            axios.post(route('game.previous.get'), {
                previous_id: this.storeChapter.previous_id,
                history_id: this.storeHistoryId,
            })
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

        nextChapter: function(nextId = null) {
            axios.post(route('game.next.get'), {
                current_chapter_id: this.storeChapter.id,
                history_id: this.storeHistoryId,
                next_id: nextId
            })
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
