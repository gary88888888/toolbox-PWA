<template>
  <div class="home">
    <Tabs>
      <TabPane label="全部" icon="md-paper">
        <v-container grid-list-xs>
          <v-row
            justify="center"
            align="center"
            v-for="order in tools_orders"
            :key="order.id"
          >
            <v-container grid-list-md>
              <v-card rounded="lg" height="auto">
                <v-container grid-list-xs>
                  <v-row justify="center" align="center">
                    <v-col cols="auto">
                      <v-avatar>
                        <img
                          :src="
                            'https://192.168.1.103/toolSystem/img/user/' +
                            order.user +
                            '.png'
                          "
                          alt="John"
                        />
                      </v-avatar>
                    </v-col>
                    <v-col>
                      <h2>{{ order.user }}</h2>
                    </v-col>
                    <v-col>
                      <v-chip label>{{ order.time_stamp_update }}</v-chip>
                    </v-col>
                  </v-row>
                  <v-divider class="ma-2"></v-divider>
                  <v-row justify="center" align="center">
                    <v-col cols="12">
                      <v-row justify="center" align="center">
                        <v-col class="align-center">
                          <v-chip label color="yellow">{{
                            order.QRcode
                          }}</v-chip>
                        </v-col>
                        <v-col>
                          <h2>{{ order.name }}</h2>
                        </v-col>
                      </v-row>
                      <v-row dense justify="center" align="center">
                        <v-col class="align-center">
                          <v-chip label color="primary">{{
                            order.QRcode
                          }}</v-chip>
                        </v-col>
                        <v-col>
                          <v-chip
                            color="red"
                            text-color="white"
                            v-show="order.order_status == 0"
                            label
                            ><h2>借用中</h2>
                          </v-chip>
                          <v-chip
                            color="green"
                            text-color="white"
                            v-show="order.order_status == 1"
                            ><h2>已歸還</h2>
                        </v-chip>
                        </v-col>
                      </v-row>
                    </v-col>
                  </v-row>
                </v-container>
              </v-card>
            </v-container>
          </v-row>
        </v-container>
      </TabPane>
      <TabPane label="人" icon="md-person">
        <v-container grid-list-lg>
          <v-row v-for="user in users" :key="user.id">
            <v-col>
              <v-card rounded="lg">
                <v-container grid-list-lg>
                  <v-row justify="center" align="center">
                    <v-col cols="auto">
                      <v-avatar>
                        <img
                          :src="
                            'https://192.168.1.103/toolSystem/img/user/' +
                            user.user +
                            '.png'
                          "
                          alt="John"
                        />
                      </v-avatar>
                    </v-col>
                    <v-col>
                      <h2>{{ user.user }}</h2>
                    </v-col>
                    <v-col>
                      <v-chip
                        label
                        color="green"
                        dark
                        v-if="user.position == 'user'"
                        ><h2>成員</h2>
                      </v-chip>
                      <v-chip
                        label
                        color="primary"
                        dark
                        v-if="user.position == 'admin'"
                        ><h2>管理員</h2>
                      </v-chip>
                    </v-col>
                  </v-row>
                  <v-row>
                    <Collapse simple>
                      <Panel name="1">
                       紀錄
                        <p slot="content">
                           <v-container grid-list-xs>
                              <Person :user="user.user"></Person>
                           </v-container>

                        </p>
                      </Panel>
                    </Collapse>
                  </v-row>
                </v-container>
              </v-card>
            </v-col>
          </v-row>
        </v-container>
      </TabPane>
      <TabPane label="物" icon="ios-hammer">标签三的内容</TabPane>
    </Tabs>
  </div>
</template>

<script>
import axios from "axios";
import { history, getUser } from "../api.js";
import Person from "../components/history/person.vue"
export default {
  name: "history",
  data() {
    return {
      tools_orders: [],
      users: [],
    };
  },
  components:{
      Person
  },
  methods: {
    history() {
      let data = new FormData();
      data.append("mode", "all");
      history(data).then((res) => {
        if (res.data != "error") {
          this.tools_orders = res.data;
        } else {
          this.Error("關閉失敗");
        }
      });
    },
    getUser() {
      let data = new FormData();
      data.append("mode", "user");
      getUser(data).then((res) => {
        if (res.data != "error") {
          this.users = res.data;
        } else {
          this.Error("錯誤");
        }
      });
    },
  },
  created() {
    this.history();
    this.getUser();
  },
};
</script>

<style scoped>
.home {
  height: 100%;
  background-color: rgb(185, 202, 233);
}
</style>