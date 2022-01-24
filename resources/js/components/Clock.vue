<template>
  <div class="mt-3 mb-3">
    <h5 class="text-white-50">{{date}}</h5>
    <h3 class="text-white">{{time}}</h3>
  </div>
</template>

<script>
import Vue from "vue";

export default {
  data() {
    return {
      date: '',
      time: '',
      week: ['（日）', '（月）', '（火）', '（水）', '（木）',  '（金）', '（土）'] 

    };
  },
  mounted() {
    let timerID = setInterval(this.updateTime, 1000); 
  },
  computed: {
  },
  methods: {
    updateTime() { 

      //現在の日付・時刻を取得 
      const currentdate = new Date();

      // 時間を12時間制（表記）で取得
      const hour24 = currentdate.getHours();
      const hour12 = hour24 % 12;

      // 午前か午後を判定
      var hourStr = hour24 < 12 ? 'AM' : 'PM';

      // 現在の時刻
      this.time = hourStr + ' ' + hour12 + ':' + this.zeroPadding(currentdate.getMinutes(), 2)

      // 現在の年月日
      this.date = this.zeroPadding(currentdate.getFullYear(), 4) + '/' + this.zeroPadding(currentdate.getMonth() + 1, 2) + '/' + this.zeroPadding(currentdate.getDate(), 2) + this.week[currentdate.getDay()]
      },
    zeroPadding(num, len) {
      let zero = '';

     // 0の文字列を作成
      for(var i = 0; i < len; i++) {
        zero += '0';
     }

     // zeroの文字列と、数字を結合し、後ろ２文字を返す
      return (zero + num).slice(-len);
    }
  },
};

</script>