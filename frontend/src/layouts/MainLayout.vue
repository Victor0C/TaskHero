<template>
  <div class="d-flex flex-column vh-100">
    <header>
      <nav class="navbar navbar-expand-lg navbar-light bg-myGreen">
        <div class="container-fluid">
          <div class="d-flex align-items-center">
            <img
              src="../assets/logoWhite.png"
              alt="Logo"
              class="img-fluid me-2"
              style="max-height: 1.8rem"
            />
            <a class="navbar-brand text-light fs-3 fst-italic">Task Hero</a>
          </div>
          <button
            class="navbar-toggler ms-auto"
            type="button"
            data-bs-toggle="offcanvas"
            data-bs-target="#offcanvasNavbar"
            aria-controls="offcanvasNavbar"
          >
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse d-lg-block" id="navbarNavAltMarkup">
            <ul class="navbar-nav ms-auto">
              <li v-for="(item, index) in filteredMenuItems" :key="index" class="nav-item">
                <router-link
                  :to="item.route"
                  class="nav-link fst-italic fs-5"
                  :class="{
                    'text-light': isRouteActive(item.route),
                    'text-decoration-underline': isRouteActive(item.route)
                  }"
                  >{{ item.text }}</router-link
                >
              </li>
              <li>
                <a class="nav-link fst-italic fs-5" @click="logout">Sair</a>
              </li>
            </ul>
          </div>
        </div>
      </nav>

      <div
        class="offcanvas offcanvas-end"
        style="width: 45%"
        tabindex="-1"
        id="offcanvasNavbar"
        aria-labelledby="offcanvasNavbarLabel"
      >
        <div class="offcanvas-header bg-myGreen">
          <h5 class="offcanvas-title text-light" id="offcanvasNavbarLabel">Menu</h5>
          <button
            type="button"
            class="btn-close text-reset"
            data-bs-dismiss="offcanvas"
            aria-label="Close"
          ></button>
        </div>
        <div class="offcanvas-body">
          <ul class="navbar-nav">
            <li v-for="(item, index) in filteredMenuItems" :key="index" class="nav-item">
              <router-link
                :to="item.route"
                class="nav-link"
                :class="{
                  'text-bold': isRouteActive(item.route),
                  'text-decoration-underline': isRouteActive(item.route),
                  'fs-4': isRouteActive(item.route)
                }"
              >
                <p data-bs-dismiss="offcanvas">{{ item.text }}</p></router-link
              >
            </li>
            <li>
              <a class="nav-link" @click="logout">Sair</a>
            </li>
          </ul>
        </div>
      </div>
    </header>

    <main class="container-fluid flex-grow-1 my-4">
      <router-view></router-view>
    </main>

    <footer class="container-fluid align-items-center py-3 mt-auto bg-myGreen">
      <p class="text-center m-0">© 2024 Victor Hugo Oliveira Cunha</p>
    </footer>
  </div>
</template>

<script>
import Cookies from 'js-cookie'

export default {
  name: 'MainLayout',
  data() {
    return {
      menuItems: [
        { text: 'Tarefas', route: 'tasks', private: false },
        { text: 'Histórico', route: 'historic', private: false },
        { text: 'Usuários', route: 'users', private: true }
      ],
      userRole: null
    }
  },
  computed: {
    filteredMenuItems() {
      return this.menuItems.filter((item) => {
        return !item.private || (item.private && this.userRole == 1)
      })
    }
  },
  methods: {
    isRouteActive(route) {
      return this.$route.name == route
    },
    logout() {
      Cookies.remove('authToken')
      Cookies.remove('userID')
      Cookies.remove('userRole')
      Cookies.remove('isAuthenticated')
      this.$router.push('/login')
    }
  },
  created() {
    this.userRole = Cookies.get('userRole')
  }
}
</script>

<style scoped>
.vh-100 {
  height: 100vh;
}
</style>
