<template>
  <div>
    <div class="accordion" id="accordionFlushExample">
      <div v-for="(task, index) in tasks" :key="task.id" class="accordion-item">
        <h2 class="accordion-header">
          <button
            class="accordion-button collapsed"
            type="button"
            data-bs-toggle="collapse"
            :data-bs-target="'#flush-collapse-' + task.id"
            aria-expanded="false"
            :aria-controls="'flush-collapse-' + task.id"
            style="width: 100%"
          >
            <div class="d-flex justify-content-between align-items-center">
              <div>
                {{ task.title }}
                <small class="text-muted ms-2">{{ formatDate(task.expired_date) }}</small>
              </div>
            </div>
          </button>
        </h2>
        <div
          :id="'flush-collapse-' + task.id"
          class="accordion-collapse collapse"
          data-bs-parent="#accordionFlushExample"
          style="max-height: 10rem; overflow-y: auto"
        >
          <div class="accordion-body d-flex flex-column">
            <div>{{ task.desc }}</div>
            <div class="mt-auto d-flex justify-content-end">
              <button
                v-if="task.done == 0"
                @click="checkTask(index)"
                type="button"
                class="btn btn-sm btn-primary me-1"
                data-bs-toggle="modal"
                data-bs-target="#editModal"
              >
                Editar
              </button>
              <button type="button" class="btn btn-sm btn-danger me-1">Apagar</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div
    class="modal fade"
    id="editModal"
    tabindex="-1"
    aria-labelledby="editModalLabel"
    aria-hidden="true"
  >
    <div class="modal-dialog">
      <div class="modal-content">
        <form @submit.prevent="submitFormUpdate">
          <div class="modal-header">
            <h5 class="modal-title" id="editModalLabel">
              {{ `Editando a tarefa: ${tasks[editTaskIndex]?.title}` }}
            </h5>
            <button
              type="button"
              class="btn-close"
              data-bs-dismiss="modal"
              aria-label="Close"
            ></button>
          </div>
          <div class="modal-body">
            <div class="mb-3">
              <label for="editTitleInput" class="form-label">Título</label>
              <input
                v-model="checkedTaks.title"
                type="text"
                class="form-control"
                :class="{ 'is-invalid': !checkedTaks.titleValid }"
                id="editTitleInput"
                placeholder="Insira o título da tarefa"
              />
              <small v-if="!checkedTaks.titleValid" class="text-danger"
                >Por favor, insira um título.</small
              >
            </div>
            <div class="mb-3">
              <label for="editDescriptionInput" class="form-label">Descrição</label>
              <input
                v-model="checkedTaks.desc"
                type="text"
                class="form-control"
                :class="{ 'is-invalid': !checkedTaks.descriptionValid }"
                id="editDescriptionInput"
                placeholder="Insira a descrição da tarefa"
              />
              <small v-if="!checkedTaks.descriptionValid" class="text-danger"
                >Por favor, insira uma descrição.</small
              >
            </div>
            <div class="mb-3">
              <label for="editDateInput" class="form-label">Data de Conclusão</label>
              <input
                v-model="checkedTaks.expired_date"
                type="date"
                class="form-control"
                :class="{ 'is-invalid': !checkedTaks.dateValid }"
                id="editDateInput"
                :min="minDate"
              />
              <small v-if="!checkedTaks.dateValid" class="text-danger"
                >Por favor, insira uma data válida a partir de hoje.</small
              >
            </div>
            <div class="mb-3 form-check">
              <input
                v-model="checkedTaks.done"
                type="checkbox"
                class="form-check-input"
                id="editDoneCheck"
              />
              <label class="form-check-label" for="editDoneCheck">Concluído</label>
            </div>
            <div v-if="checkedTaks.genericError" class="alert alert-danger" role="alert">
              Algo deu errado... Tente novamente mais tarde.
            </div>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary" data-bs-dismiss="modal">
              Salvar Alterações
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
 
</template>

<script>
import editTask from '@/service/editTasks'
import Cookies from 'js-cookie'

export default {
  name: 'Tasks',
  props: {
    tasks: Array
  },
  data() {
    return {
      userRole: null,
      checkedTask: null,
      minDate: new Date().toISOString().split('T')[0],
    }
  },
  emits: ['taskEdited'],
  created(){
    this.userRole = Cookies.get('userRole')
  },
  methods: {
    formatDate(date) {
      const formattedDate = new Date(date).toLocaleDateString('pt-BR', {
        day: '2-digit',
        month: 'short',
        year: 'numeric'
      })

      return formattedDate
    },
    async submitFormUpdate() {
      this.checkedTaks.titleValid = this.validateField(this.checkedTaks.title)
      this.checkedTaks.descriptionValid = this.validateField(this.checkedTaks.desc)
      this.checkedTaks.dateValid = this.validateDate(this.checkedTaks.expired_date)
      this.checkedTaks.genericError = false

      if (
        this.checkedTaks.titleValid &&
        this.checkedTaks.descriptionValid &&
        this.checkedTaks.dateValid
      ) {
        const taskData = {
          title: this.checkedTaks.title,
          desc: this.checkedTaks.desc,
          expired_date: this.checkedTaks.expired_date,
          done: this.checkedTaks.done
        }

        const response = await editTask(this.checkedTaks.id, taskData)

        if (response.error) {
          this.checkedTaks.genericError = true
          return
        }

        this.$emit('taskEdited')
      }
    },
    validateField(value) {
      return !!value.trim()
    },
    validateDate(date) {
      if (!date) {
        return false
      }
      return true
    },
    checkTask(index) {
      const task = this.tasks[index]
      this.checkedTaks.id = task.id
      this.checkedTaks.title = task.title
      this.checkedTaks.desc = task.desc
      this.checkedTaks.expired_date = task.expired_date
      this.checkedTaks.done = task.done
    }
  }
}
</script>

<style scoped></style>
