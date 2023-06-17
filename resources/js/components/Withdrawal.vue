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
                <center>My Credit Score: 100.00</center>
                <v-card flat >
                    <v-card-text>
                        <span>Extractable Quantity:</span>
                        <v-text-field 
                        v-model="totalmoney"
                        outlined
                        dense
                        ></v-text-field>

                        <span>Please Select a BankCard:</span>
                        <v-text-field
                        v-model="paymentmethod" 
                        outlined
                        dense
                        readonly
                        ></v-text-field>
                        <span>Amount of Coin Withdraw:</span>
                        <v-text-field 
                        outlined
                        dense
                        v-model="obj.amountwithdraw"
                        hint="Fee 0.0000 National Legal Tender"
                        ></v-text-field>
                        <span>Arived Ammount National Tender</span>
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
import moment from "moment";
import Swal from "sweetalert2";
export default {
    data:()=>({
        bank : [
            'UNITED OVERSEAS BANK LTD',
            'ANEXT BANK PTE. LTD.',
            'AUSTRALIA AND NEW ZEALAND BANKING GROUP LIMITED',
            'BANK OF CHINA LIMITED',
            'BNP PARIBAS',
            'CIMB BANK BERHAD',
            'CITIBANK NA SINGAPORE'
        ],
        BankInfo: {},
        Account: {},
        obj:{},
        totalmoney: null,
        paymentmethod: null,
        LastWithdrawalID :{},
        WithdrawIDArr:[],
    }),

    created(){
        this.getBankInfo()
        this.GetUser()
        // this.loadLastID()
    },

    methods:{
        backMain(){
            this.$router.push('/')
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

             toastMixin.fire({
                icon: 'error',
                title : 'Please!',
                animation:true,
                text: 'Please End your Game Before You Withdraw...',
            })
            // if(this.totalmoney < this.obj.amountwithdraw){
            //     alert('masmalaki ung withdraw mo')
            // }else{
               
            //     this.obj.ordernumber = `EE${moment().format("YYYYMMDD")}-${this.GenerateORDERID(this.LastWithdrawalID)}`
            //     this.obj.UserID = this.loggedInUser.id
            //     console.log(this.obj)
            //     axios.post(`api/withdraw/store`).then((res)=>{
            //         console.log(res.data)
            //     })
            // }
            
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
        axios.get(`api/bankcards`).then((res)=>{
            console.log(res.data.length == 0)
            for(let i = 0; i < res.data.length; i++){
                if(res.data.length == 0){
                    toastMixin.fire({
                        icon: 'error',
                        title : 'Warning!',
                        animation:true,
                        text: 'No Bank Account Registered',
                    })
                    this.$router.push('/BankCard')
                
                }else if(res.data[i].UserID == this.loggedInUser.id ){
                    this.BankInfo = res.data
                    console.log('bankinfo',this.BankInfo)
                    this.paymentmethod = this.BankInfo[i].bankdeposit
                    // console.log(this.obj.paymentmethod)
                }
            }
        })
    },

    GetUser(){
            axios.get(`/api/AccountInfo`).then((res) => {
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
        // }, //end 


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