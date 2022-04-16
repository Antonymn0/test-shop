<template>
  <div class="align-items-center pt-5">
    <div class="card shadow w-50 p-5 mx-auto">
      <small class='alert-danger p-2' v-if="this.errors.credentials">{{this.errors.credentials}}</small>
      <h1>Login</h1>
      <div class="form-group p-2">
        <label for="email">Email: </label>
        <input type="email" class="form-control" v-model="email">
        <small class="text-danger"> {{this.errors.email}} </small>
      </div>

      <div class="form-group p-2">
        <label for="password">Password: </label>
        <input type="password" class="form-control" v-model="password">
        <small class="text-danger"> {{this.errors.password}} </small>
      </div>
      <div>
        <button class="btn btn-primary m-2" @click.prevent="login()">Login</button>  Or 
        <router-link :to="{name: 'register'}" class="btn btn-primary m-2"> Register </router-link>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data(){
    return{
      email:null,
      password:null,
      errors:{},
       regex: /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,24}))$/, 
    }
  },
  methods:{
    login(){
      this.validateForm();
      if(Object.keys(this.errors).length) return;
      var form_data = new FormData();
          form_data.append('email', this.email);
          form_data.append('password', this.password);
      axios.post('/api/login', form_data)
      .then(response => {
        localStorage.setItem('test_token', response.data.token);
        this.$router.push({name: 'shop'})
      })
      .catch(error=>{
        if(error.response.status == 401)this.errors.credentials = "Invalid credentials";
        console.log(error.response);
      })

    },
    validateForm(){
      this.errors = {}

      if(! this.email) this.errors.email = "Email is required";
      if(! this.password) this.errors.password = "Password is required";
      if(!this.regex.test(this.email)) this.errors.email = 'Invalid email' ;
      if(this.password.length < 4) this.errors.password = "Password must be atleast 4 characters long";

    }
  }
}
</script>

<style>

</style>