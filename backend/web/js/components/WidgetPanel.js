import { computed, reactive, watchEffect, watch } from "vue";
import PanelSection from "./widgetPanel/PanelSection.js";
import Property from "./widgetPanel/Property.js";
import { store } from "../store.js";
import sizeInput from "../directives/sizeInput.js";
import Select from "./widgetPanel/Select.js";

export default {
  template: `
  <Transition>
    <div v-if="activeWidget" class="sidebar" :class="{ hidden: !widgetPanel.open }" id="sidebar">

      <button class="toggle-panel" @click="widgetPanel.open = !widgetPanel.open">
        <i class='bx bx-arrow-from-right'></i>
      </button>
      <div class="scroll-content" style="height: 100%; overflow: auto;">

      <div class="w-section">
        <div class="w-section-title" :title="'my id is: ' + activeWidget.id + '. Parent id: ' + activeWidget.parent_widget_id">Widget Info</div>
        <div class="property">
          <span class="property-name">
            <button class="panel-remove-button">-</button>
            Class Name
          </span>
          <input type="text" class="property-value" placeholder="class" v-model="activeWidget.class">
        </div>
        <div class="property">
          <span class="property-name">ID</span>
          <input type="text" class="property-value" placeholder="id" v-model="activeWidget.html_id">
        </div>
        <div class="property">
          <span class="property-name">Type</span>
          <span class="property-value">{{ activeWidget.widgetType.type }}</span>
        </div>
      </div>

      <PanelSection title="layout" :options="panel.layout" v-slot="{ opts }">
        <Property v-model="activeWidget.width" v-model:open="opts.width" name="Width" type="size" />
        <Property v-model="activeWidget.height" v-model:open="opts.height" name="Height" type="size" />

        <Property v-model="activeWidget.margin" v-model:open="opts.margin" name="Margin" size-input="multiple" type="size" />
        <Property v-model="activeWidget.padding" v-model:open="opts.padding" name="Padding" size-input="multiple" type="size" /> 
      </PanelSection>

      <PanelSection title="appearance" :options="panel.appearance" v-slot="{ opts }">
        <Property v-model="activeWidget.padding" v-model:open="opts.background" name="Background" /> 
        <Property v-model="activeWidget.radius" v-model:open="opts.radius" name="Border radius" /> 
      </PanelSection>

      <template v-if="type === 'input'">
        <PanelSection title="Input" :options="panel.input" v-slot="{ opts }">
          <Property v-model="activeWidget.input.placeholderTextSource.text" name="Placeholder" v-model:open="opts.placeholder" /> 
        </PanelSection>
      </template>

      <template v-if="type === 'image'">
        <div class="w-section">
          <div class="w-section-title">Image source</div>
          <div class="property">
            <span class="property-name">Src</span>
            <input v-if="panel.image.src" type="text" v-model="activeWidget.image.src" />
            <button v-else @click="panel.image.src = true;" class="panel-add-button">+</button>
          </div>
        </div>
      </template>

      <template v-if="type === 'container'">
        <PanelSection title="Container">
          <Property name="Justify content" class="column">
            <template #property-value>
              hello    
            </template>
          </Property>
        </PanelSection>
      </template>

      <template v-if="type === 'text'">
          <PanelSection title="Text" :options="panel.text" v-slot="{ opts }">
            <Property v-model="activeWidget.text.font_family" name="Font Family" v-model:open="opts.fontFamily" />
            <Property v-model="activeWidget.text.size" name="Font Size" v-model:open="opts.fontSize" type="size" />
            <Property v-model="activeWidget.text.color" name="Color" v-model:open="opts.color" type="color" />
            <Property v-model="activeWidget.text.letter_spacing" name="Letter spacing" v-model:open="opts.letterSpacing" />
            <Property name="Align" class="column">
              <template #property-value>
                <Select :options="textAlignOptions" v-model="activeWidget.text.align" />
              </template>
            </Property>
          </PanelSection>

          <PanelSection title="Text source" :options="panel.text" v-slot="{ opts }">
            <Property v-model:open="opts.textSource" v-model="activeWidget.text.textSource.text" name="Default text" />
          </PanelSection>

          <div style="display: flex; justify-content: center; margin-top: 12px;">
            <button style="font-size: 14px; padding: 6px 12px; border-radius: 4px;"
              @click="store.textSource = activeWidget.text.textSource">Show translations</button>
          </div>
      </template>
      <PanelSection title="Visibility">
        <Property name="Hidden">
          <template #property-value>
              <label class="toggle-switch">
                <input type="checkbox"  v-model="activeWidget.hidden">
                <span class="slider"></span>
              </label> 
          </template> 
        </Property>
      </PanelSection>
    
      </div>
    </div>
  </Transition>
  `,
  directives: { sizeInput },

  setup() {
    const activeWidget = computed(() => store.activeWidget); // Assume store.activeWidget can be null
    const type = computed(() => activeWidget.value?.widgetType?.type);

    let justContentOptions = [
      {
        label: "Start",
        value: "flex-start",
        icon: "bx bxs-objects-horizontal-left",
      },
      {
        label: "Center",
        value: "center",
        icon: "bx bxs-objects-horizontal-center",
      },
      {
        label: "End",
        value: "flex-end",
        icon: "bx bxs-objects-horizontal-right",
      },
    ];

    let textAlignOptions = [
      { label: "Left", value: "left", icon: "bx bxs-objects-horizontal-left" },
      {
        label: "Center",
        value: "center",
        icon: "bx bxs-objects-horizontal-center",
      },
      {
        label: "Right",
        value: "right",
        icon: "bx bxs-objects-horizontal-right",
      },
      { label: "Justify", value: "justify", icon: "bx bx-align-justify" },
    ];

    let state = reactive({
      widgetInfo: { className: true, id: true, type: true },
      layout: {
        width: false,
        height: false,
        margin: false,
        padding: false,
      },
      appearance: {
        background: false,
        radius: false,
      },
      image: { src: false },
      text: {
        fontFamily: null,
        color: null,
        fontSize: null,
        letterSpacing: null,
        align: true,
        textSource: false,
      },
      input: {
        name: false,
        placeholder: false,
      },
      visibility: {
        hidden: true,
      },
    });

    function setPanelAttributesStates() {
      if (!activeWidget.value) return;

      if (activeWidget.value.widgetType.type === "image") {
        state.image.src = activeWidget.value.image.src ? true : false;
      }
      if (activeWidget.value.widgetType.type === "text") {
        state.text.color = activeWidget.value.text.color ? true : false;
        state.text.fontSize = activeWidget.value.text.size ? true : false;
        state.text.fontFamily = activeWidget.value.text.font_family
          ? true
          : false;
        state.text.letterSpacing = activeWidget.value.text.letter_spacing
          ? true
          : false;

        console.log(activeWidget.value);
        state.text.textSource = activeWidget.value.text.textSource.text
          ? true
          : false;
      }

      state.layout.width =
        activeWidget.value.width === "auto"
          ? false
          : Boolean(activeWidget.value.width);

      state.layout.height =
        activeWidget.value.height === "auto"
          ? false
          : Boolean(activeWidget.value.height);

      state.layout.margin = activeWidget.value.margin ? true : false;

      state.layout.padding = activeWidget.value.padding ? true : false;

      state.appearance.background = activeWidget.value.background
        ? true
        : false;

      state.appearance.radius = activeWidget.value.radius ? true : false;
    }

    watch(activeWidget, (newVal) => {
      if (newVal) setPanelAttributesStates();
    });

    const widgetPanel = computed(() => store.widgetPanel);

    return {
      activeWidget,
      widgetPanel,
      panel: state,
      type,
      textAlignOptions,
      store,
    };
  },
  components: { Property, PanelSection, Select },
};
