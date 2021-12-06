<template style="overflow-y: hidden;">
  <sidebar />
</template>
<script>
import sidebar from './components/sidebar'


export default {
  name: 'App',

  components: {
    sidebar
  },
  methods:{
    getToken(){
      messaging
      .getToken({
        vapidKey:
        "AIzaSyA3b-6Q-jFB09sI4vXAuehZNIQSFS64yDI",
      })
      .then((currentToken)=>{
        if(currentToken){
          console.log("currentToken",currentToken)
          apiFCM({
            registration_token:currentToken,

          }).then((res)=>{
            console.log(res)
          })
        }else{
          console.log("No registration avalible")

        }
      }).catch((err)=>{
        console.log("error occured:",err)

      })
    },
    receiveMessage(){
      messaging.onMessage((payload)=>{
        console.log("Message receive:",payload)
        let notification = payload.notification
        this.$Message.success({
                content: payload.notification,
                duration: 3,
                background:true
            });
        console.log("notification:",notification)
      })
    }
  },
  created(){
    //this.receiveMessage()
    //this.getToken()
  }


};
</script>
<style >

body{
   font-family: 'Noto Sans TC', sans-serif;
}
</style>