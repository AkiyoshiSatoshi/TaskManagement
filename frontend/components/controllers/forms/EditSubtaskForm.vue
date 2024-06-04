<script setup lang="ts">
import { schema } from "@/validates/subtask/updateSubTask";

const props = defineProps<{
  subtaskId: string;
}>();

const { errors, handleSubmit, isSubmitting } = useForm({
  validationSchema: schema,
});

const { value: name } = useField<string>("name");
const { value: detail } = useField<string>("detail");

const emit = defineEmits(["on-edit-subtask-form-submitted"]);

const onEditSubTaskFormSubmitted = handleSubmit(async (values) => {
  await useSubtaskApi().update(props.subtaskId, {
    name: values.name,
    detail: values.detail,
  });

  emit("on-edit-subtask-form-submitted");
});

const { data: subtask } = await useSubtaskApi().show(props.subtaskId);

if (subtask.value) {
  name.value = subtask.value.data.name;
  detail.value = subtask.value.data.detail;
}
</script>

<template>
  <form @submit.prevent="onEditSubTaskFormSubmitted">
    <div class="mb-5 w-full">
      <InputLabel class="mb-2 block" for="name" text="サブタスク名" :required="true" />
      <InputText id="name" v-model="name" class="w-full" />
    </div>
    <InputError v-if="errors.name" class="mt-1" :text="errors.name" />
    <div class="align-items-center mb-10">
      <InputLabel class="mb-2 block" for="detail" text="詳細" :required="false" />
      <Textarea id="detail" v-model="detail" rows="5" cols="30" auto-resize class="w-full" />
      <InputError v-if="errors.detail" class="mt-1" :text="errors.detail" />
    </div>
    <div>
      <Button type="submit" label="編集" class="w-full" :disabled="isSubmitting" />
    </div>
  </form>
</template>
