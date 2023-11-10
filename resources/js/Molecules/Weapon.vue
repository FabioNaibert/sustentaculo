<template>
    <div class="card bg-white shadow-sm sm:rounded-lg" @click="equip">
        <div class="c-text text-gray-900">
            <h3>{{ resource.name }}</h3>
            <div class="c-info">
                <div class="info__attribute">
                    <div
                        v-for="attribute in storeAttributes"
                        :key="attribute.id"
                    >
                        <div class="attribute">
                            <p>{{ attribute.name }}</p>
                            <div class="attribute__points">{{attribute.totalPoints}}</div>
                        </div>
                    </div>
                </div>
                <div class="c-image">
                    <img :src="resource.image.content">
                </div>
                <RemoveButton
                    v-show="storeEditMode && !storeIsPlayer"
                    class="position-button"
                    @click="remove"
                    :tooltip="'Remover arma'"
                />
                <div class="position-button" v-show="!storeEditMode && !storeIsPlayer">
                    <ShareWeapon :weapon="resource" />
                </div>
                <div class="position-equiped" v-show="!storeEditMode && resource.equiped" title="Equipado">
                    <img src="../../images/swords.png">
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import RemoveButton from "@/Atoms/RemoveButton.vue";
import ShareWeapon from "@/Molecules/ShareWeapon.vue";

export default {
    name: 'Weapon',

    components: {
        RemoveButton,
        ShareWeapon
    },

    props: [
        'resource',
    ],

    computed: {
        storeAttributes: function() {
            return this.resource.attributes
        },

        storeChapter: function() {
            return this.$store.getters.chapter.id
        },

        storeEditMode: function() {
            return this.$store.getters.editMode
        },

        storeIsPlayer: function() {
            return this.$store.getters.isPlayer
        },
    },

    methods: {
        remove: function() {
            axios.post(route('weapon.remove'), {
                weapon_id: this.resource.id,
                chapter_id: this.storeChapter.id,
            })
            .then((response) => {
                this.$store.commit('updateResources', response.data)
            })
            .catch((error) => {
                console.error(error)
            })
        },

        equip: function() {
            if (!this.storeIsPlayer) return

            axios.post(route('weapon.equip'), {
                weapon_id: this.resource.id
            })
            .then((response) => {
            })
            .catch((error) => {
                console.error(error)
            })
        }
    }
}
</script>

<style scoped>
h3 {
    text-align: center;
}

p {
    min-width: 4.5rem;
}

.card {
    width: 100%;
    overflow: hidden;
    position: relative;
}

.c-text {
    padding: 0.2rem 1.5rem;
}

.attribute {
    display: flex;
    align-items: center;
    flex-wrap: nowrap;
    gap: 1rem;
}

.c-info {
    display: flex;
    justify-content: space-between;
    gap: 1rem;
}

.info__attribute {
    flex-grow: 2;
}

.attribute__points {
    text-align: left;
}

.c-image {
    width: 5rem;
}

.position-button {
    position: absolute;
    bottom: 0;
    right: 0;
}

.position-equiped {
    position: absolute;
    top: 0;
    right: 0;
    width: 1.5rem;
    margin: 0.4rem;
}
</style>
