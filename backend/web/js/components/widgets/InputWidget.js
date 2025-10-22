import Widget from "../Widget.js";

export default {
  components: { Widget },
  template: `
    <Widget :widget="widget">
      <template #default="props"> 
        <input v-bind="props" class="image-widget" v-model="widget.input.value" :placeholder="widget.input.placeholderTextSource.text" />
      </template>
    </Widget>
  `,
  props: ["widget"],
  name: "ViewWidget",
};
