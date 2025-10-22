import Widget from "../Widget.js";

export default {
  components: { Widget },
  template: `
    <Widget :widget="widget">
      <template #default="props"> 
        <div v-bind="props" :class="['view-widget']">
          <template v-if="widget.children.length">
            <WidgetTree :widgets="widget.children" />
          </template>
        </div>
      </template>
    </Widget>
  `,
  props: ["widget"],
  name: "ViewWidget",
};
