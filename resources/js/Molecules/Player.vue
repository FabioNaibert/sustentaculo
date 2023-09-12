<template>
    <div class="card bg-white shadow-sm sm:rounded-lg">
        <div class="c-text p-6 text-gray-900">
            <h3><!-- {{ history.title }} -->ALCINO_69</h3>
            <div>VIDA</div>
            <div>MANA</div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'Player',

    data() {
        return {
            attributes: {
                VIDA: 12,
                MANA:10,
                ATAQUE: 3,
                DEFESA: 4
            }
        }
    }

}
</script>

<style scoped>
h3 {
    text-align: center;
}
</style>
