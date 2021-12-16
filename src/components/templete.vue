<template>
<div class="delete">
    <v-card class="slider">
        <div class="report" ref='report' @click="report">
            問題回報

        </div>
        <div class="content" @touchstart='touchStart' @touchmove='touchMove' @touchend='touchEnd' :style="deleteSlider">
            <!-- 插槽中放具体项目中需要内容 -->
            <v-container grid-list-lg>
                <slot ></slot>
            </v-container>



            <!-- 默认插槽 -->
        </div>
        <div class="remove" ref='remove' @click="turnback">
            歸還
        </div>
    </v-card>

</div>
</template>
<script>

export default {
    props: ['index'],
    data() {
        return {
            startX: 0,   //触摸位置
            endX: 0,     //结束位置
            moveX: 0,   //滑动时的位置
            disX: 0,    //移动距离
            deleteSlider: '',//滑动时的效果,使用v-bind:style="deleteSlider",
            status:"mid"
        }
    },
    methods:{
        touchStart(ev){
            ev = ev || event
            //tounches类数组，等于1时表示此时有只有一只手指在触摸屏幕
            if(ev.touches.length == 1){
                // 记录开始位置
                this.startX = ev.touches[0].clientX;
            }
        },
        touchMove(ev){
            ev = ev ;

            //获取删除按钮的宽度，此宽度为滑块左滑的最大距离
            let wd = this.$refs.remove.offsetWidth;
            let wd2 = this.$refs.report.offsetWidth;
            if(ev.touches.length == 1) {

                // 滑动时距离浏览器左侧实时距离
                this.moveX = ev.touches[0].clientX
                //起始位置减去 实时的滑动的距离，得到手指实时偏移距离
                this.disX = this.startX - this.moveX;
                //console.log(this.disX)
                // 如果是向右滑动或者不滑动，不改变滑块的位置
                if (this.disX < 0 || this.disX > 0) {
                    this.deleteSlider = "transform:translateX(0px)";
                } else if (this.disX > 0) {// 大于0，表示左滑了，此时滑块开始滑动
                    //具体滑动距离我取的是 手指偏移距离*5。
                    this.deleteSlider = "transform:translateX(-" + this.disX*3 + "px)";
                    // 最大也只能等于删除按钮宽度
                    if (this.disX*3 >= wd) {
                        this.deleteSlider = "transform:translateX(-" +wd+ "px)";
                    }
                }else if(this.disX < 0){
                    this.deleteSlider = "transform:translateX(" + this.disX*3 + "px)";
                    if (this.disX*-3 >= wd2) {
                        this.deleteSlider = "transform:translateX(" +wd2+ "px)";
                    }
                }
            }
        },
        touchEnd(ev){
            ev = ev ;
            let wd = this.$refs.remove.offsetWidth;
            let wd2 = this.$refs.report.offsetWidth;
            if (ev.changedTouches.length == 1) {
                let endX = ev.changedTouches[0].clientX;
                this.disX = this.startX - endX;
                //console.log(this.disX)
                //如果距离小于删除按钮一半,强行回到起点
                if ((this.disX*1) < (wd) && this.disX>0) {
                    this.deleteSlider = "transform:translateX(0px)";
                    this.status ="mid"
                }else if((this.disX*3) > (wd) && this.disX>0 ){
                    //大于一半 滑动到最大值
                    this.deleteSlider = "transform:translateX(-"+wd+ "px)";
                    this.status = "right"
                }else if((this.disX*-3) > (wd2) && this.disX<0){
                    this.deleteSlider = "transform:translateX("+wd2+ "px)";
                    this.status = "left"

                }else if((this.disX*-1) < (wd2) && this.disX<0){
                    this.deleteSlider = "transform:translateX(0px)";
                    this.status ="mid"


                }
            }
        },
        turnback (){
            this.deleteSlider = "transform:translateX(0px)";
            this.$emit('turnback');
        },
         report (){
            this.deleteSlider = "transform:translateX(0px)";
            this.$emit('report');
        }
    }
}
</script>
<style scoped>
.slider{
    width: 100%;
    height: 22vh;
    margin-bottom: 10px;
    position: relative;
    border-radius: 20px;

}
.content{
    position: absolute;
    left: 0;
    right: 0;
    top: 0;
    bottom: 0;
    z-index: 2;
    transition: 0.1s;
    background-color: rgb(255, 255, 255);
    border-radius: 20px;
    border-bottom: 1px solid #d3d3d3;

}
.remove{
    position: absolute;
    width:140px;
    height:22vh;
    background-color: #f60;
    border-radius: 20px;
    right: 0;
    top: 0;
    color:#fff;
    text-align: center;
    font-size: 32px;
    line-height: 22vh;
}
.report{
    writing-mode: vertical-lr;
    position: absolute;
    width:140px;
    height:22vh;
    background-color: rgb(185, 18, 54);
    border-radius: 20px;
    left: 0;
    top: 0;
    color:#fff;
    text-align: center;
    font-size: 40px;
    line-height: 140px;

}
</style>