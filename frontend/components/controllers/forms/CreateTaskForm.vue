<script setup lang="ts">
import { schema } from "@/validates/task/createTask";

const { errors, handleSubmit, isSubmitting } = useForm({
  validationSchema: schema,
});

const props = defineProps<{
  projectId: string;
}>();

const { value: name } = useField<string>("name");
const { value: detail } = useField<string>("detail");

const emit = defineEmits(["on-create-task-form-submitted"]);

const onCreateTaskFormSubmitted = handleSubmit(async (values) => {
  await useTaskApi().store(props.projectId, {
    name: values.name,
    detail: values.detail,
    status: 1,
  });

  emit("on-create-task-form-submitted");
});
</script>

<template>
  <form @submit.prevent="onCreateTaskFormSubmitted">
    <div class="mb-5 w-full">
      <InputLabel class="mb-2 block" for="name" text="タスク名" :required="true" />
      <InputText id="name" v-model="name" class="w-full" />
      <InputError v-if="errors.name" class="mt-1" :text="errors.name" />
    </div>
    <div class="mb-10 w-full">
      <InputLabel class="mb-2 block" for="detail" text="詳細" :required="false" />
      <Textarea id="detail" v-model="detail" rows="5" cols="30" auto-resize class="w-full" />
      <InputError v-if="errors.detail" class="mt-1" :text="errors.detail" />
    </div>
    <div class="w-full">
      <Button type="submit" label="追加" class="w-full" :disabled="isSubmitting" />
    </div>
  </form>
</template>
