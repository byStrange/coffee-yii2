import { h } from "vue";
import Widget from "../Widget.js";

export default {
  name: "IconWidget",
  setup(props) {
    const createIcon = (attrs) => {
      switch (props.widget.icon.iconSource.type) {
        case "boxicon":
          return h("i", {
            ...attrs,
            class: [
              attrs.class,
              props.widget.icon.iconSource.data,
              "widget-icon",
            ],
            style: [attrs.style, { fontSize: props.widget.icon.size }],
          });
        case "image":
          return (() => {
            let sizes = props.widget.icon.size.split("x");
            let width = sizes[0],
              height = sizes[1];
            return h("img", {
              ...attrs,
              class: [attrs.class, "widget-icon"],
              width: width,
              height: height,
              src: props.widget.icon.iconSource.data,
            });
          })();
        case "svg":
          return h("div", {
            ...attrs,
            innerHTML: props.widget.icon.iconSource.data,
          });
      }
    };

    return () =>
      h(
        Widget,
        { widget: props.widget },
        { default: (attrs) => createIcon(attrs) }
      );
  },
  props: ["widget"],
};
