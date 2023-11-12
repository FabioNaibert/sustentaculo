<template>
    <button>
        <img src="../../svg/shield.svg">
    </button>
</template>


<script>
export default {
    name: 'CombatButton',
}
</script>

<style scoped>
button {
    border-radius: 34px;
    display: flex;
    justify-content: center;
    align-items: center;
    width: 34px;
    height: 20px;
}

button:hover {
    background: linear-gradient(187deg, rgba(1,212,175,1) 33%, rgba(168,255,240,1) 100%);
}
</style>
