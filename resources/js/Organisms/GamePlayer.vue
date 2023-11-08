<template>
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
            <CustomButton
                class="custom-button"
            >
                DEFESA
            </CustomButton>
            <CustomButton
                class="custom-button"
                @click="inventory()"
            >
                INVENTÁRIO
            </CustomButton>
            <CustomButton
                class="custom-button"
            >
                AÇÕES
            </CustomButton>
        </div>
</template>

<script>
import AttributeBar from '@/Atoms/AttributeBar.vue';
import NavLink from '@/Components/NavLink.vue';
import CustomButton from '@/Atoms/CustomButton.vue';

export default {
    name: 'GameMaster',

    emits: ['inventory'],

    components: {
        AttributeBar,
        NavLink,
        CustomButton,
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

        inventory: function() {
            this.$emit('inventory')
        }
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
    gap: 0.3rem;

    position: absolute;
    bottom: 3.5rem;
    right: 0;
    margin-right: 1.5rem;
}

.custom-button {
    flex-grow: 2;
}
</style>
