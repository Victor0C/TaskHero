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
        </div>
      </nav>
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
export default {
  name: 'MainLayout'
}
</script>

<style scoped>
.vh-100{
  height: 100vh;
}
</style>
