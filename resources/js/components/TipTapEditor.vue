<template>
 <div>
  <!-- <div v-if="editor" class="mb-2">
        <v-btn
         v-for="(item, index) in floatingMenuButtons"
         :key="index"
         small
         @click="item.command"
         class="ml-1"
         :class="{
          'is-active': editor.isActive(item.active, item.context),
         }"
        >
         {{ item.icon }}
        </v-btn>

        <v-btn small @click="addImage">
         Add Image
        </v-btn>
       </div> -->

  <bubble-menu
   class="bubble-menu"
   :tippy-options="{ duration: 100 }"
   :editor="editor"
   v-if="editor"
  >
   <v-btn
    v-for="(item, index) in menuButtons"
    :key="index"
    small
    @click="item.command"
    class="ml-1"
    :class="{
     'is-active': editor.isActive(item.active, item.context),
    }"
   >
    {{ item.icon }}
   </v-btn>

   <v-btn small @click="addImageModal">
    <v-icon>
     mdi-image
    </v-icon>
   </v-btn>
  </bubble-menu>

  <!-- floating menu for editor -->
  <floating-menu
   class="floating-menu"
   :tippy-options="{ duration: 100 }"
   :editor="editor"
   v-if="editor"
  >
   <v-btn
    v-for="(item, index) in menuButtons"
    :key="index"
    small
    @click="item.command"
    class="ml-1"
    :class="{
     'is-active': editor.isActive(item.active, item.context),
    }"
   >
    {{ item.icon }}
   </v-btn>

   <!-- Add Image -->
   <v-btn small @click="addImageModal">
    <v-icon>
     mdi-image
    </v-icon>
   </v-btn>
  </floating-menu>

  <editor-content :editor="editor" />

  <drop-zone-modal ref="modaldropzone" @upload="upload"></drop-zone-modal>
 </div>
</template>

<script>
import { Editor, EditorContent, FloatingMenu, BubbleMenu } from "@tiptap/vue-2";
import StarterKit from "@tiptap/starter-kit";
import Image from "@tiptap/extension-image";
import DropZoneModal from "./DropZoneModal.vue";
import { onUnmounted, ref } from "@vue/composition-api";
export default {
 name: "TiptapEditor",
 components: {
  EditorContent,
  FloatingMenu,
  BubbleMenu,
  DropZoneModal,
 },

 props: {
  value: {
   type: String,
   default: "",
  },
 },

 data() {
  return {};
 },

 setup(props, context) {
  // data
  const editor = ref(null);

  const menuButtons = ref([
   {
    icon: "I",
    active: "italic",
    command: () => {
     return editor.value
      .chain()
      .focus()
      .toggleItalic()
      .run();
    },
    context: {},
   },

   {
    icon: "B",
    active: "bold",
    command: () => {
     return editor.value
      .chain()
      .focus()
      .toggleBold()
      .run();
    },
    context: {},
   },

   {
    icon: "H1",
    active: "heading",
    command: () => {
     return editor.value
      .chain()
      .focus()
      .toggleHeading({ level: 1 })
      .run();
    },
    context: { level: 1 },
   },

   {
    icon: "H2",
    active: "heading",
    command: () => {
     return editor.value
      .chain()
      .focus()
      .toggleHeading({ level: 2 })
      .run();
    },
    context: { level: 2 },
   },

   {
    icon: "H3",
    active: "heading",
    command: () => {
     return editor.value
      .chain()
      .focus()
      .toggleHeading({ level: 3 })
      .run();
    },
    context: { level: 3 },
   },

   {
    icon: "ul",
    active: "bulletList",
    command: () => {
     return editor.value
      .chain()
      .focus()
      .toggleBulletList()
      .run();
    },
    context: {},
   },
  ]);

  // methods
  const addImageModal = () => {
   context.refs.modaldropzone.showModal();
  };

  const upload = (response) => {
   editor.value
    .chain()
    .focus()
    .setImage({ src: response.data })
    .run();
  };

  // mounted
  editor.value = new Editor({
   content: props.value,
   extensions: [StarterKit, Image],
   content: "",
   onUpdate: ({ editor }) => {
    context.emit("input", editor.getHTML());
   },
  });

  // befor destroyy
  onUnmounted(() => {
   editor.value.destroy();
  });

  return {
   editor,
   menuButtons,
   addImageModal,
   upload,
  };
 },
};
</script>

<style lang="scss">
.ProseMirror {
 > * + * {
  margin-top: 0.75em;
 }

 ul,
 ol {
  padding: 0 1rem;
 }

 pre {
  background: #0d0d0d;
  color: #fff;
  font-family: "JetBrainsMono", monospace;
  padding: 0.75rem 1rem;
  border-radius: 0.5rem;
  text-align: left;
  direction: ltr;

  code {
   color: inherit;
   padding: 0;
   background: none;
   font-size: 0.9rem;
  }
 }

 img {
  max-width: 100%;
  height: auto;
 }

 blockquote {
  padding-left: 1rem;
  border-left: 2px solid rgba(#0d0d0d, 0.1);
 }

 hr {
  border: none;
  border-top: 2px solid rgba(#0d0d0d, 0.1);
  margin: 2rem 0;
 }
}

.bubble-menu {
 display: flex;
 background-color: #0d0d0d;
 padding: 0.2rem;
 border-radius: 0.5rem;

 button {
  border: none;
  background: none;
  color: #fff;
  font-size: 0.85rem;
  font-weight: 500;
  padding: 0 0.2rem;
  opacity: 0.6;

  &:hover,
  &.is-active {
   opacity: 1;
  }
 }
}

.floating-menu {
 display: flex;
 background-color: #0d0d0d10;
 padding: 0.2rem;
 border-radius: 0.5rem;

 button {
  border: none;
  background: none;
  font-size: 0.85rem;
  font-weight: 500;
  padding: 0 0.2rem;
  opacity: 0.6;

  &:hover,
  &.is-active {
   opacity: 1;
  }
 }
}
</style>
