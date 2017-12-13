<template>
    <form class="form-horizontal" @submit.prevent="create">

        <!--这里是商品名称-->
        <div class="form-group" :class="{'has-error' : errors.has('pName')}">
            <label for="pName" class="col-md-4 control-label">产品名称</label>
            <div class="col-md-6">
                <input v-model="pName"
                       v-validate data-vv-rules="required|min:2|max:12" data-vv-as="用户名"
                       id="pName" type="text" class="form-control" name="pName" required>
                <span class="help-block" v-show="errors.has('pName')">{{errors.first('pName')}}</span>
            </div>
        </div>

        <!--这里是原价-->
        <div class="form-group" :class="{'has-error' : errors.has('oPrice')}">
            <label for="oPrice" class="col-md-4 control-label">原价</label>
            <div class="col-md-6">

                <input v-model="oPrice"
                       v-validate data-vv-rules="required|between:1,9999" data-vv-as="原价"
                       id="oPrice" type="text" class="form-control" name="oPrice" required>
                <span class="help-block" v-show="errors.has('oPrice')">{{errors.first('oPrice')}}</span>
            </div>
        </div>
        <!--这里是现价-->
        <div class="form-group" :class="{'has-error' : errors.has('nPrice')}">
            <label for="nPrice" class="col-md-4 control-label">现价</label>
            <div class="col-md-6">

                <input v-model="nPrice"
                       v-validate data-vv-rules="required|between:1,9999" data-vv-as="现价"
                       id="nPrice" type="text" class="form-control" name="nPrice" required>
                <span class="help-block" v-show="errors.has('nPrice')">{{errors.first('nPrice')}}</span>
            </div>
        </div>

        <!--这里是商品数量-->
        <div class="form-group" :class="{'has-error' : errors.has('stock')}">
            <label for="stock" class="col-md-4 control-label">数量</label>
            <div class="col-md-6">

                <input v-model="stock"
                       v-validate data-vv-rules="required|between:1,9999" data-vv-as="数量"
                       id="stock" type="text" class="form-control" name="stock" required>
                <span class="help-block" v-show="errors.has('stock')">{{errors.first('stock')}}</span>
            </div>
        </div>


        <!--这里是商品描述-->
        <div class="form-group" :class="{'has-error' : errors.has('description')}">
            <label for="description" class="col-md-4 control-label">商品描述</label>
            <div class="col-md-6">
                <input v-model="description"
                       v-validate data-vv-rules="required|min:2|max:100" data-vv-as="商品描述"
                       id="description" type="text" class="form-control" name="description" required>
                <span class="help-block" v-show="errors.has('description')">{{errors.first('description')}}</span>
            </div>
        </div>


        <div class="form-group">
            <div class="col-md-6 col-md-offset-4">
                <button type="submit" class="btn btn-primary form-control">
                    创建新产品到数据库
                </button>
            </div>
        </div>
    </form>

</template>

<script>
    export default {
        data() {
            return {
                pName: '',
                oPrice: '',
                nPrice: '',
                stock: '',
                description: '',
                photo: '/images/1.jpg',
                categoryId: '2'

            };

        },
        methods: {
            create() {
                let formData = {
                    pName: this.pName,
                    oPrice: this.oPrice,
                    nPrice: this.nPrice,
                    stock: this.stock,
                    description: this.description,
                    photo:this.photo,
                    categoryId:this.categoryId
                };
                axios.post('/api/products/create', formData).then(response => {
                    console.log('完成')
//                    this.$router.push({name: 'confirm'})

                })

            }
        }
    }
</script>