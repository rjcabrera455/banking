<script setup>
const props = defineProps({
    error: {
        required: true
    }
});
</script>

<template>
    <div class="p-error mt-1" v-if="error">{{ props.error }}</div>
</template>
