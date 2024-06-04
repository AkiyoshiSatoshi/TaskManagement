import { useApi } from "@/utils/useApi";

interface StoreParams {
  name: string;
  email: string;
  password: string;
}

interface UpdateParams {
  name: string;
}

interface Response {
  id: string;
  name: string;
  email: string;
  role: number;
}

export const useUserApi = () => {
  return {
    index() {
      return useApi().get<{ data: Response }>("ユーザ一覧", `/api/users`, {}, {}, true);
    },
    store(params: StoreParams) {
      return useApi().post<{ data: Response }>("ユーザ登録", `/api/users`, params);
    },
    show(userId: string) {
      return useApi().get<{ data: Response }>("ユーザ詳細", `/api/users/${userId}`);
    },
    update(userId: string, params: UpdateParams) {
      return useApi().put<{ data: Response }>("ユーザ編集", `/api/users/${userId}`, params);
    },
    destroy(userId: string) {
      return useApi().delete<void>("ユーザ削除", `/api/users/${userId}`);
    },
  };
};
