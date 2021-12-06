<template>
  <div  class="home">
      <v-container  grid-list-xs >
        <v-row justify="center" align="center">
          <v-col justify="center" align="center">
            <transition name="camera">
              <div class="camera" v-if="step==1" :style="styleVar" key="id" >
                <v-row>
                  <v-col>


                    <div class="frame" style="height:70vh;border:solid grey 4px;" >
                      <div style="right:0;left:0;position:fixed;z-index:999;margin:auto;color:white;font-size:2em; align:center;"><h2>掃描工具櫃</h2></div>
                      <qrcode-stream
                      :camera="camera.camera"
                      @decode="onDecode"
                      @init="onInit"
                      :paused="camera.paused"
                    >
                    </qrcode-stream>
                    </div>

                  </v-col>
                </v-row>
                <v-row>
                  <v-col>
                    <v-btn color="info" x-large @click="$router.push('/')"><h2>離開</h2> </v-btn>

                  </v-col>
                </v-row>
              </div>

            </transition>
            <v-row>
              <v-col> </v-col>
            </v-row>
          </v-col>
        </v-row>



        <v-row v-if="step==2">

          <v-row>
            <v-col align="center">
              <v-card key="id" color="#91dbe3" rounded="lg" width="87vw" height="auto">
                <v-container grid-list-xs>


                <v-row justify="center" align="center">
                  <v-col cols="6">
                    <v-chip
                      color="#fcad00"
                      text-color="white"
                      v-show="toolData.status == 1"
                      label
                      ><h2>外借中</h2>
                    </v-chip>
                    <v-chip
                      color="green"
                      text-color="white"
                      v-show="toolData.status == 0"
                      ><h2>有庫存</h2>
                    </v-chip>
                    <v-chip
                      color="error"
                      text-color="white"
                      v-show="toolData.status == 3"
                      ><h2>故障中</h2>
                    </v-chip>
                    <v-chip
                      color="red"
                      text-color="white"
                      v-show="toolData.status == 2"
                    >
                      <h2>維修中</h2>
                    </v-chip>
                  </v-col>
                  <v-col cols="6" align="center"
                    ><h1>{{ toolData.name }}</h1></v-col
                  >
                </v-row>
                <v-row justify="center" align="center">
                  <v-col>
                    <v-row>
                      <v-col cols="6"
                        ><h2>
                          編號:
                          <span style="color: #ba0428">{{
                            toolData.QRcode
                          }}</span>
                        </h2></v-col
                      >
                      <v-col>
                        <h2>
                          位置:
                          <span style="color: #ba0428">{{ toolData.area }}</span>
                        </h2>
                      </v-col>
                    </v-row>
                  </v-col>
                </v-row>

                <v-row  >
                  <v-col >
                    <v-carousel height="auto" hide-delimiter-background cycle >
                      <v-carousel-item
                        v-for="(img, i) in imgs"
                        :key="i"
                        style="text-align: center;"
                        ><img
                          :src="
                            'https://192.168.1.103/toolSystem/img/tools/' +
                            img.site
                          "
                          style="width: 75%; height: auto; text-align: center;border-radius: 2em;"
                      /></v-carousel-item>
                    </v-carousel>
                  </v-col>
                </v-row>

                <v-row>
                  <v-col>
                    <v-dialog
                      ref="dialogDate"
                      v-model="modal"
                      :return-value.sync="data.date"
                      persistent
                      width="80vw"
                      class="dialog_date"
                    >
                      <template v-slot:activator="{ on, attrs }">
                        <v-text-field
                          name="歸還日期"
                          label="歸還日期"
                          prepend-icon="mdi-calendar"
                          id="date"
                          v-bind="attrs"
                          v-on="on"
                          v-model="data.date"
                          readonly
                          :disabled="toolData.status != 0"
                        ></v-text-field>
                      </template>
                      <v-date-picker
                        class="datePicker"
                        v-model="data.date"
                        scrollable
                        full-width
                        height="300px"
                        :first-day-of-week="0"
                        locale="zh-tw"
                        :min="new Date().toISOString().substr(0, 10)"
                        ><!-- 限制日期選擇無法選擇昨天的日期 -->

                        <v-spacer></v-spacer>
                        <v-btn text color="primary" @click="modal = false">
                          <h1>取消</h1>
                        </v-btn>
                        <v-btn
                          text
                          color="primary"
                          @click="$refs.dialogDate.save(data.date)"
                        >
                          <h1>確定</h1>
                        </v-btn>
                      </v-date-picker>
                    </v-dialog>
                  </v-col>
                </v-row>
                <v-row>
                  <v-col>
                    <v-dialog
                      ref="dialogTime"
                      v-model="modal2"
                      :return-value.sync="data.time"
                      persistent
                      width="80vw"
                      class="dialog_time"
                    >
                      <template v-slot:activator="{ on, attrs }">
                        <v-text-field
                          name="歸還時間"
                          label="歸還時間"
                          prepend-icon="mdi-clock"
                          id="time"
                          v-bind="attrs"
                          v-on="on"
                          v-model="data.time"
                          readonly
                          :disabled="toolData.status != 0"
                        ></v-text-field>
                      </template>
                      <v-time-picker
                        class="timepicker"
                        ampm-in-title
                        format="ampm"
                        v-model="data.time"
                        width="80vw"
                        locale="zh-tw"
                      >
                        <v-spacer></v-spacer>
                        <v-btn text color="primary" @click="modal2 = false">
                          <h1>取消</h1>
                        </v-btn>
                        <v-btn
                          text
                          color="primary"
                          @click="$refs.dialogTime.save(data.time)"
                        >
                          <h1>確定</h1>
                        </v-btn>
                      </v-time-picker>
                    </v-dialog>
                  </v-col>
                </v-row>
                <v-row>
                  <v-col align="center">
              <v-btn
                type="icon"
                top
                outlined
                fab
                color="teal"
                width="60"
                height="60"
                @click="retry()"
                v-if="step==2"
                ><v-icon >{{ "mdi-camera" }}</v-icon></v-btn
              >
            </v-col>
                  <v-col
                    ><v-btn color="info" x-large :disabled="toolData.status != 0 || data.date == null || data.time == null"   @click="submit(toolData.box_id)"><h1>借出</h1> </v-btn></v-col
                  >

                </v-row>
                </v-container>
              </v-card>
            </v-col>
          </v-row>


        </v-row>
        <transition name="fade">
        <v-row v-if="step == 3" align="center" justify="center">
          <v-col align="center" justify="center">
            <v-card color="light-blue lighten-3" rounded="xl" width="400" height="400" class="mt-12">

            <div class="formContainer" ref="formContainer" >
            <div style="position: absolute;display:flex;z-index:999;justify-content: center; width:400px;height:400px;align-items: center;font-size:120px;-webkit-text-stroke: 5px #ff7c40;color:#ff7c40;"   >{{this.time}}</div>
            <div style="position: absolute;justify-content: center; width:400px;height:400px;align-items: center;color:white;top:20px;"><h1 style="font-size:45px;">請在時間內解鎖</h1></div>
            </div></v-card>
          </v-col>


        </v-row>
        </transition>
      </v-container>

  </div>
</template>

<script>
import axios from "axios";
import { QrcodeStream, QrcodeDropZone, QrcodeCapture } from "vue-qrcode-reader";
import {borrowSubmit} from "../api.js"
export default {
  Components: {
    QrcodeStream,
    QrcodeDropZone,
    QrcodeCapture,
  },
  inject:['reload'],
  data() {
    return {
      camera:{
        scaned: false,
        decodedContent: null,
        errorMessage: "",
        camera: "auto",
        paused: false,
        torchActive:false,
        fullPage:false
      },
      qrcode: "",
      box_id:'',
      toolData: null,

      styleVar: {
        "--cameraColor": "rgb(72, 204, 228)",
      },
      data:{
        date: null,
        time:null,
      },


      imgs: [],

      modal: false,
      modal2: false,
      status: "",
      message:"",
      countDownTimer:null,
      borrowErrorTimer:null,
      time:20,
      isCount:false,
      loading:null,
      step:1,
      loadingtest:null,
    };
  },

  methods: {
    async onDecode(content) {
      this.camera.decodedContent = content;
      if (content) {
        let formdata = new FormData();
        formdata.append("box_id", content);
        axios
          .post(
            "https://192.168.0.20/toolSystem/pwa_php/fetchTool.php",
            formdata,
            {}
          )
          .then((res) => {
            this.step = 2;
            this.box_id = res.data[0].box_id;
            this.Success("查詢成功")
            if (res.data) {

              this.toolData = res.data[0];


              axios
                .post(
                  "https://192.168.0.20/toolSystem/pwa_php/img.php?QRcode=" +
                    res.data[0].QRcode
                )
                .then((res) => {
                  this.imgs = res.data;
                  console.log(this.imgs);
                })
                .catch((error) => {
                  console.log(error);
                });

            } else {

              this.Error("工具編號查詢失敗")
              this.step = 1;
              this.closeCamera();
              setTimeout(() => {
                this.openCamera();
              }, 400);
            }
          })
          .catch(function (error) {
            console.log(error);
          });
      }
    },

    onInit(promise) {
      promise
        .then(() => {
          console.log("Successfully initilized! Ready for scanning now!");
        })
        .catch((error) => {
          if (error.name === "NotAllowedError") {
            this.camera.errorMessage = "Hey! I need access to your camera";
          } else if (error.name === "NotFoundError") {
            this.camera.errorMessage = "Do you even have a camera on your device?";
          } else if (error.name === "NotSupportedError") {
            this.camera.errorMessage =
              "Seems like this page is served in non-secure context (HTTPS, localhost or file://)";
          } else if (error.name === "NotReadableError") {
            this.camera.errorMessage =
              "Couldn't access your camera. Is it already in use?";
          } else if (error.name === "OverconstrainedError") {
            this.camera.errorMessage =
              "Constraints don't match any installed camera. Did you asked for the front camera although there is none?";
          } else {
            this.camera.errorMessage = "UNKNOWN ERROR: " + error.message;
          }
        });
    },

    closeCamera() {
      this.camera.camera = "off";
    },
    openCamera() {
      this.camera.camera = "auto";
    },
    retry() {
      this.step = 1

      this.camera.camera = "auto";
    },

    timeout(ms) {
      return new Promise((resolve) => {
        window.setTimeout(resolve, ms);
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
    ////////////////////////////////////////////
    borrowOpen(box_id){
      let data = new FormData()
      data.append("mode","open")
      data.append("box_id",box_id)
      borrowSubmit(data)
      .then((res) => {
        if (res.data == "success") {
          this.Success("正在開啟中")
        } else {
          this.Error("開啟失敗")
        }
      });
    },
    borrowClose(box_id){
      let data = new FormData()
      data.append("mode","close")
      data.append("box_id",box_id)
      borrowSubmit(data)
      .then((res) => {
        if (res.data == "success") {
          this.Success("已關閉")
        } else {
          this.Error("關閉失敗")
        }
      });
    },
    borrowError(box_id){

      this.loading.hide()
      this.isCount = false
      let data = new FormData()
      data.append("mode","error")
      data.append("box_id",box_id)
      borrowSubmit(data)
      .then((res) => {
        if (res.data == "success") {
          console.log("success")
          this.Error("借用流程失效")
          this.reload()
        } else {

        }
      });
    },

    statusCheck(box_id){
      let data = new FormData()
      data.append("mode","search")
      data.append("box_id",box_id)
      borrowSubmit(data)
      .then((res) => {
          this.currentToolStatus = res.data[0].status
      });
      if(this.currentToolStatus == "1"){
        this.Success("成功")
        clearTimeout(this.countDownTimer)
        clearTimeout(this.borrowErrorTimer)
        this.loading.hide()
        this.reload()
      }

    },
    countdown(box_id){
      if(this.time != 0){
        this.time --
        this.statusCheck(box_id)
        console.log(this.currentToolStatus)
      }else{
        clearInterval(this.countDownTimer)
      }


    },
    loadingfun(){
      this.loading = this.$loading.show({
          // Optional parameters
          container: this.$refs.formContainer,
          canCancel: false,
          onCancel: this.onCancel,

          color: '#ff7c40',
          loader:"spinner",
          width: 200,
          height: 200,
          backgroundColor:"#636b65",
          opacity: 0,
        },
        {
         // default: this.$createElement('MyLoading'),
        });
    },
    test(){
      this.step = 3
      setTimeout(() => {
        this.loadingfun();
      }, 100);




    },

    submit(box_id) {
        this.step = 3
        this.camera.torchActive = false
        this.message = "請在時間內解鎖"
        this.borrowOpen(box_id)
        this.isCount = true
        this.time = 20
        this.countDownTimer = setInterval(this.countdown, 1000,box_id)
        this.borrowErrorTimer = setTimeout(this.borrowError,20000,box_id)

        setTimeout(() => {
        this.loadingfun();
      }, 100);

        this.message ="工具櫃已解鎖"

    },
    ////////////////////////////////////////////////
  },
  watch: {
    step: function () {
      if (this.step == 2 ) {

        this.camera.camera = "off";
      }
    },
  },
  mounted() {
  },
  created(){
    this.user = localStorage.getItem("user")
  }
};
</script>

<style scoped>
.home{
  height: 100%;
  background-color: rgb(185, 202, 233);
}
.purpul {
  vertical-align: middle;
}
#app {
  background-color: rgb(77, 75, 71);
}

.fade-enter-active, .fade-leave-active {
  transition: opacity 5s;
}
.fade-enter, .fade-leave-to /* .fade-leave-active below version 2.1.8 */ {
  opacity: 0;
}
#countDown{
  display:flex;
  z-index:999;
  justify-content: center;
  align-items: center;
  height: 95vh;

  font-size:50px;
  -webkit-text-stroke: 5px rgb(235, 215, 215);
  color: white;
}
.formContainer{
  position:fixed;
  display:flex;
  z-index:100;

  justify-content: center;
  align-items: center;
}
.test{
  font-size: xx-large;
}
</style>