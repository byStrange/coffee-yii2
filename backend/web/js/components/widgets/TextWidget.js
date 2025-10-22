import { computed, h } from "vue";
import Widget from "../Widget.js";

export default {
  name: "TextWidget",
  setup(props) {
    var styles = computed(() => {
      return props.widget.text.styles
        ? props.widget.text.styles.replaceAll(" ", "").split(",")
        : [];
    });

    var textStyles = computed(() => {
      var t = {
        color: props.widget.text.color,
        fontSize: props.widget.text.size,
        letterSpacing: props.widget.text.letter_spacing,
        fontFamily: props.widget.text.font_family,
        textAlign: props.widget.text.align || "left",
      };
      return t;
    });

    const markupStyles = computed(() => {
      var markupStyles = {};

      if (styles.value.includes("italic")) markupStyles.fontStyle = "italic";
      if (styles.value.includes("bold")) markupStyles.fontWeight = "bold";
      if (styles.value.includes("underline"))
        markupStyles.textDecoration = "underline";
      return markupStyles;
    });

    var renderText = (attrs) =>
      h(
        props.widget.text.type ? props.widget.text.type : "p",
        {
          ...attrs,
          class: [attrs.class, "text-widget"],
          style: [attrs.style, { ...textStyles.value, ...markupStyles.value }],
        },
        props.widget.text.textSource.text
      );

    return () =>
      h(
        Widget,
        { widget: props.widget },
        { default: (attrs) => renderText(attrs) }
      );
  },
  props: ["widget"],
};
