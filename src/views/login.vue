<template>
<div class="background">
    <v-container text-xs-center fill-height >
        <v-row justify='center' >
        <v-card height="500" flat width="500" color="rgba(0,0,0,0.0)">
            <v-row justify="center">
                <v-img
                class="mx-2"
                src="https://192.168.1.103/order-system/img/logo3.png"
                max-height="200"
                max-width="200"
                contain
                dark
                ></v-img>
            </v-row>
            <v-row ma-5>
                <v-col >
                <v-form ref="form" v-model="valid" @keyup.native.enter="login">
                  <v-text-field
                    v-model="account"
                    prepend-icon="mdi-account-circle"
                    name="name"
                    label="帳號"
                    :rules="rules.account"
                    width="60vw"
                    dark
                    autocomplete="off"
                    required
                ></v-text-field>
                <v-text-field
                    v-model="password"
                    prepend-icon="mdi-lock"
                    name="name"
                    label="密碼"
                    width="60vw"
                    dark
                    :rules="rules.password"
                    :append-icon="show1 ? 'mdi-eye' : 'mdi-eye-off'"
                    :type="show1 ? 'text' : 'password'"
                    @click:append="show1 = !show1"
                    required
                ></v-text-field>
                </v-form>
                </v-col>
            </v-row>
               <v-row ma-5>
                <v-col >

                </v-col>
            </v-row>
            <v-row justify="center">
                <v-card-actions>
                <v-btn color="rgba(0,0,0,0)" width="400" type="submit" dark @click.prevent="login()" :loading = this.$store.state.isloginloading ><h3>登入</h3></v-btn>
                </v-card-actions>
            </v-row>
            <!-- <v-btn color="success" @click="decodeToken()">text</v-btn> -->
        </v-card>
        </v-row>


    </v-container>
</div>
</template>

<script>
import axios from 'axios'
import { apiUserLogin } from "../api.js";
export default {
    components:{

    },
data () {
      return {
        show1: false,
        account:"",
        password:"",
        valid:false,
        rules: {
        account: [
          v => !!v || '帳號不能空白',
        ],
        password: [
          v => !!v || '密碼不能空白',
        ],
        },
        error:'帳號密碼錯誤',
        iserror:false
      }
},
methods:{
    login(){
    if(this.account && this.password){
    let login = new FormData()
    login.append('account',this.account)
    login.append('password',this.password)


            apiUserLogin(
                login
            ).then(res=>{
                    if(res.data!="error"){
                        localStorage.setItem('user',res.data.user)
                        localStorage.setItem('position',res.data.position)
                        localStorage.setItem('islogin',true)
                        console.log("login success")
                        this.Success("登入成功")
                        this.$router.push('/')
                        this.Success("登入成功")
                        window.location.reload(true)

                    }else{
                        this.Error("登入失敗")
                        this.password=""
                        this.account=""
                    }

                })



    }

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

}
}
</script>

<style>
.background{
position: fixed;
top: 0;
left: 0;
bottom: 0;
right: 0;
background: -webkit-linear-gradient(left top,rgb(53, 50, 50),rgb(158, 163, 157));
background: -o-linear-gradient(bottom right,rgb(53, 50, 50),rgb(224, 224, 224));
background: -moz-linear-gradient(bottom right,rgb(53, 50, 50),rgb(213, 216, 213));
background: linear-gradient(to bottom right,rgb(36, 33, 33),rgb(185, 197, 182));
}
input:-webkit-autofill , textarea:-webkit-autofill, select:-webkit-autofill {

    -webkit-text-fill-color: #ededed !important;
    /* -webkit-box-shadow: 0 0 0px 1000px transparent  inset !important;   */
    background-color:rgb(213, 216, 213);
    background-image: none;
    transition: background-color 50000s ease-in-out 0s;
}
</style>