<template>
    <div class="card bg-white shadow-sm sm:rounded-lg">
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
                    class="remove-button"
                    @click="removeResource"
                    :tooltip="'Remover arma'"
                />
            </div>
        </div>
        <!-- <AccordionButton @click="showAllAttributes()" :rotate="showAll" :identifier="player.id"/> -->
    </div>
    <!-- <div v-if="resource">
        <div>{{resource.weapon}}</div>
        <img :src="resource.content">
        <img src="../../../storage/images/6/1698024992.png">
    </div> -->
</template>

<script>
import RemoveButton from "@/Atoms/RemoveButton.vue";

export default {
    name: 'Resource',

    components: {
        RemoveButton,
    },

    props: [
        'resource',
        'history_id'
    ],

    computed: {
        storeAttributes: function() {
            return this.resource.attributes
        }
    },

    methods: {
        removeResource: function() {
            axios.post(route('weapon.remove'), {
                weapon_id: this.resource.id,
                history_id: this.history_id
            })
            .then((response) => {
                this.$emit('upResource', response.data)
            })
        },
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

.remove-button {
    position: absolute;
    bottom: 0;
    right: 0;
}
</style>
