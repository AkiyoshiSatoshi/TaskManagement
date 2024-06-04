<script setup lang="ts">
import { schema } from "@/validates/task/updateTask";

const props = defineProps<{
  taskId: string;
}>();

const { errors, handleSubmit, isSubmitting } = useForm({
  validationSchema: schema,
});

const { value: name } = useField<string>("name");
const { value: detail } = useField<string>("detail");
const { value: status } = useField<string>("status");

const emit = defineEmits(["on-edit-task-form-submitted"]);

const onEditTaskFormSubmitted = handleSubmit(async (values) => {
  await useTaskApi().update(props.taskId, {
    name: values.name,
    detail: values.detail,
    status: values.status,
  });

  emit("on-edit-task-form-submitted");
});

const { data: task } = await useTaskApi().show(props.taskId);
if (task.value) {
  name.value = task.value.data.name;
  detail.value = task.value.data.detail;
  status.value = task.value.data.status.id;
}
</script>

<template>
  <form @submit.prevent="onEditTaskFormSubmitted">
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
      <Button class="w-full" type="submit" label="編集" :disabled="isSubmitting" />
    </div>
  </form>
</template>
