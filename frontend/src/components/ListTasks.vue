<template>
  <div class="d-flex flex-column align-items-center myContainer">
    <div class="d-flex mb-2 gap-1 w-100">
      <form @submit.prevent class="w-100">
        <input
          @keyup.enter="searchtasks"
          type="text"
          v-model="searchQuery"
          placeholder="Pesquisar tarefas..."
          class="form-control"
        />
      </form>
      <button @click="searchtasks" class="btn myButtonDefault" aria-label="Pesquisar">
        Pesquisar
      </button>
    </div>

    <div v-if="tasks.length == 0 && !loading" class="alert alert-warning" role="alert">
      Nenhuma tarefa encontrada...
    </div>

    <div class="accordion w-100" :id="`CompletedTask=${completedTasks}Accordion`">
      <Task v-for="task in tasks" :task="task" :completedTask="completedTasks" @refreshList='refreshList'></Task>
    </div>

    <nav v-if="pagination.total_page > 1" aria-label="Page navigation example">
      <ul class="pagination mt-2">
        <li
          v-for="link in pagination.links"
          :key="link.label"
          @click="fetchPage(link.url)"
          class="page-item"
          :class="{ active: link.active, disabled: link.url == null }"
        >
          <button class="page-link custom-pagination-button">
            {{
              link.label.includes('Previous')
                ? 'Anterior'
                : link.label.includes('Next')
                  ? 'Próximo'
                  : link.label
            }}
          </button>
        </li>
      </ul>
    </nav>
  </div>
</template>

<script>
import Task from './Task.vue'
export default {
  name: 'ListTasks',
  props: {
    completedTasks: { type: Boolean, required: true },
    tasks: { type: Array, required: true },
    pagination: { type: Object, required: true },
    loading: { type: Boolean, required: true }
  },
  components: {
    Task
  },
  emits: ['searchTasks', 'fetchPage', 'refreshList'],
  data() {
    return {
      searchQuery: ''
    }
  },
  methods: {
    searchtasks() {
      this.$emit('searchTasks', this.searchQuery)
    },
    fetchPage(url) {
      this.$emit('fetchPage', url)
    },
    refreshList(){
      this.$emit('refreshList')
    }
  }
}
</script>

<style scoped>
.myContainer {
  width: 80rem;
}

.custom-pagination-button {
  background-color: rgba(4, 223, 66, 0.807);
  color: #fff;
  border: 1px solid rgba(0, 0, 0, 0.125);
}

.custom-pagination-button:hover {
  background-color: rgba(4, 223, 66, 0.9);
}

.custom-pagination-button:focus,
.custom-pagination-button:active {
  background-color: rgba(4, 223, 66, 0.807);
  box-shadow: 0 0 0 0.2rem rgba(4, 223, 66, 0.25);
}

.page-item.active .custom-pagination-button {
  background-color: rgb(0, 0, 0);
  border-color: rgb(0, 0, 0);
  color: #fff;
}

.page-item.disabled .custom-pagination-button {
  background-color: #7f8081;
  border-color: #7f8081;
  color: #fff;
}

@media screen and (max-width: 750px) {
  .myContainer {
    width: 100%;
  }
}
</style>
