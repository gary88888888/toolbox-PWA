<template>
  <div class="home">
    <v-container grid-list-xs>
      <div>
        <div style="position: fixed; z-index: 99; left: 0;right:0;">
        <v-toolbar
          color="#91ede4"
          dense
          width="100%"
          rounded="lg"
        >
          <v-row class="mt-1" justify="center" align="center">
            <v-col justify="center">
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
        <v-card>


        <v-card-text>
               <v-row justify="center" align="center">
            <v-col>

            </v-col>
          </v-row>
          </v-card-text>
        </v-card>
        </div>
        <v-row align="center" justify="center" >

          <v-card
            v-for="(tool, index) in filterItems(tools)"
            :key="index"
            height="auto"
            width="auto"
            class="mt-2"
            rounded="lg"
          >
            <v-hover v-slot="{ hover }">
              <v-container grid-list-xs>
                <v-row>
                  <v-col align="left">
                    <h2>{{ tool.name }}</h2>
                  </v-col>

                  <v-col cols="auto">
                    <v-chip
                      color="#fcad00"
                      text-color="white"
                      v-show="tool.status == 1"
                      label
                      ><h4>外借中</h4>
                    </v-chip>
                    <v-chip
                      color="green"
                      text-color="white"
                      v-show="tool.status == 0"
                      label
                      ><h4>有庫存</h4>
                    </v-chip>
                    <v-chip
                      color="error"
                      text-color="white"
                      v-show="tool.status == 3"
                      label
                      ><h4>故障中</h4>
                    </v-chip>
                    <v-chip
                      color="red"
                      text-color="white"
                      v-show="tool.status == 2"
                      label
                    >
                      <h4>維修中</h4>
                    </v-chip>
                  </v-col>
                </v-row>

                <v-row>
                  <v-col align="left" class="d-flex align-center mb-6">
                    <v-text-field
                      label="工具櫃編號"
                      v-model="tool.box_id"
                      :append-icon="'mdi-pencil'"
                      @click:append="change(tool.QRcode, tool.box_id)"
                    ></v-text-field>
                  </v-col>
                  <v-col cols="auto" align="center">
                    <v-btn
                      align="center"
                      x-small
                      :to="`/alltool/${tool.QRcode}`"
                      ><v-icon>{{ "mdi-pencil" }}</v-icon></v-btn
                    >
                  </v-col>
                </v-row>
                <v-expand-transition>
                  <div v-if="hover">
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
                          grey
                          lighten-2
                          v-card--reveal
                          text-h2
                          white--text
                        "
                      >
                      </v-img>
                    </v-col>
                  </div>
                </v-expand-transition>
              </v-container>
            </v-hover>
          </v-card>
        </v-row>
      </div>
    </v-container>
  </div>
</template>

<script>
import axios from "axios";
import {getAllTools} from "../api.js"
export default {
  name: "allTools",
  data() {
    return {
        searchQuery:"",
        statusQuery:"",
      tools: [],
      status: [
        { text: "庫存中", code: "0" },
        { text: "外借中", code: "1" },
        { text: "維修中", code: "2" },
        { text: "故障中", code: "3" },
      ],
      selected: [
      ],
    };
  },
  methods: {
    filterItems: function (tools) {
      var app = this;
      return tools.filter(function (tool) {
        let regex = new RegExp("(" + app.searchQuery + ")", "i");
        let regex2 = new RegExp("(" + app.statusQuery + ")", "i");
        return (
          tool.name.match(regex) ||
          tool.QRcode.match(regex) ||
          tool.box_id.match(regex) &&
          tool.status.match(regex2)
        );
      });
    },
    change(QRcode, box_id) {
      console.log(QRcode);
      console.log(box_id);
      let edit = new FormData();
      edit.append("QRcode", QRcode);
      edit.append("box_id", box_id);
      axios
        .post("https://192.168.1.103/toolSystem/php/admin/edit.php", edit, {
          headers: {
            "Content-Type": "multipart/form-data",
          },
        })
        .then((res) => {
          if (res.data == "success") {
            console.log(res.data);
            this.Success("成功修改");
          }
        });
    },
    select() {
        console.log(this.selected)
        console.log(this.statusQuery)
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
  },
  created() {
    getAllTools()
      .then((res) => {
        this.tools = res.data;
      });

  },
};
</script>

<style  scoped>
.home{
  height: 100%;
  background-color: rgb(185, 202, 233);
}
</style>