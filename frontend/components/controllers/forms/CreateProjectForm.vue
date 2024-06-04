<script setup lang="ts">
import { schema } from "@/validates/project/createProject";

const { errors, handleSubmit, isSubmitting } = useForm({
  validationSchema: schema,
});

const { value: name } = useField<string>("name");

const emit = defineEmits(["on-create-project-form-submitted"]);

const onCreateProjectFormSubmitted = handleSubmit(async (values) => {
  await useProjectApi().store({
    name: values.name,
  });

  emit("on-create-project-form-submitted");
});
</script>

<template>
  <form @submit.prevent="onCreateProjectFormSubmitted">
    <div class="mb-10 w-full">
      <InputLabel class="mb-2 block" for="name" text="プロジェクト名" :required="true" />
      <InputText id="name" v-model="name" class="w-full" />
      <InputError v-if="errors.name" class="mt-1" :text="errors.name" />
    </div>
    <div class="w-full">
      <Button class="w-full bg-black" type="submit" label="作成" :disabled="isSubmitting" />
    </div>
  </form>
</template>
