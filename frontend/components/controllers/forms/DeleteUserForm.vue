<script setup lang="ts">
const props = defineProps<{
  userId: string;
}>();

const emit = defineEmits(["on-delete-user-form-submitted"]);

const onDeleteUserFormSubmitted = async () => {
  await useUserApi().destroy(props.userId);

  emit("on-delete-user-form-submitted");
};
</script>

<template>
  <form @submit.prevent="onDeleteUserFormSubmitted">
    <p>削除後の復元はできません。</p>
    <p>操作を続行する場合は、削除ボタンを押してください。</p>
    <Button type="submit" label="削除" class="mt-5 w-full border-0 bg-red-600" />
  </form>
</template>
