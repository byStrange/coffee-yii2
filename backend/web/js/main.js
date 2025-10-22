import * as Vue from "vue";
window.Vue = Vue;
import { createApp } from "vue";
import App from "./App.js";
import WidgetTree from "./components/WidgetTree.js";

const app = createApp(App);
app.component("WidgetTree", WidgetTree);
app.mount("#app");
