<script setup lang="ts">
definePageMeta({
  middleware: "client-auth",
});

const selectedProjectId = ref("");
const showCreateProjectModal = ref(false);
const showEditProjectModal = ref(false);
const showDeleteProjectModal = ref(false);

const openCreateProjectModal = () => {
  showCreateProjectModal.value = true;
};

const openEditProjectModal = (projectId: string) => {
  selectedProjectId.value = projectId;
  showEditProjectModal.value = true;
};

const openDeleteProjectModal = (projectId: string) => {
  selectedProjectId.value = projectId;
  showDeleteProjectModal.value = true;
};

const onCreateProjectFormSubmitted = () => {
  showCreateProjectModal.value = false;
  refreshProjects();
};

const onEditProjectFormSubmitted = () => {
  showEditProjectModal.value = false;
  refreshProjects();
};

const onDeleteProjectFormSubmitted = () => {
  showDeleteProjectModal.value = false;
  refreshProjects();
};

const getMemberNames = (users: any[]) => {
  return users.map((user) => user.name).join(", ");
};

const { data: projects, refresh: refreshProjects, pending: pendingProjects } = await useProjectApi().index();
</script>

<template>
  <div v-if="!pendingProjects">
    <PageTitle class="mb-6" :text="'プロジェクト一覧'" />
    <Button class="mb-3 w-32" label="新規登録" @click="openCreateProjectModal" />
    <DataTable :value="projects?.data" striped-rows paginator :rows="10">
      <Column header="プロジェクト名">
        <template #body="slotProps">
          <NuxtLink class="cursor-pointer text-sm text-blue-500" :to="`/projects/${slotProps.data.id}`">
            {{ slotProps.data.name }}
          </NuxtLink>
        </template>
      </Column>
      <Column class="text-sm" header="メンバー">
        <template #body="slotProps">
          {{ getMemberNames(slotProps.data.users) }}
        </template>
      </Column>
      <Column class="text-sm" header="操作">
        <template #body="slotProps">
          <Button class="p-0 text-sm text-blue-500" text label="編集" @click="openEditProjectModal(slotProps.data.id)" />
          <span class="mx-1">&frasl;</span>
          <Button class="p-0 text-sm text-blue-500" text label="削除" @click="openDeleteProjectModal(slotProps.data.id)" />
        </template>
      </Column>

      <Dialog v-model:visible="showCreateProjectModal" class="w-[450px]" modal header="プロジェクト作成">
        <CreateProjectForm @on-create-project-form-submitted="onCreateProjectFormSubmitted" />
      </Dialog>

      <Dialog v-model:visible="showEditProjectModal" class="w-[450px]" modal header="プロジェクト編集">
        <EditProjectForm :project-id="selectedProjectId" @on-edit-project-form-submitted="onEditProjectFormSubmitted" />
      </Dialog>

      <Dialog v-model:visible="showDeleteProjectModal" class="w-[450px]" modal header="プロジェクト削除">
        <DeleteProjectForm :project-id="selectedProjectId" @on-delete-project-form-submitted="onDeleteProjectFormSubmitted" />
      </Dialog>
    </DataTable>
  </div>
</template>
