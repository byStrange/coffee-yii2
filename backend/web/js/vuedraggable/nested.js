import { computed } from "vue";
import draggable from "./vuedraggable.js";
import { store } from "../store.js";

export default {
  components: { draggable },
  template: `
  <draggable class="dragArea" tag="div" :list="tasks" :group="{ name: 'g1' }" item-key="name" animation="200"
    @change="handleChange">
    <template #item="{ element }">
      <div style="padding: 20px; padding-left: 40px;" @click.stop="setActiveWidget(element)">
        <div :style="{ color: activeWidget?.id == element.id ? 'blue' : 'gray' }">
          <div>{{ element.widgetType.type }}</div>
          <template v-if="element.widgetType.type === 'component_widget'">
            <draggable class="dragArea" style="padding: 10px" tag="div" :list="[element.theholy_component]"
              :group="{ name: 'g1' }" item-key="name" animation="200">
              <template #item="{ element }">
                <div @click.stop="setActiveWidget(element)" class="padding: 20px; padding-left: 40px;">
                  <div :style="{ color: activeWidget?.id == element.id ? 'blue' : 'gray' }">
                    <p>{{ element.component.name }}</p>
                    <NestedDraggable :tasks="element.children" />
                  </div>
                </div>
              </template>
            </draggable>
          </template>
          <NestedDraggable :tasks="element.children" v-else-if="isSupportedToHaveDropZone(element.widgetType.type)" />
        </div>
      </div>
    </template>
  </draggable> 
  `,
  setup() {
    function setActiveWidget(w) {
      store.activeWidget = w;
    }

    function handleChange(event) {
      console.log(event);
    }

    function isSupportedToHaveDropZone(widgetType) {
      switch (widgetType) {
        case "input":
          return false;
        case "image":
          return false;
        case "icon":
          return false;
      }
      return true;
    }

    const activeWidget = computed(() => {
      return store.activeWidget;
    });

    return {
      setActiveWidget,
      activeWidget,
      isSupportedToHaveDropZone,
      handleChange,
    };
  },
  props: ["tasks"],
  name: "NestedDraggable",
};
