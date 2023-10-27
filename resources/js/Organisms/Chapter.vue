<template>
    <div class="c-chapter">
        <div class="title">
            <TextInput
                ref="nameInput"
                v-model="titleChapter"
                type="text"
                class="mt-1 block input__title"
                placeholder="Título do capítulo"
            />
        </div>

        <div class="text-history">
            <textarea
                v-model="textChapter"
                placeholder="Escreva a história do seu capítulo aqui"
                class="input__text-history border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
            />

        </div>
    </div>
</template>

<script>
import TextInput from '@/Components/TextInput.vue';

export default {
    name: 'Chapter',

    components: {
        TextInput,
    },

    data() {
        return {
            titleChapter: '',
            textChapter: ''
        }
    },

    computed: {
        storeChapters: function() {
            return this.$store.getters.chapters
        },



        storeCurrentChapter: function() {
            return this.storeChapters
        }
    },
}
</script>

<style scoped>
.c-chapter {
    width: 100%;
    display: flex;
    padding: 2rem;
    flex-direction: column;
    align-items: center;
    gap: 1rem;
}

.title, .text-history, .input__text-history {
    width: 100%;
}

.text-history, .input__text-history {
    height: 100%;
}

.input__title {
    width: 100%;
}
</style>
