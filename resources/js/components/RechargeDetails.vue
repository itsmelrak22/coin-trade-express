<template>
    <div id="app">
      <div class="home">
        <v-container>
          <v-card flat>
            <v-card-title>
              <v-btn @click="BACK()" plain><v-icon>mdi-keyboard-backspace</v-icon></v-btn><b>Order Details</b>
            </v-card-title>
            <v-stepper v-model="e1">
              <v-stepper-header>
                <v-stepper-step :complete="e1 > 1" step="1">
                  Match Order
                </v-stepper-step>
  
                <v-divider></v-divider>
  
                <v-stepper-step :complete="e1 > 2" step="2">
                  Buyer Pays
                </v-stepper-step>
  
                <v-divider></v-divider>
  
                <v-stepper-step step="3">
                  Confirm Complete
                </v-stepper-step>
              </v-stepper-header>
  
              <v-stepper-items>
                <v-stepper-content step="1">
                  <v-card>
                  </v-card>
                  <v-btn color="primary" @click="e1 = 2">
                    Continue
                  </v-btn>
  
                  <v-btn text>
                    Cancel
                  </v-btn>
                </v-stepper-content>
  
                <v-stepper-content step="2">
                  <v-card>
                    <v-card-title>
                      <center>Payment Info</center>
                    </v-card-title>
                    <v-card-text>
                      <v-row>
                        <v-col cols="12" md="4">
                          <span>Bank</span>
                        </v-col>
  
                        <v-col cols="12" md="4">
                          <center>Please Contact the Receptionist</center>
                        </v-col>
  
                        <v-col cols="12" md="4" style="text-align: right;">
                          <v-btn plain color="primary">Copy</v-btn>
                        </v-col>
  
                        <v-col cols="12" md="4">
                          <span>Card Number</span>
                        </v-col>
  
                        <v-col cols="12" md="4">
                          <center>Please Contact the Receptionist</center>
                        </v-col>
  
                        <v-col cols="12" md="4" style="text-align: right;">
                          <v-btn plain color="primary">Copy</v-btn>
                        </v-col>
  
                        <v-col cols="12" md="4">
                          <span>Account Holder</span>
                        </v-col>
  
                        <v-col cols="12" md="4">
                          <center>Please Contact the Receptionist</center>
                        </v-col>
  
                        <v-col cols="12" md="4" style="text-align: right;">
                          <v-btn plain color="primary">Copy</v-btn>
                        </v-col>
                      </v-row>
                      <center>
                        <span>Match Business, Please Complete the Payment Within 30 minutes</span>
                        <p><b>Order has timed out</b></p>
                      </center>
                      <v-file-input accept="image/*" label="Update Image"></v-file-input>
                    </v-card-text>
                    <v-card-actions>
                      <v-btn color="primary" @click="e1 = 3, SAVE()">MAKE SURE YOU PAID</v-btn>
  
                      <v-btn text @click="CancelOrder()">CANCEL ORDER</v-btn>
                    </v-card-actions>
                  </v-card>
                </v-stepper-content>
  
                <v-stepper-content step="3">
                  <v-card flat>
                    <h1>Order Complete</h1>
                  </v-card>
  
                  <v-btn color="primary" @click="Home()">Continue</v-btn>
                </v-stepper-content>
              </v-stepper-items>
            </v-stepper>
          </v-card>
        </v-container>
      </div>
    </div>
  </template>

<script>
import Swal from "sweetalert2";
export default {
    data:()=>({
        e1 : 2,
        amount_arr : []
    }),
    created(){
        // this.getdata()
    },
   
    methods: {
        Home(){
            this.$router.push("/")
        },
        BACK(){
            this.$router.push("/RechargePage")
        },
        SAVE(){
            var toastMixin = Swal.mixin({
                toast: true,
                icon: 'success',
                title: 'General Title',
                animation : false,
                position: 'top-right',
                showConfirmButton: false,
                timer: 1500,
                timerProgressBar : true,
                dibOpen : (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            })
            // console.log(this.userDeposit)
            axios.post(`api/RechargeDetails/update`,this.userDeposit).then((res)=>{
                if(res.data){
                    // alert('Process Completed Please wait...')
                    toastMixin.fire({
                        icon: 'success',
                        title : 'Success!',
                        animation:true,
                        text: 'Process Completed Please wait...',
                    })
                }
            })
        },

        CancelOrder(){
            var toastMixin = Swal.mixin({
                toast: true,
                icon: 'success',
                title: 'General Title',
                animation : false,
                position: 'top-right',
                showConfirmButton: false,
                timer: 1500,
                timerProgressBar : true,
                dibOpen : (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            })
            axios.post(`api/CancelOrder/update`,this.userDeposit).then((res)=>{
                if(res.data){
                    // alert('Order canceled')
                    toastMixin.fire({
                        icon: 'success',
                        title : 'Success!',
                        animation:true,
                        text: 'Order canceled',
                    })
                    this.$router.push("/")
                }
            })
        },

        // getdata(){
        //     axios.get(`/api/RechargeDetails`).then((res) => {
        //         this.amount_arr = res.data;
        //         console.log('rechargedeposit',this.amount_arr);
        //     });
        // }
    }
}
</script>

<style>
    .home {
        padding: 10px;
        display: flex;
        flex-direction: column;
    }
    
    @media screen and (max-width: 600px) {
        .home {
          padding: 0 20px;
        }
      
        v-card-title {
          font-size: 14px;
        }
      
        v-card-actions {
          flex-direction: column;
          align-items: flex-start;
        }
      }
      
      @media screen and (max-width: 960px) {
        v-stepper-step {
          padding: 0 10px;
        }
      }
</style>