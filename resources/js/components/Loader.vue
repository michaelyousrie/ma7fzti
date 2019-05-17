<template>
    <div id="bigWrapper">
        <div class="bar">
            <div class="circle"></div>
            <p>Loading</p>
        </div>
    </div>
</template>

<script>
export default {
    
}
</script>

<style scoped>
    #bigWrapper {
        background: #347fc3;
        width: 100%;
        height: 100%;
        position: absolute;
        z-index: 9999;
        overflow-x: hidden;
        overflow-y: hidden;
        top: 0;
        left: 0;
    }

    .bar {
        position: relative;
        height: 2px;
        width: 500px;
        margin: 0 auto;
        background: #fff;
        margin-top: 150px;
        z-index: 99;
        }

    .circle {
        position: absolute;
        top: -30px;
        margin-left: -30px;
        height: 60px;
        width: 60px;
        left: 0;
        background: #fff;
        border-radius: 30%;
        -webkit-animation: move 5s infinite;
        }

    p {
        position: absolute;
        top: -35px;
        right: -85px;
        text-transform: uppercase;
        color: #347fc3;
        font-family: helvetica, sans-serif;
        font-weight: bold;
    }

    @-webkit-keyframes move {
        0% {left: 0;}
        50% {left: 100%; -webkit-transform: rotate(450deg); width: 150px; height: 150px;}
        75% {left: 100%; -webkit-transform: rotate(450deg); width: 150px; height: 150px;}
    } 

</style>
