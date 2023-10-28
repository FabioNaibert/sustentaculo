<template>
    <div class="c-chapter">
        <div class="title">
            <TextInput
                ref="nameInput"
                v-model="storeChapter.title"
                type="text"
                class="mt-1 block input__title"
                placeholder="Título do capítulo"
            />
        </div>

        <div class="text-history">
            <textarea
                v-model="storeChapter.text"
                placeholder="Escreva a história do seu capítulo aqui"
                class="input__text-history border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
            />
        </div>

        <div class="c-commands">
            <CustomButton >
                <img src="../../svg/arrow-left.svg" />
            </CustomButton>
            <CustomButton @click="addNewInTheMiddle" :disabled="firstChapter">
                <img src="../../svg/plus-lg.svg" />
            </CustomButton>
            <CustomButton @click="addNewAtTheEnd">
                <img src="../../svg/arrow-right.svg" />
            </CustomButton>

        </div>
    </div>
</template>

<script>
import TextInput from '@/Components/TextInput.vue';
import CustomButton from '@/Atoms/CustomButton.vue';

export default {
    name: 'Chapter',

    components: {
        TextInput,
        CustomButton
    },

    data() {
        return {
            titleChapter: '',
            textChapter: ''
        }
    },

    computed: {
        storeChapter: function() {
            return this.$store.getters.chapter
        },

        firstChapter: function() {
            return !this.storeChapter.previous_id
        }
    },

    methods: {
        addNewAtTheEnd: function() {
            const data = {
                current: {
                    id: this.storeChapter.id,
                    title: this.storeChapter.title,
                    text: this.storeChapter.text,
                },

                new_data: {
                    history_id: this.storeChapter.history_id,
                    previous_id: this.storeChapter.id,
                }
            }

            console.log(data)

            this.add(data)
        },

        addNewInTheMiddle: function() {
            const data = {
                current: {
                    id: this.storeChapter.id,
                    title: this.storeChapter.title,
                    text: this.storeChapter.text,
                },

                new_data: {
                    history_id: this.storeChapter.history_id,
                    previous_id: this.storeChapter.previous_id,
                }
            }

            console.log(data)
            this.add(data)
        },

        add: function(data) {
            axios.post(route('chapter.add'), data)
            .then((response) => {
                this.$store.commit('setHistory', response.data.history)
            })
            .catch((error) => {
                console.error(error)
            })
        },

        edit: function() {
            const data = {
                chapter_id: this.storeChapter.id,
                title: this.storeChapter.title,
                text: this.storeChapter.text,
            }

            axios.post(route('chapter.edit'), data)
            .then((response) => {
                this.$store.commit('updateChapters', this.response.chapters)
            })
            .catch((error) => {
                console.error(error)
            })
        }
    }
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

.c-commands {
    display: flex;
    justify-content: center;
    gap: 0.5rem;
    align-items: center;
    flex-wrap: nowrap;
}
</style>
