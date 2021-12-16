<template>
  <div class="home">
    <v-container grid-list-lg>
      <Tabs>
        <TabPane label="未處理" icon="md-paper">
          <v-container grid-list-xs>
            <v-row
              justify="center"
              align="center"
              v-for="report in data"
              :key="report.report_id"
            >
              <v-container grid-list-md>
                <v-card
                  rounded="lg"
                  height="auto"
                  v-if="report.reportStatus == '0'"
                >
                  <v-container grid-list-xs>
                    <v-row justify="center" align="center">
                      <v-col cols="4">
                        <v-row>
                          <v-col>
                            <v-avatar>
                              <img
                                :src="
                                  'https://192.168.1.103/toolSystem/img/user/' +
                                  report.user +
                                  '.png'
                                "
                                alt="error"
                              />
                            </v-avatar>
                          </v-col>
                        </v-row>
                        <v-row no-gutters align="center">
                          <v-col>
                            <h2>{{ report.user }}</h2>
                          </v-col>
                        </v-row>
                      </v-col>
                      <v-col cols="8">
                        <v-row>
                          <v-col>
                            <h2>{{ report.name }}</h2>
                          </v-col>
                        </v-row>
                        <v-row>
                          <v-col>
                            <v-chip
                              color="red"
                              text-color="white"
                              v-show="report.reportStatus == 0"
                              label
                              ><h2>未處理</h2>
                            </v-chip>
                            <v-chip
                              color="green"
                              text-color="white"
                              v-show="report.reportStatus == 1"
                              ><h2>已處理</h2>
                            </v-chip>
                          </v-col>
                        </v-row>
                      </v-col>
                    </v-row>
                    <v-divider class="ma-2"></v-divider>
                    <v-row justify="center" align="center">
                      <v-col cols="4">
                        <v-row justify="center" align="center">
                          <v-col class="align-center">
                            <v-chip label color="yellow">{{
                              report.QRcode
                            }}</v-chip>
                          </v-col>
                        </v-row>
                        <v-row dense justify="center" align="center">
                          <v-col class="align-center">
                            <v-chip label color="primary">{{
                              report.QRcode
                            }}</v-chip>
                          </v-col>
                        </v-row>
                      </v-col>
                      <v-col cols="8">
                        <v-row>
                          <v-col>
                            <v-chip label>{{ report.timeStamp }}</v-chip>
                          </v-col>
                        </v-row>
                        <Input
                          v-model="report.remark"
                          type="textarea"
                          readonly
                          placeholder="沒有備註"
                        />
                      </v-col>
                    </v-row>
                     <v-row>

                      <v-col align="center">
                        <Button
                          size="small"
                          type="success"
                          long
                          @click="fix(report.report_id)"
                          >處理</Button
                        >
                      </v-col>
                    </v-row>
                  </v-container>
                </v-card>
              </v-container>
            </v-row>
          </v-container>
        </TabPane>
        <TabPane label="已處裡" icon="md-paper">
          <v-container grid-list-xs>
            <v-row
              justify="center"
              align="center"
              v-for="report in data"
              :key="report.index"
            >
              <v-container grid-list-md>
                <v-card
                  rounded="lg"
                  height="auto"
                  v-if="report.reportStatus == '1'"
                >
                  <v-container grid-list-xs>
                    <v-row justify="center" align="center">
                      <v-col cols="4">
                        <v-row>
                          <v-col>
                            <v-avatar>
                              <img
                                :src="
                                  'https://192.168.1.103/toolSystem/img/user/' +
                                  report.user +
                                  '.png'
                                "
                                alt="error"
                              />
                            </v-avatar>
                          </v-col>
                        </v-row>
                        <v-row no-gutters align="center">
                          <v-col>
                            <h2>{{ report.user }}</h2>
                          </v-col>
                        </v-row>
                      </v-col>
                      <v-col cols="8">
                        <v-row>
                          <v-col>
                            <h2>{{ report.name }}</h2>
                          </v-col>
                        </v-row>
                        <v-row>
                          <v-col>
                            <v-chip
                              color="red"
                              text-color="white"
                              v-show="report.reportStatus == 0"
                              label
                              ><h2>未處理</h2>
                            </v-chip>
                            <v-chip
                              color="green"
                              text-color="white"
                              v-show="report.reportStatus == 1"
                              ><h2>已處理</h2>
                            </v-chip>
                          </v-col>
                        </v-row>
                      </v-col>
                    </v-row>
                    <v-divider class="ma-2"></v-divider>
                    <v-row justify="center" align="center">
                      <v-col cols="4">
                        <v-row justify="center" align="center">
                          <v-col class="align-center">
                            <v-chip label color="yellow">{{
                              report.QRcode
                            }}</v-chip>
                          </v-col>
                        </v-row>
                        <v-row dense justify="center" align="center">
                          <v-col class="align-center">
                            <v-chip label color="primary">{{
                              report.QRcode
                            }}</v-chip>
                          </v-col>
                        </v-row>
                      </v-col>
                      <v-col cols="8">
                        <v-row>
                          <v-col>
                            <v-chip label>{{ report.timeStamp }}</v-chip>
                          </v-col>
                        </v-row>
                        <Input
                          v-model="report.remark"
                          type="textarea"
                          readonly
                          placeholder="沒有備註"
                        />
                      </v-col>
                    </v-row>

                  </v-container>
                </v-card>
              </v-container>
            </v-row>
          </v-container>
        </TabPane>
      </Tabs>
    </v-container>
  </div>
</template>

<script>
import { history, report } from "../api";

export default {
  name: "report",
  data() {
    return {
      data: [],
    };
  },
  inject:["reload"],
  methods: {
    getData() {
      let data = new FormData();
      data.append("mode", "search");

      report(data).then((res) => {
        this.data = res.data;
        console.log(this.data);
      });
    },
    fix(report_id){
       let data = new FormData();
      data.append("mode", "fix");
      data.append("report_id", report_id);
      report(data).then((res) => {
          console.log(res.data)
          if(res.data == "success"){
              this.Success("確認處理")
            setTimeout(() => {
               this.reload()
            }, 2000);

          }
      });
    },
    Error(content) {
      this.$Message.error({
                content: content,
                duration: 2,
                background:true
            });
    },
    Success(content) {
      this.$Message.success({
                content: content,
                duration: 2,
                background:true
            });
    },
  },
  created() {
    this.getData();
  },
};
</script>

<style  scoped>
.home {
  height: 100%;
  background-color: rgb(185, 202, 233);
}
</style>