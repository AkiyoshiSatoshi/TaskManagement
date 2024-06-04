import * as yup from "yup";

export const schema = yup.object({
  name: yup.string().required("必ず指定してください").max(255, "255文字以下で指定してください"),
});
