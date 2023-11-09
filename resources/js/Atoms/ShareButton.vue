<template>
    <button>
        <img src="../../svg/menu-ellipsis.svg">
    </button>
</template>


<script>
export default {
    name: 'ShareButton',
}
</script>

<style scoped>
button {
    border-radius: 50%;
    width: 2rem;
    height: 2rem;
    display: flex;
    justify-content: center;
    align-items: center;
}

button:hover {
    background: linear-gradient(187deg, rgba(1,212,175,1) 33%, rgba(168,255,240,1) 100%);
}
</style>
