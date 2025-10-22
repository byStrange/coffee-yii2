import Widget from "../Widget.js";
export default {
  template: `
    <Widget :widget="widget">
      <template #default="attrs">
        <div v-bind="attrs" class="component" :data-component-name="widget.component.name" :data-parent-id="parentId">
          <WidgetTree :widgets="widget.children" />
        </div>
      </template>
    </Widget>
  `,
  props: ["widget", "parentId"],
  components: {
    Widget,
  },
  name: "Component",
};
