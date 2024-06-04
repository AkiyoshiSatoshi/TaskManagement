const nuxtApp = useNuxtApp();
const getToast = () => nuxtApp.vueApp.config.globalProperties.$toast;
const toast = {
  add(msg: any) {
    getToast().add(msg);
  },
};

type HttpMethod = "GET" | "POST" | "PUT" | "DELETE";
type QueryString = {
  [key: string]: string | number | boolean | string[] | number[] | boolean[] | null;
};
type Headers = { [key: string]: string };
type RequestBody = { [key: string]: any } | FormData;
type errorData = {
  title: string;
  detail: string;
};

export const useApi = () => {
  return Api;
};

class Api {
  public static get<T>(key: string, path: string, params: QueryString = {}, headers: Headers = {}, lazy = false) {
    const query = Object.entries(params)
      .map(([k, v]) => {
        if (v instanceof Array) {
          return v.map((e) => `${k}=${encodeURIComponent(e)}`);
        } else {
          return `${k}=${encodeURIComponent(v ?? "")}`;
        }
      })
      .flat()
      .join("&");

    const pathWithQuery = query.length > 0 ? `${path}?${query}` : path;

    return Api.fetch<T>(key, "GET", pathWithQuery, null, headers, lazy);
  }

  public static post<T>(key: string, path: string, params: RequestBody = {}, headers: Headers = {}) {
    const body = params instanceof FormData ? params : JSON.stringify(params);

    return Api.fetch<T>(key, "POST", path, body, headers);
  }

  public static put<T>(key: string, path: string, params: RequestBody = {}, headers: Headers = {}) {
    const body = params instanceof FormData ? params : JSON.stringify(params);

    return Api.fetch<T>(key, "PUT", path, body, headers);
  }

  public static delete<T>(key: string, path: string, params: RequestBody = {}, headers: Headers = {}) {
    const body = params instanceof FormData ? params : JSON.stringify(params);

    return Api.fetch<T>(key, "DELETE", path, body, headers);
  }

  private static async fetch<T>(key: string, method: HttpMethod, path: string, body: any, headers: Headers = {}, lazy = false) {
    const xsrfToken = useCookie("XSRF-TOKEN").value;

    const response = await useAsyncData<T>(
      crypto.randomUUID(),
      () =>
        $fetch(`${useSanctumConfig().baseUrl}${path}`, {
          method,
          body,
          headers: {
            ...headers,
            "X-XSRF-TOKEN": xsrfToken as string,
          },
          credentials: "include",
        }),
      {
        lazy,
      },
    );

    const error = response.error.value;

    if (method === "POST" || method === "PUT" || method === "DELETE") {
      if (error) {
        const data = error.data as errorData;
        toast.add({ severity: "error", summary: "エラー", detail: data.detail, life: 3000 });
      } else {
        toast.add({ severity: "success", summary: "成功", detail: `${key}に成功しました`, life: 3000 });
      }
    }

    return response;
  }
}
