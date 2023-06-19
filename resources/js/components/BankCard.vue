<template>
    <div class="grid-container" fluid>
        <div>
            <!-- User information -->

            <!-- Asset Center -->
            <!-- <h1> {{ checking.UserID }}  </h1> 
            <h1> log{{loggedInUser.id }}</h1>   -->
            <!-- v-if="this.checking.UserID != this.loggedInUser.id" -->
            <v-card flat class="user-id" >
                <v-list dense>
                    <v-list-item>
                        <v-list-item-content>
                            <v-card>
                                <v-card-text>
                                    <v-col></v-col>
                                </v-card-text>
                            </v-card>
                        </v-list-item-content>
                    </v-list-item>
                    <v-btn
                        absolute
                        bottom
                        block
                        dark
                        color="primary"
                        @click="openBankcard()"
                    >
                        <v-icon>mdi-plus</v-icon>
                    </v-btn>
                </v-list>
            </v-card>

            
        <v-list dense>
            <v-list-item v-for="(item, i) in BankInfo" :key="i">
                <v-list-item-content>
                    <v-card >
                        <v-card-text>
                            <v-row>
                                <v-col>
                                    <v-btn plain color="success" @click="Handle_Edit(item)"><v-icon>mdi-pencil</v-icon></v-btn>
                                    <v-btn plain color="error" @click="Handle_Delete(item)"><v-icon>mdi-trash-can</v-icon></v-btn>
                                    </v-col>
                            </v-row>
                            <v-row>
                                <v-col><span>Name</span><br/></v-col>
                                <v-col><span>Bank Name</span><br/></v-col>
                                <v-col><span>Branch Branch</span><br/></v-col>
                                <v-col><span>Bank Account</span><br/></v-col>
                                <v-col><span>IFSC</span><br/></v-col>
                                </v-row>
                                <v-row>
                                    <v-col><span>{{item.name}}</span><br/></v-col>
                                    <v-col><span>{{item.bankdeposit}}</span><br/></v-col>
                                    <v-col><span>{{item.depositbranch}}</span><br/></v-col>
                                    <v-col><span>{{item.bankaccount}} </span><br/></v-col>
                                    <v-col><span>{{item.ifsc}} </span><br/></v-col>
                                </v-row>
                                <v-row>
                                <!-- <v-col><span>time</span><br/></v-col>
                                <v-col><span>P/L[BTC]</span><br/></v-col>
                                <v-col><span>status </span><br/></v-col> -->
                            
                                </v-row>
                        
                                <v-row>
                                <!-- <v-col>Sec</v-col>
                                <v-col></v-col>
                                <v-col></v-col> -->
                                </v-row>
                        </v-card-text>
                    </v-card>
                </v-list-item-content>
            </v-list-item>
        </v-list>

            <!-- Your bottom sheet content here -->

            <v-dialog v-model="dialogBankCard" fullscreen>
                <v-card color="#F1F1F1" flat>
                    <v-toolbar color="#F1F1F1"  dense flat>
                        <v-btn
                            icon
                            large
                            dark
                            color="black"
                            @click="returnBankCard()"
                        >
                            <v-icon>mdi-arrow-left</v-icon>
                        </v-btn>
                        <h3>Go Back</h3>
                    </v-toolbar>
                    <v-card-text style="background-color: #FFFFFF">
                    <v-row  no-gutters class="ma-3">
                        <span style="font-size: 11px;font-weight:bold">Please enter your name</span>
                    </v-row>
                    <v-row  no-gutters class="ma-3">
                        <v-text-field  color="black" v-model="obj.name" dense hide-details> </v-text-field>
                    </v-row>
                    <v-row  no-gutters class="ma-3">
                        <span style="font-size: 11px;font-weight:bold">Please enter your phone number</span>
                    </v-row>
                    <v-row  no-gutters class="ma-3">
                        <v-text-field color="black" v-model="obj.phonenumber" dense hide-details> </v-text-field>
                    </v-row>
                </v-card-text>
                  <v-card-text style="background-color: #FFFFFF">
       
                    <v-row  no-gutters  class="ma-3">
                        <span style="font-size: 11px;font-weight:bold">Bank of Deposit </span>
                    </v-row>
                    <v-row  no-gutters class="ma-3">
                        <v-select   :items="bankdeposit_arr"
                        item-text="bankName"
                        item-value="bankName" color="black" class="custom-text-field" v-model="obj.bankdeposit" dense hide-details> </v-select>
                    </v-row>
                    <v-row  no-gutters  class="ma-3">
                        <span style="font-size: 11px;font-weight:bold">Please enter the Bank of Deposit Branch</span>
                    </v-row>
                    <v-row  no-gutters class="ma-3">
                        <v-text-field color="black" v-model="obj.depositbranch" dense hide-details> </v-text-field>
                    </v-row>
                    <v-row  no-gutters  class="ma-3">
                        <span style="font-size: 11px;font-weight:bold">Bank Account</span>
                    </v-row>
                    <v-row  no-gutters class="ma-3">
                        <v-text-field color="black" v-model="obj.bankaccount" dense hide-details> </v-text-field>
                    </v-row>
                    <v-row  no-gutters  class="ma-3">
                        <span style="font-size: 11px;font-weight:bold">IFSC Code</span>
                    </v-row>
                    <v-row  no-gutters class="ma-3">
                        <v-text-field color="black" v-model="obj.ifsc" dense hide-details> </v-text-field>
                    </v-row>
                

                </v-card-text>
                <v-card-text style="background-color: #FFFFFF">
                    <v-row  no-gutters class="ma-3">
                        <v-btn color ="primary" block @click="submitBank()">Submit</v-btn>
                    </v-row>
</v-card-text>
                </v-card>
            </v-dialog>

            <template>
                <v-footer plain padless class="footer">
                    <v-bottom-navigation color="primary" fixed>
                        <v-row no-gutters>
                            <v-col class="text-center" cols="4">
                                <v-btn @click="Home" block>
                                    <v-icon> mdi-home-analytics </v-icon>
                                    Home
                                </v-btn>
                            </v-col>
                            <v-col class="text-center" cols="4">
                                <v-btn block @click="Order">
                                    <v-icon> mdi-chart-line-stacked </v-icon>
                                    Order
                                </v-btn>
                            </v-col>
                            <v-col class="text-center" cols="4">
                                <v-btn @click="Center" block>
                                    <v-icon> mdi-account </v-icon>
                                    My Center
                                </v-btn>
                            </v-col>
                        </v-row>
                    </v-bottom-navigation>
                </v-footer>
            </template>
        </div>
    </div>
</template>

<script>
import { mapActions, mapState } from "vuex";
import Swal from "sweetalert2";
export default {
    data: () => ({
        dialogBankCard: false,
        bankdeposit_arr:[
            {bankName:'UNITED OVERSEAS BANK LTD'},
            {bankName:'ANEXT BANK PTE. LTD.'},
            {bankName:'AUSTRALIA AND NEW ZEALAND BANKING GROUP LIMITED'},
            {bankName:'BANK OF CHINA LIMITED'},
            {bankName:'BNP PARIBAS'},
            {bankName:'CIMB BANK BERHAD'},
            {bankName:'CITIBANK NA SINGAPORE'},
        ],
        obj:{},
        BankInfo:{},
        checking:{},
        checking1:{},
        BankInfo: [],
        title: 'Add',
        
    csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),

    }),

    created() {
        this.getBankInfo();
    },
computed:{

        ...mapState(["loggedInUser"]),

},
    methods: {
        ...mapActions(["GetAccounts"]),
        getBankIndo(){
            axios.get(`api/bankcards`).then((res)=>{
            console.log(res.data.length == 0)
                    this.BankInfo = res.data
                    console.log('bankinfo',this.BankInfo)
        })
        },

        openBankcard() {
            // var toastMixin = Swal.mixin({
            //     toast: true,
            //     icon: 'success',
            //     title: 'General Title',
            //     animation : false,
            //     position: 'top-right',
            //     showConfirmButton: false,
            //     timer: 1500,
            //     timerProgressBar : true,
            //     dibOpen : (toast) => {
            //     toast.addEventListener('mouseenter', Swal.stopTimer)
            //     toast.addEventListener('mouseleave', Swal.resumeTimer)
            //     }
            // })
            // alert('Please End your Game Before You Withdraw')
            // toastMixin.fire({
            //             icon: 'error',
            //             title : 'Please!',
            //             animation:true,
            //             text: 'Please End your Game Before You Withdraw...',
            //         })
            this.dialogBankCard = true;
            this.title = 'Add'
        },
        returnBankCard(val) {
           
            this.dialogBankCard = val;
        },
        submitBank(){
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
            if(this.title == 'Add'){
                if(this.obj.name){
                if(this.obj.phonenumber){
                    if(this.obj.bankdeposit){
                        if(this.obj.depositbranch){
                            if(this.obj.bankaccount){
                                if(this.obj.ifsc){
                                    this.obj.UserID = this.loggedInUser.id;
                                        axios.post("api/bankcard/store", this.obj).then((res) => {
                                        this.obj = {};
                                        this.dialogBankCard = false;
                                        toastMixin.fire({
                                            icon: 'success',
                                            title : 'Susscessful!',
                                            animation:true,
                                            text: 'Successfully added',
                                        })
                                        this.getBankInfo();
                                        });
                                }else{
                                    toastMixin.fire({
                                    icon: 'error',
                                    title : 'Please!',
                                    animation:true,
                                    text: 'Please Input your IFSC!',
                                    })
                                }
                               
                            }else{
                                toastMixin.fire({
                                icon: 'error',
                                title : 'Please!',
                                animation:true,
                                text: 'Please Input your Bank Account!',
                                })
                            }
                          
                        }else{
                            toastMixin.fire({
                            icon: 'error',
                            title : 'Please!',
                            animation:true,
                            text: 'Please Input your Bank Branch!',
                            })
                        }
                    }else{
                        toastMixin.fire({
                        icon: 'error',
                        title : 'Please!',
                        animation:true,
                        text: 'Please Input your Bank!',
                        })
                    }
                }else{
                    toastMixin.fire({
                    icon: 'error',
                    title : 'Please!',
                    animation:true,
                    text: 'Please Input your Number!',
                    })
                }
            }else{
                toastMixin.fire({
                    icon: 'error',
                    title : 'Please!',
                    animation:true,
                    text: 'Please Input your name!',
                })
            }
            }else if(this.title == 'Edit'){
                // console.log('pasok')
                this.obj.UserID = this.loggedInUser.id;
                console.log('pasok',this.obj)
                axios.post(`api/bankcard/update`, this.obj).then((res) => {
                this.obj = {};
                this.dialogBankCard = false;
                toastMixin.fire({
                    icon: 'success',
                    title : 'Susscessful!',
                    animation:true,
                    text: 'Successfully Updated',
                })
                this.getBankInfo();
                });
            }
            
           
        },
        GotoRecharge(){
        this.$router.push("/DepositView");
        },
        GotoWithdrawal(){
        this.$router.push("/Withdrawal");
        },
        Home(){
        this.$router.push('/')
        },
        Center(){
        this.$router.push('/AccountInfo')
        },
        Order(){
        this.$router.push('/Order')
        },
        BankCard(){
        this.$router.push("/BankCard");
        },

    getBankInfo(){
        axios.get(`api/bankcards`).then((res)=>{
            // console.log(res.data[0].UserID)
            for(let i = 0; i < res.data.length; i++){
                if(res.data[i].UserID == this.loggedInUser.id ){
                this.BankInfo = res.data
                console.log('bankinfo',this.BankInfo)
                this.checking = res.data[i]
                }else{
                  this.checking = res.data[i]
                }
            }
        })
    },

    Handle_Edit(item){
        console.log(item)
        this.obj = {...item}
        this.dialogBankCard = true;
        this.title = "Edit"

    },

    Handle_Delete(item){
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
        item.UserID = this.loggedInUser.id;
                console.log('pasok',item)
                axios.post(`api/bankcard/Delete`, item).then((res) => {
                this.obj = {};
                this.dialogBankCard = false;
                toastMixin.fire({
                    icon: 'success',
                    title : 'Susscessful!',
                    animation:true,
                    text: 'Successfully Deleted',
                })
                this.getBankInfo();
                location.reload();
                });
    }
    },
};
</script>

<style scoped>
.custom-text-field input,
.custom-text-field .v-input__control,
.custom-text-field .v-text-field__slot {
  border-bottom-color: red; /* Change the line color as desired */
}

.home {
    overflow: auto;
    height: 800px !important;
    max-width: 100%;
    margin: auto;
}

.user-id {
    color: #676767;
    font-family: -apple-system, BlinkMacSystemFont, PingFang SC, Helvetica Neue,
        STHeiti, Microsoft Yahei, Tahoma, Simsun, sans-serif;
}

p {
    display: block;
    margin-block-start: 1em;
    margin-block-end: 1em;
    margin-inline-start: 0px;
    margin-inline-end: 0px;
    font-family: -apple-system, BlinkMacSystemFont, PingFang SC, Helvetica Neue,
        STHeiti, Microsoft Yahei, Tahoma, Simsun, sans-serif;
}

.amount {
    font-family: -apple-system, BlinkMacSystemFont, PingFang SC, Helvetica Neue,
        STHeiti, Microsoft Yahei, Tahoma, Simsun, sans-serif;
    text-indent: 10px;
    line-height: 40px;
    text-align: left;
}

.footer {
    position: fixed;
    bottom: 0;
    width: 100%;
    z-index: 999;
}

@media (max-width: 600px) {
    .footer {
        padding: 10px;
    }
}
</style>
