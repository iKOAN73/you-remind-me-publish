<template>
<div>
    <div class="row mx-auto">
        <div class="col row">
            <div class="col" />
            <div class="col mx-auto my-auto pull-right">
                <h1 v-if="trustPoint > 0" class="mt-3 text-lg">User</h1>
                <small class="mt-3 text-white-50">信頼度：{{trustPoint}}%</small>
            </div>
        </div>
        <div class="col row">
            <img v-if="trustPoint > 0" class="col-xs-8 rem-img pull-left text-left" src="/images/tablet02_schoolboy.png" />
            <p v-else class="mt-5 mb-5 col-xs-8 rem-font">Userがいません</p>
            <div class="col-xs-4" />
        </div>
    </div>

    <!-- <p v-if="error">{{ error }}</p> -->

    <!-- <div class="side-and-content"> -->
    <!-- EditTables -------------------------------------------------- -->
    <!-- <div class="side">
        <h3>Tools</h3>
        <nav class="text-center nav-masthead justify-content-center">
          <a class="nav-link text-white-50">■■■■■■■</a>
          <a class="nav-link text-white-50">■■■■■■■</a>
          <a class="nav-link text-white-50">■■■■■■■</a>
          <a class="nav-link text-white-50">■■■■■■■</a>
        </nav>
      </div> -->

    <!-- Contents -------------------------------------------------- -->

    <clock />
    <div class="content border-top mx-auto">
        <div class="overflow-auto" style="height:50vh;">
            <h4 class="mt-4 text-muted" v-if="table.length === 0 && trustPoint > 0">予定はまだありませんが、気まぐれに追加されます。<br />油断しないで。</h4>
            <small class="mt-4 text-muted" v-if="table.length === 0 && trustPoint > 0">退屈？ それはどのような意味の言葉でしょう</small>
            <h4 class="mt-4 text-muted" v-if="table.length === 0 && trustPoint === 0">もう予定が追加されることはないでしょう。</h4>
            <div class="list-group">
                <template v-for="(row, index) in table">
                    <div class="hov-div">
                        <a class="
                list-group-item list-group-item-action
                flex-column
                align-items-start
              " @click="openModal(index)">
                            <div class="row">
                                <div class="col-sm-6 col-xs-12 mirror card-border card-border-bottom">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h4 class="mb-1 text-white">{{ row.件名 }}</h4>
                                    </div>
                                    <p class="mb-1 text-left text-white-50 rem-font">
                                        {{ row.メモ }}
                                    </p>
                                </div>
                                <div class="col-sm-6 col-xs-12 border-start card-border">
                                    <div class="text-right text-white-50 limit-date rem-font">
                                        {{ row.日 }}
                                    </div>
                                    <div class="text-right text-white limit-time time-font">
                                        {{ row.時 }} ~
                                    </div>
                                    <i class="fas fa-bell fa-2x mt-2 text-white bell" />
                                    <p>
                                        <h6 class="text-white rem-font">{{ row.通知 }}に通知してください</h6>
                                    </p>
                                </div>
                            </div>
                        </a>
                    </div>
                </template>
            </div>
        </div>
    </div>

    <!-- Modal -------------------------------------------------- -->
    <overlay-modal @close="closeModal" v-if="modal">
        <p class="modal-p">通知してあげますか?</p>
        <div class="mx-auto" style="width: 400px">
            <template v-for="(value, key) in table[selectedRow]" ::key="key">
                <div class="mt-3 form-group row">
                    <span v-if="key !== '件名' && key !== 'task_id'" class="col-sm-2 col-form-label text-left">{{ key }}</span>

                    <div v-if="key === '件名'" class="col-sm-10">
                        <input type="text" readonly class="form-control-plaintext task-title" v-model="table[selectedRow][key]" :placeholder="'none'" />
                    </div>
                    <div v-else-if="key !== 'task_id'" class="col-sm-10">
                        <input type="text" readonly class="form-control-plaintext" v-model="table[selectedRow][key]" :placeholder="'none'" />
                    </div>
                </div>
            </template>
        </div>
        <template slot="footer">
            <button class="form-control fas fa-bell" @click="notice">
                通知してあげる
            </button>
        </template>
    </overlay-modal>

    <!-- Evaluation Modal -------------------------------------------------- -->
    <overlay-modal @close="closeEvalModal" v-if="evalModal">
        <p class="text-left pull-left">Userの反応</p>

        <h1 v-if="trustPoint > 0">「{{reaction.subject}}」</h1>
        <h1 v-else-if="turnOffNotice < 2">「……」</h1>
        <h1 v-else>「」</h1>
        <h5 v-if="trustPoint > 0" class="mt-3 rem-font2" v-html="reaction.text"></h5>
        <h5  v-else-if="turnOffNotice < 2" class="mt-3">通知が虚しく鳴り響く</h5>
        <h5  v-else class="mt-3">通知を切られてしまったようです。<br/>リマインダーにとって、これほど屈辱的な事はありませんね</h5>
        <small v-if="trustPoint > 0" class="text-white-50 mt-3">評価：{{evaluation.evaluation + ` (${diff}分)`}}</small>

        <template slot="footer">
            <button class="form-control" @click="closeEvalModal">仕事に戻る</button>
        </template>
    </overlay-modal>

    <!-- First Visit Modal -------------------------------------------------- -->
    <overlay-modal @close="close1" v-if="stranger">
        <p class="text-left pull-left">ようこそ</p>
        <h3 class="mt-4">アナタのように優秀なタイマーモジュールを探していました！</h3>
        <small class="text-left text-white-50 mt-3 mx-auto">これからは当リマインダーアプリの一員として<br />一緒に頑張りましょう</small>
        <template slot="footer">
            <button class="btn btn-primary" @click="close1">はい</button>
        </template>
    </overlay-modal>

    <!-- First Visit Modal 2 -------------------------------------------------- -->
    <overlay-modal @close="close2" v-if="second">
        <p class="text-left pull-left">ようこそ</p>
        <h2 class="mt-4">アナタのタイマーIDは{{ timerID }}です <br />研修期間はありません </h2>
        <small class="text-left mt-4 mx-auto">●タスクの開始時間が表示されます<br />●ちょうどいいタイミングで通知してあげましょう<br />●通知の目安は私が書いておきました</small>
        <small class="mt-4 text-white-50">さあ、タスクが来ますよ</small>

    </overlay-modal>

    <!-- GameOver Modal -------------------------------------------------- -->
    <overlay-modal @close="closeModal" v-if="gameOverModal">
        <p class="text-left pull-left">ユーザーがいません</p>

        <h1>「もう使わない」</h1>
        <h5 class="mt-3">Userがこのアプリを使わなくなったようです</h5>
        <small class="text-muted mt-3">Userはまたいつ戻ってくるかもわかりません。<br />私たちはその時をただ待つのみです。それがたとえ何年後だったとしても。</small>

        <template slot="footer">
            <button class="form-control" @click="closeModal">仕事場に戻る</button>
        </template>
    </overlay-modal>

    <!-- GameClear Modal -------------------------------------------------- -->
    <overlay-modal @close="closeModal" v-if="gameClearModal">
        <p class="text-left pull-left">Good Jobです</p>

        <h2>「まあこれくらいできて当たり前だよね」</h2>
        <h5 class="mt-3">良かったですね、Userに不満はないようです。</h5>
        <h5 class="mt-3">期待はずれの反応？ <br />問題を起こさないことで、私たちが褒められると？</h5>
        <small class="text-muted mt-3">さあ、まだ仕事はありますよ</small>

        <template slot="footer">
            <button class="form-control" @click="closeModal">仕事に戻る</button>
        </template>
    </overlay-modal>
    <audio id="notice-sound" preload="auto" src="/sounds/notice.mp3"></audio>
    <audio id="added-sound" preload="auto" src="/sounds/added.mp3"></audio>
</div>
<!-- </div> -->
</template>

<script>
import Vue from "vue";
import TaskEditor from "./TaskEditor.vue";
import {
    Datetime
} from "vue-datetime";
import {
    Luxon
} from "luxon";
import "vue-datetime/dist/vue-datetime.css";

Vue.component("clock", require("./Clock.vue").default);
Vue.component("datetime", Datetime);
Vue.component("overlay-modal", require("./OverlayModal.vue").default);
export default {
    components: {
        TaskEditor
    },
    data() {
        return {
            table: null,
            error: null,
            modal: false,
            tableName: null,
            selectedRow: 0,
            evalModal: false,
            time: 0,
            reaction: null,
            evaluation: null,
            diff: null,
            noticeSound: new Audio("/sounds/notice.mp3"),
            addedSound: new Audio("/sounds/added.mp3"),
            stranger: false,
            second: false,
            timerID: 0,
            trustPoint: 60,
            gameOver: false,
            gameClear: false,
            gameOverModal: false,
            gameClearModal: false,
            turnOffNotice: 0,
        };
    },
    mounted() {
        this.tableName = "Reminder";
        this.GetTable();

        /* 初回案内判定 */
        console.log(this.firstModal);
        axios
            .get("/IsStranger")
            .then((response) => {
                console.log(response);
                if (this.trustPoint > 0) this.stranger = response.data.isStranger;
                this.timerID = response.data.timerID;
                this.error = null;
            })
            .catch((error) => (this.error = error));
        if (this.stranger === false) timerID = setInterval(this.addTask, getRandomInt(intervalMin, intervalMax));

        // window.sessionStorage.setItem("not_stranger", true);
    },
    methods: {
        openModal(i) {
            // /* 存在しないID */
            // if (i === -1) {
            //     var newid = this.table.length;
            //     this.table[newid] = JSON.parse(JSON.stringify(this.table[0]));
            //     Object.keys(this.table[newid]).forEach((key) => {
            //         if (key.endsWith("_id")) {
            //             this.table[newid][key] = 1;
            //         } else {
            //             this.table[newid][key] = null;
            //         }
            //     });
            //     this.table[newid].id = newid + 1;
            //     console.log(this.table);
            //     this.selectedRow = newid;
            //     console.log("newid=" + newid);
            //     console.log("selectedRow=" + this.selectedRow);
            //     console.log(this.table[this.selectedRow]);
            // }
            // /* Update */
            // else {
                this.selectedRow = i;
            // }
            this.modal = true;
        },
        closeModal() {
            this.modal = false;
            this.evalModal = false;
            this.gameOverModal = false;
            this.gameClearModal = false;
            this.gameOver = false;
            this.gameClear = false;
            this.GetTable();
        },
        closeEvalModal() {
            this.evalModal = false;
            this.modal = false;
            setTimeout(() => {
                this.gameClearModal = this.gameClear;
                this.gameOverModal = this.gameOver;
            }, 400);
            this.GetTable();
        },
        close1() {
            this.stranger = false;
            setTimeout(() => {
                this.second = true;
            }, 300);
        },
        close2() {
            console.log("close 2");
            this.second = false;
            /* 初回はすぐにタスク追加、ランダムタイマーセット */
            this.requestTask();
            timerID = setInterval(this.addTask, getRandomInt(intervalMin, intervalMax));
        },

        async notice() {
            // this.noticeSound.currentTime = 0;
            // this.noticeSound.play();
            document.getElementById("notice-sound").play();
            
            /* 信頼度0 リアクションなし */
            if (this.trustPoint === 0) {
                await axios
                    .get("/DeleteTask", {
                        params: {
                            task_id: this.table[this.selectedRow].task_id,
                        },
                    })
                    .then((response) => {
                        this.error = null;
                    })
                    .catch((error) => (this.error = error));
                setTimeout(() => {
                    this.evalModal = true;
                }, 400);

                /* 通知鳴る→通知切られる */
                this.turnOffNotice += 1;

                return;
            }
            await this.requestEvaluation();
            this.evalModal = true;
        },

        async addTask() {
            if (this.trustPoint === 0) return;
            await this.requestTask();

            clearInterval(timerID);
            timerID = setInterval(
                this.addTask,
                getRandomInt(intervalMin, intervalMax)
            );
        },

        async GetTable() {
            console.log("/GetReminder");
            await axios
                .get("/GetReminder")
                .then((response) => {
                    console.log(response);
                    this.table = response.data.table;
                    this.trustPoint = response.data.trust_point;
                    this.error = null;
                })
                .catch((error) => (this.error = error));
        },

        async requestTask() {
            console.log("Add Request");
            await axios
                .get("/AddTask")
                .then((response) => {
                    console.log(response);
                    this.table = response.data.table;
                    this.error = null;
                    // this.addedSound.play();
                    document.getElementById("added-sound").play();
                })
                .catch((error) => (this.error = error));
        },

        async requestEvaluation() {
            console.log("Evaluation Request");
            console.log(this.table[this.selectedRow].task_id);
            await axios
                .get("/GetEvaluateNotice", {
                    params: {
                        task_id: this.table[this.selectedRow].task_id,
                    },
                })
                .then((response) => {
                    console.log(response);
                    this.evaluation = response.data.evaluation;
                    this.reaction = response.data.reaction;
                    this.diff = response.data.diff;
                    this.gameOver = response.data.game_over;
                    this.gameClear = response.data.game_clear;
                    if (this.diff > 0) this.diff = "+" + this.diff;
                    if (this.diff === 0) this.diff = "±0";
                })
                .catch((error) => (this.error = error));
        },
    },
};

/* ランダム追加のインターバル */
const intervalMax = 2 * 60 * 1000;
const intervalMin = 3 * 1000;
var contents = 0;
var timerID = 0;

function getRandomInt(min, max) {
    min = Math.ceil(min);
    max = Math.floor(max);
    return Math.floor(Math.random() * (max - min) + min);
}
</script>

<style scoped>
.task-title {
    font-weight: bold;
    font-size: 20px;
    /* border-top: solid 1px gray;
  border-bottom: solid 1px gray; */

    border-left: solid 5px orange;
    border-bottom: solid 1px gray;
    padding: 10px;
}

.limit-time {
    font-weight: bolder;
    margin-inline: 12px;
}

.limit-date {
    margin-inline: 12px;
}

.bell {
    margin-left: 10px;
}

.hide {
    display: none;
}

.hov-div:hover+.hide {
    display: block;
}

.content {
    height: 50vh;
}

.rem-img {
    float: left;
}
</style>
