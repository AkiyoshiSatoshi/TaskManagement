<script setup lang="ts">
const props = defineProps<{
  text: string;
}>();
</script>

<template>
  <h2 class="text-2xl font-bold">{{ props.text }}</h2>
</template>
