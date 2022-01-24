<template>
  <div>
    <h1 class="mt-5" v-if="tableName">{{ tableName }}</h1>

    <p v-if="error">{{ error }}</p>

    <div class="side-and-content">
      <!-- EditTables -------------------------------------------------- -->
      <div class="side">
        <h3>Edit Tables</h3>
        <nav class="text-center nav-masthead justify-content-center">
          <a class="nav-link text-white-50" @click="EditReactions">Reactions</a>
          <a class="nav-link text-white-50" @click="EditEvaluations"
            >Evaluations</a
          >
          <a class="nav-link text-white-50" @click="EditTaskContents"
            >Task Contents</a
          >
          <a class="nav-link text-white-50" @click="EditTasks">Tasks</a>
        </nav>
      </div>

      <!-- Editors ----------------------------------------------------------->
      <template v-if="tableName === 'Tasks'">
        <task-editor />
      </template>

      <template v-else>
        <!-- Contents -------------------------------------------------- -->
        <div class="content">
          <i @click="openModal(-1)" class="fas fa-plus pull-right" />
          <table class="table table-dark table-striped text-left">
            <thead>
              <tr>
                <template v-for="(value, key) in table[0]">
                  <th scope="col">{{ key }}</th>
                </template>
              </tr>
            </thead>

            <tbody id="tasksTable">
              <template v-for="(row, index) in table">
                <tr>
                  <template v-for="(data, key) in row">
                    <td v-if="!key.endsWith('_id')">{{ data }}</td>
                    <td v-else>{{ data + ": " + subFind(data) }}</td>
                  </template>
                  <td>
                    <div class="pull-right">
                      <i @click="openModal(index)" class="fas fa-trash" />
                      <i @click="openModal(index)" class="fas fa-pen-alt" />
                    </div>
                  </td>
                </tr>
              </template>
            </tbody>
          </table>
        </div>

        <!-- Modal -------------------------------------------------- -->
        <overlay-modal @close="closeModal" v-if="modal">
          <p class="modal-p">Vue.js Modal Window!</p>
          <template v-for="(value, key) in table[selectedRow]" ::key="key">
            <div class="mt-3 form-group row">
              <span class="col-sm-2 col-form-label text-left">{{ key }}</span>

              <div class="col-sm-10" v-if="key === 'id'">
                <input
                  type="text"
                  readonly
                  class="form-control-plaintext"
                  v-model="table[selectedRow][key]"
                  :placeholder="'enter ' + key"
                />
              </div>
              <div class="col-sm-10" v-else-if="key === 'evaluation_id'">
                <select class="form-control" v-model="table[selectedRow][key]">
                  <option
                    v-for="item in sub"
                    v-bind:value="item.id"
                    v-bind:key="item.id"
                    :selected="value"
                  >
                    {{ item.id + ": " + item.evaluation }}
                  </option>
                </select>
              </div>
              <div class="col-sm-10" v-else>
                <input
                  type="text"
                  class="form-control"
                  v-model="table[selectedRow][key]"
                  :placeholder="'enter ' + key"
                />
              </div> 
            </div>
          </template>
          <template slot="footer">
            <button class="form-control" @click="doSend">Submit</button>
          </template>
        </overlay-modal>
      </template>
    </div>
  </div>
</template>

<script>
import Vue from "vue";
import TaskEditor from "./TaskEditor.vue";
import { Datetime } from "vue-datetime";
import { Luxon } from 'luxon';
import "vue-datetime/dist/vue-datetime.css";

Vue.component('datetime', Datetime);
Vue.component("overlay-modal", require("./OverlayModal.vue").default);
export default {
  components: { TaskEditor },
  data() {
    return {
      sub: null,
      table: null,
      error: null,
      modal: false,
      tableName: null,
      selectedRow: 0,
    };
  },
  mounted() {
    this.tableName = "AdminEditor";
    axios
      .get("/GetTable")
      .then((response) => {
        this.table = response.data;
        console.log(response.data);
        console.log(this.title);
      })
      .catch((error) => (this.error = error));
  },
  computed: {
    subFind() {
      return (key) => {
        console.log("this.sub.find((v) => v.id === key) ?? ");
        console.log(key);
        console.log(this.sub.find((v) => v.id === key) ?? "");
        return this.sub.find((v) => v.id === key).evaluation ?? "";
      };
    },
  },
  methods: {
    openModal(i) {
      /* Create */
      if (i == -1) {
        /* 新しい行（ここ、axiosリクエスト、サーバーでUpSertNewIDでCreate、レスポンスで同じ処理にできた説 */
        var newid = this.table.length;
        this.table[newid] = JSON.parse(JSON.stringify(this.table[0]));
        Object.keys(this.table[newid]).forEach((key) => {
          if (key.endsWith("_id")) {
            this.table[newid][key] = 1;
          } else {
            this.table[newid][key] = null;
          }
        });
        this.table[newid].id = newid + 1;
        console.log(this.table);
        this.selectedRow = newid;
        console.log("newid=" + newid);
        console.log("selectedRow=" + this.selectedRow);
        console.log(this.table[this.selectedRow]);
      } else {
        /* Update */
        this.selectedRow = i;
      }
      this.modal = true;
    },
    closeModal() {
      this.modal = false;
      this.GetTable(this.tableName);
    },

    /* Submit */
    doSend() {
      /* Validationlはサーバーでやりたいが */

      const row = this.table[this.selectedRow];

      console.log("dosend");
      console.log(row);

      axios
        .post("/PostTable", {
          rowData: row,
          tableName: this.tableName,
        })
        .then((response) => {
          console.log(response);
          this.table = response.data.table;
          this.sub = response.data.sub[0];
          this.error = null;
        })
        .catch((error) => (this.error = error));

      this.closeModal();
    },

    EditReactions() {
      this.GetTable("Reactions");
    },
    EditEvaluations() {
      this.GetTable("Evaluations");
    },
    EditTaskContents() {
      this.GetTable("TaskContents");
    },
    EditTasks() {
      this.tableName = "Tasks";
    },

    GetTable(t) {
      this.tableName = t;
      console.log("/Get" + t + "Table");
      axios
        .get("/Get" + t + "Table")
        .then((response) => {
          console.log(response);
          this.table = response.data.table;
          this.sub = response.data.sub[0];
          this.error = null;
        })
        .catch((error) => (this.error = error));
    },

    GetCurrentTable() {
      console.log("/Get" + this.tableName + "Table");
      axios
        .get("/Get" + this.tableName + "Table")
        .then((response) => {
          console.log(response);
          this.table = response.data.table;
          this.sub = response.data.sub[0];
          this.error = null;
        })
        .catch((error) => (this.error = error));
    },
  },
};

// const vue = new Vue({
//     el: '#Reminder',
// });

// Vue.createApp(tasksTable).mount("#Reminder");

/* test */
// const app = new Vue({
//     el: "#app",
//     data: {
//         date: "",
//         time: "",
//     },

//     mounted: function () {
//         this.updateList();
//     },

//     methods: {
//         updateList() {
//             this.time = getRandomInt(100, 200);
//             addContent();
//             clearInterval(timerID);
//             timerID = setInterval(this.updateList, getRandomInt(intervalMin, intervalMax));
//         },
//     },
// });

// const intervalMax = 5000;
// const intervalMin = 100;
// var contents = 0;
// var timerID = 0;

// function getRandomInt(min, max) {
//   min = Math.ceil(min);
//   max = Math.floor(max);
//   return Math.floor(Math.random() * (max - min) + min);
// }
</script>