<template>


    <div class="background">
      <div class="report">
      <v-container grid-list-lg s>
        <v-row justify="center">
          <v-card min-width="70vw" max-width="90vw" class="mt-16">
            <v-container grid-list-lg>
              <v-row justify="center" align="center">
                <v-col cols="4">
                  <v-row align="center">
                    <v-col class="align-center">
                      工具編號<v-chip label color="yellow">{{
                        tool.QRcode
                      }}</v-chip>
                    </v-col>
                  </v-row>
                  <v-row dense>
                    <v-col class="align-center">
                      儲櫃編號<v-chip label color="primary">{{
                        tool.box_id
                      }}</v-chip>
                    </v-col>
                  </v-row>
                </v-col>
                <v-col cols="1"></v-col>
                <v-col cols="7">
                  <v-row justify="center">
                    <v-col>
                      <h2>{{ tool.name }}</h2>
                    </v-col>
                  </v-row>
                  <v-row dense>
                    <v-col>
                      登記日期<v-chip label color="grey-lighten2">{{
                        tool.time_stamp
                      }}</v-chip>
                    </v-col>
                  </v-row>
                </v-col>
              </v-row>
              <Divider>回報問題</Divider>
              <v-row>
                <v-col align="center">
                  <RadioGroup v-model="reportType" size="large">
                    <Radio label="1">
                      <Icon type="md-help"></Icon>
                      <span>遺失</span>
                    </Radio>
                    <Radio label="2">
                      <Icon type="md-build" />
                      <span>損壞</span>
                    </Radio>
                    <Radio label="3">
                      <Icon type="md-text" />
                      <span>其他</span>
                    </Radio>
                  </RadioGroup>
                </v-col>
              </v-row>
              <Divider>備註</Divider>

              <v-row>
                <v-col>
                  <Input
                    v-model="remark"
                    type="textarea"
                    :rows="4"
                    placeholder="輸入備註"
                  />
                </v-col>
              </v-row>
              <v-row>
                <v-col align="center">
                  <Button size="large" type="warning" long @click="cancel()"
                    >取消</Button
                  >
                </v-col>
                <v-col align="center">
                  <Button size="large" type="success" @click="submit()" long
                    >送出</Button
                  >
                </v-col>
              </v-row>
            </v-container>
          </v-card>
        </v-row>
      </v-container>
    </div>
    </div>

</template>

<script>
import { report } from "../api";

export default {
  name: "",
  props: {
    tool: [],
  },

  data() {
    return {
      reportType: "",
      remark: "",
    };
  },
  methods: {
    cancel() {
      console.log("jiji");
      this.$emit("close");
    },
    submit() {
      if (this.reportType) {
        let data = new FormData();
        data.append("mode", "report");
        data.append("user", this.tool.user);
        data.append("QRcode", this.tool.QRcode);
        data.append("reportType", this.reportType);
        data.append("remark", this.remark);
        report(data).then((res) => {
          if (res.data == "success") {
            console.log(res);
            this.$emit("close");
            this.$emit("Success", "成功提交");
          }
        });
      } else {
        this.$emit("Error", "不能為空");
      }
    },
  },
};
</script>

<style scoped>
.report {
  position: fixed;
  top: 5vh;
  width: 100vw;
  height: 100%;
  z-index: 4;
  left: 0;
  right: 0;
  align-content: center;
  justify-content: center;
}
.background {

  position: fixed; /* Stay in place */
  z-index: 50; /* Sit on top */
  left: 0;

  top: 0;
  width: 100%; /* Full width */
  height: 100%; /* Full height */
  /* Enable scroll if needed */
  background-color: rgb(0,0,0); /* Fallback color */
  background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
}
</style>