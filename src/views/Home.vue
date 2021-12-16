<template>
  <div class="home">
    <v-container grid-list-xs>
      <v-card class="mt-5" color="rgba(23, 138, 173,0.6)" dark rounded="lg">
        <v-card-title primary-title>
         <h2>工具狀態及時看板</h2>
        </v-card-title>
        <v-row>
          <v-col align="center" class="mt-5">
            <radial-progress-bar
              :diameter="120"
              :completed-steps="info.num_store"
              :total-steps="info.toolsToatl"
              startColor="#cee356"
              stopColor="#cee356"
            >
              <h3>{{ info.num_store }} / {{ info.toolsToatl }}</h3>
            </radial-progress-bar>
            <v-chip label  color="#829cad" ><h1>可用工具</h1></v-chip>

          </v-col>
          <v-col align="center" class="mt-5">
            <radial-progress-bar
              :diameter="120"
              :completed-steps="info.num_broken"
              :total-steps="info.toolsToatl"
              startColor="red"
              stopColor="red"
            >
              <h3>{{ info.num_broken }} / {{ info.toolsToatl }}</h3>
            </radial-progress-bar>
            <v-chip label  color="#829cad" ><h1>故障工具</h1></v-chip>
          </v-col>
        </v-row>
        <v-row>
          <v-col align="center">
            <radial-progress-bar
              :diameter="120"
              :completed-steps="info.num_signed"
              :total-steps="info.toolsToatl"
              startColor="#2db0ed"
              stopColor="#2db0ed"
            >
              <h3>{{ info.num_signed }} / {{ info.toolsToatl }}</h3>
            </radial-progress-bar>
            <v-chip label  color="#829cad" ><h1>外借工具</h1></v-chip>
          </v-col>
          <v-col align="center">
            <radial-progress-bar
              :diameter="120"
              :completed-steps="info.num_repair"
              :total-steps="info.toolsToatl"
              startColor="#edd353"
              stopColor="#edd353"
            >
              <h3>{{ info.num_repair }} / {{ info.toolsToatl }}</h3>
            </radial-progress-bar>
            <v-chip label  color="#829cad" ><h1>工具維修</h1></v-chip>

          </v-col>
        </v-row>
      </v-card>
    </v-container>
    <v-container grid-list-xs>
      <v-card color="rgba(23, 138, 173,0.6)" dark rounded="lg">
      <v-card-title primary-title>
        <h2></h2>
      </v-card-title>
      </v-card>

    </v-container>

    <div class="bar">
      <v-container grid-list-xs>
        <v-row align="center" justify="center">
          <v-col cols="auto">
            <v-btn color="success" fab x-large dark to="/borrow">
              <v-icon x-large>{{ "mdi-camera" }}</v-icon>
            </v-btn>
          </v-col>
          <v-col cols="auto">
            <v-badge
              :value="unreturn_num > 0"
              offset-x="20"
              offset-y="20"
              color="red"
              :content="unreturn_num"
              size="60"
            >
              <v-btn color="#5f86d9" fab x-large dark to="/myTools">
                <v-icon x-large>{{ "mdi-package-variant" }}</v-icon>
              </v-btn>
            </v-badge>
          </v-col>
          <v-col cols="auto" v-if="this.position == 'admin'">
            <v-badge
              :value="info.report > 0"
              offset-x="20"
              offset-y="20"
              color="red"
              :content="info.report"
              size="60"
            >
              <v-btn color="#e6c20e" fab x-large dark to="/report">
                <v-icon x-large>{{ "mdi-account-alert" }}</v-icon>
              </v-btn>
            </v-badge>
          </v-col>
        </v-row>
      </v-container>
    </div>
  </div>
</template>

<script>
// @ is an alias to /src
import RadialProgressBar from "vue-radial-progress";
import axios from "axios";
import { findMyTools, report } from "../api";

export default {
  name: "Home",
  components: {
    RadialProgressBar,
  },
  data() {
    return {
      toolsAvaliable: 30,
      toolsBroken: 12,
      toolsTaken: 26,
      toolsFix: 26,

      value: 1,
      user: localStorage.getItem("user"),
      position: localStorage.getItem("position"),
      order_status: 0,
      data: [],
      unreturn_num: 0,
      info: {
        num_store: 0,
        num_signed: 0,
        num_repair: 0,
        num_broken: 0,
        toolsToatl: 0,
        report: 0,
      },
    };
  },
  methods: {
    number() {
      let data = new FormData();
      data.append("mode", "number");
      data.append("user", this.user);
      data.append("order_status", this.order_status);

      findMyTools(data).then((res) => {
        if (res.data != "error") {
          this.unreturn_num = res.data;
        } else {
          console.log("NULL");
        }
      });
    },
    count() {
      let data = new FormData();
      data.append("mode", "count");
      data.append("user", this.user);
      data.append("order_status", this.order_status);

      findMyTools(data).then((res) => {
        if (res.data != "error") {
          this.data = res.data;
          console.log(this.data);
          this.info.num_store = this.data[0];
          this.info.num_signed = this.data[1];
          this.info.num_repair = this.data[2];
          this.info.num_broken = this.data[3];
          this.info.toolsToatl =
            this.info.num_store +
            this.info.num_signed +
            this.info.num_repair +
            this.info.num_broken;
        } else {
          console.log("NULL");
        }
      });
    },
    countReport() {
      let data = new FormData();
      data.append("mode", "count");
      report(data).then((res) => {
        if (res.data != "error") {
          this.info.report = res.data;
        }
      });
    },
  },
  computed: {},
  created() {
    this.count();
    this.number();
    this.countReport();
  },
};
</script>

<style scoped>
.home {
  height: 100%;
  background-color: #e8e8e8;

  background-image: repeating-radial-gradient(
      circle at 0 0,
      transparent 0,
      #e8e8e8 40px
    ),
    repeating-linear-gradient(#45bcf755, #45bcf7);
}
.bar {
  position: fixed;
  bottom: 0;
  right: 0;
  left: 0;
  background-color: rgb(11, 146, 187);
}
</style>

