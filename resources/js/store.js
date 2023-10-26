import { createApp } from 'vue';
import { createStore } from 'vuex';

const store = createStore({
    state: {
        history: [],
        allAttributes: [],
        currentChapter: null
    },

    getters: { // this.$store.getters.doneTodosCount
        historyId (state) {
            return state.history.id
        },

        historyTitle (state) {
            return state.history.title
        },

        historyMasterId (state) {
            return state.history.masterId
        },

        allAttributes (state) {
            return state.allAttributes
        },

        resources (state) {
            return state.history.resources
        },

        enemies (state) {
            return state.history.enemies
        },

        players (state) {
            return state.history.players
        },

        currentChapter (state) {
            return state.history.chapters[0] //state.currentChapter
        },
    },

    mutations:{ // store.commit('increment')
        setHistory (state, payload) {
            state.history = payload
        },

        setCurrentChapter (state, payload) {
            state.currentChapter = payload
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
    },

    actions: { // store.dispatch('increment')
        increment ({ commit }) {
            commit('increment')
        }
    }
})

export default store