<template>
    <button :title="tooltip">
        <img src="../../svg/close.svg" />
    </button>
</template>


<script>
export default {
    name: 'RemoveButton',

    props: ['tooltip'],
}
</script>

<style scoped>
button {
    background: rgb(209, 0, 0);
    border-radius: 8px;
    width: 3rem;
    height: 2rem;
    display: flex;
    justify-content: center;
    align-items: center;
}

button:hover {
    background: rgb(145, 0, 0);
}
</style>
