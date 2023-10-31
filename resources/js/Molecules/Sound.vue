<template>
    <div class="c-sound">
        <span>{{ sound.name }}</span>
        <div class="sound-panel">
            <audio controls>
                <source :src="sound.content" type="audio/mpeg">
                Seu navegador não suporta elementos de áudio
            </audio>
        </div>
        <RemoveButton
            class="remove-button"
            @click="removePlayer"
            :tooltip="tooltip"
        />
    </div>
</template>

<script>
import RemoveButton from '@/Atoms/RemoveButton.vue'
export default {
    name: 'Sound',

    props: ['sound'],

    components: {
        RemoveButton,
    },

    data() {
        return {
            tooltip: 'Remover áudio',
        }
    },

    computed: {
        storeChapterId: function() {
            return this.$store.getters.chapter.id
        }
    },

    methods: {
        removePlayer: function() {
            axios.post(route('sound.remove'), {
                sound_id: this.sound.id,
                chapter_id: this.storeChapterId
            })
            .then((response) => {
                this.$store.commit('updateSounds', response.data)
            })
        }
    }
}
</script>

<style scoped>
.c-sound {
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    background-color: #fff;
    border-radius: 8px;
    padding: 0.5rem 0.5rem 0;
    position: relative;
}

.sound-panel {
    width: 100%;
    display: flex;
    justify-content: center;
}

audio {
    background-color: #fff;
}

audio::-webkit-media-controls-panel {
    background-color: #fff;
}

span {
    white-space: nowrap;
    text-overflow: ellipsis;
    overflow: hidden;
    width: calc(100% - 3rem);
}

.remove-button {
    position: absolute;
    top: 0;
    right: 0;
}
</style>
