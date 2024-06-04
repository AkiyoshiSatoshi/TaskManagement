<script setup lang="ts">
import { schema } from "~/validates/users/createUser";

const { errors, handleSubmit, isSubmitting } = useForm({
  validationSchema: schema,
});

const { value: name } = useField<string>("name");
const { value: email } = useField<string>("email");
const { value: password } = useField<string>("password");

const emit = defineEmits(["on-create-user-form-submitted"]);

const onCreateUserFormSubmitted = handleSubmit(async (values) => {
  await useUserApi().store({
    name: values.name,
    email: values.email,
    password: values.password,
  });

  emit("on-create-user-form-submitted");
});

onMounted(() => {
  password.value = usePasswordGenerator();
});
</script>

<template>
  <form @submit.prevent="onCreateUserFormSubmitted">
    <div class="mb-5 w-full">
      <InputLabel class="mb-2 block" for="name" text="ユーザ名" :required="true" />
      <InputText id="name" v-model="name" class="w-full" />
      <InputError v-if="errors.name" class="mt-1" :text="errors.name" />
    </div>
    <div class="mb-5 w-full">
      <InputLabel class="mb-2 block" for="email" text="メールアドレス" :required="true" />
      <InputText id="email" v-model="email" class="w-full" />
      <InputError v-if="errors.email" class="mt-1" :text="errors.email" />
    </div>
    <div class="mb-10 w-full">
      <InputLabel class="mb-2 block" for="password" text="パスワード" :required="true" />
      <InputText id="password" v-model="password" class="w-full" />
      <InputError v-if="errors.password" class="mt-1" :text="errors.password" />
    </div>
    <div class="w-full">
      <Button type="submit" label="作成" class="w-full" :disabled="isSubmitting" />
    </div>
  </form>
</template>
