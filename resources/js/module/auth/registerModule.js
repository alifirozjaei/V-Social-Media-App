import { ref, reactive } from "@vue/composition-api";

import { required, verifyEmail, moreThan, lessThan } from "../../rule/index";

import router from "../../router/router";
import store from "../../store";

export function registerModule(root) {
 // state
 const registerForm = ref(null);

 const loading = ref(false);

 const form = ref({
  email: null,
  password: null,
 });

 const errors = ref({
  email: null,
  password: null,
 });

 const emailRules = ref([
  required("ایمیل الزامی است !"),
  verifyEmail(),
  lessThan(255, "ایمیل"),
 ]);

 const passwordRules = ref([
  required("رمز عبور الزامی است !"),
  moreThan(8, "رمز عبور"),
 ]);

 // methods
 function register() {
  if (registerForm.value.validate()) {
   loading.value = true;
   store
    .dispatch("user/register", form)
    .then(() => {
     router.push({ name: "verify" });
    })
    .catch((err) => {
     errors.value.email = err.response.data.errors.email[0];
     //  errors.value.password = err.response.data.errors.password[0];
    })
    .finally(() => (loading.value = false));
  }
 }

 return {
  registerForm,
  loading,
  form,
  errors,
  emailRules,
  passwordRules,
  register,
 };
}
