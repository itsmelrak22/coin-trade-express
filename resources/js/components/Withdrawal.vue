<template>
    <div class="home">
        <div>
                <v-card flat>
                    <v-card-title style="background-color: #ECEFF1">
                        <v-btn  @click="backMain()" plain > 
                            <v-icon>mdi-keyboard-backspace</v-icon>
                        </v-btn>
                        <b>Withdraw</b>
                        </v-card-title>
                </v-card>
                <center>My Credit Score: {{totalmoney}}</center>
                <v-card flat >
                    <v-card-text>
                        <span>Bank of Deposit *:</span>
                        <v-autocomplete 
                        clearable
                        @change="GetInfo()"
                        outlined
                        dense
                        item-text="bankdeposit"
                        :items="arraybank"
                        v-model="obj.bankdeposit"
                        ></v-autocomplete> 

                        <span>Name:</span>
                        <v-text-field 
                        v-model="obj.name"
                        outlined
                        dense
                        disabled
                        ></v-text-field>

                        <span>Phone Number:</span>
                        <v-text-field
                        v-model="obj.phonenumber" 
                        outlined
                        dense
                        disabled
                        ></v-text-field>
                        <!-- <span>Bank Branch:</span>
                        <v-text-field
                        v-model="obj.depositbranch"
                        outlined
                        dense
                        readonly
                        ></v-text-field> -->

                        <span>Bank Account:</span>
                        <v-text-field
                        v-model="obj.bankaccount"
                        outlined
                        dense
                        disabled
                        ></v-text-field>

                        <span>IFSC Code:</span>
                        <v-text-field
                        v-model="obj.ifsc"
                        outlined
                        dense
                        disabled
                        ></v-text-field>

                        <span>Amount Withdraw *:</span>
                        <v-text-field
                        v-model="obj.amount"
                        outlined
                        dense
                        ></v-text-field>
                        
                        <v-card-actions>
                            <v-btn @click="SAVE()" color="primary" block>
                                WITHDRAWAL
                            </v-btn>
                        </v-card-actions>
                    </v-card-text>
                </v-card>
        </div>
    </div>
</template>

<script>
import Swal from "sweetalert2";
import { getTradeOrder } from '../tradeOrderService';
import { mapActions, mapState } from "vuex";
export default {
    data:()=>({
        bankdeposit_arr:[
            {bankName:'UNITED OVERSEAS BANK LTD'},
            {bankName:'ANEXT BANK PTE. LTD.'},
            {bankName:'AUSTRALIA AND NEW ZEALAND BANKING GROUP LIMITED'},
            {bankName:'BANK OF CHINA LIMITED'},
            {bankName:'BNP PARIBAS'},
            {bankName:'CIMB BANK BERHAD'},
            {bankName:'CITIBANK NA SINGAPORE'},
        ],
        BankInfo: {},
        Account: {},
        obj:{},
        arraybank:[],
        totalmoney: null,
        paymentmethod: null,
        LastWithdrawalID :{},
        WithdrawIDArr:[],
        bankdeposit: undefined,
    }),

    created(){
        const loggedInUserId = this.loggedInUser.id
        getTradeOrder(loggedInUserId);
        this.getBankInfo()
        this.GetUser()
        // this.GetInfo()
        // this.loadLastID()
    },
    computed: {
        ...mapState(["loggedInUser"]),
    },

    methods:{
        backMain(){
            this.$router.push('/')
            location.reload();
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

        if(this.obj.bankdeposit){
            if(this.obj.amount){
                if(this.totalmoney != 0){

                
                this.obj.id = String(this.loggedInUser.id)
                console.log(this.Account.id,'s')
                this.Account.AmountExchange = this.obj.amount
                this.Account.prev_Asset =  this.totalmoney ;
                this.Account.Amount = '0';
                this.Account.remarks = 'Account Locked'

                
                axios.post("api/withdrawAdd", this.Account)//kuku
                                .then((res) => {

                axios.post(`api/user/update2/${this.Account.id}`,this.Account).then((res)=>{
                    
                                    this.GetUser()
                                    this.obj = {};
                                    toastMixin.fire({
                                        icon: 'error',
                                        title : 'Please!',
                                        animation:true,
                                        text: 'Finish Your task first and contact your receptionist, This will lead your account to locked mode',
                                    })
                    this.$socket.emit('newUpdate', { updateType: "ConfirmRecharge" })
                })
                });
                }else{
                    toastMixin.fire({
                        icon: 'error',
                        title : 'Please!',
                        animation:true,
                        text: 'Your Balance is Not enough to Withdraw!',
                    })
                    }
            }else{
                toastMixin.fire({
                icon: 'error',
                title : 'Please!',
                animation:true,
                text: 'Please fill out all required fields',
            })
            }
        }else{
            toastMixin.fire({
                icon: 'error',
                title : 'Please!',
                animation:true,
                text: 'Please fill out all required fields',
            })
        }    
        },
        getBankInfo(){
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
        axios.get(`api/bankcards/${this.loggedInUser.id}`).then((res)=>{
            
            this.arraybank = res.data
            console.log('bankcard', res.data.length)
            if(res.data.length == 0){
                toastMixin.fire({
                    icon: 'error',
                    title : 'Warning!',
                    animation:true,
                    text: 'No Bank Account Registered',
                })
                this.$router.push('/BankCard')
                }
           
        })
    },

    GetUser(){
            axios.get(`api/AccountInfo`).then((res) => {
            for(let i = 0; i < res.data.length; i++){
                if(this.loggedInUser.id == res.data[i].id){
                //   console.log('user',res.data[i].Asset)
                this.Account = res.data[i]
                this.totalmoney = this.Account.Asset
                console.log(this.totalmoney)
                }
            }
            });
    },


    GenerateORDERID(Last_Wid) {
            let id = Last_Wid;
            let split = id.split("-");
            console.log('split',split)
            let newId = +split[1] + 1;
            console.log('newid',newId )
            return newId.toString().padStart(7, "0");
            
        }, //GENERATE VAMID FOR EMPLOYEE APPLICATION

        // loadLastID() {
        //     // LOAD VAM ID FOR EMPLOYEE APPLICATION
        //     axios
        //         .get(`api/withdrawal`).then((res) => {
        //             console.log('res',res.data)
        //             this.LastWithdrawalID = "";
        //             if (res.data[0] != null) {
        //                 this.WithdrawIDArr = res.data[0];
        //                 console.log('last1',this.UserIDArr)
        //                 this.LastWithdrawalID = this.WithdrawIDArr; // Last VAMID for current date
        //                 // console.log('last2',this.LastUserID)
        //             } else {
        //                 this.LastWithdrawalID = "XXXXXXXXXX-000000";
        //                 console.log('Employee',this.LastWithdrawalID)
        //             }
        //         })
        // if( res.data.UserID == this.loggedInUser.id){
        //             this.BankInfo = res.data
        //             // console.log('bankinfo',this.BankInfo)
        //             // this.paymentmethod = this.BankInfo[0].bankdeposit
        //             this.obj = this.BankInfo
        //             // console.log('obj',this.obj)
                
        //         }else if(res.data.length == 0 ){
        //             toastMixin.fire({
        //                 icon: 'error',
        //                 title : 'Warning!',
        //                 animation:true,
        //                 text: 'No Bank Account Registered',
        //             })
        //             this.$router.push('/BankCard')
                   
        //             // console.log(this.obj.paymentmethod)
        //         }else if(res.data[0].UserID == this.loggedInUser.id ){
        //             this.BankInfo = res.data
        //             console.log('bankinfo',this.BankInfo)
        //             // this.paymentmethod = this.BankInfo[0].bankdeposit
        //             this.obj = this.BankInfo
        //             console.log('obj',this.obj)
        //         }
            // }
        // }, //end 
    GetInfo(){
            console.log('name',this.obj.bankdeposit)
        if(this.obj.bankdeposit == null ){
            this.obj = {}
        }else{
            
            axios.get(`api/basicinfo/${this.obj.bankdeposit}`).then((res)=>{
                if(res.data[0]){
                    console.log('dto',res.data[0])
                    this.obj = {...res.data[0]}
                    // this.arraybank = res.data
                }
            })
        }
       
    },

    },
}
</script>

<style>
.home {
    overflow: auto;
    height: 750px;
    padding: 20px;
    margin: auto;
    width: 80%;
  }
</style>