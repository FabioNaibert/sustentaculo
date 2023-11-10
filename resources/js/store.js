import { createApp } from 'vue';
import { createStore } from 'vuex';
import { orderBy } from 'lodash';

const store = createStore({
    state: {
        history: [],
        allAttributes: [],
        currentChapter: null,
        editMode: false,
        gameMobile: [],
        isPlayer: false,
    },

    getters: { // this.$store.getters.doneTodosCount
        editMode (state) {
            return state.editMode
        },

        isPlayer (state) {
            return state.isPlayer
        },

        historyId (state) {
            return state.history.id
        },

        gameMobile (state) {
            return state.gameMobile
        },

        historyTitle (state) {
            return state.history.title
        },

        historyMasterId (state) {
            return state.history.masterId
        },

        allAttributes (state) {
            return orderBy(state.allAttributes, ['id'])
        },

        resources (state) {
            return orderBy(state.history.resources, ['name'])
        },

        enemies (state) {
            return orderBy(state.history.enemies, ['name'])
        },

        players (state) {
            return orderBy(state.history.players, ['name'])
        },

        chapter (state) {
            return state.history.chapter
        },

        sounds (state) {
            return orderBy(state.history.sounds, ['name'])
        }
    },

    mutations:{ // store.commit('increment')
        setEditMode (state, payload) {
            state.editMode = payload
        },

        setHistory (state, payload) {
            state.history = payload
        },

        setGameMobile (state, payload) {
            state.isPlayer = true
            state.gameMobile = payload
        },

        setAllAttributes (state, payload) {
            state.allAttributes = payload
        },

        updateResources (state, payload) {
            state.history.resources = payload
        },

        updatePlayers (state, payload) {
            state.history.players = payload
        },

        updateEnemies (state, payload) {
            state.history.enemies = payload
        },

        updateChapters (state, payload) {
            state.history.chapters = payload
        },

        updateSounds (state, payload) {
            state.history.sounds = payload
        },
    },

    actions: { // store.dispatch('defineLastChapter')
        // defineLastChapter ({ commit, getters }) {
        //     commit('setCurrentChapterId', getters.chapter.id)
        // }
    }
})

export default store
