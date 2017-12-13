<template>
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="panel panel-default">
                    <div class="panel-heading text-center">创建产品</div>
                    <div class="panel-body">
                        <create-product-form></create-product-form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import CreateProductForm from './CreateProductForm.vue'

    export default {
        components: {
            CreateProductForm
        }
    }

</script>