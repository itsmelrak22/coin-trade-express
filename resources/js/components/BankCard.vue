<template>
    <div class="home">
        <div>
            <!-- User information -->

            <!-- Asset Center -->

            <v-card flat class="user-id">
                <v-list dense>
                    <v-list-item>
                        <v-list-item-content>
                            <v-card>
                                <v-card-text>
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
                        <h3>Go bind nowBank card</h3>
                    </v-toolbar>
<v-card-text style="background-color: #FFFFFF">
                    <v-row  no-gutters class="ma-3">
                        <v-text style="font-size: 11px;font-weight:bold">Please enter your name</v-text>
                    </v-row>
                    <v-row  no-gutters class="ma-3">
                        <v-text-field  color="black" v-model="obj.name" dense hide-details> </v-text-field>
                    </v-row>
                    <v-row  no-gutters class="ma-3">
                        <v-text style="font-size: 11px;font-weight:bold">Please enter your phone number</v-text>
                    </v-row>
                    <v-row  no-gutters class="ma-3">
                        <v-text-field color="black" v-model="obj.phonenumber" dense hide-details> </v-text-field>
                    </v-row>
                </v-card-text>
                  <v-card-text style="background-color: #FFFFFF">
       
                    <v-row  no-gutters  class="ma-3">
                        <v-text style="font-size: 11px;font-weight:bold">bank of deposit </v-text>
                    </v-row>
                    <v-row  no-gutters class="ma-3">
                        <v-select   :items="bankdeposit_arr"
          item-text="bankName"
          item-value="bankName" color="black" class="custom-text-field" v-model="obj.bankdeposit" dense hide-details> </v-select>
                    </v-row>
                    <v-row  no-gutters  class="ma-3">
                        <v-text style="font-size: 11px;font-weight:bold">Please enter the bank of deposit branch</v-text>
                    </v-row>
                    <v-row  no-gutters class="ma-3">
                        <v-text-field color="black" v-model="obj.depositbranch" dense hide-details> </v-text-field>
                    </v-row>
                    <v-row  no-gutters  class="ma-3">
                        <v-text style="font-size: 11px;font-weight:bold">Bank Account</v-text>
                    </v-row>
                    <v-row  no-gutters class="ma-3">
                        <v-text-field color="black" v-model="obj.bankaccount" dense hide-details> </v-text-field>
                    </v-row>
                    <v-row  no-gutters  class="ma-3">
                        <v-text style="font-size: 11px;font-weight:bold">IFSC Code</v-text>
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

export default {
    data: () => ({
        dialogBankCard: false,
        bankdeposit_arr:[{bankName:'ANEXT BANK PTE. LTD.'}],
        obj:{},
    csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),

    }),

    created() {},
computed:{

        ...mapState(["loggedInUser"]),

},
    methods: {
        ...mapActions(["GetAccounts"]),

        openBankcard() {
            this.dialogBankCard = true;
        },
        returnBankCard(val) {
            this.dialogBankCard = val;
        },
        submitBank(){
            alert('succes')
            this.obj.UserID = this.loggedInUser.id;
            axios.post("api/bankcard/store", this.obj)
                .then((res) => {
                    this.obj = {};
                    this.dialogBankCard = false;
                });

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
