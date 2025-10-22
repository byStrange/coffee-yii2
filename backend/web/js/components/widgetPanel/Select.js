export default {
  template: `
      <div class="text-align-input-container">
        <div v-for="option in options" :key="option.value"
            @click="$emit('update:modelValue', option.value)" :class="[
              'text-align-choice',
              { active: option.value == (modelValue || 'left') }
            ]">
          <i :class="option.icon"></i>
        </div>
      </div>
  `,
  setup() {},
  props: ["modelValue", "options"],
  emits: ["update:modelValue"],
};
