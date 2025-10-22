import nested from "../vuedraggable/nested.js";
import { store } from "../store.js";
import AvailableWidgets from "./AvailableWidgets.js";

export default {
  template: `
    <div style="height: 100vh; width: 0; overflow-x: hidden; overflow-y: auto; background-color: #ccc; transition: 200ms;" :style="{ width: store.leftSidebar.open ? '400px' : '0' }">
        <NestedDraggable :tasks="widgets" /> 
    </div> 
  `,
  components: {
    NestedDraggable: nested,
    AvailableWidgets,
  },
  data() {
    return {
      store,
    };
  },
  props: ["widgets"],
};
