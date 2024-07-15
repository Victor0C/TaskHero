<template>
  <button
    type="button"
    class="btn myButton btn-primary"
    data-bs-toggle="modal"
    :data-bs-target="`#${task.id}editModal`"
  >
    Editar
  </button>
  <div
    class="modal fade"
    :id="`${task.id}editModal`"
    tabindex="-1"
    :aria-labelledby="`#${task.id}EditModalLabel`"
    aria-hidden="true"
  >
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" :id="`${task.id}EditModalLabel`">
            Editar a tarefa: {{ task.title }}
          </h1>
          <button
            type="button"
            class="btn-close"
            data-bs-dismiss="modal"
            aria-label="Close"
            @click="resetForm"
          ></button>
        </div>
        <div class="modal-body">
          <form class="d-flex flex-column gap-3" @submit.prevent="submitFormUpdate">
            <div>
              <label :for="`editTitleInput${task.id}`" class="form-label">Título</label>
              <input
                v-model="title"
                @blur="validateTitle"
                maxlength="30"
                type="text"
                class="form-control"
                :class="{ 'is-invalid': validations.title.invalid }"
                :id="`editTitleInput${task.id}`"
                placeholder="Insira o título da tarefa"
              />
              <small v-if="validations.title.invalid" class="text-danger"
                >Por favor, insira um título.</small
              >
            </div>
            <div>
              <label :for="`editDescriptionInput${task.id}`" class="form-label">Descrição</label>
              <input
                v-model="desc"
                @blur="validateDescription"
                type="text"
                maxlength="150"
                class="form-control"
                :class="{ 'is-invalid': validations.description.invalid }"
                :id="`editDescriptionInput${task.id}`"
                placeholder="Insira a descrição da tarefa"
              />
              <small v-if="validations.description.invalid" class="text-danger"
                >Por favor, insira uma descrição.</small
              >
            </div>
            <div>
              <label :for="`editDateInput${task.id}`" class="form-label">Data de Conclusão</label>
              <input
                v-model="expired_date"
                @blur="validateDate"
                type="date"
                class="form-control"
                :class="{ 'is-invalid': validations.expiredDate.invalid }"
                :id="`editDateInput${task.id}`"
                :min="minDate"
              />
              <small v-if="validations.expiredDate.invalid" class="text-danger"
                >Por favor, insira uma data válida a partir de hoje.</small
              >
            </div>
            <div class="mb-3 form-check">
              <input
                v-model="done"
                type="checkbox"
                class="form-check-input"
                :id="`editDoneCheck${task.id}`"
              />
              <label class="form-check-label" :for="`editDoneCheck${task.id}`">Concluído</label>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button
            @click="submitFormUpdate"
            type="button"
            class="btn myButtonDefault"
            :class="{ disabled: !formOK }"
            data-bs-dismiss="modal"
          >
            Confirmar
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import editTask from '../../service/editTask.js'

export default {
  name: 'ModalEditTask',
  emits: ['refreshList'],
  props: {
    task: {
      type: Object,
      required: true
    }
  },
  data() {
    return {
      title: this.task.title,
      desc: this.task.desc,
      expired_date: this.task.expired_date,
      done: this.task.done,
      formOK: true,
      validations: {
        title: { invalid: false },
        description: { invalid: false },
        expiredDate: { invalid: false }
      },
      minDate: new Date().toISOString().split('T')[0]
    }
  },
  methods: {
    async submitFormUpdate() {
      this.validateTitle()
      this.validateDescription()
      this.validateDate()

      if (this.formOK) {
        const taskData = {
          title: this.title,
          desc: this.desc,
          expired_date: this.expired_date,
          done: this.done
        }
        const data = await editTask(this.task.id, taskData)

        if (data.error) {
          alert('Algo deu errado com a edição da tarefa...')
          return
        }
        this.$emit('refreshList')
      }
    },
    validateTitle() {
      this.validations.title.invalid = !this.title.trim()
      this.validForm()
    },
    validateDescription() {
      this.validations.description.invalid = !this.desc.trim()
      this.validForm()
    },
    validateDate() {
      this.validations.expiredDate.invalid = !this.expired_date
      this.validForm()
    },
    validForm() {
      this.formOK =
        !this.validations.title.invalid &&
        !this.validations.description.invalid &&
        !this.validations.expiredDate.invalid
    },
    resetForm() {
      this.title = this.task.title
      this.desc = this.task.desc
      this.expired_date = this.task.expired_date
      this.done = this.task.done
      this.validations.title.invalid = false
      this.validations.description.invalid = false
      this.validations.expiredDate.invalid = false
      this.formOK = true
    }
  }
}
</script>
