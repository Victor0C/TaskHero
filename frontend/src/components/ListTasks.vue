<template>
  <div class="myContainer">
    <form @submit.prevent="applySearchFilter" class="mb-3 input-group">
      <input
        type="text"
        v-model="searchQuery"
        placeholder="Pesquisar tarefas..."
        class="form-control"
      />
      <button type="submit" class="btn btn-sm btn-primary ms-2" aria-label="Pesquisar">
        Pesquisar
      </button>
    </form>

    <Tasks @taskEdited='fetchTasks()' :tasks="filteredTasks"></Tasks>

    <nav aria-label="Page navigation example" class="d-flex justify-content-center">
      <ul class="pagination mt-4">
        <li v-for="(link, index) in pagination.links" :key="index" class="page-item">
          <a
            class="page-link"
            href="#"
            v-if="link.url"
            @click.prevent="pageTasks(link.url)"
            :class="{ active: link.active }"
          >
            {{
              link.label.includes('Next')
                ? 'Próximo'
                : link.label.includes('Previous')
                  ? 'Anterior'
                  : link.label
            }}
          </a>
          <span class="page-link" v-else>
            {{
              link.label.includes('Next')
                ? 'Próximo'
                : link.label.includes('Previous')
                  ? 'Anterior'
                  : link.label
            }}
          </span>
        </li>
      </ul>
    </nav>
  </div>
</template>

<script>
import Tasks from './Tasks.vue'
import getPageTasks from '../service/getPageTasks.js'
import getTasks from '../service/tasks.js'

export default {
  name: 'ListTasks',
  props: {
    tasksDone: Number,
    update: Boolean
  },
  components: {
    Tasks
  },
  data() {
    return {
      filteredTasks: [],
      searchQuery: '',
      pagination: {}
    }
  },
  emits: ['taskEdited'],
  methods: {
    async fetchTasks() {
      const params = {
        done: this.tasksDone,
        title: this.searchQuery.trim()
      }
      const response = await getTasks(params)
      this.filteredTasks = response.data
      this.pagination = response
    },
    async pageTasks(url) {
      const response = await getPageTasks(url)
      this.filteredTasks = response.data
      this.pagination = response
    },
    applySearchFilter() {
      this.fetchTasks()
    },
    tellDad(){
      this.$emit('taskEdited')
    }

  },
  created() {
    this.fetchTasks()

    this.$watch('update', (newValue, oldValue) => {
      if (newValue !== oldValue) {
        this.fetchTasks()
      }
    })
  },
}
</script>


<style scoped>
.myContainer {
  width: 40rem;
}

@media screen and (max-width: 750px) {
  .myContainer {
    width: 100%;
  }
}
</style>
