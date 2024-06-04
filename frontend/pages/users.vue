<script setup lang="ts">
definePageMeta({
  middleware: "client-auth",
});

const selectedUserId = ref("");
const showCreateUserModal = ref(false);
const showEditUserModal = ref(false);
const showDeleteUserModal = ref(false);

const openCreateUserModal = () => {
  showCreateUserModal.value = true;
};

const onCreateUserFormSubmitted = () => {
  showCreateUserModal.value = false;
  refreshUsers();
};

const openEditUserModal = (userId: string) => {
  selectedUserId.value = userId;
  showEditUserModal.value = true;
};

const onEditUserFormSubmitted = () => {
  showEditUserModal.value = false;
  refreshUsers();
};

const openDeleteUserModal = (userId: string) => {
  selectedUserId.value = userId;
  showDeleteUserModal.value = true;
};

const onDeleteUserFormSubmitted = () => {
  showDeleteUserModal.value = false;
  refreshUsers();
};

const { data: users, refresh: refreshUsers } = await useUserApi().index();
</script>

<template>
  <div>
    <div class="mb-6">
      <PageTitle :text="'ユーザ一覧'" />
    </div>

    <div class="mb-3">
      <Button class="w-32" label="新規登録" @click="openCreateUserModal" />
    </div>

    <DataTable :value="users?.data" striped-rows paginator :rows="10">
      <Column header="ユーザ名" field="name" />
      <Column header="メールアドレス" field="email" />
      <Column header="操作">
        <template #body="slotProps">
          <Button class="p-0 text-sm text-blue-500" text label="編集" @click="openEditUserModal(slotProps.data.id)" />
          <span class="mx-1">&frasl;</span>
          <Button class="p-0 text-sm text-blue-500" text label="削除" @click="openDeleteUserModal(slotProps.data.id)" />
        </template>
      </Column>
    </DataTable>

    <Dialog v-model:visible="showCreateUserModal" class="w-[450px]" modal header="ユーザ作成">
      <CreateUserForm @on-create-user-form-submitted="onCreateUserFormSubmitted" />
    </Dialog>

    <Dialog v-model:visible="showEditUserModal" class="w-[450px]" modal header="ユーザ編集">
      <EditUserForm :user-id="selectedUserId" @on-edit-user-form-submitted="onEditUserFormSubmitted" />
    </Dialog>

    <Dialog v-model:visible="showDeleteUserModal" class="w-[450px]" modal header="ユーザ削除">
      <DeleteUserForm :user-id="selectedUserId" @on-delete-user-form-submitted="onDeleteUserFormSubmitted" />
    </Dialog>
  </div>
</template>
