import { createApp } from 'vue';
import { createStore } from 'vuex';

const store = createStore({
    state: {
        history: [],
        allAttributes: [],
        currentChapter: null,
        currentChapterId: null,
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

        currentChapterId (state) {
            return state.currentChapterId //state.currentChapter
        },

        chapters (state) {
            return state.history.chapters
        }
    },

    mutations:{ // store.commit('increment')
        setHistory (state, payload) {
            state.history = payload
        },

        setCurrentChapterId (state, payload) {
            state.currentChapterId = payload
        },

        setCurrentChapter (state, payload) {
            state.history.chapters = payload
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

    actions: { // store.dispatch('defineLastChapter')
        defineLastChapter ({ commit, getters }) {
            const lastChapter = Math.max(Object.keys(getters.chapters))
            console.log(lastChapter)
            commit('setCurrentChapterId', lastChapter)
        }
    }
})

export default store
