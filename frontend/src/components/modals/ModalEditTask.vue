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
            Editar a tarefa de {{ task.title }}
          </h1>
          <button
            type="button"
            class="btn-close"
            data-bs-dismiss="modal"
            aria-label="Close"
          ></button>
        </div>
        <div class="modal-body">
          <h1>Corpo do modal de edição de tarefa</h1>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn myButtonDefault" data-bs-dismiss="modal">Confirmar</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'ModalEditTask',
  emits: ['taskUpdated'],
  props: {
    task: null
  }
}
</script>
