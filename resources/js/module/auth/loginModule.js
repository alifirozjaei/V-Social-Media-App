import { ref } from "@vue/composition-api";
import { required, moreThan } from "../../rule/index";
import router from "../../router/router";
import store from "../../store";
export function loginModule() {
 const loginForm = ref(null);
 const form = ref({
  email: null,
  password: null,
  remember: true,
 });

 const errors = ref({
  email: null,
  password: null,
 });

 const loading = ref(false);

 const emailRules = ref([required("ایمیل الزامی است !")]);

 const passwordRules = ref([
  required("رمز عبور الزامی است !"),
  moreThan(8, "رمز عبور"),
 ]);

 function login() {
  if (loginForm.value.validate()) {
   loading.value = true;
   store
    .dispatch("user/login", form)
    .then(() => {
     router.push({ name: "home" });
    })
    .catch((err) => {
     errors.value.email = err.response.data.errors.email[0];
    })
    .finally(() => (loading.value = false));
  }
 }

 return {
  login,
  form,
  loading,
  emailRules,
  passwordRules,
  errors,
  loginForm,
 };
}
