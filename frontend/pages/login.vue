<script setup lang="ts">
definePageMeta({
  layout: false,
});

const forgotPassword = () => {
  navigateTo("/password/forgot");
};
</script>

<template>
  <div class="flex h-screen w-screen items-center justify-center">
    <div class="w-[450px]">
      <div class="mb-10 flex justify-center">
        <img class="w-64" src="@/assets/img/logo.svg" alt="logo" />
      </div>
      <LoginForm />
      <div class="mt-5 flex justify-center">
        <a class="text-yellow-950" @click="forgotPassword">パスワードをお忘れの方</a>
      </div>
    </div>
  </div>
</template>
