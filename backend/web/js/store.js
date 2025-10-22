import { reactive } from "vue";

export const store = reactive({
  activeWidget: null,
  widgetPanel: {
    open: true,
    toggle() {
      store.widgetPanel.open = !store.widgetPanel.open;
    },
  },
  textSource: null,
  widgetTree: [],
  leftSidebar: {
    open: true,
    toggle() {
      store.leftSidebar.open = !store.leftSidebar.open;
    },
  },
});
