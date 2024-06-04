<script setup lang="ts">
import { schema } from '@/validates/auth/login';

const { errors, handleSubmit, isSubmitting } = useForm({
  validationSchema: schema,
});

const { value: email } = useField<string>("email");
const { value: password } = useField<string>("password");

const onLoginFormSubmitted = handleSubmit(async (values) => {
  await useUserAuthApi().login({
    email: values.email,
    password: values.password,
  });
  await navigateTo("/projects");
});
</script>

<template>
  <form @submit.prevent="onLoginFormSubmitted">
    <div class="mb-5 w-full">
      <InputLabel for="email" class="mb-2 block" text="メールアドレス" :required="true" />
      <InputText id="email" v-model="email" class="w-full" />
      <InputError v-if="errors.email" class="mt-1" :text="errors.email" />
    </div>
    <div class="mb-10 w-full">
      <InputLabel
        class="mb-2 block"
        for="password"
        text="パスワード"
        :required="true"
      />
      <Password
        v-model="password"
        input-id="password"
        class="w-full"
        input-class="w-full"
        toggle-mask
        :feedback="false"
      />
      <InputError v-if="errors.password" class="mt-1" :text="errors.password" />
    </div>
    <div class="w-full">
      <Button
        class="w-full border-0 bg-client"
        type="submit"
        label="ログイン"
        :disabled="isSubmitting"
      />
    </div>
  </form>
</template>
