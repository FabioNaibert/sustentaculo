import { createApp } from 'vue';
import { createStore } from 'vuex';

const store = createStore({
    state: {
        history: [],
        allAttributes: [],
        currentChapter: null,
        editMode: false,
        gameMobile: [],
    },

    getters: { // this.$store.getters.doneTodosCount
        editMode (state) {
            return state.editMode
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

        chapter (state) {
            return state.history.chapter
        },

        sounds (state) {
            return state.history.sounds
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
