import { store } from "../store.js";
import { watch, computed, ref, reactive, toValue } from "vue";

export default {
  name: "TextSourceModal",
  template: `
    <template v-if="textSource">
      <div class="fixed inset-0 z-10 flex items-center justify-center bg-black bg-opacity-20 backdrop-blur-sm" @click.self="store.textSource = null">
          <div class="w-full max-w-2xl rounded-lg bg-white shadow-xl">
            <div class="flex items-center justify-between border-b px-6 py-4">
              <h1 class="text-xl font-semibold">Text source - <span class="text-sm text-zinc-500">{{ store.textSource.text }}</span></h1>
              <button class="flex h-8 w-8 items-center justify-center rounded-full border text-xl hover:bg-slate-100">&times;</button>
            </div>
            <div class="modal-content max-h-[70vh] overflow-y-auto p-6">
              <div class="space-y-4">
                <!-- Example of a translation item -->
                

                <!-- Another example translation item -->
                <div class="translation-item rounded border p-4" :key="translation.id" v-for="translation in translations">
                  <div class="mb-2 flex items-center justify-between">
                    <span class="font-medium">{{ translation.language_code }}</span>
                    <button class="text-red-500 hover:text-red-700" style="background: none;">Delete</button>
                  </div>
                  <input type="text" v-model="translation.translation" class="w-full rounded border p-2" style="width: 100%;"/>
                </div>

                <!-- Add new translation form -->
                <form class="mt-6 space-y-4 rounded border p-4" @submit.prevent="handleCreateTranslationSubmit">
                  <h2 class="text-lg font-semibold">Add New Translation</h2>
                  <div>
                    <label for="lang-code" class="mb-1 block text-sm font-medium">Language Code</label>
                    <input type="text" id="lang-code" placeholder="e.g. FR" v-model="newTranslation.language_code" class="w-full rounded border p-2" style="width: 100%;"/>
                  </div>
                  <div>
                    <label for="translation" class="mb-1 block text-sm font-medium">Translation</label>
                    <input type="text" id="translation" placeholder="Enter translation" v-model="newTranslation.translation" class="w-full rounded border p-2" style="width: 100%;" />
                  </div>
                  <button type="submit" class="rounded bg-blue-500 px-4 py-2 text-white hover:bg-blue-600">Add Translation</button>
                </form>
              </div>
            </div>
          </div>
        </div>
    </template>    
  `,
  setup() {
    var textSource = computed(() => {
      return store.textSource;
    });

    var translations = ref([]);

    const newTranslation = ref({
      language_code: "",
      translation: "",
    });

    function handleCreateTranslationSubmit(event) {
      console.log("submitting ");
      console.log(newTranslation);

      translations.value.push(toValue(newTranslation));

      newTranslation.value = { language_code: "", translation: "" };
    }

    watch(textSource, (val) => {
      if (val) {
        fetch(
          "http://localhost:2121/crud/text-source/source/?id=" +
            textSource.value.id
        )
          .then((res) => res.json())
          .then((r) => {
            translations.value.concat(r.translations);
          });
      }
    });

    return {
      textSource,
      store,
      translations,
      handleCreateTranslationSubmit,
      newTranslation,
    };
  },
};
