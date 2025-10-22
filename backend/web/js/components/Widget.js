import { watch, computed, onMounted } from "vue";
import { store } from "../store.js";
import { MagicRender } from "../utils.js";

export default {
  template: `
      <slot @click="wrapperEvents.clickAndDoubleClickUniversal" @mouseenter="wrapperEvents.mouseEnter" @mouseleave="wrapperEvents.mouseLeave" :class="['widget', widget.class]" :id="widget.html_id" :style="[widget.style, computedStyle]" />  
  `,
  setup(props) {
    const computedStyle = computed(() => {
      return {
        background: props.widget.background,
        borderRadius: props.widget.radius,
        width: props.widget.width == "auto" ? "" : props.widget.width,
        height: props.widget.height == "auto" ? "" : props.widget.height,
        visibility: props.widget.hidden ? "hidden" : "",
        padding: props.widget.padding,
        margin: props.widget.margin
      };
    });
    // Function to find the top-most parent widget
    function findParent(widget) {
      if (!widget) {
        return props.widget;
      }

      if (widget.widgetType.type == "component") {
        console.log("i foudn that mfkrer", widget);
      }
      if (widget.parent_widget_id || widget.usedBy) {
        console.log(widget);
        if (widget.usedBy) {
          console.log("hello motherfucker");

          return findParent(
            MagicRender.findWidgetById(store.widgetTree, widget.usedBy)
          );
        } else {
          return findParent(
            MagicRender.findWidgetById(
              store.widgetTree,
              widget.parent_widget_id
            )
          );
        }
      }

      return widget;
    }

    function findPath(root, targetId, path = []) {
      if (root.id === targetId) {
        path.push(root);
        return true;
      }

      if (root.widgetType.type == "component_widget") {
        var cWidget = root.theholy_component;
        var children = cWidget ? cWidget.children : [];
        for (let child of children) {
          if (findPath(child, targetId, path)) {
            path.push(cWidget);
            path.push(root);
            return true;
          }
        }
      }

      for (let child of root.children) {
        if (findPath(child, targetId, path)) {
          path.push(root);
          return true;
        }
      }

      return false;
    }

    function findNearestElement(element, attributeName) {
      var currentElement = element;
      while (currentElement) {
        if (currentElement.hasAttribute(attributeName)) {
          return currentElement;
        }
        currentElement = currentElement.parentElement;
      }
      return null;
    }

    var currentIndex = 0;
    var currentNode = null;

    // Function to find the specific clicked child widget

    var path = [];

    const wrapperEvents = {
      clicked: false,
      timer: null,
      clickAndDoubleClickUniversal(event) {
        event.stopPropagation();
        // Clear any existing timer
        if (wrapperEvents.timer) {
          clearTimeout(wrapperEvents.timer);
          wrapperEvents.timer = null;
        }

        if (wrapperEvents.clicked) {
          // Double click detected
          wrapperEvents.clicked = false; // Reset the flag
          wrapperEvents.doubleClick(event);
        } else {
          // Single click detected
          wrapperEvents.clicked = true; // Set the flag

          // Set a timeout to reset the flag and trigger single click
          wrapperEvents.timer = setTimeout(() => {
            wrapperEvents.clicked = false;
            wrapperEvents.click(event);
          }, 300); // Adjust the delay as needed
        }
      },
      click(event) {
        if (event) {
          event.preventDefault();
          event.stopPropagation();
        }
        path.length = 0;
        currentIndex = 0;
        var isChildOfComponent = findNearestElement(
          event.target,
          "data-parent-id"
        );

        let parent = isChildOfComponent
          ? MagicRender.findWidgetById(
              store.widgetTree,
              +isChildOfComponent.dataset.parentId
            )
          : findParent(props.widget);

        findPath(parent, props.widget.id, path);
        path.reverse();
        console.log("the path is ", path);

        if (
          store.activeWidget &&
          store.activeWidget.id != path[currentIndex].id
        )
          store.activeWidget.style = "border: none";
        store.activeWidget = path[currentIndex];
        path[currentIndex].style = "border: 2px solid lime";
        currentIndex = Math.min(currentIndex + 1, path.length - 1);
      },

      doubleClick(event) {
        if (event) {
          event.preventDefault();
          event.stopPropagation();
        }

        if (!path.length) wrapperEvents.click(event);

        currentNode = path[currentIndex];
        console.log("index is:", currentIndex);
        console.log("node is:", currentNode);
        console.log(
          "node list in simpler way",
          path.map(({ widgetType, id }) => ({ widgetType, id }))
        );

        if (store.activeWidget && store.activeWidget.id != currentNode.id) {
          console.log(
            "there is activeWidget",
            "ids dont match",
            store.activeWidget.id,
            currentNode.id
          );
          store.activeWidget.style = "border: none;";
        }

        console.log(currentNode.id, store.activeWidget.id);

        currentNode.style = "border: 2px solid lime;";

        store.activeWidget = currentNode;

        if (currentIndex < path.length - 1) {
          currentIndex++;
        }
      },

      mouseEnter(event) {
        event.preventDefault();
        //var firstNode = findParent(props.widget);
        //firstNode.style = "border: 1px solid red"; // Highlight on hover
      },

      mouseLeave(event) {
        //props.widget.style = "border: none"; // Reset style on mouse leave
      },
    };

    const shallowWidget = computed(() => {
      const { children, ...rest } = props.widget;
      return rest;
    });

    const childrenLength = computed(() => {
      return props.widget.children.length;
    });

    onMounted(() => {
      let mismatches = props.widget.children.filter(
        (widget) => widget.parent_widget_id != props.widget.id
      );
      if (mismatches.length) {
        mismatches.forEach((mismatchWidget) => {
          mismatchWidget.parent_widget_id = props.widget.id;
        });
      }
    });

    watch(childrenLength, (newlength) => {
      console.log(
        "on widget " + props.widget.id + " length has changed",
        newlength
      );
      props.widget.children.forEach((children) => {
        children.parent_widget_id = props.widget.id;
      });
    });

    watch(shallowWidget, (newVal) => {
      console.log("WATCHER 1. smth has changed", newVal.class);
    });

    return {
      wrapperEvents,
      childrenLength,
      computedStyle,
    };
  },
  props: ["widget"],
};
