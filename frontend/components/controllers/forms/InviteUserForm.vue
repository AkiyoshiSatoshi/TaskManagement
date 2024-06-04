<script setup lang="ts">
const selectedUsers = ref();

const props = defineProps<{
  projectId: string;
}>();

const { errors } = useForm({});

const emit = defineEmits(["on-invite-user-form-submitted"]);

const onInviteUserFormSubmitted = async () => {
  await useProjectUserApi().store(props.projectId, {
    users: selectedUsers.value.map((user) => user.id),
  });

  emit("on-invite-user-form-submitted");
};

const { data: users } = await useUserApi().index();
</script>

<template>
  <form @submit.prevent="onInviteUserFormSubmitted">
    <div class="mb-10 w-full">
      <InputLabel class="mb-2 block" for="user" text="ユーザ" :required="true" />
      <MultiSelect v-model="selectedUsers" :options="users?.data" option-label="name" class="w-full" />
      <InputError v-if="errors.users" class="mt-1" :text="errors.users" />
    </div>
    <div class="w-full">
      <Button class="w-full" type="submit" label="編集" />
    </div>
  </form>
</template>
