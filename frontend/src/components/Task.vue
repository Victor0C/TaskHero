<template>
  <div class="accordion-item">
    <h2 class="accordion-header">
      <button
        class="accordion-button collapsed"
        type="button"
        data-bs-toggle="collapse"
        :data-bs-target="`#${task.id}taskAccordion`"
        aria-expanded="true"
        aria-controls="collapseOne"
      >
        <div class="d-flex justify-content-between align-items-center w-100 me-2">
          {{ task.title }}
          <small class="text-muted ms-2">Conclusão para {{ formatDate(task.expired_date) }}</small>
        </div>
      </button>
    </h2>
    <div
      :id="`${this.task.id}taskAccordion`"
      class="accordion-collapse collapse"
      :data-bs-parent="`#CompletedTask=${completedTask}Accordion`"
    >
      <div class="accordion-body d-flex">
        <p><span class="fw-semibold"></span>{{ task.desc }}</p>
        <div class="d-flex gap-1 ms-auto justify-content-end">
          <ModalEditTask v-if="!completedTask" @refreshList="refreshList" :task="task"></ModalEditTask>
          <ModalDeleteTask v-if="!completedTask" @refreshList="refreshList" :task="task"></ModalDeleteTask>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import ModalEditTask from './modals/ModalEditTask.vue'
import ModalDeleteTask from './modals/ModalDeleteTask.vue'

export default {
  name: 'Task',
  emits: ['refreshList'],
  props: {
    task: {
      type: Object,
      required: true
    },
    completedTask:{
      type:Boolean,
      required: true
    }
  },
  components: {
    ModalEditTask,
    ModalDeleteTask
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
    refreshList(){
      this.$emit('refreshList')
    }
  }
}
</script>
