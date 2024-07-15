<template>
  <div class="d-flex justify-content-center">
    <form @submit.prevent="submitForm" class="myContainer">
      <div class="mb-3">
        <label for="userSelect" class="form-label">Usuário</label>
        <select v-model="selectedUser" class="form-select" id="userSelect">
          <option v-for="user in users" :key="user.id" :value="user.id">{{ user.name }}</option>
        </select>
      </div>
      <div class="mb-3">
        <label for="titleInput" class="form-label">Título</label>
        <input
          v-model="title"
          type="text"
          maxlength="30"
          class="form-control"
          :class="{ 'is-invalid': !titleValid }"
          id="titleInput"
          placeholder="Insira o título da tarefa"
        />
        <small v-if="!titleValid" class="text-danger">Por favor, insira um título.</small>
      </div>
      <div class="mb-3">
        <label for="descriptionInput" class="form-label">Descrição</label>
        <input
          v-model="description"
          type="text"
          maxlength="150"
          class="form-control"
          :class="{ 'is-invalid': !descriptionValid }"
          id="descriptionInput"
          placeholder="Insira a descrição da tarefa"
        />
        <small v-if="!descriptionValid" class="text-danger">Por favor, insira uma descrição.</small>
      </div>
      <div class="mb-3">
        <label for="dateInput" class="form-label">Data de Conclusão</label>
        <input
          v-model="dueDate"
          type="date"
          class="form-control"
          :class="{ 'is-invalid': !dateValid }"
          id="dateInput"
          :min="minDate"
        />
        <small v-if="!dateValid" class="text-danger"
          >Por favor, insira uma data válida a partir de hoje.</small
        >
      </div>
      <div v-if="genericError" class="alert alert-danger" role="alert">
        Algo deu errado... Tente novamente mais tarde.
      </div>
      <div class="d-flex justify-content-center">
        <button type="submit" class="btn myButtonDefault addButton rounded-2">
          Adicionar Tarefa
        </button>
      </div>
    </form>
  </div>
</template>

<script>
import addTask from '@/service/Tasks/addTasks'
import getUsers from '@/service/Users/getUsers'

export default {
  name: 'NewTask',
  data() {
    return {
      selectedUser: null,
      title: '',
      description: '',
      dueDate: '',
      titleValid: true,
      descriptionValid: true,
      dateValid: true,
      genericError: false,
      users: []
    }
  },
  computed: {
    minDate() {
      const today = new Date().toISOString().split('T')[0]
      return today
    }
  },
  created() {
    this.getAllUsers()
  },
  methods: {
    async submitForm() {
      this.titleValid = this.validateField(this.title)
      this.descriptionValid = this.validateField(this.description)
      this.dateValid = this.validateDate(this.dueDate)
      this.genericError = false

      if (this.titleValid && this.descriptionValid && this.dateValid) {
        const taskData = {
          user_id: this.selectedUser,
          title: this.title,
          desc: this.description,
          expired_date: this.dueDate,
          done: false
        }

        const response = await addTask(taskData)

        if (response.error) {
          this.genericError = true
          return
        }

        this.$emit('taskAdded')
        this.title = ''
        this.description = ''
        this.dueDate = ''
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
    async getAllUsers() {
      const usersData = await getUsers()
      if (!usersData.erro) {
        this.users = usersData
        this.selectedUser = usersData[0].id
      }
    }
  }
}
</script>

<style scoped>
.addButton {
  width: 15rem;
  height: 2.5rem;
}

.myContainer {
  width: 25rem;
}

@media screen and (max-width: 750px) {
  .myContainer {
    width: 100%;
    margin-bottom: 3rem;
  }
}
</style>
