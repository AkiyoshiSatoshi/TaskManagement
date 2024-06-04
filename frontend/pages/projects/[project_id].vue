<script setup lang="ts">
definePageMeta({
  middleware: "client-auth",
});

const projectId = useRoute().params.project_id as string;

const selectedTabIndex = ref(0);
const tabItems = ref([{ label: "タスク一覧" }, { label: "ユーザー覧" }]);

const keyword = ref("");

const selectedTaskStatus = ref("未完了");
const taskStatuses = ref(["未完了", "完了済"]);

const selectedTaskId = ref("");
const selectedSubtaskId = ref("");

// const selectedTask = ref({});
// const expandedRows = ref({});

const showCreateTaskModal = ref(false);
const showEditTaskModal = ref(false);
const showDeleteTaskModal = ref(false);
const showEditSubtaskModal = ref(false);
const showDeleteSubtaskModal = ref(false);
const showInviteUserFormModal = ref(false);

const openCreateTaskModal = () => {
  showCreateTaskModal.value = true;
};

const openEditTaskModal = (taskId: string) => {
  selectedTaskId.value = taskId;
  showEditTaskModal.value = true;
};

const openDeleteTaskModal = (taskId: string) => {
  selectedTaskId.value = taskId;
  showDeleteTaskModal.value = true;
};

const openEditSubtaskModal = (subtaskId: string) => {
  selectedSubtaskId.value = subtaskId;
  showEditSubtaskModal.value = true;
};

const openDeleteSubtaskModal = (subtaskId: string) => {
  selectedSubtaskId.value = subtaskId;
  showDeleteSubtaskModal.value = true;
};

const openInviteUserModal = () => {
  showInviteUserFormModal.value = true;
};

const onCreateTaskFormSubmitted = () => {
  showCreateTaskModal.value = false;
  refreshTasks();
};

const onEditTaskFormSubmitted = () => {
  showEditTaskModal.value = false;
  refreshTasks();
};

const onDeleteTaskFormSubmitted = () => {
  showDeleteTaskModal.value = false;
  refreshTasks();
};

const onEditSubtaskFormSubmitted = () => {
  showEditSubtaskModal.value = false;
  refreshTasks();
};

const onDeleteSubtaskFormSubmitted = () => {
  showDeleteSubtaskModal.value = false;
  refreshTasks();
};

const onInviteUserFormSubmitted = () => {
  showInviteUserFormModal.value = false;
  refreshTasks();
  refreshProjectUsers();
};

const onCreateSubtaskButtonClicked = async (taskId: string) => {
  await useSubtaskApi().store(taskId);
  await refreshProjectUsers();
  await refreshTasks();
};

const switchTaskStatus = async (taskId: string, status: number) => {
  await useTaskApi().status(taskId, { status });
  await refreshProjectUsers();
  await refreshTasks();
};

const onRemoveUserButtonClicked = (userId: string) => {
  useProjectUserApi().destroy(projectId, userId);
  refreshTasks();
  refreshProjectUsers();
};

const { data: project } = await useProjectApi().show(projectId);

const { data: tasks, refresh: refreshTasks, pending: pendingTasks } = await useTaskApi().index(projectId);

const { data: projectUsers, refresh: refreshProjectUsers, pending: pendingProjectUsers } = await useProjectUserApi().index(projectId);
</script>

<template>
  <div>
    <div class="mb-6">
      <PageTitle :text="`プロジェクト詳細 - ${project?.data.name}`" />
    </div>

    <div class="mb-6">
      <TabMenu v-model:activeIndex="selectedTabIndex" :model="tabItems" />
    </div>

    <div v-if="!pendingTasks">
      <template v-if="selectedTabIndex === 0">
        <div class="mb-3 flex justify-start">
          <Button class="w-32" label="新規追加" @click="openCreateTaskModal" />
          <InputGroup class="ml-auto w-96">
            <InputText v-model="keyword" placeholder="タスク検索" />
            <Button label="検索" class="border-blue-500 bg-blue-500" />
          </InputGroup>
          <SelectButton v-model="selectedTaskStatus" class="ml-5" :options="taskStatuses" aria-labelledby="basic" />
        </div>

        <DataTable
          v-model:expandedRows="expandedRows"
          v-model:selection="selectedTask"
          :value="tasks?.data"
          striped-rows
          paginator
          :rows="10"
          scrollable
          scroll-height="500px"
        >
          <Column expander />
          <Column class="text-sm" field="status" header="タスク状態" headerStyle="width: 7rem">
            <template #body="slotProps">
              <Checkbox
                v-model="slotProps.data.status.done"
                class="mr-1"
                :input-id="`taskStatus${slotProps.data.id}`"
                :binary="true"
                @click="switchTaskStatus(slotProps.data.id, slotProps.data.status.id)"
              />
            </template>
          </Column>
          <Column class="text-sm" field="name" header="タスク名" />
          <Column class="text-sm" field="status" header="ステータス" headerStyle="width: 10rem">
            <template #body="slotProps">
              <span>{{ slotProps.data.status.name }}</span>
            </template>
          </Column>
          <Column class="text-sm" field="detail" header="詳細" />
          <Column class="text-sm" header="操作">
            <template #body="slotProps">
              <Button class="p-0 text-sm text-blue-500" label="サブタスク登録" text @click="onCreateSubtaskButtonClicked(slotProps.data.id)" />
              <span class="mx-1">&frasl;</span>
              <Button class="p-0 text-sm text-blue-500" label="編集" text @click="openEditTaskModal(slotProps.data.id)" />
              <span class="mx-1">&frasl;</span>
              <Button class="p-0 text-sm text-blue-500" label="削除" text @click="openDeleteTaskModal(slotProps.data.id)" />
            </template>
          </Column>
          <template #expansion="slotProps">
            <DataTable :value="slotProps.data.subtasks" striped-rows scrollable scroll-height="300px">
              <Column class="text-sm" field="name" header="サブタスク名" />
              <Column class="text-sm" field="detail" header="詳細" />
              <Column class="text-sm" header="操作">
                <template #body="slotProps">
                  <Button class="p-0 text-sm text-blue-500" label="サブタスク編集" text @click="openEditSubtaskModal(slotProps.data.id)" />
                  <span class="mx-1">&frasl;</span>
                  <Button class="p-0 text-sm text-blue-500" label="サブタスク削除" text @click="openDeleteSubtaskModal(slotProps.data.id)" />
                </template>
              </Column>
            </DataTable>
          </template>
        </DataTable>

        <Dialog v-model:visible="showCreateTaskModal" class="w-[450px]" modal header="タスク作成">
          <CreateTaskForm :project-id="projectId" @on-create-task-form-submitted="onCreateTaskFormSubmitted" />
        </Dialog>

        <Dialog v-model:visible="showEditTaskModal" class="w-[450px]" modal header="タスク編集">
          <EditTaskForm :task-id="selectedTaskId" @on-edit-task-form-submitted="onEditTaskFormSubmitted" />
        </Dialog>

        <Dialog v-model:visible="showDeleteTaskModal" class="w-[450px]" modal header="タスク削除">
          <DeleteTaskForm :task-id="selectedTaskId" @on-delete-task-form-submitted="onDeleteTaskFormSubmitted" />
        </Dialog>

        <Dialog v-model:visible="showEditSubtaskModal" modal header="サブタスク編集" class="w-[450px]">
          <EditSubtaskForm :subtask-id="selectedSubtaskId" @on-edit-subtask-form-submitted="onEditSubtaskFormSubmitted" />
        </Dialog>

        <Dialog v-model:visible="showDeleteSubtaskModal" modal header="サブタスク削除" class="w-[450px]">
          <DeleteSubtaskForm :subtask-id="selectedSubtaskId" @on-delete-subtask-form-submitted="onDeleteSubtaskFormSubmitted" />
        </Dialog>
      </template>
    </div>

    <div v-if="!pendingProjectUsers">
      <template v-if="selectedTabIndex === 1">
        <div class="mb-3">
          <Button class="w-32" label="ユーザ招待" @click="openInviteUserModal" />
        </div>

        <DataTable :value="projectUsers?.data" striped-rows paginator :rows="10" scrollable scroll-height="600px">
          <Column class="text-sm" field="name" header="ユーザ" />
          <Column class="text-sm" field="email" header="メールアドレス" />
          <Column class="text-sm" header="操作">
            <template #body="slotProps">
              <Button class="p-0 text-sm text-blue-500" label="削除" text @click="onRemoveUserButtonClicked(slotProps.data.id)" />
            </template>
          </Column>
        </DataTable>
      </template>
      <Dialog v-model:visible="showInviteUserFormModal" modal header="ユーザ招待" class="w-[450px]">
        <InviteUserForm :project-id="projectId" @on-invite-user-form-submitted="onInviteUserFormSubmitted" />
      </Dialog>
    </div>
  </div>
</template>
