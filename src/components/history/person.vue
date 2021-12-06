<template>
  <v-container grid-list-lg>
    <v-row justify="center" align="center">
      <v-col>
        <v-row
          justify="center"
          align="center"
          v-for="history in historys"
          :key="history.id"
        >
          <v-card width="100%"  class="mt-1" color="#ebf2f7"
            ><v-container grid-list-lg>
              <v-row justify="center" align="center">
                <v-col class="align-center">
                  <v-chip label color="yellow">{{ history.QRcode }}</v-chip>
                </v-col>
                <v-col>
                  {{ history.name }}
                </v-col>
                <v-col>
                  <v-chip
                    color="red"
                    text-color="white"
                    v-show="history.order_status == 0"
                    label
                    ><h2>借用中</h2>
                  </v-chip>
                  <v-chip
                    color="green"
                    text-color="white"
                    v-show="history.order_status == 1"
                    ><h2>已歸還</h2>
                  </v-chip>
                </v-col>
              </v-row>
              <v-row justify="center" align="center">
                <v-col class="align-center">
                  <v-chip label color="primary">{{ history.box_id }}</v-chip>
                </v-col>
                <v-col>
                  <v-chip label>{{ history.time_stamp_update }}</v-chip>
                </v-col>
              </v-row></v-container
            >
          </v-card>
        </v-row>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
import { getUser } from "../../api";

export default {
  name: "",
  props: {
    user: { type: String, default: "" },
  },
  data() {
    return {
      historys: [],
    };
  },
  methods: {
    data() {
      let data = new FormData();
      data.append("mode", "person");
      data.append("user", this.user);
      getUser(data).then((res) => {
        if (res.data != "error") {
          this.historys = res.data;
          console.log(this.historys);
        } else {
          this.Error("關閉失敗");
        }
      });
    },
  },
  created() {
    this.data();
  },
};
</script>

<style scoped>
</style>