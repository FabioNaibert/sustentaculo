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
    background-color: rgb(135 41 255 / 45%);
}

button:hover {
    background: rgb(135 41 255 / 75%);
}

button:disabled {
    background-color: darkgrey;
}
</style>
