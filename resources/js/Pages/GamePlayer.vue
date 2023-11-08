<template>
    <LayoutMobile :player_id="this.response.player.id">
        <div class="c-info">
            <h3><b>{{ storeGameMobile.player.name }}</b></h3>

            <div class="info__attribute">
                <div
                    v-for="attribute in storePlayer.attributes"
                    :key="attribute.id"
                >
                    <div class="attribute">
                        <p>{{ attribute.name }}</p>
                        <AttributeBar v-if="showAttributeBar(attribute.currentPoints)"
                            :totalPoints="attribute.totalPoints"
                            :currentPoints="attribute.currentPoints"
                            :color="attribute.representationColor"
                        />
                        <div v-else class="attribute__points">{{attribute.totalPoints}}</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="c-options">
            <NavLink
                class="option__action"
                :href="route('game.mobile.get')"
                :class="{'bg-gray-100': route().current('game.mobile.get')}"
            >
                <CustomButton class="custom-button">
                    DEFESA
                </CustomButton>
            </NavLink>
            <NavLink
                class="menu__option"
                :href="route('history.get') + '/9'"
                :class="{'bg-gray-100': route().current('history.get')}"
            >
                <CustomButton class="custom-button">
                    INVENTÁRIO
                </CustomButton>
            </NavLink>
            <NavLink
                class="menu__option"
                :href="route('history.get') + '/9'"
            >
                <CustomButton class="custom-button">
                    AÇÕES
                </CustomButton>
            </NavLink>
        </div>

    </LayoutMobile>
</template>

<script>
import LayoutMobile from '@/Layouts/LayoutMobile.vue';
import AttributeBar from '@/Atoms/AttributeBar.vue';
import NavLink from '@/Components/NavLink.vue';
import CustomButton from '@/Atoms/CustomButton.vue';

export default {
    name: 'GameMaster',

    props: ['response'],

    components: {
        LayoutMobile,
        AttributeBar,
        NavLink,
        CustomButton
    },

    created() {
        console.log(this.response)
        this.$store.commit('setGameMobile', this.response)
    },

    data() {
        return {
            addTooltip: 'Criar nova história',
            defaultPoints: 5,
            teste: null
        }
    },

    computed: {
        storeGameMobile: function() {
            return this.$store.getters.gameMobile
        },

        storePlayer: function() {
            return this.storeGameMobile.player
        },
    },

    methods: {
        showAttributeBar: function(current) {
            return current !== null && current !== undefined
        },
    }
}
</script>

<style scoped>
.attribute {
    display: flex;
    align-items: center;
    flex-wrap: nowrap;
    gap: 1rem;
}

.info__attribute {
    flex-grow: 2;
}

p {
    min-width: 4.5rem;
}

.attribute__points {
    text-align: left;
}

.c-info {
    display: flex;
    justify-content: space-between;
    gap: 1rem;
    flex-direction: column;
    position: absolute;
    bottom: 3.5rem;
    margin-left: 1.5rem;
    width: 45%;
}

.c-options {
    display: flex;
    flex-direction: column;
    align-items: stretch;

    position: absolute;
    bottom: 3.5rem;
    right: 0;
    margin-right: 1.5rem;
}

.custom-button {
    flex-grow: 2;
}
</style>
