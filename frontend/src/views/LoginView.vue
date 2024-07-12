<template>
  <div class="container-fluid d-flex justify-content-center h-100">
    <form @submit.prevent="submitForm" class="w-75 my-forms">
      <div class="mb-3">
        <label for="email1" class="form-label">Email</label>
        <input
          v-model="email"
          type="email"
          class="form-control"
          id="email1"
          aria-describedby="emailHelp"
          placeholder="email@exemplo.com"
        />
        <small v-if="!emailValid" class="text-danger">Por favor, insira um email válido.</small>
      </div>
      <div class="mb-3">
        <label for="Password1" class="form-label">Senha</label>
        <input
          v-model="password"
          type="password"
          class="form-control"
          id="Password1"
          placeholder="******"
        />
        <small v-if="!passwordValid" class="text-danger">Por favor, insira uma senha válida.</small>
      </div>
      <div class="d-flex justify-content-center">
        <button type="submit" class="btn bg-myButton rounded-2">Entrar</button>
      </div>
    </form>
  </div>
</template>

<script>
import login from '../service/login.js'


export default {
  name: 'LoginForm',
  data() {
    return {
      email: '',
      password: '',
      emailValid: true,
      passwordValid: true
    }
  },
  methods: {
    async submitForm() {
      this.emailValid = this.validateEmail()
      this.passwordValid = this.validatePassword()


      if (this.emailValid && this.passwordValid) {

        const response = await login(this.email, this.password)

        localStorage.setItem('token', response.token);

        this.email = ''
        this.password = ''
      }
    },
    validateEmail() {
      return /\S+@\S+\.\S+/.test(this.email)
    },
    validatePassword() {
      return this.password.length > 0
    },
  }
}
</script>

<style>
.my-forms {
  margin-top: 5rem;
}

.bg-myButton {
  background-color: rgba(6, 240, 72, 0.807);
  width: 15rem;
  height: 2.5rem;
  border: none;
  transition: transform 0.1s ease-in-out;
}

.bg-myButton:hover,
.bg-myButton:active {
  background-color: rgba(6, 240, 72, 0.807);
  color: white;
  border: none;
  box-shadow: none;
}

.bg-myButton:active {
  transform: scale(0.95);
}
</style>
