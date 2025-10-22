export default {
  name: "PanelSection",
  template: `
      <div class="w-section">
          <div class="w-section-title">{{ title }}</div>
          <slot :opts="options"></slot>
      </div> 
  `,
  props: ['title', 'options']
};
