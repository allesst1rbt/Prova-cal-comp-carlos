<template>
  <div>
    <b-navbar toggleable="sm" type="dark" variant="dark">
      <b-navbar-toggle target="nav-text-collapse"></b-navbar-toggle>

      <b-navbar-brand>
        <router-link class="link" :to="{ path: '/' }">Prova</router-link>
      </b-navbar-brand>

      <b-collapse id="nav-text-collapse" is-nav>
        <b-navbar-nav>
          <b-nav-item>
            <router-link class="link" :to="{ path: '/dqcmodels' }"
              >DqcModels</router-link
            >
          </b-nav-item>
          <b-nav-item>
            <router-link class="link" :to="{ path: '/dqc84' }"
              >Dqc84</router-link
            >
          </b-nav-item>
          <b-nav-item>
            <router-link class="link" :to="{ path: '/dqc841' }"
              >Dqc841</router-link
            >
          </b-nav-item>
          <b-nav-item>
            <router-link class="link" :to="{ path: '/report' }"
              >Report</router-link
            >
          </b-nav-item>
        </b-navbar-nav>
      </b-collapse>
    </b-navbar>
  </div>
</template>
<script>
export default {
  name: "NavBar",
};
</script>
<style scoped>
.link {
  text-decoration: none;
  color: aliceblue;
}
</style>
