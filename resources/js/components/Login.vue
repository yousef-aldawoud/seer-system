<template>
    <div class="pt-4 forms">
        <v-container >
            <v-card>
                <v-card-text class="flex flex-wrap">
                    <form  method="POST" action="/login" class="w-full p-4 md:w-1/2">
                        <h1 class="text-black">Login</h1>
                        <input type="hidden" name="_token" :value="csrf" />
                        <v-text-field
                            placeholder="E-mail"
                            :rules="[rules.required,rules.email]"
                            type="email"
                            name='email'
                            v-model="loginEmail"
                            label="E-mail"></v-text-field>
                        <v-text-field
                            v-model="loginPassword"
                            :append-icon="showLoginPassword ? 'mdi-eye' : 'mdi-eye-off'"
                            :rules="[rules.required]"
                            :type="showLoginPassword ? 'text' : 'password'"
                            name="password"
                            label="Password"
                            @click:append="showLoginPassword = !showLoginPassword"
                        ></v-text-field>
                        <v-btn :disabled="!validateLoginFields()" type="submit" class="blue text-white" block>Login</v-btn>

                    </form>
                    <form action="register" method="POST"  class="w-full md:w-1/2 p-4">
                        <h1 class="text-black">Sign up</h1>

                        <input type="hidden" name="_token" :value="csrf" />
                        <v-text-field
                            v-model="signUpEmail"
                            placeholder="E-mail"
                            name="email"
                            :rules="[rules.required,rules.email]"
                            type="email"
                            label="E-mail"></v-text-field>

                        <v-text-field
                            v-model="name"
                            name="name"
                            placeholder="name that will show up"
                            :rules="[rules.required]"
                            type="name"
                            label="name"></v-text-field>

                        <v-text-field
                            v-model="signUpPassword"
                            :append-icon="showSignUpPassword ? 'mdi-eye' : 'mdi-eye-off'"
                            :rules="[rules.required]"
                            :type="showSignUpPassword ? 'text' : 'password'"
                            name="password"
                            label="Password"
                            @click:append="showSignUpPassword = !showSignUpPassword"
                        ></v-text-field>
                        <span class="inline-block">
                            <v-checkbox label="Subscribe to our newspaper" color="yellow" v-model="subscribe" value="subscribe" name="subscribe"></v-checkbox>
                            
                        </span>
                        <slot/>
                        <v-btn :disabled="!validateSignUpFields()" type="submit" class="blue text-white" block>Sign up</v-btn>
                    </form>
                </v-card-text>
            </v-card>
        </v-container>
    </div>
</template>
<script>
import { mdiEye, mdiEyeOff } from '@mdi/js';

export default {
    data(){
        return{
            csrf:document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            name:"",
            subscribe:false,
            showLoginPassword:false,
            showSignUpPassword:false,
            loginPassword:"",
            loginEmail:"",
            signUpPassword:"",
            signUpEmail:"",
            rules: {
                eyeOff:mdiEyeOff,
                eyeOn:mdiEye,
                required: value => !!value || 'Required.',
                min: v => v.length >= 8 || 'Min 8 characters',
                email: value => this.validateEmail(value)|| 'Must be an email' ,
            },
        }
    },methods:{
        validateEmail(email) {
            var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
            return re.test(String(email).toLowerCase());
        },

        validateLoginFields(){
            if(!this.loginEmail || !this.loginPassword){
                this.loginWarning = "E-mail and password are required";
                return false;
            }
            return this.validateEmail(this.loginEmail)
        },

        validateSignUpFields(){
            if(!this.signUpEmail || !this.signUpPassword || !this.name){
                this.signUpWarning = "E-mail and password are required";
                return false;
            }
            if(this.signUpPassword.length < 8){
                console.log("pass small")
                return false;
            }
            return this.validateEmail(this.signUpEmail)
        }
    }
}
</script>
<style scoped>
.forms{
    min-height: 600px;
}
</style>