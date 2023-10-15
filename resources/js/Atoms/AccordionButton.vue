<template>
    <button :title="tooltip">
        <img :id="`arrow-down--${identifier}`" src="../../svg/arrow-down.svg" />
    </button>
</template>


<script>
export default {
    name: 'AccordionButton',

    props: [
        'tooltip',
        'rotate',
        'identifier'
    ],

    watch: {
        rotate: function (rotateArrow) {
            const arrow = document.getElementById(`arrow-down--${this.identifier}`)

            if (rotateArrow) return arrow.style.transform = "rotate(180deg)";

            return arrow.style.transform = "rotate(0deg)";
        }
    }
}
</script>

<style scoped>
button {
    width: 100%;
    height: 2rem;
    display: flex;
    justify-content: center;
    align-items: center;
}

button:hover {
    background: rgb(55 65 81 / 0.5);
}
</style>
