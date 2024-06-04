import { useApi } from "@/utils/useApi";

interface StoreParams {
  users: string[];
}

interface Response {
  id: string;
  name: string;
  email: string;
}

export const useProjectUserApi = () => {
  return {
    index(projectId: string) {
      return useApi().get<{ data: Response }>("プロジェクトユーザ一覧", `/api/projects/${projectId}/users`, {}, {}, true);
    },
    store(projectId: string, params: StoreParams) {
      return useApi().post<{ data: Response }>("プロジェクトユーザ登録", `/api/projects/${projectId}/users`, params);
    },
    destroy(projectId: string, userId: string) {
      return useApi().delete<void>("プロジェクトユーザ削除", `/api/projects/${projectId}/users/${userId}`);
    },
  };
};
