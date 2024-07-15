<template>
    <div class="d-flex justify-content-evenly">
  
      <ListTasks
        :tasks="listTasks.tasks"
        :completedTasks="true"
        :pagination="listTasks.pagination"
        :loading="loading"
        @searchTasks="searchTasks"
        @fetchPage="fetchPage"
        @refreshList="fetchTasks"
      ></ListTasks>
    </div>
  </template>
  
  <script>
  import Task from '../components/Task.vue'
  import ListTasks from '../components/ListTasks.vue'
  import NewTask from '@/components/NewTask.vue'
  import getTasks from '@/service/getTasks'
  import getPageTasks from '@/service/getPageTasks'
  
  export default {
    name: 'HistoricView',
    components: {
      Task,
      ListTasks,
      NewTask
    },
    data() {
      return {
        listTasks: {
          tasks: [],
          pagination: {
            current_page: 1,
            total_page: 1,
            links: []
          }
        },
        searchQuery: '',
        loading: true
      }
    },
    created() {
      this.fetchTasks()
    },
    methods: {
      async fetchTasks() {
        this.loading = true
        const data = await getTasks(this.searchQuery, 1)
  
        if (data.error) {
          alert('Algo deu errado com a busca da lista de tarefas...')
          return
        }
  
        this.fillDatas(data)
        this.loading = false
      },
      searchTasks(searchQuery) {
        this.searchQuery = searchQuery
        this.fetchTasks()
      },
      async fetchPage(url) {
        this.loading = true
        const data = await getPageTasks(url)
  
        if (data.error) {
          alert('Algo deu errado com a busca da lista de tarefas...')
          return
        }
  
        this.fillDatas(data)
        this.loading = false
      },
      fillDatas(data) {
        this.listTasks.tasks = data.data
        this.listTasks.pagination.links = data.links
        this.listTasks.pagination.current_page = data.current_page
        this.listTasks.pagination.total_page = data.last_page
      }
    }
  }
  </script>