<template>
    <div @click="enterHistory" class="card bg-white shadow-sm sm:rounded-lg">
        <div class="c-text p-6 text-gray-900">
            <h3>{{ history.title }}</h3>
            <p>{{ firstChapter }}</p>
        </div>
    </div>
</template>

<script>
import { Link } from '@inertiajs/vue3';
import { useForm } from '@inertiajs/vue3';

export default {
    name: 'Card',

    props: ['history'],

    components: {
        Link,
    },

    computed: {
        firstChapter: function() {
            if (this.history.first_chapter) {
                return this.history.first_chapter.text
            }

            return 'Este mundo ainda está em construção...'
        }
    },

    methods: {
        enterHistory: function() {
            const form = useForm({});

            form.get(route('history.get') + '/' + this.history.id, /* { id: this.history.id }, */ {
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
}

.card {
    width: 100%;
    min-width: 15rem;
    max-width: 22rem;
    height: 16rem;
    overflow: hidden;
    cursor: pointer;
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

</style>
