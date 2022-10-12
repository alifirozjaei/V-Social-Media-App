export const namespaced = true;

export const state = {
 categories: [],
};

export const mutations = {
 SET_CATEGORIES(state, data) {
  state.categories = [];
  data.categories.forEach((element) => {
   state.categories.push({
    text: element.title,
    to: {
     name: "post-category",
     params: {
      slug: element.slug,
     },
    },
   });
  });
 },
};

export const actions = {
 async getNavbarCategories({ commit, state }) {
  if (!state.categories.length) {
   let { data } = await axios.get("/api/navbar-categories");
   commit("SET_CATEGORIES", data);
  }
 },
};
