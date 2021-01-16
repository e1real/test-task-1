<template>
  <div class="container">
    <div class="my-2">
      <h2 class="text-center">Chord list</h2>
      <button
        class="btn btn-success btn-sm"
        @click="handleClickCreate"
      >
        Create new chord
      </button>
    </div>
    <table class="table">
      <thead>
      <tr>
        <th scope="col">#</th>
        <th scope="col">Song Name</th>
        <th scope="col">Author</th>
        <th scope="col">Is original</th>
        <th scope="col"></th>
      </tr>
      </thead>
      <tbody>
      <tr v-for="(chord, index) in chordsLocal">
        <th scope="row">{{ index + 1 }}</th>
        <td>{{ chord.title }}</td>
        <td>{{ chord.author }}</td>
        <td>
          <div class="custom-control custom-checkbox">
            <input
              type="checkbox"
              v-model="chord.is_original"
              class="custom-control-input"
              :id="index + '-is-original'"
              disabled
            >
            <label
              class="custom-control-label"
              :for="index + '-is-original'"
            />
          </div>
        </td>
        <td>
          <div>
            <button
              class="btn btn-primary btn-sm text-uppercase"
              @click="itemEvent('show', index)"
            >
              show
            </button>
            <button
              class="btn btn-secondary btn-sm text-uppercase"
              @click="itemEvent('edit', index)"
            >
              edit
            </button>
            <button
              class="btn btn-danger btn-sm text-uppercase"
              @click="itemEvent('delete', index, $event)"
            >
              delete
            </button>
          </div>
        </td>
      </tr>
      </tbody>
    </table>
    <div
      class="modal fade"
      id="modalChordText"
      tabindex="-1"
      role="dialog"
      aria-labelledby="modalChordTextTitle"
      aria-hidden="true"
    >
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="modalChordTextTitle">
              {{ chosenChord.author + ' - ' + chosenChord.title }}
            </h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div v-html="chosenChord.chords"></div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  props: {
    chords: {
      type: Array,
      required: true,
    },
  },
  data() {
    return {
      chordsLocal: [],
      chosenChord: {},
    };
  },
  mounted() {
    this.chordsLocal = this.chords;
  },
  methods: {
    /**
     * Call item event
     * @param {string} eventType
     * @param {number} idx index of item
     * @param {Event} ev button event
     */
    itemEvent(eventType, idx, ev) {
      this.chosenChord = this.chordsLocal[idx];

      if (eventType === 'show') {
        this.showItem(idx)
      } else if (eventType === 'edit') {
        location.href = `/cf-chords/${this.chosenChord.chord_id}/edit`;
      } else if (eventType === 'delete') {
        this.deleteItem(idx, ev)
      }
    },
    /**
     * Show item chords in modal
     * @param {number} idx
     */
    showItem(idx) {
      $('#modalChordText').modal('show');
    },
    /**
     * Delete row in table
     * @param {number} idx
     * @param {Event} ev
     */
    async deleteItem(idx, ev) {
      const deleteButton = ev.target;
      deleteButton.disabled = true;
      try {
        await axios.delete(`/cf-chords/${this.chosenChord.chord_id}`);
        this.chordsLocal.splice(idx, 1);
      } catch (e) {
        console.error(e);
      }
      deleteButton.disabled = false;
    },
    /**
     * Click create new chord event
     */
    handleClickCreate() {
      location.href = `/cf-chords/create`
    }
  },
}
</script>
