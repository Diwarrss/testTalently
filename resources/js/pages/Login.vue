<template>
  <section class="vh-100">
    <div class="container-fluid h-custom">
      <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col-md-9 col-lg-6 col-xl-5">
          <img
            src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-login-form/draw2.webp"
            class="img-fluid"
            alt="Sample image"
          />
        </div>
        <div class="col-md-8 col-lg-6 col-xl-4 offset-xl-1">
          <form>
            <p class="text-center h1 fw-bold mb-5 mx-1 mx-md-4 mt-4">Sign in</p>
            <!-- Email input -->
            <div class="form-outline mb-4">
              <input
                type="email"
                id="form3Example3"
                class="form-control form-control-lg"
                placeholder="Enter a valid email address"
                v-model="auth.email"
              />
              <label class="form-label" for="form3Example3">
                Email address
              </label>
            </div>

            <!-- Password input -->
            <div class="form-outline mb-3">
              <input
                type="password"
                id="form3Example4"
                class="form-control form-control-lg"
                placeholder="Enter password"
                v-model="auth.password"
              />
              <label class="form-label" for="form3Example4">Password</label>
            </div>

            <div class="text-center text-lg-start mt-4 pt-2">
              <button
                type="button"
                class="btn btn-primary btn-lg"
                style="padding-left: 2.5rem; padding-right: 2.5rem"
                :disabled="processing"
                @click.prevent="login"
              >
                {{ processing ? "Please wait" : "Login" }}
              </button>
              <p class="small fw-bold mt-2 pt-1 mb-0">
                Don't have an account?
                <router-link class="link-danger" :to="{ name: 'register' }">
                  Register Now!</router-link
                >
              </p>
            </div>
          </form>
        </div>
      </div>
    </div>
  </section>
</template>

<script>
import { mapActions } from "vuex";

export default {
  name: "login",
  data() {
    return {
      auth: {
        email: "",
        password: "",
      },
      processing: false,
      errors: {},
    };
  },
  methods: {
    ...mapActions({
      signIn: "auth/login",
    }),
    async login() {
      this.processing = true;
      await axios
        .post("/api/v1/login", this.auth)
        .then(({ data }) => {
          this.$toaster.success("Login successfully");
          this.$store.commit("auth/SET_TOKEN", data.access_token);
          this.signIn();
        })
        .catch(({ response: { data } }) => {
          this.$toaster.error(data.message);
        })
        .finally(() => {
          this.processing = false;
        });
    },
  },
};
</script>
<style lang="scss" scoped>
.divider:after,
.divider:before {
  content: "";
  flex: 1;
  height: 1px;
  background: #eee;
}

.h-custom {
  height: calc(100% - 73px);
}

@media (max-width: 450px) {
  .h-custom {
    height: 100%;
  }
}
</style>
