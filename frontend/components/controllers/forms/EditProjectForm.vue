<script setup lang="ts">
import { schema } from "@/validates/project/updateProject";

const props = defineProps<{
  projectId: string;
}>();

const { errors, handleSubmit, isSubmitting } = useForm({
  validationSchema: schema,
});

const { value: name } = useField<string>("name");

const emit = defineEmits(["on-edit-project-form-submitted"]);

const onEditProjectFormSubmitted = handleSubmit(async (values) => {
  await useProjectApi().update(props.projectId, {
    name: values.name,
  });

  emit("on-edit-project-form-submitted");
});

const { data: project } = await useProjectApi().show(props.projectId);

if (project.value) {
  name.value = project.value.data.name;
}
</script>

<template>
  <form @submit.prevent="onEditProjectFormSubmitted">
    <div class="mb-10 w-full">
      <InputLabel class="mb-2 block" for="name" text="プロジェクト名" :required="true" />
      <InputText id="name" v-model="name" class="w-full" />
      <InputError v-if="errors.name" class="mt-1" :text="errors.name" />
    </div>
    <div class="w-full">
      <Button class="w-full" type="submit" label="編集" :disabled="isSubmitting" />
    </div>
  </form>
</template>
