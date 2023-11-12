<template>
    <label class="switch" :title="tooltip">
        <input type="checkbox" @change="changeTooltip()" v-model="check">
        <span class="slider round"></span>
    </label>
</template>

<script>
export default {
    name: 'Toggle',

    props: ['player'],

    data() {
        return {
            check: false,
            tooltip: 'Fora de combate'
        }
    },

    mounted() {
        this.check = this.player.active
    },

    methods: {
        changeTooltip: function() {
            this.tooltip = this.check ? 'Em combate' : 'Fora de combate'

            this.toggleCombatActivity()
        },

        toggleCombatActivity: function() {
            const data = {
                player_id: this.player.id,
                active: this.check
            }

            axios.post(route('player.block'), data)
            .then((response) => {})
            .catch((error) => {
                console.error(error)
            })
        }
    }
}
</script>

<style scoped>
.switch {
    position: relative;
    display: inline-block;
    width: 34px;
    height: 20px;
}

.switch input {
    opacity: 0;
    width: 0;
    height: 0;
}

.slider {
    position: absolute;
    cursor: pointer;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: #ccc;
    -webkit-transition: .4s;
    transition: .4s;
}

.slider:before {
    position: absolute;
    content: url('../../svg/fire.svg');;
    height: 12px;
    width: 12px;
    left: 4px;
    -webkit-transition: .4s;
    transition: .4s;
}

input:checked + .slider {
    background-color: rgb(180, 0, 0);
}

input:focus + .slider {
    box-shadow: 0 0 1px rgb(180, 0, 0);
}

input:checked + .slider:before {
    -webkit-transform: translateX(12px);
    -ms-transform: translateX(12px);
    transform: translateX(12px);
}

.slider.round {
    border-radius: 34px;
}

.slider.round:before {
    border-radius: 50%;
}
</style>
