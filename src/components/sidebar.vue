<template>
    <v-app id="inspire" >

    <v-navigation-drawer
      v-model="drawer"
      light
      app
      color="rgb(201, 222, 255)"
      class="drawer"

    >
      <v-list-item >
         <v-list-item-avatar>
          <v-img :src=" 'https://192.168.1.103/toolSystem/img/user/'+user+'.png' "  ></v-img>
        </v-list-item-avatar>
        <v-list-item-content>
          <v-list-item-title class="title">{{user}}</v-list-item-title>
          <v-list-item-subtitle>身分:{{position}}</v-list-item-subtitle>
        </v-list-item-content>
      </v-list-item>
      <v-divider width="300"></v-divider>
      <v-list-item  to="/">
        <v-icon large>{{"mdi-home"}}</v-icon>
        <v-list-item-content>

          <v-list-item-title>首頁</v-list-item-title>
        </v-list-item-content>
      </v-list-item>
      <v-list-item to="/borrow" >
        <v-icon large>{{"mdi-hammer-screwdriver"}}</v-icon>
        <v-list-item-content>

          <v-list-item-title large>工具登記
          </v-list-item-title>
        </v-list-item-content>
      </v-list-item>

      <v-list-item to="/myTools">
        <v-icon large>{{"mdi-account"}}</v-icon>
        <v-list-item-content>

          <v-list-item-title large>我的工具</v-list-item-title>
        </v-list-item-content>
      </v-list-item>



      <v-list-group
          v-if="position =='admin' "
          :value="true"
          no-action
          sub-group
        >
     <template v-slot:activator>
            <v-list-item-content>
              <v-list-item-title>管理</v-list-item-title>
            </v-list-item-content>
          </template>

          <v-list-item
            v-for="([title, icon,site], i) in admins"
            :key="i"
            link
            :to="site"
          >
            <v-list-item-title v-text="title" ></v-list-item-title>

            <v-list-item-icon>
              <v-icon v-text="icon"></v-icon>
            </v-list-item-icon>
          </v-list-item>
        </v-list-group>
      <v-row class="mt-17" justify="bottom" align="center" >
        <v-col justify="center" align="center">
          <v-btn color="success" @click="logout()">登出</v-btn>
        </v-col>
      </v-row>
    </v-navigation-drawer>

    <v-app-bar app color="#7a8cff" dark>

      <v-app-bar-nav-icon @click="drawer = !drawer" v-if="islogin"></v-app-bar-nav-icon>

      <v-toolbar-title dark style="cursor: pointer" @click="$router.push('/')" >{{$route.meta.title}}</v-toolbar-title>

    </v-app-bar>
    <v-main>
      <transition name="slide-fade">
      <router-view  v-if="isRouterAlive" />
      </transition>
    </v-main>


  </v-app>
</template>

<script>
export default {
  provide(){
    return{
      reload: this.reload
    }
  },
data: () => ({
  isRouterAlive:true,
    drawer:false,
    user:"",
    position:"",
    islogin:false,
    admins:[
      ["工具一覽",'mdi-account-multiple-outline','/allTools'],
      ['問題回報', 'mdi-cog-outline','/report'],
      ['調用紀錄', 'mdi-cog-outline','/history'],
    ],
    transitionName:'',


  }),
  methods:{
    reload(){
      this.isRouterAlive = false
      this.$nextTick(function(){
        this.isRouterAlive = true
      })
    },

    logout(){
      localStorage.clear();
      this.user=""
      this.position=""
      this.islogin=false
      this.$router.push('/login')

    }
  },
  mounted(){
    if(localStorage.islogin){
      this.islogin = localStorage.islogin
      console.log("mounted")
    }
    this.user = localStorage.getItem("user")
    this.position = localStorage.getItem("position")
  },
  watch:{
    islogin(){
    this.user = localStorage.getItem("user")
    this.position = localStorage.getItem("position")
    },
    $route(to, from) {
      //如果to索引大于from索引,判断为前进状态,反之
      if (to.meta.index > from.meta.index) {
        this.transitionName = 'slide-left';
      } else {
        this.transitionName = 'slide-right';
      }
    }

  }
}
</script>

<style scoped>
.router-link-exact-active {
  color: #ffb01f;
}
.slide-right-enter-active,
.slide-right-leave-active,
.slide-left-enter-active,
.slide-left-leave-active {
  will-change: transform;
  transition: all 500ms;
  position: absolute;
}
.slide-right-enter {
  opacity: 0;
  transform: translate3d(-100%, 0, 0);
}
.slide-right-leave-active {
  opacity: 0;
  transform: translate3d(100%, 0, 0);
}
.slide-left-enter {
  opacity: 0;
  transform: translate3d(100%, 0, 0);
}
.slide-left-leave-active {
  opacity: 0;
  transform: translate3d(-100%, 0, 0);
}

.slide-fade{
 position: absolute;left:0;right: 0;
}
.slide-fade-enter-active {
 transition: all 0.6s ease;
}
.slide-fade-leave-active {

 transition: all .1s cubic-bezier(2.0, 0.5, 0.8, 1.0);
}
.slide-fade-enter, .slide-fade-leave-to
{
 left:0;right: 0;
 transform: translateX(50px);
 opacity: 0;
}
#inspire{
  z-index: 999;
}
.drawer{
  z-index: 999;

}
</style>