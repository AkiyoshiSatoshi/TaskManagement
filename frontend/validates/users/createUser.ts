import * as yup from "yup";

export const schema = yup.object({
  name: yup.string().required("必ず指定してください").max(255, "255文字以下で指定してください"),
  email: yup
    .string()
    .required("必ず指定してください")
    .max(255, "255文字以下で指定してください")
    .matches(/^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/, "正しい形式を指定してください"),
  password: yup
    .string()
    .required("必ず指定してください")
    .min(10, "10文字以上で指定してください")
    .max(255, "255文字以下で指定してください")
    .matches(/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[.!#$%&'*+/=?^_`{|}~-])[A-Za-z\d.!#$%&'*+/=?^_`{|}~-]+$/, "正しい形式を指定してください"),
});
