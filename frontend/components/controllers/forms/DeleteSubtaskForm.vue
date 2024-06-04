<script setup lang="ts">
const props = defineProps<{
  subtaskId: string;
}>();

const emit = defineEmits(["on-delete-subtask-form-submitted"]);

const onDeleteSubTaskFormSubmitted = async () => {
  await useSubtaskApi().destroy(props.subtaskId);

  emit("on-delete-subtask-form-submitted");
};
</script>

<template>
  <form @submit.prevent="onDeleteSubTaskFormSubmitted">
    <p>削除後の復元はできません。</p>
    <p>操作を続行する場合は、削除ボタンを押してください。</p>
    <Button class="mt-5 w-full border-0 bg-red-600" type="submit" label="削除" />
  </form>
</template>
