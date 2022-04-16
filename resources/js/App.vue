<template>
  <div class="mx-5 ">
      <div class=" py-3 border-bottom d-flex justify-content-between align-items-center">
        <span>
            <h1>Test Shop</h1>
        </span>
        <span v-if="!this.token">
            <router-link :to="{name: 'login'}" class="mx-2"> Login </router-link>
            <router-link :to="{name: 'register'}" class="mx-2"> Register </router-link>
        </span>
        <a href="#" @click.prevent="logout()" v-if="this.token">Logout</a>
        
      </div>
      
      <router-view></router-view>
  </div>
</template>

<script>
export default {
  data(){
    return{
      token:  null
    }
  },
  methods:{
    getToken(){
        this.token = localStorage.getItem('test_token') || null
    },
    chechIfUserIsAuthenticated(){
      this.getToken();
      axios.get('/api/check-if-user-authenticated')
      .then( response => {
        // redirect user to shop if token is valid 
        if(response.status == 200)  this.$router.push({name: 'shop'})
      })
      .catch(error=>{
        console.log(error.response);
      })
    },

    logout(){
      axios.get('/api/logout')
      .then( response => {
        // redirect user back to login 
        if(response.status == 200) {
          localStorage.removeItem('test_token');
           this.$router.push({name: 'login'});
           this.getToken();
           }
      })
      .catch(error=>{
        console.log(error.response);
      })
    }
  },
  mounted(){
    setTimeout( this.chechIfUserIsAuthenticated() , 100);    
  }

}
</script>

<style>

</style>