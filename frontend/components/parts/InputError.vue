<script setup lang="ts">
const props = defineProps<{
  text: string;
}>();
</script>

<template>
  <p class="text-red-600">{{ props.text }}</p>
</template>
