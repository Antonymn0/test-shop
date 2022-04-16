<template>
    <div class="container pt-5">
        <div class="row justify-content-center align-items-center h-100">
            <div class="col-md-10 my-auto">
                <div class="card ">
                    <h2 class="card-header">
                        Products
                        <span class="btn btn-sm btn-secondary float-end" @click.prevent="fetchProducts()">Refresh</span>
                    </h2>

                    <div class="card-body">
                        <div class="row pt-1 pb-3 mb-3 mt-0 border-bottom">
                            <h5>Search:</h5>
                            <div class="col-md-4">
                                <label for="product_name">Product name:</label> <br>
                                <input type="text" id="author_name" placeholder="Product name" class="border p-1 rounded" v-model="product_name">
                                <button class="btn btn-sm btn-primary" @click.prevent="searchProductsByProductName()">Search</button> <br>
                                <small class="text-danger">{{this.errors.product_name}}</small>
                            </div>

                            <div class="col-md-4">
                                <label for="author_name">Author name:</label> <br>
                                <input type="text"  id="author_name" placeholder="Author name" class="border p-1 rounded" v-model="author_name">
                                <button class="btn btn-sm btn-primary" @click.prevent="searchProductsByAuthorName()">Search</button> <br>
                                <small class="text-danger">{{this.errors.author_name}}</small>
                            </div>

                            <div class="col-md-4">
                                <label for="date">Date:</label> <br>
                                <input type="date" id="date" placeholder="Search by date" class="border p-1 rounded" v-model="date">
                                <button class="btn btn-sm btn-primary" @click.prevent="searchProductsByDate()">Search</button> <br>
                                <small class="text-danger">{{this.errors.date}}</small>
                            </div>
                        </div>
                        <h4 class="text-muted py-2">{{title}}</h4>
                        <div class="table-responsive">
                            <table class="table table-sm table-striped">
                                <thead>
                                    <th>#</th>
                                    <th>SKU NO</th>
                                    <th>PRODUCT NAME</th>
                                    <th>AUTHOR</th>
                                    <th>DATE</th>
                                </thead>
                                <tbody v-if="Object.keys(this.current_products).length">
                                    <tr v-for="(product, index) in this.current_products" :key="index">
                                        <td>{{index +1}}</td>
                                        <td>{{product.sku}}</td>
                                        <td>{{capitalize(product.product_name)}}</td>
                                        <td>{{capitalize(product.author_name)}}</td>
                                        <td>{{formatDate(product.created_at)}}</td>
                                    </tr>
                                </tbody>
                                <tbody v-else>
                                    <tr>
                                        <td colspan="5" class="small text-muted text-center py-5">No items to show</td>                                        
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import moment from 'moment';
    export default {
        data(){
            return{
                current_products:{},
                errors:{},
                product_name:null,
                author_name:null,
                date:null,
                title:'A list of all products'
            }
        },
        methods:{
            formatDate(date){
                if (date)  return moment(String(date)).format('ll ');            
            },
            capitalize(string){
                if(string)  return string.charAt(0).toUpperCase() + string.slice(1);
            },
            searchProductsByAuthorName(){
                this.errors ={}
                if(! this.author_name) { this.errors.author_name = "Please type author name"; return; }
                axios.get('/api/search/products-by-author/' + this.author_name)
                .then(response => {
                    this.title = 'Search by author name results';
                    this.current_products = response.data.data.data;
                    this.author_name = null;
                })
                .catch(error => {
                    console.log(error.response);
                })
            },
            searchProductsByProductName(){
                this.errors ={}
                if(! this.product_name) { this.errors.product_name = "Please type product name"; return; }
                axios.get('/api/search/products-by-product-name/' + this.product_name)
                .then(response => {
                    this.title = 'Search by product name results';
                    this.current_products = response.data.data.data;
                    this.product_name = null;
                })
                .catch(error => {
                    console.log(error.response);
                })
            },
            searchProductsByDate(){
                this.errors ={}
                if(! this.date) { this.errors.date = "Please pick a date"; return; }
                axios.get('/api/search/products-by-date/' + this.date)
                .then(response => {
                    this.title = `Search by date results (${this.date})`;
                    this.current_products = response.data.data.data;
                    this.date = null;
                })
                .catch(error => {
                    console.log(error.response);
                })
            },
            fetchProducts(){
                this.current_products ={}
                axios.get('/api/products')
                .then(response=>{
                    this.title = 'A list of all products';
                    this.current_products = response.data.data.data;
                })
                .catch(error=>{
                    console.log(error.response);
                })
            }
        },
        mounted() {
            this.fetchProducts();
        }
    }
</script>