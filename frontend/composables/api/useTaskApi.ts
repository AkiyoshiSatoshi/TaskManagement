import { useApi } from "@/utils/useApi";

interface StoreParams {
  name: string;
  detail: string;
  status: number;
}

interface UpdateParams {
  name: string;
  detail: string;
  status: number;
}

interface StatusParams {
  status: number;
}

interface Response {
  id: string;
  name: string;
  status: {
    id: string;
    name: string;
  };
  detail: string;
  subtasks: Array<{
    id: string;
    name: string;
    detail: string;
  }>;
}

export const useTaskApi = () => {
  return {
    index(projectId: string) {
      return useApi().get<{ data: Response }>("タスク一覧", `/api/projects/${projectId}/tasks`, {}, {}, true);
    },
    store(projectId: string, params: StoreParams) {
      return useApi().post<{ data: Response }>("タスク登録", `/api/projects/${projectId}/tasks`, params);
    },
    show(taskId: string) {
      return useApi().get<{ data: Response }>("タスク詳細", `/api/tasks/${taskId}`);
    },
    update(taskId: string, params: UpdateParams) {
      return useApi().put<{ data: Response }>("タスク編集", `/api/tasks/${taskId}`, params);
    },
    destroy(taskId: string) {
      return useApi().delete<void>("タスク削除", `/api/tasks/${taskId}`);
    },
    status(taskId: string, params: StatusParams) {
      return useApi().put<{ data: Response }>("タスクステータス変更", `/api/tasks/${taskId}/status`, params);
    },
  };
};
