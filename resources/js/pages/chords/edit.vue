<template>
  <div class="container">
    <div class="w-100 d-flex mb-2">
      <button
        class="btn btn-success ml-auto"
        @click="handleClickSave"
        :disabled="formBusy"
      >
        Save changes
      </button>
    </div>
    <div>
      <div class="alert alert-warning alert-dismissible fade show" v-show="formErrors" role="alert" v-for="(error, key) in formErrors">
        {{ error[0] }}
      </div>
    </div>
    <div class="form-group">
      <label for="chord-title">Title</label>
      <input
        v-model="form.title"
        type="text"
        class="form-control"
        id="chord-title"
        placeholder="Enter song name | title"
      >
    </div>
    <div class="form-group">
      <label for="chord-author">Author</label>
      <input
        v-model="form.author"
        type="text"
        class="form-control"
        id="chord-author"
        placeholder="Enter song author"
      >
    </div>
    <div class="form-group form-check">
      <input
        v-model="form.is_original"
        type="checkbox"
        class="form-check-input"
        id="chord-is-original"
      >
      <label class="form-check-label" for="chord-is-original">Is original</label>
    </div>
    <editor-menu-bar :editor="editor" v-slot="{ commands, isActive }">
      <div class="menubar">
        <button
          class="menubar__button"
          :class="{ 'is-active': isActive.bold() }"
          @click="commands.bold"
        >
          <img width="20" height="20" src="/images/svg/icons/bold.svg" />
        </button>

        <button
          class="menubar__button"
          :class="{ 'is-active': isActive.italic() }"
          @click="commands.italic"
        >
          <img width="20" height="20" src="/images/svg/icons/italic.svg" />
        </button>

        <button
          class="menubar__button"
          :class="{ 'is-active': isActive.strike() }"
          @click="commands.strike"
        >
          <img width="20" height="20" src="/images/svg/icons/strike.svg" />
        </button>

        <button
          class="menubar__button"
          :class="{ 'is-active': isActive.underline() }"
          @click="commands.underline"
        >
          <img width="20" height="20" src="/images/svg/icons/underline.svg" />
        </button>

        <button
          class="menubar__button"
          :class="{ 'is-active': isActive.code() }"
          @click="commands.code"
        >
          <img width="20" height="20" src="/images/svg/icons/code.svg" />
        </button>

        <button
          class="menubar__button"
          :class="{ 'is-active': isActive.paragraph() }"
          @click="commands.paragraph"
        >
          <img width="20" height="20" src="/images/svg/icons/paragraph.svg" />
        </button>

        <button
          class="menubar__button"
          :class="{ 'is-active': isActive.heading({ level: 1 }) }"
          @click="commands.heading({ level: 1 })"
        >
          H1
        </button>

        <button
          class="menubar__button"
          :class="{ 'is-active': isActive.heading({ level: 2 }) }"
          @click="commands.heading({ level: 2 })"
        >
          H2
        </button>

        <button
          class="menubar__button"
          :class="{ 'is-active': isActive.heading({ level: 3 }) }"
          @click="commands.heading({ level: 3 })"
        >
          H3
        </button>

        <button
          class="menubar__button"
          :class="{ 'is-active': isActive.bullet_list() }"
          @click="commands.bullet_list"
        >
          <img width="20" height="20" src="/images/svg/icons/ul.svg" />
        </button>

        <button
          class="menubar__button"
          :class="{ 'is-active': isActive.ordered_list() }"
          @click="commands.ordered_list"
        >
          <img width="20" height="20" src="/images/svg/icons/ol.svg" />
        </button>

        <button
          class="menubar__button"
          :class="{ 'is-active': isActive.blockquote() }"
          @click="commands.blockquote"
        >
          <img width="20" height="20" src="/images/svg/icons/quote.svg" />
        </button>

        <button
          class="menubar__button"
          :class="{ 'is-active': isActive.code_block() }"
          @click="commands.code_block"
        >
          <img width="20" height="20" src="/images/svg/icons/code.svg" />
        </button>

        <button
          class="menubar__button"
          @click="commands.horizontal_rule"
        >
          <img width="20" height="20" src="/images/svg/icons/hr.svg" />
        </button>

        <button
          class="menubar__button"
          @click="commands.undo"
        >
          <img width="20" height="20" src="/images/svg/icons/undo.svg" />
        </button>

        <button
          class="menubar__button"
          @click="commands.redo"
        >
          <img width="20" height="20" src="/images/svg/icons/redo.svg" />
        </button>

      </div>
    </editor-menu-bar>

    <div class="editor-content-wrapper mt-2 bg-white">
      <editor-content class="editor__content" :editor="editor" />
    </div>
  </div>
</template>

<script>
import { Editor, EditorContent, EditorMenuBar } from 'tiptap'
import {
  Blockquote,
  CodeBlock,
  HardBreak,
  Heading,
  HorizontalRule,
  OrderedList,
  BulletList,
  ListItem,
  TodoItem,
  TodoList,
  Bold,
  Code,
  Italic,
  Link,
  Strike,
  Underline,
  History,
} from 'tiptap-extensions'

export default {
  components: {
    EditorContent,
    EditorMenuBar,
  },
  props: {
    cfchord: {
      type: Object,
      required: true,
    }
  },
  data() {
    return {
      editor: null,
      form: {
        title: '',
        author: '',
        chords: '',
        is_original: false,
      },
      formBusy: false,
      formErrors: null,
    };
  },
  mounted() {
    this.form = { ...this.cfchord };

    this.editor = new Editor({
      extensions: [
        new Blockquote(),
        new BulletList(),
        new CodeBlock(),
        new HardBreak(),
        new Heading({ levels: [1, 2, 3] }),
        new HorizontalRule(),
        new ListItem(),
        new OrderedList(),
        new TodoItem(),
        new TodoList(),
        new Link(),
        new Bold(),
        new Code(),
        new Italic(),
        new Strike(),
        new Underline(),
        new History(),
      ],
      content: this.cfchord.chords,
    });
    this.editor.on('update', ({ getHTML }) => {
      this.form.chords = getHTML();
    });
  },
  beforeDestroy() {
    this.editor.destroy();
  },
  methods: {
    /**
     * Save button click event
     */
    async handleClickSave() {
      this.formBusy = true;
      try {
        await axios.put(`/cf-chords/${this.cfchord.chord_id}/`, {
          title: this.form.title,
          author: this.form.author,
          is_original: this.form.is_original,
          chords: this.form.chords,
        })
      } catch (e) {
        this.formErrors = e.response.data.errors;
        setTimeout(() => {
          this.formErrors = null;
        }, 2000);      }
      this.formBusy = false;
    }
  }
}
</script>
