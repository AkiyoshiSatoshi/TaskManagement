<script setup lang="ts">
const props = defineProps<{
  for: string;
  text: string;
  required: boolean;
}>();
</script>

<template>
  <label :for="props.for">
    {{ props.text }} <span v-if="required" class="text-red-600">&#42;</span>
  </label>
</template>
