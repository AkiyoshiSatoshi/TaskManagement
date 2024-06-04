interface LoginParams {
  email: string;
  password: string;
}

export const useUserAuthApi = () => {
  return {
    login(params: LoginParams) {
      return useSanctumAuth().login(params);
    },
    logout() {
      return useSanctumAuth().logout();
    },
    me() {
      return useSanctumAuth().user;
    },
  };
};
