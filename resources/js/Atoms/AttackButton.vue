<template>
    <button :title="tooltip" :class="activeClass" class="border-gray-300 border">
        <slot></slot>
    </button>
</template>


<script>
export default {
    name: 'AttackButton',

    props: ['tooltip', 'active'],

    computed: {
        activeClass: function() {
            return this.active ? 'button-active' : null
        }
    }
}
</script>

<style scoped>
button {
    display: flex;
    justify-content: center;
    align-items: center;

    padding: 0.5rem;
    border-radius: 8px;
    background-color: rgba(212, 177, 255, 0.45);
}

.button-active {
    background-color: rgb(135 41 255 / 75%);
}

button:hover {
    background-color: rgb(207 68 255 / 65%);
}

button:disabled {
    background-color: darkgrey;
}
</style>
