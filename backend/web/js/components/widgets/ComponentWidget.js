import Widget from "../Widget.js";
import Component from "./Component.js";
export default {
  template: `
    <Widget :widget="widget"> 
      <template #default="attrs">
        <div v-bind="attrs" class="widget-component_widget">
          <Component :widget="widget.theholy_component" :parentId="widget.id" />
        </div>
      </template>
    </Widget>
  `,
  components: { Component, Widget },
  props: ["widget"],
  name: "ComponentWidget",
};
