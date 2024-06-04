<script setup lang="ts">
import { schema } from "@/validates/users/updateUser";

const { errors, handleSubmit, isSubmitting } = useForm({
  validationSchema: schema,
});

const { value: name } = useField<string>("name");

const showForgotPasswordModal = ref(false);

const openForgotPasswordModal = () => {
  showForgotPasswordModal.value = true;
};

const onForgotPasswordFormSubmitted = () => {
  showForgotPasswordModal.value = false;
  refreshAccount();
};

const updateUser = handleSubmit(async (values) => {
  await useAccountApi().updateMyAccount({
    name: values.name,
  });
  await reloadNuxtApp();
});

const { data: user, refresh: refreshAccount, pending: pendingAccount } = await useAccountApi().fetchMyAccount();
console.log(user.value);
console.log(pendingAccount.value);
name.value = user.value ? user.value.data.name : "";
</script>

<template>
  <div v-if="!pendingAccount" class="w-[400px]">
    <div class="mb-6">
      <PageTitle text="ユーザ設定" />
    </div>

    <form>
      <div class="mb-10 w-full">
        <InputLabel class="mb-2 block" for="name" text="ユーザ名" :required="true" />
        <InputText id="name" v-model="name" class="w-full" toggle-mask :feedback="false" />
        <InputErrors v-if="errors.name" class="mt-1" :text="errors.name" />
      </div>
      <div class="flex w-full justify-between">
        <Button label="パスワードリセット" class="border-orange-300 bg-white font-bold text-orange-300" @click="openForgotPasswordModal" />
        <Button label="保存" class="w-20" type="submit" :disabled="isSubmitting" @click="updateUser" />
      </div>
    </form>

    <Dialog v-model:visible="showForgotPasswordModal" class="w-[450px]" modal header="パスワードリセット">
      <ForgotPasswordForm @on-forgot-password-form-submitted="onForgotPasswordFormSubmitted" />
    </Dialog>
  </div>
</template>
