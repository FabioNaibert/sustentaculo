<template>
    <div class="c-bar">
        <div class="points">{{ currentPoints }}/{{ totalPoints }}</div>
        <div class="current" :style="{width: calcCurrentPoints, 'background-color': color}"></div>
    </div>
</template>

<script>
export default {
    name: 'AttributeBar',

    props: [
        'totalPoints',
        'currentPoints',
        'color'
    ],

    computed: {
        calcCurrentPoints: function() {
            console.log(this.currentPoints / this.totalPoints * 100)
            return (this.currentPoints / this.totalPoints * 100) + '%';
        }
    }

}
</script>

<style scoped>
.c-bar {
    width: 100%;
    height: 1rem;
    border: 1px solid rgb(88, 88, 88);
    border-radius: 8px;
    box-sizing: border-box;
    overflow: hidden;
    position: relative;
}

.current {
    height: 2rem;
}

.points {
    position: absolute;
    font-size: 10px;
    font-weight: bold;
    left: 50%;
    transform: translateX(-50%);
    color: white;
}
</style>
