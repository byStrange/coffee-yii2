const sizeInput = {
  mounted(el, binding) {
    const isMultiple = binding.value === "multiple";
    const r = /^(-?\d*\.?\d+)([a-z%]+)$/i;

    el.addEventListener("keydown", function (event) {
      if (event.key !== "ArrowUp" && event.key !== "ArrowDown") return;

      event.preventDefault();

      const incrementBy = event.ctrlKey ? 10 : 1;
      const direction = event.key === "ArrowUp" ? 1 : -1;

      if (isMultiple) {
        handleMultipleValues(el, r, incrementBy, direction);
      } else {
        handleSingleValue(el, r, incrementBy, direction);
      }

      // Dispatch input event to ensure v-model is updated
      const inputEvent = new Event("input", { bubbles: true });
      el.dispatchEvent(inputEvent);
    });
  },
};

function handleSingleValue(el, regex, incrementBy, direction) {
  const match = el.value.match(regex);
  if (!match) return;

  const [_, number, unit] = match;
  const newValue = parseFloat(number) + incrementBy * direction;
  el.value = `${newValue}${unit}`;
}

function handleMultipleValues(el, regex, incrementBy, direction) {
  const values = el.value.split(" ");
  const cursorPosition = el.selectionStart;
  let currentValueIndex = 0;
  let currentPosition = 0;

  // Find which value the cursor is currently on
  for (let i = 0; i < values.length; i++) {
    if (
      cursorPosition > currentPosition &&
      cursorPosition <= currentPosition + values[i].length
    ) {
      currentValueIndex = i;
      break;
    }
    currentPosition += values[i].length + 1; // +1 for the space
  }

  const match = values[currentValueIndex].match(regex);
  if (!match) return;

  const [_, number, unit] = match;
  const newValue = parseFloat(number) + incrementBy * direction;
  values[currentValueIndex] = `${newValue}${unit}`;
  el.value = values.join(" ");

  // Maintain cursor position
  el.setSelectionRange(cursorPosition, cursorPosition);
}

export default sizeInput;
