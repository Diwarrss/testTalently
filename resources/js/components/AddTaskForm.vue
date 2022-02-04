<template>
  <div class="card-body">
    <div class="card">
      <div class="card-body">
        <form>
          <div class="mb-3">
            <label for="dateDelivery" class="form-label">Enter a title</label>
            <input
              type="text"
              class="form-control"
              id="inputTitle"
              v-model.trim="newTask.title"
            />
          </div>
          <div class="mb-3">
            <label for="dateDelivery" class="form-label">
              Enter a date of delivery
            </label>
            <input
              type="date"
              class="form-control"
              id="dateDelivery"
              v-model="newTask.date_delivery"
            />
          </div>
          <div class="alert alert-danger" role="alert" v-show="errorMessage">
            {{ errorMessage }}
          </div>
          <button @click="$emit('task-canceled')" class="btn btn-danger">
            Cancel
          </button>
          <button
            v-if="!editForm"
            type="button"
            class="btn btn-primary"
            @click.prevent="handleAddNewTask"
          >
            Add
          </button>
          <button
            v-else
            type="button"
            class="btn btn-primary"
            @click.prevent="handleUpdateTask"
          >
            Update
          </button>
        </form>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  name: "AddTaskForm",
  props: {
    statusId: Number,
  },
  data() {
    return {
      newTask: {
        id: null,
        title: "",
        date_delivery: null,
        order: 0,
        status_id: null,
      },
      errorMessage: "",
    };
  },
  computed: {
    editForm() {
      return !!this.$store.state.task.task;
    },
  },
  mounted() {
    this.newTask.status_id = this.statusId;
    if (this.editForm) {
      this.newTask.id = this.$store.state.task.task.id;
      this.newTask.title = this.$store.state.task.task.title;
      this.newTask.date_delivery = this.$store.state.task.task.date_delivery;
      this.newTask.order = this.$store.state.task.task.order;
      this.newTask.status_id = this.$store.state.task.task.status_id;
    }
  },
  methods: {
    handleAddNewTask() {
      // Basic validation so we don't send an empty task to the server
      if (!this.newTask.title) {
        this.errorMessage = "The title field is required";
        return;
      }
      // Send new task to server
      axios
        .post("/api/v1/tasks", this.newTask)
        .then((res) => {
          this.$toaster.success("Task add successfully");
          // Tell the parent component we've added a new task and include it
          this.$emit("task-added", res.data);
        })
        .catch((err) => {
          // Handle the error returned from our request
          this.handleErrors(err);
        });
    },
    handleUpdateTask() {
      // Basic validation so we don't send an empty task to the server
      if (!this.newTask.title) {
        this.errorMessage = "The title field is required";
        return;
      }
      // Send new task to server
      axios
        .put(`/api/v1/tasks/${this.newTask.id}`, this.newTask)
        .then(({ data }) => {
          this.$toaster.success(data.msg);
          this.$emit("task-added", data.task, true);
          this.$emit("task-canceled");
        })
        .catch((err) => {
          // Handle the error returned from our request
          this.handleErrors(err);
        });
    },
    handleErrors(err) {
      if (err.response && err.response.status === 422) {
        // We have a validation error
        const errorBag = err.response.data.errors;
        if (errorBag.title) {
          this.errorMessage = errorBag.title[0];
        } else if (errorBag.date_delivery) {
          this.errorMessage = errorBag.date_delivery[0];
        } else {
          this.errorMessage = err.response.message;
        }
      } else {
        // We have bigger problems
        console.log(err.response);
      }
    },
  },
};
</script>
