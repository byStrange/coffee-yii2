import Widget from "../Widget.js";

export default {
  components: { Widget },
  template: `
    <Widget :widget="widget">
      <template #default="attrs">
        <button v-bind="attrs" class="button-widget">
          <template v-if="widget.children.length">
            <WidgetTree :widgets="widget.children" />
          </template>
        </button>
      </template>
    </Widget>
  `,
  props: ["widget"],
  name: "ButtonWidget",
};
