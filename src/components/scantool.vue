<template>
  <div class="camera">
    <v-container grid-list-sm>
      <div class="frame" v-if="this.step != 4">
        <div
          class="interFrame"
          style="position: fixed; z-index: 999; margin: auto"
        >
          <v-container grid-list-xs>
            <v-row align="center">
              <v-col align="center" cols="auto">
                <h1 style="color: white; font-size: 2em; align: center">
                  {{ this.message }}
                </h1>
              </v-col>
              <v-col>
                <v-chip v-show="this.step == 1" label color="yellow"
                  ><h3>{{ QRcode }}</h3> </v-chip
                ><v-chip v-show="this.step == 2" label color="primary"
                  ><h3>{{ box_id }}</h3></v-chip
                >
              </v-col>
            </v-row>
          </v-container>
          <!-- <div class="countDown" v-show="this.isCount">

            {{this.time}}


          </div> -->
        </div>

        <qrcode-stream
          :camera="cameraSwitch"
          @decode="onDecode"
          @init="onInit"
          :paused="paused"
          :torch="torchActive"
        >
          <!-- <div class="formContainer" ref="formContainer"></div> -->
        </qrcode-stream>
      </div>
      <v-row v-if="this.step == 4" align="center" justify="center">
        <v-col align="center" justify="center">
          <v-card
            color="light-blue lighten-3"
            rounded="xl"
            width="90vw"
            height="400"
          >
            <div class="formContainer" ref="formContainer">
              <div
                style="
                  position: absolute;
                  display: flex;
                  z-index: 999;
                  justify-content: center;
                  width: 90vw;
                  height: 400px;
                  align-items: center;
                  font-size: 120px;
                  -webkit-text-stroke: 5px #ff7c40;
                  color: #ff7c40;
                "
              >
                {{ this.time }}
              </div>
              <div
                style="
                  position: absolute;
                  justify-content: center;
                  width: 90vw;
                  height: 400px;
                  align-items: center;
                  color: white;
                  top: 20px;
                "
              >
                <h1 style="font-size: 25px">請在時間內解鎖</h1>
              </div>
            </div></v-card
          >
        </v-col>
      </v-row>
      <div id="wrap" v-if="this.step != 4">
        <div class="div">
          <v-btn color="orange" width="95vw" @click="closeCamera()">取消</v-btn>
        </div>
        <!-- <div class="div">
          <v-btn color="green" width="47.5vw" @click="reload()">下一步</v-btn>
      </div> -->
      </div>
    </v-container>
  </div>
</template>

<script>
import axios from "axios";
import { QrcodeStream, QrcodeDropZone, QrcodeCapture } from "vue-qrcode-reader";
import MyLoading from "../components/loadingText.vue";
import { returnSubmit, locate } from "../api.js";
export default {
  name: "",
  Components: {
    QrcodeStream,
    QrcodeDropZone,
    QrcodeCapture,
    MyLoading,
  },
  props: {
    box_id: { type: String, default: "" },
    QRcode: { type: String, default: "" },
    cameraSwitch: { type: String, default: "off" },
  },
  inject: ["reload"],
  data() {
    return {
      scaned: false,
      decodedContent: null,
      errorMessage: "",
      paused: false,
      history: [],
      qrcode: "",
      corrent: null,
      stream: false,
      styleVar: {
        "--cameraColor": "rgb(72, 204, 228)",
      },
      date: null,
      imgs: [],
      time: 0,
      status: "",
      checkRes: false,
      message: "",
      step: "",
      fullPage: false,
      loading: null,
      countDownTimer: null,
      isCount: false,
      currentToolStatus: null,
      returnErrorTimer: null,
      torchActive: false,
    };
  },
  methods: {
    async onDecode(content) {
      this.decodedContent = content;
      console.log(this.decodedContent);
      console.log(this.QRcode);

      switch (this.step) {
        case 1:
          console.log("this is step 1");

          if (this.decodedContent == this.QRcode) {
            this.Success("核對成功");
            this.checkRes = true;
            this.step = 2;
            this.message = "掃描工具櫃";
            let data = new FormData();
            data.append("mode", "open");
            data.append("box_id",this.box_id);
            locate(data).then((res) => {
              if (res.data == "success") {
                console.log("success");
                this.Success("定位中");
              } else {
                console.log("NULL");
              }
            });
          } else if (this.decodedContent != this.QRcode) {
            console.log("錯誤");
            this.Error("核對錯誤");
            this.pause();
            await this.timeout(500);
            this.unpause();
          }

          break;
        case 2:
          if (this.decodedContent == this.box_id) {
            this.Success("核對成功");
            this.checkRes = true;
            ////////////////////////
            this.submit(this.box_id);
            // this.cameraSwitch = "off"
            this.message = "請在時限內歸還完成";
            this.step = 4;
          } else {
            console.log("錯誤");

            this.Error("核對錯誤");
            this.pause();
            await this.timeout(500);
            this.unpause();
          }

          break;
      }
    },

    onInit(promise) {
      this.message = "請掃描工具";
      this.step = 1;
      // if(this.loading!=null){
      // this.loading.hide()

      // }
      promise
        .then(() => {
          console.log("Successfully initilized! Ready for scanning now!");
        })
        .catch((error) => {
          if (error.name === "NotAllowedError") {
            this.errorMessage = "Hey! I need access to your camera";
          } else if (error.name === "NotFoundError") {
            this.errorMessage = "Do you even have a camera on your device?";
          } else if (error.name === "NotSupportedError") {
            this.errorMessage =
              "Seems like this page is served in non-secure context (HTTPS, localhost or file://)";
          } else if (error.name === "NotReadableError") {
            this.errorMessage =
              "Couldn't access your camera. Is it already in use?";
          } else if (error.name === "OverconstrainedError") {
            this.errorMessage =
              "Constraints don't match any installed camera. Did you asked for the front camera although there is none?";
          } else {
            this.errorMessage = "UNKNOWN ERROR: " + error.message;
          }
        });
    },

    closeCamera() {
      this.camera = "off";
      this.$emit("close");
      this.loading.hide();
    },
    openCamera() {
      this.camera = "auto";
    },

    unpause() {
      this.cameraSwitch = "auto";
    },

    pause() {
      this.cameraSwitch = "off";
    },

    timeout(ms) {
      return new Promise((resolve) => {
        window.setTimeout(resolve, ms);
      });
    },
    borrow() {
      this.status = "1"; // 借出
      axios
        .post(
          "https://192.168.1.103/toolSystem/pwa_php/single_upload.php?QRcode=" +
            this.qrcode +
            "&date=" +
            this.date +
            "&time=" +
            this.time +
            "&status=" +
            this.status +
            "&user=" +
            this.user
        )
        .then((res) => {
          if (res.data == "success") {
            this.Success("借出成功");
            this.retry();
          }
        });
    },
    Error(content) {
      this.$Message.error({
        content: content,
        duration: 3,
        background: true,
      });
    },
    Success(content) {
      this.$Message.success({
        content: content,
        duration: 3,
        background: true,
      });
    },
    returnOpen(box_id) {
      let data = new FormData();
      data.append("mode", "open");
      data.append("box_id", box_id);
      returnSubmit(data).then((res) => {
        if (res.data == "success") {
          console.log("success");
          this.Success("正在開啟中");
        } else {
          console.log("NULL");
        }
      });
    },
    returnClose(box_id) {
      let data = new FormData();
      data.append("mode", "close");
      data.append("box_id", box_id);
      returnSubmit(data).then((res) => {
        if (res.data == "success") {
          console.log("success");
          this.Success("已關閉");
        } else {
          console.log("NULL");
        }
      });
    },
    returnError(box_id) {
      this.loading.hide();
      this.isCount = false;
      let data = new FormData();
      data.append("mode", "error");
      data.append("box_id", box_id);
      returnSubmit(data).then((res) => {
        if (res.data == "success") {
          console.log("success");
          this.Error("歸還失敗");
          this.reload();
        } else {
          console.log("NULL");
        }
      });
    },

    statusCheck(box_id) {
      let data = new FormData();
      data.append("mode", "search");
      data.append("box_id", box_id);
      returnSubmit(data).then((res) => {
        this.currentToolStatus = res.data[0].status;
      });
      if (this.currentToolStatus == "0") {
        this.Success("成功");
        clearTimeout(this.countDownTimer);
        clearTimeout(this.returnErrorTimer);
        this.loading.hide();
        this.$emit("close");
        this.reload();
      }
    },
    countdown(box_id) {
      if (this.time != 0) {
        this.time--;
        this.statusCheck(box_id);
        console.log(this.currentToolStatus);
      } else {
        clearInterval(this.countDownTimer);
      }
    },
    loadingFun() {
      this.loading = this.$loading.show(
        {
          container: this.fullPage ? null : this.$refs.formContainer,
          canCancel: false,
          onCancel: this.onCancel,
          color: "#18d651",
          loader: "spinner",
          width: 170,
          height: 170,
          backgroundColor: "#636b65",
          opacity: 0,
        },
        {
          // default: this.$createElement('MyLoading'),
        }
      );
    },

    submit(box_id) {
      this.torchActive = false;
      this.message = "請在時間內解鎖";
      this.returnOpen(box_id);
      this.isCount = true;
      this.time = 20;
      this.countDownTimer = setInterval(this.countdown, 1000, box_id);
      this.returnErrorTimer = setTimeout(this.returnError, 20000, box_id);
      setTimeout(() => {
        this.loadingFun();
      }, 100);

      this.step = 3;
      this.message = "工具櫃已解鎖";
    },
    onCancel() {},
  },
  watch: {
    scaned: function () {
      if (this.scaned == true) {
        // this.stream = !this.stream
        this.camera = "off";
      }
    },
  },
};
</script>

<style scoped>
.camera {
  position: fixed;
  top: 20vh;
  right: 0;
  z-index: 900;
}
.purpul {
  vertical-align: middle;
}
#app {
  background-color: rgb(77, 75, 71);
}
.frame {
  border: 3px solid black;
  position: relative;
  width: 95vw;
  display: flex;
  justify-content: center;
  /* align-items: center; */
}
#wrap {
  display: flex;
}
.div {
  width: 47.5vw;
  position: relative;
}
.countDown {
  display: flex;
  z-index: 998;

  justify-content: center;
  align-items: center;
  height: 39vh;

  font-size: 50px;
  -webkit-text-stroke: 5px rgb(235, 215, 215);
  color: white;
}
.formContainer {
  display: flex;
  z-index: 998;

  justify-content: center;
  align-items: center;
  height: 400px;

  font-size: 50px;
  -webkit-text-stroke: 5px rgb(235, 215, 215);
  color: white;
}
</style>