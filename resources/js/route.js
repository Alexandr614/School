import vueRoute from 'vue-router';
import Vue from 'vue';

Vue.use(vueRoute);

import ViewClass from "./components/ViewClass";
import AddClass from "./components/AddClass";
import AddChild from "./components/AddChild";
import ViewChilds from "./components/ViewChilds";

const routes = [
  {
    path: "/",
    component: ViewChilds
  },
  {
    path: "/viewclass",
    component: ViewClass
  },
  {
    path: "/addclass",
    component: AddClass
  },
  {
    path: "/addchild",
    component: AddChild
  }
];

export default new vueRoute({
  mode: "history",
  routes
})
