<template>
  <div class="d-flex flex-column vh-100">
    <header>
      <nav class="navbar navbar-expand-lg navbar-light bg-myGreen">
        <div class="container-fluid">
          <a class="navbar-brand">Task Hero</a>
        </div>
      </nav>
    </header>

    <main class="container-fluid">
      <router-view></router-view>
    </main>

    <footer class="container-fluid align-items-center py-3 mt-auto bg-myGreen">
        <p class="text-center m-0">© 2024 Victor Hugo Oliveira Cunha</p>
    </footer>
  </div>
</template>

<script>
export default {
  name: 'MainLayout'
}
</script>

<style scoped>
.vh-100{
  height: 100vh;
}
</style>
