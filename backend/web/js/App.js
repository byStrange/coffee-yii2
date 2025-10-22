import { ref, onMounted } from "vue";
import { MagicRender } from "./utils.js";
import WidgetPanel from "./components/WidgetPanel.js";
import WidgetTree from "./components/WidgetTree.js";
import LeftSidebar from "./components/LeftSidebar.js";
import TextSourceModal from "./components/TextSourceModal.js";
import AvailableWidgets from "./components/AvailableWidgets.js";
import { store } from "./store.js";

export default {
  components: {
    WidgetTree,
    WidgetPanel,
    TextSourceModal,
    LeftSidebar,
    AvailableWidgets,
  },
  template: `
    <Teleport to="body">
      <TextSourceModal />
    </Teleport>
    <div class="flex">
      <AvailableWidgets />
      <LeftSidebar :widgets="widgets" />
      <div style="transition: 200ms;" :style="{ paddingLeft: store.leftSidebar.open ? '24px': 0}">
        <WidgetTree :widgets="widgets" />
      </div>
    </div>
        <WidgetPanel />
  `,
  setup() {
    const widgets = ref();

    const list = ref([
      {
        name: "task 1",
        tasks: [
          {
            name: "task 2",
            tasks: [],
          },
        ],
      },
      {
        name: "task 3",
        tasks: [
          {
            name: "task 4",
            tasks: [],
          },
        ],
      },
      {
        name: "task 5",
        tasks: [],
      },
    ]);

    onMounted(() => {
      window.addEventListener("keydown", (event) => {
        if (event.ctrlKey && event.key == "/") {
          if (event.altKey) {
            store.widgetPanel.open = !store.widgetPanel.open;
          }
          store.leftSidebar.toggle();
        }
      });
    });

    function fetchData() {
      fetch("/site/serve")
        .then((response) => {
          return response.json();
        })
        .then((res) => {
          const widgetTree = MagicRender.buildWidgetTree(res);
          widgets.value = widgetTree.value;
          store.widgetTree = widgets.value;
        })
        .catch((err) => {
          console.error("ERROR", err);
        });
    }

    fetchData();

    return {
      widgets,
      store,
      list,
    };
  },
};
