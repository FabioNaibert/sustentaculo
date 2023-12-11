<template>
    <Head :title="storeHistory.title" />

    <AuthenticatedLayout>
        <div class="c-mobile__content">
            <div class="mobile__content">
                <component
                    :is="componentImport"
                    @inventory="setComponent(gameBackpackComponent)"
                ></component>
            </div>

            <div class="mobile__menu">
                <MobileMenuButton
                    class="menu__option"
                    @click="setComponent(gamePlayerComponent)"
                    :active="gamePlayerComponent == componentImport"
                >
                    <img src="../../svg/info.svg">
                </MobileMenuButton>
                <MobileMenuButton
                    class="menu__option"
                    @click="setComponent(gameResourcesComponent)"
                    :active="gameResourcesComponent == componentImport"
                >
                    <img src="../../svg/paper.svg">
                </MobileMenuButton>
                <MobileMenuButton
                    class="menu__option"
                    @click="setComponent(gameTeamComponent)"
                    :active="gameTeamComponent == componentImport"
                >
                    <img src="../../svg/team.svg">
                </MobileMenuButton>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { shallowRef } from 'vue';
import GamePlayer from '@/Organisms/GamePlayer.vue';
import GameResources from '@/Organisms/GameResources.vue';
import MobileMenuButton from '@/Atoms/MobileMenuButton.vue';
import GameTeam from '@/Organisms/GameTeam.vue'
import GameBackpack from '@/Organisms/GameBackPack.vue'

export default {
    name: 'LayoutMobile',

    props: ['response'],

    components: {
        AuthenticatedLayout,
        Head,
        GamePlayer,
        GameResources,
        GameTeam,
        GameBackpack,
        MobileMenuButton,
    },

    data() {
        return {
            componentImport: shallowRef(GamePlayer),
            gamePlayerComponent: shallowRef(GamePlayer),
            gameResourcesComponent: shallowRef(GameResources),
            gameTeamComponent: shallowRef(GameTeam),
            gameBackpackComponent: shallowRef(GameBackpack),
        }
    },

    created() {
        this.$store.commit('setGameMobile', this.response)

        window.Pusher.channel('update-game-player.' + this.storeGameMobile.player.id)
            .listen('UpdatePlayerEvent', (e) => {
                this.$store.commit('setGameMobile', e.response)
            });
    },

    computed: {
        storeGameMobile: function() {
            return this.$store.getters.gameMobile
        },

        storeHistory: function() {
            return this.storeGameMobile.history
        },
    },

    methods: {
        setComponent: function(upComponent) {
            this.componentImport = upComponent
        }
    }
}
</script>

<style scoped>
.c-mobile__content {
    position: relative;
    width: 100%;
    height: calc(100vh - 8rem);
    max-height: calc(100vh - 8rem);
    display: flex;
}

.mobile__content {
    width: 100%;
    padding: 0.2rem 0;
}

.mobile__menu {
    position: fixed;
    bottom: 0;
    height: 4rem;
    width: 100%;
    background-color: rgb(193 193 193);

    display: flex;
    justify-content: space-between;
}

.menu__option {
    width: 100%;
}

img {
    margin: auto;
    width: 2rem;
}
</style>
