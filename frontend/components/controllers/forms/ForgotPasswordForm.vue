<script setup lang="ts">
const emit = defineEmits(["on-forgot-password-form-submitted"]);

const onForgotPasswordFormSubmitted = async () => {
  // await useUserAuthApi().sendPasswordResetEmail();

  emit("on-forgot-password-form-submitted");
};
</script>

<template>
  <form @submit.prevent="onForgotPasswordFormSubmitted">
    <p class="text-sm">登録されているメールアドレス宛にリセット用URLを送付します。</p>
    <p class="text-sm">操作を続行する場合は、リセットボタンを押してください。</p>
    <Button class="mt-5 w-full border-0 bg-orange-400" type="submit" label="リセット" />
  </form>
</template>
