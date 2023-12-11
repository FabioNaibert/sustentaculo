<template>
    <button :title="tooltip">
        <slot></slot>
    </button>
</template>


<script>
export default {
    name: 'CustomButton',

    props: ['tooltip'],
}
</script>

<style scoped>
button {
    display: flex;
    justify-content: center;
    align-items: center;

    padding: 0.5rem;
    border-radius: 8px;
    background-color: rgb(184 132 249);
}

button:hover {
    background: rgb(127, 64, 209)
}

button:disabled {
    background-color: darkgrey;
}
</style>
