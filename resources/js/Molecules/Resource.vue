<template>
    <div>
        <component
            :is="componentCuston"
            v-bind="properties"
        ></component>
    </div>
</template>

<script>
import Image from '@/Molecules/Image.vue';
import Weapon from '@/Molecules/Weapon.vue';
import { shallowRef } from 'vue';

export default {
    name: 'Resource',

    components: {
        Image,
        Weapon
    },

    props: [
        'resource',
    ],

    data() {
        return {
            weponComponent: shallowRef(Weapon),
            imageComponent: shallowRef(Image),
            properties: {
                resource: this.resource,
            }
        }
    },

    computed: {
        componentCuston: function() {
            if (this.resource.hasOwnProperty('attributes')) {
                return this.weponComponent
            }

            return this.imageComponent
        }
    },
}
</script>
