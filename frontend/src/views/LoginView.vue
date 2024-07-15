<template>
  <div class="container-fluid d-flex justify-content-center h-100">
    <form @submit.prevent="submitForm" class="w-75 my-forms">
      <div class="mb-3">
        <label for="email1" class="form-label">Email</label>
        <input
          v-model="email"
          type="email"
          class="form-control"
          :class="{ 'is-invalid': emailError }"
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
          :class="{ 'is-invalid': passwordError }"
          id="Password1"
          placeholder="******"
        />
        <small v-if="!passwordValid" class="text-danger">Por favor, insira uma senha válida.</small>
      </div>
      <div v-if="credentialsError" class="alert alert-danger" role="alert">
        Credenciais incorretas...
      </div>
      <div v-if="genericError" class="alert alert-danger" role="alert">
        Algo deu errado... Tente novamente mais tarde.
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
      passwordValid: true,
      emailError: false,
      passwordError: false,
      credentialsError: false,
      genericError: false
    }
  },
  methods: {
    async submitForm() {
      this.emailValid = this.validateEmail()
      this.passwordValid = this.validatePassword()
      this.credentialsError = false
      this.genericError = false

      if (this.emailValid && this.passwordValid) {
        const response = await login(this.email, this.password)

        if (response.error) {
          response.error == 401 ? (this.credentialsError = true) : (this.genericError = true)
          return
        }

      
        this.$router.push('/tasks');

        this.email = ''
        this.password = ''
      }
    },
    validateEmail() {
      if (/\S+@\S+\.\S+/.test(this.email)) {
        return true
      }

      this.emailError = true

      return false
    },
    validatePassword() {
      if (this.password.length <= 0) {
        this.passwordError = true
        return false
      }

      return true
    }
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
