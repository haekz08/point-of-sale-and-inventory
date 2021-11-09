<template>
  <CContainer class="d-flex content-center min-vh-100">
    <b-row>
      <b-col md="8" offset-md="2">
        <CCardGroup>
          <CCard class="p-4">
            <CCardBody>
              <loading :visibility="loading.visibility" :label="loading.label"/>
              <form v-on:submit.prevent="login">
                <h1>Login</h1>
                <p class="text-muted">Sign In to your account</p>

                <div class="input-group mb-2">
                  <div class="input-group-prepend">
                    <div class="input-group-text"><font-awesome-icon icon="user" /></div>
                  </div>
                  <input type="text" class="form-control" placeholder="Username" v-model="credentials.username">
                </div>
                <div class="input-group mb-2">
                  <div class="input-group-prepend">
                    <div class="input-group-text"><font-awesome-icon icon="lock" /></div>
                  </div>
                  <input type="password" class="form-control" placeholder="Password" v-model="credentials.password">
                </div>
                <div class="text-left">
                  <button type="submit" class="btn btn-info btn-block">Login</button>
                </div>
              </form>
            </CCardBody>
          </CCard>
          <CCard
                  color="info"
                  text-color="white"
                  class="text-center py-5 d-sm-down-none"
                  body-wrapper
          >
            <h2>Sign up</h2>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>

          </CCard>
        </CCardGroup>
      </b-col>
    </b-row>
  </CContainer>
</template>

<script>
    import {client_details,assets_path} from '@/config';
    import Loading from '@/views/widgets/Loading.vue';
    export default {
        name: 'Login',
        components: {Loading},
        data(){
            return{
                credentials:{
                    username: '',
                    password:'',
                    grant_type: 'password',
                    client_id: client_details.CLIENT_ID,
                    client_secret:  client_details.CLIENT_SECRET
                },
                hasError:{
                    username: false,
                    password:false
                },
                assets_path:{},
                loading:{
                    visibility:false,
                    label:"Checking your credentials..."
                }
            }
        },
        created() {
            //if(this.loggedIn){this.$router.push('/')}
            this.assets_path = assets_path;
        },
        methods:{
            login(){
                this.loading.visibility=true;
                //console.log(this.$store.state.sidebarShow);
                this.$store.dispatch('logInAction',this.credentials)
                    .then(response => {
                        this.loading.label="Logging In...";
                        setTimeout(() => {
                            this.$router.push('/')
                        },2000);
                    })
                    .catch(error => {
                        this.loading.visibility=false;
                        this.$swal({
                            title: 'Error!',
                            text: 'Incorrect email or password!',
                            showCloseButton: true,
                            onClose: () => {
                                //this.showErrors()
                            },
                        })
                    })
            }
        }
    }
</script>
