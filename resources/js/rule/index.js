export function required(text) {
 return (value) => !!value || text;
}

export function verifyEmail() {
 return (value) =>
  /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(value) ||
  "ایمیل معتبر وارد کنید !";
}

export function verifyUsername() {
 return (value) =>
  /^[a-z0-9_-]{3,15}$/.test(value) || "نام کاربری معتبر نیست";
}

export function lessThan(length, field, nullable = false) {
 return (value) => {
  if (nullable && !value) {
   return true;
  }
  return (
   (value ? value.length <= length : false) ||
   "طول " + field + " باید کمتر از" + length + " کاراکتر باشد"
  );
 };
}

export function moreThan(length, field, nullable = false) {
 return (value) => {
  if (nullable && !value) {
   return true;
  }
  return (
   (value ? value.length >= length : false) ||
   "طول " + field + " باید بیشتر از" + length + " کاراکتر باشد"
  );
 };
}
