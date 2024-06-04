<script setup lang="ts">
const props = defineProps<{
  projectId: string;
}>();

const emit = defineEmits(["on-delete-project-form-submitted"]);

const onDeleteProjectFormSubmitted = async () => {
  await useProjectApi().destroy(props.projectId);

  emit("on-delete-project-form-submitted");
};
</script>

<template>
  <form @submit.prevent="onDeleteProjectFormSubmitted">
    <p>削除後の復元はできません。</p>
    <p>操作を続行する場合は、削除ボタンを押して下さい。</p>
    <Button class="mt-5 w-full border-0 bg-red-600" type="submit" label="削除" />
  </form>
</template>