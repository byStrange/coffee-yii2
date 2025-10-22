import Widget from "../Widget.js";

export default {
  components: { Widget },
  template: `
    <Widget :widget="widget">
      <template #default="props"> 
        <img v-bind="props" class="image-widget" :src="widget.image.src" />
      </template>
    </Widget>
  `,
  props: ["widget"],
  name: "ImageWidget",
};
