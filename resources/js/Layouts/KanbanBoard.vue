<template>
  <div>
    <Header />
    <main class="mt-3">
      <router-view></router-view>
    </main>
  </div>
</template>

<script>
import Header from "../components/Partials/Header";

export default {
  name: "kanbanboard-layout",
  components: {
    Header,
  }
};
</script>
