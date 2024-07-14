<template>
  <div class="myContainer">
    <div class="d-flex mb-2 gap-1 w-100">
      <form class="w-100">
        <input
          @keyup.enter=""
          type="text"
          v-model="searchQuery"
          placeholder="Pesquisar tarefas..."
          class="form-control"
        />
      </form>
      <button @click="" class="btn myButtonDefault" aria-label="Pesquisar">
        Pesquisar
      </button>
    </div>

    <div v-for="task in tasks" class="accordion w-100" :id="`${typeTasks}Accordion`">
      <Task :task="task"></Task>
    </div>

    <nav v-if="pagination.total_page > 1" aria-label="Page navigation example">
      <ul class="pagination mt-2">
        <li
          v-for="link in pagination.links"
          @click=""
          class="page-item"
          :class="{ active: link.active, disabled: link.url == null }"
        >
          <button class="page-link">
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
    typeTasks: '',
    tasks: [],
    pagination:{}
  },
  components: {
    Task
  },
  data() {
    return {
      pagination: {
        current_page: 1,
        total_page: 1,
        links: []
      }
    }
  }
}
</script>

<style scoped>
.myContainer {
  width: 80rem;
}

@media screen and (max-width: 750px) {
  .myContainer {
    width: 100%;
  }
}
</style>
