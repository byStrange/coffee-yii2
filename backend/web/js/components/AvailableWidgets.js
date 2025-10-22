import { onMounted, computed, ref } from "vue";
import draggable from "../vuedraggable/vuedraggable.js";
import { store } from "../store.js";

export default {
  components: {
    draggable,
  },
  name: "AvailableWidgets",
  template: `
   <div :class="[
      'bg-white shadow-lg transition-all duration-300 ease-in-out',
      isOpen ? 'translate-x-0' : '-translate-x-full',
      isCompact ? 'w-16' : 'w-56'
    ]">
      <div class="p-4">
        <div class="flex justify-between items-center mb-4">
          <h2 v-if="!isCompact" class="text-lg font-semibold text-gray-800">Widget Picker</h2>
          <button @click="toggleCompact" class="text-gray-500 hover:text-gray-700 focus:outline-none">
            <i :class="['fas', isCompact ? 'fa-expand-alt' : 'fa-compress-alt']">hi</i>
          </button>
        </div>
        
        <draggable :list="schemas" v-if="schemas" :clone="handleClone" item-key="id" :group="{ name: 'g1', pull: 'clone', put: false }" class="space-y-1" animation="200">    
          <template #item="{ element }">
            <div class="relative">
              <button href="#" class="flex items-center p-2 hover:bg-gray-50 rounded-md transition duration-150 ease-in-out">
                  <i :class="['bx bxs-balloon']"></i>
                  <span v-if="!isCompact" class="text-sm text-gray-700">{{ element.widgetType.type }}</span>
              </button>
              <div v-if="isCompact" class="popover">{{ element.widgetType.type }}</div>
            </div> 
          </template>
        </draggable>
      </div>
    </div>
  `,
  setup() {
    function handleClone(item) {
      const i = JSON.parse(JSON.stringify(item));
      i.id = Math.random();
      return i;
    }
    const schemas = computed(() => {
      return store.schemas;
    });

    const isOpen = ref(true);
    const isCompact = ref(false);

    const toggleSidebar = () => {
      isOpen.value = !isOpen.value;
    };

    const toggleCompact = () => {
      isCompact.value = !isCompact.value;
    };

    onMounted(() => {
      fetch("http://localhost:2121/site/schemas/")
        .then((res) => res.json())
        .then((resData) => {
          store.schemas = resData.map((widget) => {
            if (widget.widgetType.type === "input") {
              widget.input.value = "";
            }
            return widget;
          });
          console.log(resData);
        });
    });

    return {
      schemas,
      isOpen,
      isCompact,
      toggleSidebar,
      toggleCompact,
      handleClone,
    };
  },
};
