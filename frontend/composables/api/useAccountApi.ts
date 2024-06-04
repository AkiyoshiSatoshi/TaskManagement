import { useApi } from "@/utils/useApi";

interface UpdateParams {
  name: string;
}

interface Response {
  id: string;
  name: string;
}

export const useAccountApi = () => {
  return {
    fetchMyAccount() {
      return useApi().get<{ data: Response }>("アカウント情報詳細", "/api/my/account");
    },
    updateMyAccount(params: UpdateParams) {
      return useApi().put<{ data: Response }>("アカウント情報編集", "/api/my/account", params);
    },
  };
};
