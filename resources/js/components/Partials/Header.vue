<template>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">Test Talently</a>
      <button
        class="navbar-toggler"
        type="button"
        data-bs-toggle="collapse"
        data-bs-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent"
        aria-expanded="false"
        aria-label="Toggle navigation"
      >
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <router-link :to="{ name: 'kanbanboard' }" class="nav-link active">
              Kanban Board
            </router-link>
          </li>
        </ul>
        <form class="d-flex">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item dropdown">
              <a
                class="nav-link dropdown-toggle"
                href="#"
                id="navbarDropdown"
                role="button"
                data-bs-toggle="dropdown"
                aria-expanded="false"
              >
                {{ user.name }}
              </a>
              <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                <li>
                  <a
                    class="dropdown-item"
                    href="javascript:void(0)"
                    @click.prevent="logout"
                  >
                    Logout
                  </a>
                </li>
              </ul>
            </li>
          </ul>
        </form>
      </div>
    </div>
  </nav>
</template>

<script>
import { mapActions } from "vuex";

export default {
  name: "Header",
  data() {
    return {
      user: this.$store.state.auth.user,
    };
  },
  mounted() {
    window.axios.defaults.headers.common[
      "Authorization"
    ] = `Bearer ${this.$store.state.auth.token}`;
  },
  methods: {
    ...mapActions({
      signOut: "auth/logout",
    }),
    async logout() {
      await axios
        .post("/api/v1/logout", { email: this.user.email })
        .then(({ data }) => {
          this.$toaster.success(data.message);
          this.signOut();
          this.$store.commit("status/SET_STATUSES", []);
          this.$router.push({ name: "login" });
        });
    },
  },
};
</script>
