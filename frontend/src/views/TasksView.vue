<template>
  <div class="d-flex myContainer justify-content-evenly">
    <div v-if="this.userRole == 1">
      <h2>Adicionar uma tarefa</h2>
      <NewTask @taskAdded="handleTaskAdded"></NewTask>
    </div>

    <div>
      <h2>Tarefas a fazer</h2>
      <ListTasks :tasksDone="0" :update="updateLists" @tellDad="handleTaskAdded()"></ListTasks>
    </div>
    <div>
      <h2>Tarefas concluidas</h2>
      <ListTasks :tasksDone="1" :update="updateLists" @tellDad="handleTaskAdded()"></ListTasks>
    </div>
  </div>
</template>

<script>
import Tasks from '../components/Tasks.vue'
import ListTasks from '../components/ListTasks.vue'
import NewTask from '@/components/NewTask.vue'
import Cookies from 'js-cookie'

export default {
  name: 'TasksView',
  components: {
    Tasks,
    ListTasks,
    NewTask
  },
  data(){
    return{
      updateLists: false,
      userRole: null,
    }
  },
  created(){
    this.userRole = Cookies.get('userRole')
  },
  methods: {
    handleTaskAdded() {
      this.updateLists = !this.updateLists
    }
  }
}
</script>

<style scoped>
@media screen and (max-width: 750px) {
  .myContainer {
    flex-direction: column !important;
  }
}
</style>
