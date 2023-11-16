<template>
    <button class="bg-gray-800 border border-transparent tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
        <slot />
    </button>
</template>


<script>
export default {
    name: 'CircleButton',
}
</script>

<style scoped>
button {
    border-radius: 50%;
    display: flex;
    justify-content: center;
    align-items: center;
    min-width: 50px;
    width: 50px;
    height: 50px;
}
</style>
