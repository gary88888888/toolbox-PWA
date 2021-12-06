<template>
  <div class="home">
    <v-container grid-list-xs>
      <v-row
        ><v-spacer><v-col></v-col></v-spacer
      ></v-row>
      <v-row justify="center" align="center" v-for="order in tools_orders" :key="order.id">
        <v-container grid-list-md>
          <v-card rounded="lg" height="auto">
            <v-container grid-list-xs>
              <v-row justify="center" align="center">
                <v-col cols="auto">
                  <v-avatar>
                    <img
                      src="https://cdn.vuetifyjs.com/images/john.jpg"
                      alt="John"
                    />
                  </v-avatar>
                </v-col>
                <v-col>
                  <h2>{{order.user}}</h2>
                </v-col>
                <v-col>
                  <v-chip label>{{order.time_stamp_update}}</v-chip>
                </v-col>
              </v-row>
              <v-divider class="ma-2"></v-divider>
              <v-row justify="center" align="center">
                <v-col cols="12">
                  <v-row justify="center" align="center">
                    <v-col class="align-center">
                      <v-chip label color="yellow">{{order.QRcode}}</v-chip>
                    </v-col>
                    <v-col>
                      <h2> {{order.name}}</h2>
                    </v-col>
                  </v-row>
                  <v-row dense justify="center" align="center">
                    <v-col class="align-center" >
                      <v-chip label color="primary">{{order.QRcode}}</v-chip>
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
                <!-- <v-col cols="4">
                  <v-img
                    rounded
                    :aspect-ratio="16 / 9"
                    :src="
                      'https://192.168.1.103/toolSystem/img/tools/' +
                      700241 +
                      '.jpg'
                    "
                  >
                  </v-img>
                </v-col> -->
              </v-row>
            </v-container>
          </v-card>
        </v-container>
      </v-row>
    </v-container>
  </div>
</template>

<script>
import axios from "axios";
export default {
  name: "",
  data() {
    return {
      tools_orders: [],
    };
  },
  created() {
    axios
      .post("https://192.168.0.20/toolSystem/pwa_php/history.php")
      .then((res) => {
        if (res.data != "error") {
          console.log(res.data);
          this.tools_orders = res.data;
        } else {
        }
      });
  },
};
</script>

<style scoped>
.home {
  height: 100%;
  background-color: rgb(185, 202, 233);
}
</style>