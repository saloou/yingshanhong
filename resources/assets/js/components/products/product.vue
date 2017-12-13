<template>
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4>
                        {{product.pName}}
                    </h4>
                </div>

                <div class="panel-body">
                    <p>
                        {{ product.description}}
                    </p>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        mounted() {
            return axios.get('/api/products/' + this.$route.params.id).then(response => {
                //这里的data.data是因为controller中用到了分页
                this.product = response.data
            })
        },
        data() {
            return {
                product: []
            }
        }
    }
</script>
