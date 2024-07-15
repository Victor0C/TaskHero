<template>
  <button
    type="button"
    class="btn btn-danger myButton"
    data-bs-toggle="modal"
    :data-bs-target="`#${task.id}deleteModal`"
  >
    Deletar
  </button>
  <div
    class="modal fade"
    :id="`${task.id}deleteModal`"
    tabindex="-1"
    :aria-labelledby="`#${task.id}deleteModalLabel`"
    aria-hidden="true"
  >
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" :id="`${task.id}deleteModalLabel`">
            Deletar a tarefa "<span class="text-danger">{{ task.title }}</span
            >"
          </h1>
          <button
            type="button"
            class="btn-close"
            data-bs-dismiss="modal"
            aria-label="Close"
          ></button>
        </div>
        <div class="modal-body">
          <p class="fs-5">Tem certeza em deletar a tarefa "{{ task.title }}"?</p>
        </div>
        <div class="modal-footer">
          <button @click="removeTask" type="button" class="btn btn-danger" data-bs-dismiss="modal">
            Deletar
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import deleteTask from '@/service/Tasks/deleteTask.js'

export default {
  name: 'ModalDeleteTask',
  emits: ['refreshList'],
  props: {
    task: {
      type: Object,
      required: true
    }
  },
  methods: {
    async removeTask() {
      const data = await deleteTask(this.task.id)
      if (data.error) {
        alert('Algo deu errado com a deleção da tarefa...')
        return
      }
      this.$emit('refreshList')
    }
  }
}
</script>
