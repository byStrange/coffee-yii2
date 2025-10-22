import sizeInput from "../../directives/sizeInput.js";

export default {
  template: `
    <div class="property" @click.self="handleToggleOpen">
      <span class="property-name">{{ name }}</span>
      <slot name="property-value">
          <div v-if="open" class="property-value">
          <slot name="input" :open="open">
            <input type="text" v-if="type === 'size'" :value="modelValue" @input="handleUpdateModelValue"
              v-size-input="sizeInput ? sizeInput : 'normal'">
            <input v-else :type="type || 'text'" :value="modelValue" @input="handleUpdateModelValue" />
          </slot>
          <slot name="close-button">
            <button @click="handleToggleOpen" style="margin-left: 6px;">×</button>
          </slot>
      </div>
      <slot name="open-button" v-else >
        <button @click="handleToggleOpen" class="panel-add-button">+</button>
      </slot>
      </slot>
    </div>
  `,
  directives: { sizeInput },
  setup(props, { emit }) {
    const value = props.modelValue;

    const handleToggleOpen = () => {
      emit("update:open", !props.open);
      const e = { target: { value } };
      handleUpdateModelValue(e);
    };

    const handleUpdateModelValue = (event) => {
      emit("update:modelValue", event.target.value);
    };

    return { handleToggleOpen, handleUpdateModelValue };
  },
  props: ["modelValue", "name", "open", "type", "sizeInput"],
  emits: ["update:modelValue", "update:open"],
};
