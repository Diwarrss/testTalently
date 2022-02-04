<template>
  <div class="container">
    <div class="card shadow-md">
      <div class="card-header text-center fw-bolder fs-3">Kanban Board</div>
      <div class="card-body">
        <div class="row">
          <div class="col" v-for="status in statuses" :key="status.slug">
            <div class="card shadow bg-body rounded">
              <div class="card-header fw-bolder d-flex justify-content-between">
                <span class="fs-5">
                  {{ status.title }} ({{ status.tasks.length }})
                </span>
                <button
                  type="button"
                  class="btn btn-primary"
                  @click.prevent="openAddTaskForm(status.id)"
                >
                  Add one
                </button>
              </div>
              <AddTaskForm
                v-if="newTaskForStatus === status.id"
                :status-id="status.id"
                v-on:task-added="handleTaskAdded"
                v-on:task-canceled="closeAddTaskForm"
              />
              <!-- Tasks -->
              <draggable
                class="overflow-hidden"
                v-model="status.tasks"
                v-bind="taskDragOptions"
                @end="handleTaskMoved"
              >
                <transition-group>
                  <div
                    class="card-body card-draggable"
                    v-for="task in status.tasks"
                    :key="task.id"
                    @click.prevent="openEditTaskForm(task)"
                  >
                    <div class="card">
                      <div class="card-body">
                        <h5
                          class="card-title mb-0"
                          :class="{
                            'text-danger': validateDate(task.date_delivery),
                          }"
                        >
                          {{ task.title }}
                        </h5>
                      </div>
                    </div>
                  </div>
                  <!-- ./Tasks -->
                </transition-group>
              </draggable>
              <!-- ./Tasks -->
              <!-- No Tasks -->
              <div
                class="card-body"
                v-if="!status.tasks.length && newTaskForStatus !== status.id"
              >
                <div class="card">
                  <div class="card-body">
                    <div class="row d-flex justify-content-center">
                      <h5 class="card-title text-center text-warning mb-0">
                        No tasks yet
                      </h5>
                    </div>
                  </div>
                </div>
              </div>
              <!-- ./No Tasks -->
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import moment from "moment";
import AddTaskForm from "../components/AddTaskForm";
import draggable from "vuedraggable";

export default {
  name: "KanbanBoard",
  components: { AddTaskForm, draggable },
  data() {
    return {
      user: this.$store.state.auth.user,
      newTaskForStatus: null,
      editTaskForStatus: null,
      statuses: [],
    };
  },
  computed: {
    taskDragOptions() {
      return {
        animation: 200,
        group: "task-list",
        dragClass: "status-drag",
      };
    },
    taskInitials() {
      /**Get task for get movedTask */
      let allTasks = [];
      this.statuses.map((st) => {
        return st.tasks.map((task) => {
          return allTasks.push(`${st.slug}-${st.id}-${task.id}-${task.order}`);
        });
      });

      return allTasks;
    },
  },
  created() {
    window.axios.defaults.headers.common[
      "Authorization"
    ] = `Bearer ${this.$store.state.auth.token}`;
    this.getStatuses();
  },
  watch: {
    taskInitials: function (newVal, oldVal) {
      /**Return moved task*/
      let old = oldVal;
      let yung = newVal;
      let movedTask = yung.filter((y) => !old.includes(y));

      if (movedTask.length) this.handleTaskMoved(movedTask[0]);
    },
  },
  methods: {
    async getStatuses() {
      await axios
        .get("/api/v1/statuses")
        .then(({ data }) => {
          this.statuses = data;
          this.$store.commit("status/SET_STATUSES", data);
        })
        .catch(({ response: { data } }) => {
          this.$toaster.error(data.message);
        });
    },
    validateDate(date_delivery) {
      let todayDate = moment().format("YYYY-MM-DD");
      moment(date_delivery);
      return date_delivery < todayDate;
    },
    openAddTaskForm(statusId) {
      this.newTaskForStatus = statusId;
      this.$store.commit("task/SET_TASK", null);
    },
    openEditTaskForm(task) {
      this.newTaskForStatus = task.status_id;
      this.$store.commit("task/SET_TASK", task);
    },
    closeAddTaskForm() {
      this.newTaskForStatus = null;
      this.$store.commit("task/SET_TASK", null);
    },
    handleTaskAdded(newTask, edit = false) {
      // Find the index of the status where we should add the task
      const statusIndex = this.statuses.findIndex(
        (status) => status.id === newTask.status_id
      );
      if (edit) {
        // Find the index of the task where we should edit the task
        const index = this.statuses[statusIndex].tasks.findIndex(
          (e) => e.id === newTask.id
        );

        if (index !== -1) {
          this.statuses[statusIndex].tasks[index] = newTask;
        }
      } else {
        // Add newly created task to our column
        this.statuses[statusIndex].tasks.push(newTask);
      }
      // Reset and close the AddTaskForm
      this.closeAddTaskForm();
    },
    handleTaskMoved(movedTask = null) {
      // Send the moved task to the server
      if (movedTask.length) {
        if (movedTask.includes("done"))
          this.$toaster.success("Felicitaciones por lograrlo!");

        axios
          .put("/api/v1/tasks/sync", { movedTask: movedTask })
          .then(({ data }) => {
            this.$store.commit("status/SET_STATUSES", data.tasks);
          })
          .catch((err) => {
            this.$toaster.error(err.response);
            console.log(err.response);
          });
      }
    },
  },
};
</script>
<style scoped>
.status-drag {
  transition: transform 0.5s;
  transition-property: all;
}
.card-draggable {
  cursor: move;
}
</style>
