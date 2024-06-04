<script setup lang="ts">
import { schema } from "@/validates/users/updateUser";

const props = defineProps<{
  userId: string;
}>();

const { errors, handleSubmit, isSubmitting } = useForm({
  validationSchema: schema,
});

const { value: name } = useField<string>("name");

const emit = defineEmits(["on-edit-user-form-submitted"]);

const onEditUserFormSubmitted = handleSubmit(async (value) => {
  await useUserApi().update(props.userId, {
    name: value.name,
  });

  emit("on-edit-user-form-submitted");
});

const { data: user } = await useUserApi().show(props.userId);
if (user.value) {
  name.value = user.value.data.name;
}
</script>

<template>
  <form @submit.prevent="onEditUserFormSubmitted">
    <div class="mb-10 w-full">
      <InputLabel class="mb-2 block" for="name" text="ユーザ名" :required="true" />
      <InputText id="name" v-model="name" class="w-full" />
      <InputError v-if="errors.name" class="mt-1" :text="errors.name" />
    </div>
    <div class="w-full">
      <Button type="submit" label="編集" class="w-full" :disabled="isSubmitting" />
    </div>
  </form>
</template>
