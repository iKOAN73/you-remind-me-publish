<template>
  <div>
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
                <td v-if="!key.endsWith('_id') || key === 'user_task_id'">
                  {{ data }}
                </td>
                <td v-else>{{ `${data}: ${subFind([data, key])}` }}</td>
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
      <!-- <p class="modal-p">Edit</p> -->
      <template v-for="(value, key) in table[selectedRow]" ::key="key">
        <div class="mt-3 form-group row">
          <span class="col-sm-2 col-form-label text-left">{{ key }}</span>

          <div class="col-sm-10" v-if="key === 'id' || key === 'user_task_id'">
            <input
              type="text"
              readonly
              class="form-control-plaintext"
              v-model="table[selectedRow][key]"
              :placeholder="'enter ' + key"
            />
          </div>
          <div class="col-sm-10" v-else-if="key === 'user_id'">
            <select class="form-control" v-model="table[selectedRow][key]">
              <option
                v-for="item in sub.InstantUser"
                v-bind:value="item.id"
                v-bind:key="item.id"
                :selected="value"
              >
                {{ item.id + ": " + item.name }}
              </option>
            </select>
          </div>
          <div class="" v-else-if="key === 'limits'">
            <datetime type="datetime" v-model="table[selectedRow][key]">
              <label slot="before" for="startDate">日時</label>
            </datetime>
          </div>
          <div class="col-sm-10" v-else-if="key === 'content_id'">
            <select class="form-control" v-model="table[selectedRow][key]">
              <option
                v-for="item in sub.TaskContent"
                v-bind:value="item.id"
                v-bind:key="item.id"
                :selected="value"
              >
                {{ `${item.id}: [${item.subject}]` }}
              </option>
            </select>
          </div>
          <div class="col-sm-10" v-else-if="key === 'evaluation_id'">
            <select class="form-control" v-model="table[selectedRow][key]">
              <option
                v-for="item in sub.Evaluation"
                v-bind:value="item.id"
                v-bind:key="item.id"
                :selected="value"
              >
                {{ `${item.id}: [${item.evaluation}]` }}
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
  </div>
</template>

<script>
import Vue from "vue";
import { Datetime } from "vue-datetime";
import { Luxon } from 'luxon';
import "vue-datetime/dist/vue-datetime.css";
Vue.component("overlay-modal", require("./OverlayModal.vue").default);

export default {
  data() {
    return {
      sub: null,
      table: null,
      error: null,
      modal: false,
      tableName: "Tasks",
      selectedRow: 0,
    };
  },
  mounted() {
    this.tableName = "Tasks";
    this.GetTable();
  },
  computed: {
    subFind() {
      return (key) => {
        switch (key[1]) {
          case "user_id":
            return this.sub.InstantUser.find((v) => v.id === key[0]).name ?? "";
          case "evaluation_id":
            return (
              this.sub.Evaluation.find((v) => v.id === key[0]).evaluation ?? ""
            );
          case "content_id":
            const s = this.sub.TaskContent.find((v) => v.id === key[0]) ?? "";
            return `[${s.subject}] ${s.memo}`;
        }
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
      this.GetTable();
    },

    /* Submit */
    doSend() {
      /* Validationlはサーバーでやりたいが */

      const row = this.table[this.selectedRow];

      console.log("date to sql");
      console.log(row.limits);
      row.limits = new Date(row.limits)
        .toISOString()
        .slice(0, 19)
        .replace("T", " ");
      console.log("row.limits => " + row.limits);

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
          this.sub = response.data.sub;
          this.error = null;
        })
        .catch((error) => (this.error = error));

      this.closeModal();
    },

    EditTasks() {
      this.GetTable();
    },

    GetTable() {
      console.log("/Get" + this.tableName + "Table");
      axios
        .get("/Get" + this.tableName + "Table")
        .then((response) => {
          console.log(response);
          this.table = response.data.table;
          this.sub = response.data.sub;
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
          this.sub = response.data.sub;
          this.error = null;
        })
        .catch((error) => (this.error = error));
    },
  },
};
</script>