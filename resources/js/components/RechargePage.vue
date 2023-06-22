<template>
    <v-container>
    <div class="main">
        <div class="sticky">
        <v-toolbar flat dense>
            <v-icon @click="goback()">mdi-arrow-left</v-icon>
            <span class="ml-3" style="font-weight: bold;">Deposit</span>
        </v-toolbar>
        <div>
            <v-row>
            <v-col cols="12" md="6">
                <v-card flat color="#ECEFF1" class="text-center">
                <span>Certified Seller</span>
                <br />
                <span style="font-weight: bold">Official</span>
                </v-card>
            </v-col>

            <v-col cols="12" md="6">
                <v-card flat color="#ECEFF1" class="text-center">
                <span>Arrival Rate</span>
                <br />
                <span style="font-weight: bold">100%</span>
                </v-card>
            </v-col>
            </v-row>
        </div>
        </div>

        <div>
        <div>
            <v-text-field
            v-model="rechargeAmount"
            label="Recharge amount"
            hint="The amount of a single transaction is 1-1000000000"
            />
        </div>

        <div>
            <v-row>
            <v-col cols="12" md="4" v-for="amount in rechargeAmounts" :key="amount">
                <v-btn
                @click="selectAmount(amount)"
                :color="selectedAmount === amount ? 'primary' : ''"
                
                dense
                width="100%"
                >
                {{ amount }}
                </v-btn>
            </v-col>
            </v-row>
        </div>

        <div>
            <v-text-field v-model="arrivalAmount" label="Arrival amount" value="0.00" />
        </div>

        <div>
            <span>Payment Method</span> <br /><br />

            <v-btn
            v-for="paymentMethod in paymentMethods"
            :key="paymentMethod"
            @click="selectPaymentMethod(paymentMethod)"
            :color="selectedPaymentMethod === paymentMethod ? 'error' : ''"
            class="mb-4"
            width="100%"
            style="border-radius: 10px"
            >
            {{ paymentMethod }}
            <v-spacer />
            </v-btn>
        </div>

        <div>
            <v-btn @click="SAVE()" class="mt-4" color="primary" width="100%">
            <span>Confirm Recharge</span>
            <v-spacer />
            </v-btn>
        </div>
        </div>
    </div>
    </v-container>
</template>

<script>
import Swal from "sweetalert2";
import moment from "moment";
export default {
data() {
    return {
        rechargeAmount: '',
        arrivalAmount: '0.00',
        selectedAmount: null,
        selectedPaymentMethod: null,
        rechargeAmounts: ['1000', '3000', '5000', '25000', '50000'],
        paymentMethods: [
            'S1pay',
            'FastPay',
            'INRpay',
            'Masterpay',
            'UZpay122',
            'wowpay',
            'Axpay',
            'htpay',
            'UZpay102',
            'wepay',
            'LEpay',
            'nicepay',
            'Bank card transfer'
        ],
        toorder : {},
        UserIDArr : [],
        FirstSelect : undefined,
        SecondSelect : undefined,
        thirdSelect : undefined,
        fourthSelect : undefined,
        fifthSelect : undefined,
        rechargeAmount : null,

        bct : undefined,
        nicepay : undefined,
        lepay : undefined,
        wepay : undefined,
        UZpay102 : undefined,
        htpay : undefined,
        axpay : undefined,
        wowpay : undefined,
        uzpay122 : undefined,
        masterpay : undefined,
        inrpay : undefined,
        fastpay : undefined,
        s1pay : undefined,
        strlabel : ''
        // sixthSelect : undefined,
        // seventhSelect : undefined,
        // eightSelect : undefined,
    }
},

methods: {
    selectAmount(amount) {
        console.log(amount)
    this.selectedAmount = amount;
    this.rechargeAmount = this.selectedAmount
    this.arrivalAmount = this.rechargeAmount
    },
selectPaymentMethod(paymentMethod) {
  this.selectedPaymentMethod = paymentMethod;
  console.log(paymentMethod)
},
    goback(){
        this.$router.push('/DepositView')
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

        if(this.selectedAmount){
            if(this.selectedPaymentMethod){
                this.toorder.ordernumber = `EE${moment().format("YYYYMMDD")}-${this.GenerateORDERID(this.LastUserID)}`
                this.toorder.amount = this.selectedAmount
                this.toorder.methods = this.selectedPaymentMethod
                this.toorder.userid = this.loggedInUser.id
                this.toorder.useraccount = this.loggedInUser.email
                this.toorder.state  = 'PENDING'

                axios.post('api/RechargeDetails/store',this.toorder).then((res)=>{
                    if(res.data){
                        toastMixin.fire({
                            icon: 'success',
                            title : 'Success!',
                            animation:true,
                            text: 'Successfully Proceeded!',
                        })
                        this.$store.commit("STORE_USERDEPOSIT",  this.toorder);
                        console.log(this.toorder)
                        this.$router.push('/RechargeDetails')
                    }
                })
              
            }else{
                // alert('Please Select')
                toastMixin.fire({
                    icon: 'error',
                    title : 'Oppsss....',
                    animation:true,
                    text: 'Please Input Amount',
                    })
            }
        }else{
            // alert('Please enter')
            toastMixin.fire({
                    icon: 'error',
                    title : 'Oppsss....',
                    animation:true,
                    text: 'Please Select Bank',
                    })
        }
        
    },

    GenerateORDERID(Last_userid) {
        let id = Last_userid;
        let split = id.split("-");
        console.log('split',split)
        let newId = +split[1] + 1;
        console.log('newid',newId )
        return newId.toString().padStart(7, "0");
        
    }, //GENERATE VAMID FOR EMPLOYEE APPLICATION

    loadLastID() {
        // LOAD VAM ID FOR EMPLOYEE APPLICATION
        console.log('load')
        axios
            .get(`api/RechargeDetails`).then((res) => {
                this.LastUserID = "";
                if (res.data[0] != null) {
                    this.UserIDArr = res.data[0];
                    // console.log('last1',this.UserIDArr)
                    this.LastUserID = this.UserIDArr; // Last VAMID for current date
                    // console.log('last2',this.LastUserID)
                } else {
                    this.LastUserID = "XXXXXXXXXX-000000";
                    console.log('Employee',this.LastUserID)
                }
            })
    }, //end of load vehicleID/VAMSID
},

created(){
    this.loadLastID()
}

}
</script>

<style>
/*.sticky{
    position: -webkit-sticky;
    position: sticky;
    top: 0;
}*/

.main{
    overflow: auto;
    height:700px;
    padding: 20px;
    width: 70%;
    margin: auto;
}
</style>