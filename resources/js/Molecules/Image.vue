<template>
    <div class="card bg-white shadow-sm sm:rounded-lg" @click="openModal">
        <div class="c-text text-gray-900">
            <div class="c-info">
                <div class="c-image">
                    <img :src="resource.content">
                </div>
                <h3>{{ resource.name }}</h3>
                <RemoveButton
                    v-show="storeEditMode && !storeIsPlayer"
                    class="position-button"
                    @click="remove"
                    :tooltip="'Excluir imagem'"
                />
                <div class="position-button" v-show="!storeEditMode && !storeIsPlayer">
                    <ShareResources :image="resource" />
                </div>
            </div>
        </div>
    </div>

    <Modal :show="showModal" @close="closeModal">
        <div class="p-6">
            <img :src="resource.content" class="modal-img">

            <div class="mt-6 flex justify-end">
                <SecondaryButton @click="closeModal"> FECHAR </SecondaryButton>
            </div>
        </div>
    </Modal>
</template>

<script>
import RemoveButton from "@/Atoms/RemoveButton.vue";
import ShareResources from '@/Molecules/ShareResources.vue';
import Modal from '@/Components/Modal.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';

export default {
    name: 'Image',

    components: {
        RemoveButton,
        ShareResources,
        Modal,
        SecondaryButton
    },

    props: [
        'resource',
    ],

    data() {
        return {
            showModal: false,
        }
    },

    computed: {
        storeAttributes: function() {
            return this.resource.attributes
        },

        storeChapter: function() {
            return this.$store.getters.chapter
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
            axios.post(route('image.remove'), {
                image_id: this.resource.id,
                chapter_id: this.storeChapter.id,
            })
            .then((response) => {
                this.$store.commit('updateResources', response.data)
            })
        },

        openModal: function() {
            this.showModal = true
        },

        closeModal: function() {
            this.showModal = false
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

.modal-img {
    margin: auto;
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
</style>
