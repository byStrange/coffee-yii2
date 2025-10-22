import { ref, watchEffect, toValue } from "vue";

export function getComponentName(widget) {
  switch (widget.widgetType.type) {
    case "text":
      return "TextWidget";
    case "view":
      return "ViewWidget";
    case "button":
      return "ButtonWidget";
    case "icon":
      return "IconWidget";
    case "component_widget":
      return "ComponentWidget";
    case "image":
      return "ImageWidget";
    case "input":
      return "InputWidget";
    case "container":
      return "ContainerWidget";
  }
}

export function useFetch(url) {
  const data = ref(null);
  const error = ref(null);

  const fetchData = () => {
    data.value = null;
    error.value = null;

    fetch(toValue(url))
      .then((res) => res.json())
      .then((json) => (data.value = json))
      .catch((err) => (error.value = err));
  };

  watchEffect(() => {
    fetchData();
  });

  return { data, error };
}

export class MagicRender {
  static componentWidgets = ref([]);

  static findWidgetById(widgetTree, id) {
    function find(widget, id) {
      // If the current widget's id matches the search id, return it
      if (widget.id === id) {
        return widget;
      }

      // If this widget has children, search recursively in its children
      if (widget.children && widget.children.length > 0) {
        for (let child of widget.children) {
          let found = find(child, id);
          if (found) {
            return found;
          }
        }
      }

      // If no widget is found in this branch, return null
      return null;
    }

    // Iterate over the top-level widget tree
    for (let widget of widgetTree) {
      let result = find(widget, id);
      if (result) {
        return result;
      }
    }

    // Return null if no widget with the matching ID is found
    for (let widget of MagicRender.componentWidgets.value) {
      let result = find(widget, id);
      if (result) return result;
    }
  }

  static buildWidgetTree(widgets) {
    function build(widgets, parentId = null) {
      const tree = [];
      for (var widget of widgets) {
        if (widget.parent_widget_id === parentId) {
          let children = build(widgets, widget.id);
          if (children) {
            children.sort(function (a, b) {
              a.order - b.order;
            });
            widget.children = children;
          }
          if (widget.widgetType.type === "input") widget.input.value = "";
          if (widget.widgetType.type === "component_widget") {
            let component = MagicRender.componentWidgets.value.find(
              (component) =>
                component.component.id == widget.componentWidget.component_id
            );
            widget.theholy_component = component;
            component.usedBy = widget.id;
          }
          if (widget.widgetType.type == "component")
            MagicRender.componentWidgets.value.push(widget);
          else tree.push(widget);
        }
      }

      tree.sort(function (a, b) {
        return a.order - b.order;
      });
      return tree;
    }

    const widgetTree = ref(build(widgets));
    return widgetTree;
  }
}

export function detectWidgetChanges(oldWidgets, newWidgets) {
  const changes = [];

  function compareWidgets(oldWidget, newWidget, path) {
    // Compare properties
    for (const key in oldWidget) {
      if (key === "children") continue; // Handle children separately
      if (oldWidget[key] !== newWidget[key]) {
        changes.push({
          id: newWidget.id,
          path,
          changes: { [key]: newWidget[key] },
        });
      }
    }

    // Compare children
    const maxLength = Math.max(
      oldWidget.children.length,
      newWidget.children.length
    );
    for (let i = 0; i < maxLength; i++) {
      const oldChild = oldWidget.children[i];
      const newChild = newWidget.children[i];

      if (!oldChild) {
        // New child added
        changes.push({
          id: newChild.id,
          path: [...path, i],
          changes: newChild,
        });
      } else if (!newChild) {
        // Child removed
        changes.push({
          id: oldChild.id,
          path: [...path, i],
          changes: null, // Indicate deletion
        });
      } else {
        // Recursively compare children
        compareWidgets(oldChild, newChild, [...path, i]);
      }
    }
  }

  // Compare root level widgets
  const maxLength = Math.max(oldWidgets.length, newWidgets.length);
  for (let i = 0; i < maxLength; i++) {
    const oldWidget = oldWidgets[i];
    const newWidget = newWidgets[i];

    if (!oldWidget) {
      changes.push({
        id: newWidget.id,
        path: [i],
        changes: newWidget,
      });
    } else if (!newWidget) {
      changes.push({
        id: oldWidget.id,
        path: [i],
        changes: null, // Indicate deletion
      });
    } else {
      compareWidgets(oldWidget, newWidget, [i]);
    }
  }

  return changes;
}
