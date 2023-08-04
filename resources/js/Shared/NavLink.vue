<template>
    <Link
        class="text-blue-500 hover:underline"
        :class="{ 'font-bold underline' : active }"
    >
        <slot />
    </Link>
</template>

<script>
import {Link} from "@inertiajs/vue3";
export default {
    props : {
        active : {
            type : Boolean,
            required : true
        }
    },
    components : {Link}
}
</script>
