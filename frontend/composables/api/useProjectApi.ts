import { useApi } from "@/utils/useApi";

interface StoreParams {
  name: string;
}

interface UpdateParams {
  name: string;
}

interface Response {
  id: string;
  name: string;
  users: Array<{
    id: string;
    name: string;
  }>;
}

export const useProjectApi = () => {
  return {
    index() {
      return useApi().get<{ data: Response }>("プロジェクト一覧", `/api/projects`, {}, {}, true);
    },
    store(params: StoreParams) {
      return useApi().post<{ data: Response }>("プロジェクト登録", `/api/projects`, params);
    },
    show(projectId: string) {
      return useApi().get<{ data: Response }>("プロジェクト詳細", `/api/projects/${projectId}`);
    },
    update(projectId: string, params: UpdateParams) {
      return useApi().put<{ data: Response }>("プロジェクト編集", `/api/projects/${projectId}`, params);
    },
    destroy(projectId: string) {
      return useApi().delete<void>("プロジェクト削除", `/api/projects/${projectId}`);
    },
  };
};