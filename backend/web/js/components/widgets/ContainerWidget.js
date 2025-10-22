import Widget from "../Widget.js";
import { computed } from "vue";

export default {
  components: { Widget },
  template: `
    <Widget :widget="widget">
      <template #default="props"> 
          <template v-if="widget.children.length">
        <div v-bind="props" :class="['container-widget']" :style="">
            <WidgetTree :widgets="widget.children" />
          </template>
        </div>
      </template>
    </Widget>
  `,
  setup(props) {
    const styles = computed(() => ({
      display: "flex",
      flexDirection: props.widget.direction,
      gap: `${props.widget.gap_size_x || 0} ${props.widget.gap_size_y || 0}`,
    }));

    return { styles };
  },
  props: ["widget"],
  name: "ContinerWidget",
};
