import TextWidget from "./widgets/TextWidget.js";
import ViewWidget from "./widgets/ViewWidget.js";
import ButtonWidget from "./widgets/ButtonWidget.js";
import ComponentWidget from "./widgets/ComponentWidget.js";
import IconWidget from "./widgets/IconWidget.js";
import ImageWidget from "./widgets/ImageWidget.js";
import InputWidget from "./widgets/InputWidget.js";
import ContainerWidget from './widgets/ContainerWidget.js'; 

import { getComponentName } from "../utils.js";

export default {
  template: `
    <template v-for="widget in widgets">
      <component :is="getComponentName(widget)" :widget="widget" />
    </template>
  `,
  setup() {
    return {
      getComponentName,
    };
  },
  components: {
    TextWidget,
    ViewWidget,
    IconWidget,
    ButtonWidget,
    ComponentWidget,
    InputWidget,
    ContainerWidget, 
    ImageWidget,
  },
  name: "WidgetTree",

  props: ["widgets"],
};
