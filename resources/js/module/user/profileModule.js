import { computed, ref } from "@vue/composition-api";
import uploadBase64 from "../../module/file/uploadBase64.js";
import {
 moreThan,
 required,
 verifyEmail,
 verifyUsername,
} from "../../rule/index";
import store from "../../store";
export default function profileModule() {
 const profileForm = ref(null);
 const user = ref(null);

 const editing = ref({
  username: false,
  email: false,
 });

 const old = ref({
  email: null,
  username: null,
 });

 const errors = ref({
  username: false,
  email: false,
 });

 const loading = ref(false);

 // return url
 const url = computed(() => {
  return `http://${process.env.MIX_APP_URL}/`;
 });

 // return url + username
 const fullUsername = computed(() => {
  return `http://${process.env.MIX_APP_URL}/` + user.value.username;
 });

 //get user data from server
 const getUser = () => {
  axios.get("/api/me").then(({ data }) => {
   user.value = data;
   old.value.username = data.username;
   old.value.email = data.email;
  });
 };

 // created hook
 getUser();

 // cancel edit username and email, rollback to old data
 const cancel = (data) => {
  user.value[data] = old.value[data];
  editing.value[data] = false;
 };

 // store new email and username on user data
 const changeEdit = (data) => {
  old.value[data] = user.value[data];
  editing.value[data] = !editing.value[data];
 };

 // upload image from storage
 const uploadProfile = (event) => {
  user.value.profile_name = event.target.files[0].name;
  user.value.profile = uploadBase64(event);
  user.value.profile_src = uploadBase64(event);
 };

 //  update user profile
 const update = () => {
  if (profileForm.value.validate()) {
   loading.value = true;
   axios
    .patch("/api/profile", user.value)
    .then(({ data }) => {
     store.dispatch("user/changeName", data.name);
    })
    .catch(({ response }) => {
     for (const index in response.data.errors) {
      errors.value[index] = true;
      editing.value[index] = true;
     }
    })
    .finally(() => {
     loading.value = false;
    });
  }
 };

 return {
  user,
  editing,
  old,
  url,
  fullUsername,
  getUser,
  cancel,
  changeEdit,
  uploadProfile,
  moreThan,
  required,
  verifyEmail,
  verifyUsername,
  update,
  profileForm,
  errors,
  loading,
 };
}
