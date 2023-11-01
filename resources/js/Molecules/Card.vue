<template>
    <div
        @mouseover="() => showEditHistory = true"
        @mouseleave="() => showEditHistory = false"
        class="card bg-white shadow-sm sm:rounded-lg"
        :class="{'element--hover': hoverHistory}"
    >
        <div class="c-text p-6 text-gray-900">
            <h3 :class="{'element--hover': hoverTitle}" v-if="!editMode">
                {{ history.title }}
                <EditButton
                    class="edit--title"
                    v-if="showEditHistory"
                    :style="{position: 'absolute'}"
                    @click.stop="editTitle"
                    @mouseover="() => hoverTitle = true"
                    @mouseleave="() => hoverTitle = false"
                    tooltip="Editar título"
                />
            </h3>
            <TextInput
                v-if="editMode"
                ref="nameInput"
                v-model="history.title"
                type="text"
                class="mt-1 block input__name"
                placeholder="Nome do inimigo"
                @keyup.enter="saveEdition"
                @keyup.esc="exitEdition"
                autofocus
                @focusout="exitEdition"
            />
            <p>{{ firstChapter }}</p>
        </div>
        <EditButton
            class="edit--history"
            v-if="showEditHistory"
            :style="{position: 'absolute'}"
            @click.stop="enterHistory"
            @mouseover="() => hoverHistory = true"
            @mouseleave="() => hoverHistory = false"
            tooltip="Editar história"
        />
    </div>
</template>

<script>
import { Link } from '@inertiajs/vue3';
import { useForm } from '@inertiajs/vue3';
import EditButton from '@/Atoms/EditButton.vue';
import TextInput from '@/Components/TextInput.vue';

export default {
    name: 'Card',

    props: ['history'],

    components: {
        Link,
        EditButton,
        TextInput,
    },

    data() {
        return {
            showEditHistory: false,
            showEditTitle: false,
            hoverTitle: false,
            hoverHistory: false,
            defaultTitle: null,
            editMode: false,
        }
    },

    created() {
        this.defaultTitle = this.history.title
    },

    computed: {
        firstChapter: function() {
            if (this.history.first_chapter) {
                return this.history.first_chapter.text
            }

            return 'Este mundo ainda está em construção...'
        },
    },

    methods: {
        editTitle: function() {
            this.editMode = true
        },

        exitEdition: function() {
            this.editMode = false
            this.history.title = this.defaultTitle
            this.hoverTitle = this.hoverHistory = false
        },

        saveEdition: function() {
            axios.post(route('history.edit.title'), {
                history_id: this.history.id,
                title: this.history.title,
            })
            .then((response) => {
                this.history.title = this.defaultTitle = response.data
            })
            .catch((error) => {
                console.error(error)
                this.history.title = this.defaultTitle
            })
            .finally(() => {
                this.editMode = false
                this.hoverTitle = this.hoverHistory = false
            })
        },

        enterHistory: function() {
            const form = useForm({});

            form.get(route('history.get') + '/' + this.history.id, {
                // onSuccess: () => closeModal(),
                onError: (error) => console.error(error),
                onFinish: () => form.reset(),
            });
        }
    }
}
</script>

<style scoped>
h3 {
    text-align: center;
    position: relative;
    min-height: 2rem;
    display: flex;
    justify-content: center;
    align-items: center;
}

.card {
    width: 100%;
    min-width: 15rem;
    max-width: 22rem;
    height: 16rem;
    overflow: hidden;
    cursor: pointer;
    position: relative;
}

.c-text {
    display: flex;
    flex-direction: column;
    justify-content: space-around;
    gap: 1rem;
}

p {
    display: -webkit-box;
    -webkit-line-clamp: 7;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.edit--title {
    z-index: 99;
    left: calc(100% - 0.5rem);
    top: 0;
    bottom: 0;
}

.edit--history {
    z-index: 99;
    right: 0;
    bottom: 0;
}

.element--hover {
    background-color: #8080803b;
    color: #fff;
    border-radius: 8px;
}

</style>
