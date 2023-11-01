<template>
    <button :title="tooltip">
        <img src="../../svg/edit.svg" />
    </button>
</template>


<script>
export default {
    name: 'EditButton',

    props: ['tooltip'],
}
</script>

<style scoped>
button {
    display: flex;
    justify-content: center;
    align-items: center;
    width: 2rem;
    height: 2rem;

    padding: 0.5rem;
    border-radius: 8px;
    background-color: rgb(135 41 255 / 45%);
}

button:hover {
    background: rgb(135 41 255 / 75%);
}
</style>
