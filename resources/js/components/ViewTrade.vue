<template>
    <div class="main">
        <div>
            <center>
                <v-card flat>
                    <v-card-title style="background-color: #d7d3d3">
                      <v-btn @click="backMain()" plain><v-icon>mdi-keyboard-backspace</v-icon></v-btn>
                      <b>{{ details.symbolDisplayName }}</b>
                      <b>{{ obj.counting }}</b>
                    </v-card-title>
                  </v-card>

                <v-card flat>
                    <v-card-title>
                        <h1 :style="details.change > 0 ? 'color:Green;' : 'color:red;' ">
                            {{ details.now_price }}000
                        </h1>
                        <v-chip color="error">{{ details.change }}%</v-chip>
                    </v-card-title>
                    <v-divider />
                    <v-card-text>
                        <v-simple-table>
                            <thead>
                                <tr>
                                    <th>
                                        <center>High</center>
                                    </th>
                                    <th>
                                        <center>Low</center>
                                    </th>
                                    <th>
                                        <center>24H Quantiry</center>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <center>
                                            {{ ticker.high }}
                                        </center>
                                    </td>
                                    <td>
                                        <center>
                                            {{ ticker.low }}
                                        </center>
                                    </td>
                                    <td>
                                        <center>
                                            {{ ticker.vol }}
                                        </center>
                                    </td>
                                </tr>
                            </tbody>
                        </v-simple-table>

                        <div class="container-fluid">
                            <div class="row flex-xl-nowrap">
                                <div class="col">
                                    <div class="row">
                                        <div class="col-12 mb-3">
                                            <coin-charts
                                                :symbol="symbol"
                                            ></coin-charts>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <v-divider> </v-divider>
                        <!-- {{details}} -->

                        <v-simple-table
                            fixed-header
                            dense
                            style="overflow-y: auto;"
                            :height="$vuetify.breakpoint.height - 220"
                        >
                            <template v-slot:default>
                                <!-- the row will go here -->

                                <thead>
                                    <tr>
                                        <th class="text-center">Time</th>
                                        <th class="text-center">Direction</th>
                                        <th class="text-center">Price</th>
                                        <th class="text-center">Number</th>
                                       
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr
                                        v-for="(item, i) in getmarket_arr.filter((r)=>{return r.No == toTrading.symbol})"
                                        :key="i"
                                    >
                                        <td style="font-size: 12px">
                                            {{ item.updated_at.substring(0,10) }}
                                            {{ item.updated_at.substring(11,19) }}
                                        </td>

                                        <td style="font-size: 12px">
                                            {{ item.Direction == 'sell'?'Outsell':'Inbuy' }}
                                        </td>
                                        <td :style="{'font-size': '12px', 'color': item.Direction === 'sell' ? 'red' : 'green'}">
                                            {{ item.Price }}
                                        </td>

                                   
                                        <td :style="{'font-size': '12px', 'color': item.Direction === 'sell' ? 'red' : 'green'}">
                                            {{ item.Number }}
                                        </td>
                                      
                                    </tr>
                                </tbody>
                            </template>
                        </v-simple-table>
                    </v-card-text>
                </v-card>
            </center>
        </div>

        <v-footer fixed>
            <v-container fluid>
                <v-row>
                    <v-col >
                        <v-btn
                            block
                            dark
                            style="background-color: #12a36e"
                            @click="upbtn(cryptos)"
                            >Up</v-btn
                        ></v-col
                    >
                    <v-col 
                        ><v-btn 
                        dark 
                        style="background-color: #d72015" 
                        block
                        @click="upbtn(cryptos)"
                            >Down</v-btn
                        ></v-col
                    >
                </v-row>
                <!-- Your footer content goes here -->
            </v-container>
        </v-footer>

        <v-bottom-sheet v-model="sheet">
            <v-card style="overflow-y: auto"  :height="$vuetify.breakpoint.height - 400">
                <v-card-text>
                    <v-row>
                    <v-col class="ml-5">
                        <span style="font-size: 14px">Product Name</span><br />
                        <span>Direction</span><br />
                        <span>Current Price</span><br />
                    </v-col>
                    <v-col class="text-right mr-5">
                        <span class="text-right mr-5"> {{ obj.symbolDisplayName }}</span><br />
                        <span class="text-right mr-5"> {{ obj.direction }}</span><br />
                        <span class="text-right mr-5"> {{ obj.close }}</span><br />
                    </v-col>
                    </v-row>
                    <v-row>
                    <v-col class="ml-5">
                        <h3
                        style="
                            color: black;
                            font-weight: bold;
                            font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
                        "
                        >
                        Trading Time
                        </h3>
                        <br />
                        <v-row>
                        <v-sheet
                            rounded="lg"
                            class="text-center pt-1 px-1 mr-1"
                            @click="discount = 0.60"
                            :style="{
                            width: '120px',
                            'background-color': discount === 0.60 ? '#178BF6' : '#F8F8F9',
                            }"
                        >
                            <v-sheet
                            rounded="lg"
                            class="text-center mb-5"
                            :style="{
                                color: discount === 0.60 ? 'white' : '#676767',
                                'background-color': discount === 0.60 ? '#2492f8fa' : '#F2F2F2',
                            }"
                            >
                            <span>Time</span>
                            </v-sheet>
                            <span style="color: #feba3f; font-weight: bold; font-size: 18px"
                            >60S</span
                            >
        
                            <span :style="{ color: discount === 0.60 ? 'white' : '#676767' }"
                            >Scale:60.00%</span
                            >
                        </v-sheet>
                        <v-sheet
                            rounded="lg"
                            class="text-center pt-1 px-1 mr-1"
                            @click="discount = 0.40"
                            :style="{
                            width: '120px',
                            'background-color': discount === 0.40 ? '#178BF6' : '#F8F8F9',
                            }"
                        >
                            <v-sheet
                            rounded="lg"
                            class="text-center mb-5"
                            :style="{
                                color: discount === 0.40 ? 'white' : '#676767',
                                'background-color': discount === 0.40 ? '#2492f8fa' : '#F2F2F2',
                            }"
                            >
                            <span>Time</span>
                            </v-sheet>
                            <span style="color: #feba3f; font-weight: bold; font-size: 18px"
                            >120S</span
                            >
        
                            <span :style="{ color: discount === 0.40 ? 'white' : '#676767' }"
                            >Scale:40.00%</span
                            >
                        </v-sheet>
                        <v-sheet
                            rounded="lg"
                            class="text-center pt-1 px-1 mr-1"
                            @click="discount = 0.30"
                            :style="{
                            width: '120px',
                            'background-color': discount === 0.30 ? '#178BF6' : '#F8F8F9',
                            }"
                        >
                            <v-sheet
                            rounded="lg"
                            class="text-center mb-5"
                            :style="{
                                color: discount === 0.30 ? 'white' : '#676767',
                                'background-color': discount === 0.30 ? '#2492f8fa' : '#F2F2F2',
                            }"
                            >
                            <span>Time</span>
                            </v-sheet>
                            <span style="color: #feba3f; font-weight: bold; font-size: 18px"
                            >180S</span
                            >
        
                            <span :style="{ color: discount === 0.30 ? 'white' : '#676767' }"
                            >Scale:30.00%</span
                            >
                        </v-sheet>
                        </v-row>
                    </v-col>
                    </v-row>
                    <v-row>
                    <v-col class="ml-5">
                        <p>Investment Amount</p><br />
                        <v-text-field
                        placeholder="Minimun Purchase Limit 100"
                        outlined
                        dense
                        @keypress="onlyNumber"
                        v-model="obj.recharge"
                        ></v-text-field>
                    </v-col>
                    </v-row>
                    <v-row>
                    <v-col class="ml-5">
                        <span>Available Balance</span><br />
                        <span>Expected Earnings</span><br />
                    </v-col>
                    <v-col class="text-right mr-5" >
                        <span class="text-right mr-5"> {{ Account.Asset }}</span>
                        <br />
                        
                        <span class="text-right mr-5" v-if="obj.recharge == 0">
                        {{obj.recharge ==  0 ? 0 : 
                            obj.profit = (parseFloat(obj.recharge)  + parseFloat(discount) * parseFloat(obj.recharge)).toFixed(2)
                        }} </span>
                        <span class="text-right mr-5 " v-else>
                            {{obj.recharge ==  null ? 0 : 
                                obj.profit = (parseFloat(obj.recharge)  + parseFloat(discount) * parseFloat(obj.recharge)).toFixed(2)
                            }} </span>

                        
                        
                        <br/>
                       
                    </v-col>
                    </v-row>
                    <v-row>
                    <v-col>
                        <v-btn block color="primary" @click="submitbtn()">Submit</v-btn></v-col
                    >
                    </v-row>
                </v-card-text>
            </v-card>
        </v-bottom-sheet>
        <v-overlay :value="overlay">
            <v-progress-circular
            color="white"
            indeterminate
            :size="150"
            ></v-progress-circular>
        </v-overlay>
    </div>
</template>

<script>
import Swal from "sweetalert2";
import axios from "axios";
import CoinCharts from "../components/CoinCharts.vue";
import moment from "moment";
import { mapActions, mapState } from "vuex";

export default {
    components: {
        CoinCharts,
    },
    props: ["symbol"],
    data: () => ({
        TIDArr: [],
        SelectedCrpyto: {},
        details: {},
        ticker: {},
        cryptos: [],
        cryptos1: [],
        getmarket_arr: [],
        getamount: [],
        obj: {},
        recharge: 0,
        discount: 0.60,
        now: "",
        sheet: false,
        errors: [],
        Account:[],
        overlay: false,
    }),

    created() {
        this.getTickers();

        this.getMarketTable();

        this.GetDetails();

        this.loadLastID();

        this.GetUser();
        
        this.getTradeOrder()

        // this.calculateCount();

        setInterval(() => {
            this.GetDetails();
        }, 4000);

        // this.GetTrade();
        // setInterval(() => {
        // this.GetTrade();}, 4000);

        setInterval(() => {
            this.getTickers();
            let lastElement = this.getmarket_arr[this.getmarket_arr.length - 1];
            let countValue = lastElement.Count;
            
            if (String(this.cryptos1[0].ticker.count) != countValue) {
                this.addMarketTable();
            }
        }, 10000);
        this.getAmount();
    },
    computed: {
        ...mapState(["loggedInUser"]),
    },

    methods: {

        GetUser(){
            axios.get(`/api/AccountInfo`).then((res) => {
            for(let i = 0; i < res.data.length; i++){
                if(this.loggedInUser.id == res.data[i].id){
                // console.log('data',res.data[i])
                this.Account = res.data[i]
                }
            }
            });
        },

        backMain(){
            this.$router.push("/");
            location.reload();
        } ,
        ...mapActions(["GetAccounts"]),
        GetDetails() {
            axios
                .get(`https://omicomadswork.com/api/currency/getTradeDetail`)
                .then((res) => {
                    this.SelectedCrpyto = res.data.result.detail;
                    for (let i = 0; i < this.SelectedCrpyto.length; i++) {
                        if (
                            this.toTrading.match_id ==
                            this.SelectedCrpyto[i].match_id
                        ) {
                            this.details = this.SelectedCrpyto[i];
                            this.ticker = this.SelectedCrpyto[i].ticker;
                            // console.log("detail", this.details);
                            // console.log("ticker", this.ticker);
                        }
                    }
                });
        },

        getTickers() {
            const url1 =
                "https://omicomadswork.com/api/currency/getTradeDetail";

            axios
                .get(url1)
                .then((response) => {
                    this.cryptos1 = response.data.result.detail.filter((r)=>{return r.symbolDisplayName == this.toTrading.symbolDisplayName})
                    // this.cryptos1= response.data.result.trade
                 
                    // console.log(   this.cryptos  )

                    // Handle the API response here
                    let array=[];

                    array =response.data.result.trade.filter((r)=>{return r.symbol == this.toTrading.symbolDisplayName})
                    this.obj.direction = array[0].ticker.data[0].direction
                   
                    // console.log(this.obj.direction)
                    

                    // console.log(this.obj.direction,'1');
                })
                .catch((error) => {
                    // Handle any errors that occur during the API request
                    console.error(error);
                });

            const url =
                `https://api-testnet.bybit.com/v5/market/tickers?category=spot&symbol=${this.toTrading.symbol}`;

            axios
                .get(url)
                .then((response) => {
                    this.cryptos = response.data.result.list[0];
                    // Handle the API response here

                    // console.log(this.cryptos,'s');
                })
                .catch((error) => {

                    // Handle any errors that occur during the API request
                    console.error(error);
                });
        },
        getMarketTable() {
            
            let symbolDisplayName = this.toTrading.symbolDisplayName.replace(
                "/",
                ""
            );
            axios.get(`/api/getMarketTables/${symbolDisplayName}`)
                .then((res) => {
                    this.getmarket_arr = res.data;
                    // console.log(this.getmarket_arr, "sssssss");
                });
        },

        getAmount() {
            axios.get(`api/userright`).then((res) => {
                this.amount_arr = res.data;
                // console.log(this.getmarket_arr);
            });
        },
        addMarketTable() {
            let symbolDisplayName = this.toTrading.symbolDisplayName.replace(
                "/",
                ""
            );

            this.obj.lastPrice = this.cryptos.lastPrice;
            this.obj.price24hPcnt = this.cryptos.price24hPcnt;
            this.obj.updated_at = moment().format("YYYY-MM-DD HH:mm:ss");
            this.obj.Count = this.cryptos1[0].ticker.count;
            this.obj.SymbolName = symbolDisplayName;
// console.log( this.obj)

            axios
                .put("api/market/update", this.obj)
                .then((res) => {
                    this.getMarketTable();
                });
        },
        upbtn() {
            // this.discount == 0.6 ? (this.obj.discountResult = "60") : this.discount == 0.4 ? (this.obj.discountResult = "120") : (this.obj.discountResult = "180");
            this.obj.userId = this.loggedInUser.id;
            this.obj.email = this.loggedInUser.email;
            this.obj.profit = this.loggedInUser.remember_token;
            this.obj.name = this.loggedInUser.name;
            this.obj.symbolDisplayName = this.details.symbolDisplayName;
            this.sheet = true;
            this.obj.close = this.cryptos1[0].ticker.close;
            this.obj.open = this.cryptos1[0].ticker.open;
            console.log('UPPPPP',this.obj)
        },

        submitbtn() {
            let total = parseInt(this.Account.Asset) - parseInt(this.obj.recharge)
            console.log(total)
            // Alert
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
            if(this.obj.recharge >= 100){
                if (parseInt(this.Account.Asset) >= parseInt(this.obj.recharge)) {
                    if(100000000 > this.obj.recharge){
                        this.discount == 0.6
                    ? (this.obj.discountResult = "60")
                    : this.discount == 0.4
                    ? (this.obj.discountResult = "120")
                    : (this.obj.discountResult = "180");
                        // this.discount == 0.6 ? (this.obj.discountResult = "60") : this.discount == 0.4 ? (this.obj.discountResult = "120") : (this.obj.discountResult = "180");
                        this.obj.trading = "pending";
                        this.obj.T_id = `T${moment().format("YYYYMMDD")}-${this.GenerateTID(this.LastTID)}`
                        this.obj.order_time = moment().format("YYYY-MM-DD HH:mm:ss");
                        this.obj.complete_time = moment().format("YYYY-MM-DD HH:mm:ss");
                        this.obj.profit
                        
                        let addingTime = null;
                        this.discount == 0.6
                        ? (addingTime = 1)
                        : this.discount == 0.4
                        ? (addingTime = 2)
                        : (addingTime = 3);

                        let d = moment().format("YYYY-MM-DD HH:mm:ss");
                        let a = d.substring(0, 14);
                        let b = parseFloat(d.substring(14, 16)) + addingTime;
                        let c = d.substring(16, 19);
                        let combine = a + b + c;
                        this.obj.closing_time = moment().format(`${combine}`);
                        this.obj.delection = parseInt(this.Account.Asset - this.obj.recharge)
                        console.log('total',this.obj)
                        axios.post(`/api/BetDeduction`,this.obj).then((res)=>{
                            this.GetUser()
                        })
                        axios.post("api/Dashboard/store", this.obj)
                            .then((res) => {
                                this.$socket.emit('newUpdate', { updateType: "GetTrade" })
                                this.obj = {};
                                this.sheet = false;
                                toastMixin.fire({
                                    icon: 'success',
                                    title : 'Successfully',
                                    animation:true,
                                    text: 'Process Completed',
                                })
                                
                            });
                            
                    }else{
                        toastMixin.fire({
                        icon: 'error',
                        title : 'Oppsss....',
                        animation:true,
                        text: 'The Maximum Bet is 100,000.000',
                        })
                    }
               
                }else{
                    toastMixin.fire({
                        icon: 'error',
                        title : 'Oppsss....',
                        animation:true,
                        text: 'Your Input  is to Above in your E-money',
                        })
                }
            }else{
                toastMixin.fire({
                    icon: 'error',
                    title : 'Oppsss....',
                    animation:true,
                    text: 'Minimun Purchese Limit is 100',
                })
            }
           
        },

        GenerateTID(Last_TID) {
            let id = Last_TID;
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
                .get(`api/GetTID`).then((res) => {
                    // console.log('resdto',res.data)
                    this.LastTID = "";
                    if (res.data[0] != null) {
                        this.TIDArr = res.data[0];
                        // console.log('last1',this.TIDArr)
                        this.LastTID = this.TIDArr; // Last VAMID for current date
                        // console.log('last2',this.LastUserID)
                    } else {
                        this.LastTID = "XXXXXXXXXX-000000";
                        // console.log('Employee',this.LastTID)
                    }
                })
        }, //end of load vehicleID/VAMSID


        onlyNumber($event) {
            let keyCode = $event.keyCode ? $event.keyCode : $event.which;
            if (keyCode < 48 || keyCode > 57) {
                // 46 is dot
                $event.preventDefault();
            }
        }, //END FOR ONLY NUMBER FUNCTION

        getTradeOrder() {
        let interval= setInterval(() => {
            // if(this.functionName != 'Transaction'){
            //     clearInterval(interval)
            // }
            axios.get(`api/TradeOrders/${this.loggedInUser.id}`).then((res) => {
                            this.gettradeorders = res.data
                        
                            if(this.gettradeorders[0].trading == 'closed'){
                                clearInterval(interval)
                            }
                            console.log('sa order',this.gettradeorders)
                                this.gettradeorders.forEach((item,index) => {
                                    let daycut = moment().format("YYYY-MM-DD HH:mm:ss");
                                    let string = daycut;
                                    let targetMoment1 = moment(`${string}`);
                                    let targetMoment2 = moment(`${item.closing_time}`);
                                    let diffInSeconds = targetMoment2.diff(targetMoment1, "seconds");
                                    
                                    item.counting = diffInSeconds +1;
                                    // console.log(item.counting)
                                    
                                    // let interval = setInterval(() => {
                                    if ( item.counting == 0) {
                                        console.log('1')
                                        clearInterval(interval);
                                        this.updateTradingValue(item);
                                    }else if(item.counting <= 0 && item.trading === 'pending'){
                                        console.log('2')
                                        clearInterval(interval);
                                        this.updateTradingValue(item);
                                    }
                                    item.counting--;
                            })
            });
        },2000 );
            },
            updateTradingValue(item) {
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
                console.log('item',item)
                item.result = parseFloat(item.quantity) + parseFloat(item.profit);
                console.log('item dto sa order',item)
                axios.post(`api/calculateCount`, item).then((res) => {
                        //admin win or loost bawas o dagdag ng pera
                axios.post(`api/adminprocess`,item).then((res)=>{
                    setTimeout(() => {
                        // this.getTradeOrder();
                        toastMixin.fire({
                        icon: 'success',
                        title : 'Your Bet is Susscessful Done!',
                        animation:true,
                        text: 'Successfully Done',
                    })
                    this.$socket.emit('newUpdate', { updateType: "GetTrade" })
                    this.$socket.emit('newUpdate', { updateType: "ProcessBet" })
                    this.$socket.emit('newUpdate', { updateType: "ConfirmRecharge" })
                    }, 2000);
                })
                // this.getTradeOrder(); 
                    })
                    .catch((error) => {
                    console.error(error);
                    });
            },


    },
    components: {
        CoinCharts,
    },
};
</script>

<style scoped>
tbody,
th,
thead,
tr,
td {
    border: 0px solid white;
    border-collapse: collapse;
    text-align: center !important;

}

th {
    font-weight: bold !important;
    text-align: center !important;
    color: black !important;
}

.main{
    width: 100%;
}
@media only screen and (max-width: 375px) {
    .main {
      /* Adjust styles for iPhone 6/7/8 */
      display: flex;
      flex-direction: column;
      align-items: center;
    }
  
    .main .v-card {
      width: 100%;
    }
  }

  @media only screen and (min-width: 376px) and (max-width: 600px) {
    .main {
      /* Adjust styles for larger mobile devices */
      display: flex;
      flex-direction: column;
      align-items: center;
    }
  
    .main .v-card {
      width: 80%;
    }
  }

@media only screen and (max-width: 600px) {
    .main {
      /* Adjust styles for mobile devices */
      display: flex;
      flex-direction: column;
      align-items: center;
    }
  
    .main .v-card {
      width: 100%;
    }
  }

  @media only screen and (min-width: 601px) and (max-width: 1024px) {
    .main {
      /* Adjust styles for tablets */
      display: flex;
      flex-direction: column;
      align-items: center;
    }
  
    .main .v-card {
      width: 80%;
    }
  }

  @media only screen and (min-width: 1025px) {
    .main {
      /* Default styles for larger screens */
      display: flex;
      justify-content: center;
    }
  
    .main .v-card {
      width: 60%;
    }
  }

  /* Additional CSS styles for the table */

  @media only screen and (max-width: 375px) {
    .v-simple-table {
      /* Adjust table width for iPhone 6/7/8 */
      width: 100%;
    }
  }
  @media only screen and (min-width: 376px) and (max-width: 600px) {
    .v-simple-table {
      /* Adjust table width for larger mobile devices */
      width: 80%;
    }
  }
@media only screen and (max-width: 600px) {
    .v-simple-table {
      /* Adjust table width for mobile devices */
      width: 100%;
    }
  }

  @media only screen and (min-width: 601px) and (max-width: 1024px) {
    .v-simple-table {
      /* Adjust table width for tablets */
      width: 80%;
    }
  }

  @media only screen and (min-width: 1025px) {
    .v-simple-table {
      /* Default table width for larger screens */
      width: 60%;
    }
  }

  @media only screen and (min-width: 1025px) and (max-width: 1280px) {
    .main {
      /* Adjust styles for screens with width between 1025px and 1280px */
      display: flex;
      flex-direction: column;
      align-items: center;
    }
  
    .main .v-card {
      width: 70%;
      max-height: 60vh; /* Adjust the height as needed */
    }
  
    .v-simple-table {
      /* Adjust table width for screens with width between 1025px and 1280px */
      width: 70%;
      max-height: 40vh; /* Adjust the height as needed */
    }
  }

  @media only screen and (min-width: 1281px) and (max-width: 1920px) {
    .main {
      /* Adjust styles for screens with width between 1281px and 1920px */
      display: flex;
      flex-direction: column;
      align-items: center;
    }
  
    .main .v-card {
      width: 80%;
      max-height: 65vh; /* Adjust the height as needed */
    }
  
    .v-simple-table {
      /* Adjust table width for screens with width between 1281px and 1920px */
      width: 80%;
      max-height: 50vh; /* Adjust the height as needed */
    }
  }
</style>
