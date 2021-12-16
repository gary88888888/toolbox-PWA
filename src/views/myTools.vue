
<template>
  <div class="home">
    <v-toolbar
      color="#91ede4"
      class="mb-1"
      dense
      style="position: fixed; z-index: 3"
      width="100vw"
      rounded="lg"
      height="60vh"
    >
      <v-row class="mt-1" justify="center" align="center">
        <v-col>
          <v-text-field
            v-model="searchQuery"
            name="name"
            label="名稱 編號 搜尋"
            id="id"
            autocomplete="off"
          ></v-text-field>
        </v-col>
        <v-col cols="auto">
          <v-btn icon color="success" @click="reload()"
            ><v-icon>{{ "mdi-reload" }}</v-icon></v-btn
          >
        </v-col>
      </v-row>
    </v-toolbar>
    <v-container grid-list-xs>
      <head>
        <meta
          http-equiv="Content-Security-Policy"
          content="upgrade-insecure-requests"
        />
      </head>
      <transition name="fade">
        <Scantool
          transition="fade-transition"
          @close="close()"
          v-if="camera.scan"
          :box_id="camera.box_id"
          :QRcode="camera.QRcode"
          :cameraSwitch="camera.cameraSwitch"
        ></Scantool>

        <ReportProblem @close="cancelReport" @Error="Error" @Success="Success"  transition="fade-transition" v-if="reportData.isreport" :tool="reportData.tool">


        </ReportProblem>
      </transition>
      <div class="mt-14">
        <Templete
          v-for="(tool, index) in filterItems(tools)"
          :key="index"
          @turnback="turnback(index, tool.QRcode, tool.box_id)"
          @report="report(index, tool)"
          class="mt-1"
        >
          <v-container grid-list-xs >
            <v-card width="100vw" height="13vh" flat>
              <v-row no-gutters >
              <v-col  align="center">
                <v-row>

                    <v-col>
                      <v-img
                    :aspect-ratio="16 / 9"
                    :src="
                      'https://192.168.1.103/toolSystem/img/tools/' +
                      tool.QRcode +
                      '.jpg'
                    "
                    class="
                      d-flex
                      transition-fast-in-fast-out
                      orange
                      darken-2
                      v-card--reveal
                      text-h2
                      white--text
                    "
                  >
                  </v-img>
                    </v-col>
                    <v-col>
                <v-row  >
                  <v-col align="left">
                    <h2>{{ tool.name }}</h2>
                  </v-col>
                </v-row>


                <!-- <v-row >
                  <v-col class="align-center">
                    <v-row no-gutters >
                      <v-col align="left">登記日期</v-col>
                    </v-row>
                    <v-row no-gutters align="center">
                      <v-col align="left">
                      <v-chip label color="grey-lighten-2">{{ tool.time_stamp }}</v-chip>
                      </v-col>
                    </v-row>

                  </v-col>
                </v-row> -->

              </v-col>



                </v-row>
                <v-row dense >
                  <v-col class="align-center">
                    <v-row no-gutters >
                      <v-col align="left">工具ID</v-col>
                    </v-row>
                    <v-row no-gutters align="center">
                      <v-col align="left">
                      <v-chip label color="yellow">{{ tool.QRcode }}</v-chip>
                      </v-col>
                    </v-row>

                  </v-col>
                  <v-col class="align-center">
                    <v-row no-gutters >
                      <v-col align="left">儲櫃ID</v-col>
                    </v-row>
                    <v-row no-gutters align="center">
                      <v-col align="left">
                      <v-chip label color="primary">{{ tool.box_id }}</v-chip>
                      </v-col>
                    </v-row>

                  </v-col>
                   <v-col class="align-center">
                    <v-row no-gutters >
                      <v-col align="left">登記日期</v-col>
                    </v-row>
                    <v-row no-gutters align="center">
                      <v-col align="left">
                      <v-chip label color="grey-lighten-2">{{ tool.time_stamp }}</v-chip>
                      </v-col>
                    </v-row>

                  </v-col>
                </v-row>

              </v-col>

            </v-row>
            </v-card>

            <v-expand-transition>
              <!-- <div v-show="toolExpend[i]===true"  >
                    <v-col>

                    </v-col>
                </div> -->
            </v-expand-transition>
          </v-container>
        </Templete>
      </div>
    </v-container>
  </div>
</template>

<script>
import axios from "axios";
import Templete from "../components/templete.vue";
import { QrcodeStream, QrcodeDropZone, QrcodeCapture } from "vue-qrcode-reader";
import Scantool from "../components/scantool.vue";
import ReportProblem from "../components/reportProblem.vue"
import {findMyTools} from "../api.js"
export default {
  name: "",
  components: {
    Templete,
    Scantool,
    ReportProblem,
    QrcodeStream,
    QrcodeDropZone,
    QrcodeCapture,
  },
  inject: ["reload"],
  data() {
    return {
      user: "",
      order_status: "0",
      tools: [],
      hover: false,
      searchQuery: "",
      toolExpend: {},
      startX: 0, //觸控位置
      endX: 0, //結束位置
      moveX: 0, //滑動時的位置
      disX: 0, //移動距離
      deleteSlider: "", //滑動時的效果,使用v-bind:style="deleteSlider",
      camera: {
        box_id: "",
        QRcode: "",
        scan: false,
        cameraSwitch: "off",
      },
      reportData:{
        tool:[],
        isreport:false,
      }
    };
  },
  methods: {
    filterItems: function (tools) {
      var app = this;
      return tools.filter(function (tool) {
        let regex = new RegExp("(" + app.searchQuery + ")", "i");
        return (
          tool.name.match(regex) ||
          tool.QRcode.match(regex) ||
          tool.box_id.match(regex)
        );
      });
    },
    turnback(index, QRcode, box_id) {
      this.camera.scan = true;
      this.camera.QRcode = QRcode;
      this.camera.box_id = box_id;
      this.camera.cameraSwitch = "auto";
      console.log(this.camera.QRcode);
      console.log(this.camera.box_id);
    },
    report(index,tool){
      this.reportData.tool = tool
      this.reportData.isreport = true
    },
    cancelReport(){
      this.reportData.isreport = false
      console.log("jhygyh")
    },


    close() {
      this.camera.scan = false;
      this.camera.cameraSwitch = "off";
      console.log(this.camera.scan);
    },
    loadingData() {
      this.user = localStorage.getItem("user");
      console.log(this.user);

      let data = new FormData()
      data.append("mode","data")
      data.append("user",this.user)
      data.append("order_status",this.order_status)
      findMyTools(data)
      .then((res) => {
        if (res.data != "error") {
          console.log(res.data);
          this.tools = res.data;
        }
      });

    },
    Error(content) {
      this.$Message.error({
                content: content,
                duration: 3,
                background:true
            });
    },
    Success(content) {
      this.$Message.success({
                content: content,
                duration: 3,
                background:true
            });
    },
  },
  created() {
    this.loadingData();
  },
  computed: {},
};
</script>

<style scoped>
.home {
  height: 100%;
  background-color: rgb(185, 202, 233);
}
.slider {
  width: 100%;
  height: 120px;
  margin-bottom: 10px;
  position: relative;
}
.content {
  position: absolute;
  left: 0;
  right: 0;
  top: 0;
  bottom: 0;
  /* z-index: 2; */
  transition: 0.3s;
  background-color: #fff;
  border-bottom: 1px solid #d3d3d3;
}
.remove {
  position: absolute;
  width: 140px;
  height: 140px;
  background-color: #f60;
  right: 0;
  top: 0;
  color: #fff;
  text-align: center;
  font-size: 32px;
  line-height: 120px;
}
.fade-enter-active,
.fade-leave-active {
  transition: opacity 3s;
}
.fade-enter, .fade-leave-to /* .fade-leave-active below version 2.1.8 */ {
  opacity: 0;
}
</style>