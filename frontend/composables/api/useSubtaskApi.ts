import { useApi } from "@/utils/useApi";

interface UpdateParams {
  name: string;
  detail: string;
}

interface Response {
  id: string;
  name: string;
  detail: string;
}

export const useSubtaskApi = () => {
  return {
    store(taskId: string) {
      return useApi().post<{ data: Response }>("サブタスク登録", `/api/tasks/${taskId}/subtasks`);
    },
    show(subtaskId: string) {
      return useApi().get<{ data: Response }>("サブタスク詳細", `/api/subtasks/${subtaskId}`);
    },
    update(subtaskId: string, params: UpdateParams) {
      return useApi().put<{ data: Response }>("サブタスク編集", `/api/subtasks/${subtaskId}`, params);
    },
    destroy(subtaskId: string) {
      return useApi().delete<void>("サブタスク削除", `/api/subtasks/${subtaskId}`);
    },
  };
};
