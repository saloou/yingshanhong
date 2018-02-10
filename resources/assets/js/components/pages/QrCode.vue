<style>
    .qr-div {
        margin-top: 50px;
    }


</style>

<template>
    <div class="container">

        <div class="row text-center">
            <div class="text-center">
                <img :src="QrCodePath">
            </div>
        </div>

        <div class="qr-div text-center">
            <a v-on:click="getQrCode" class="btn btn-sm animated-button thar-one">获取二维码图像</a>
        </div>

    </div>
</template>


<script>
    export default {
        mounted() {
//            this.getQrCode();
        },

        data() {
            return {
                QrCodePath: '',
            }
        },
        methods: {
            getQrCode() {
                axios.get('/api/getQrCode').then(response => {
                    this.QrCodePath = response.data;
                });
            },
        }
    }

</script>
