<style>
    .panel{

    }
    .product {
        font-family: HYRunYuan;
        font-weight: 200;
        margin: 10px auto;
    }

    .product:hover {
    }

    .product-item {
        transition: all 0.3s ease 0s;
        transition-property: all;
        transition-duration: 0.3s;
        transition-timing-function: ease;
        transition-delay: 0s;

        border: 1px solid #ffa500;
        background-color: #FFFFFF;
        padding-bottom: 20px;

    }

    .product-item:hover {
        box-shadow: 0 0 20px rgba(0, 0, 0, .2);

    }

    .pName {
        color: #000;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;

        font-size: 20px;
        /*letter-spacing: 5px;*/
    }

    .action-btn {
        position: relative;
        bottom: 40px;
    }

    .action-btn > a {
        padding: 2px 20px;
        color: #5e5e5e;
        opacity: .8;
    }

    .action-btn > a > i {
        transition: all 0.3s; /*放大过程的时间*/

    }

    .action-btn > a > i:hover {

        color: #ffa500;
        transform: scale(1.2); /*放大倍数*/
    }
</style>

<template>
    <div class="container">
        <div class="row">
            <div class="panel">
                <div class="panel-heading text-center">商品首页列表</div>
                <div class="panel-body">
                    <div v-for="product in products" :key="product.id"
                         class="product col-lg-3 col-md-4 col-sm-6 col-xs-12 mb-50">
                        <div class="product-item  text-center">
                            <div class="product-img">
                                <a class="img" href=""><img :src="product.photo" width="100%"></a>
                                <div class="action-btn">
                                    <a href="#" title="Add to Cart"><i class="fa fa-cart-plus"
                                                                       style="font-size: 18px"></i></a>
                                    <a href="#" title="Quick View"><i
                                            class="fa fa-eye" style="font-size: 18px"></i></a>
                                    <a href="#" title="Wishlist"><i class="fa fa-heart"
                                                                    style="font-size: 18px"></i></a>
                                </div>
                            </div>
                            <div class="product-info">
                                <router-link :to="{name:'product',params:{id:product.id}}">
                                    <p class="pName">{{product.pName}}</p>
                                </router-link>

                                <div class="price">
                                    <span class="price"><span class="new"><i
                                            class="fa fa-cny"></i>{{ product.nPrice}}</span></span>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>
                <div class="panel-footer text-center">
                    <ul class="pagination">
                        <li :class="current_page === first_page?'disabled':''"><a v-on:click="prevPage">&laquo;</a></li>

                        <li v-for="i in maxNumber" :class="i === current_page ? 'active' : '' ">
                            <a v-on:click="page(i)">{{i}}</a>
                        </li>

                        <li :class="current_page === last_page?'disabled':''"><a v-on:click="nextPage">&raquo;</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        mounted() {
            axios.get('/api/products').then(response => {
                //这里的data.data是因为controller中用到了分页
                this.total = response.data;
                this.maxNumber = this.total["last_page"];
                this.current_page = this.total["current_page"];
                this.last_page = this.total["last_page"];
                this.products = response.data.data
            })
        },
        data() {
            return {
                products: [],
                total: [],
                maxNumber: 0,
                current_page: 0,
                last_page: 0,
                first_page: 1
            }
        },
        methods: {
            prevPage() {
                let pageUrl = this.total["prev_page_url"];
                console.log(pageUrl);
                axios.get(pageUrl).then(response => {
                    //每一次获取新的page时 必须再次 把新得到数据 综合给total
                    this.total = response.data;
                    this.maxNumber = this.total["last_page"];
                    this.current_page = this.total["current_page"];
                    this.last_page = this.total["last_page"];
                    this.products = response.data.data
                })
            },
            nextPage() {
                let pageUrl = this.total["next_page_url"];
                console.log(pageUrl);
                axios.get(pageUrl).then(response => {
                    //每一次获取新的page时 必须再次 把新得到数据 综合给total
                    this.total = response.data;
                    this.maxNumber = this.total["last_page"];
                    this.current_page = this.total["current_page"];
                    this.last_page = this.total["last_page"];
                    this.products = response.data.data
                })
            },
            page(i) {
                let pageUrl = this.total["path"];
                pageUrl = pageUrl + '?page=' + i;
                console.log(pageUrl);
                axios.get(pageUrl).then(response => {
                    //每一次获取新的page时 必须再次 把新得到数据 综合给total
                    this.total = response.data;
                    this.maxNumber = this.total["last_page"];
                    this.current_page = this.total["current_page"];
                    this.last_page = this.total["last_page"];
                    this.products = response.data.data
                })
            },
        }
    }

</script>
