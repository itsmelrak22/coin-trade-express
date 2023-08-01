<template>
  <v-container fluid>
    <div class="home">
      <div style="margin-bottom: 10px;">
        <div>
          <img style="width: 100%; border-radius: 5px; height: 100%;" src="BTC.jpeg" alt="no img">
          <v-row no-gutters>
            <v-col cols="4" md="2" style="margin-bottom: 20px;">
              <v-card height="150px" flat>
                <v-card-title>
                  <b>{{( CoinDataBTC.symbol.substring(0, 3)) }}</b>
                </v-card-title>
                <v-card-text>
                  <h3 :style="CoinDataBTC.priceChangePercent > 0 ? 'color:green;' : 'color:red;'"><b>{{(CoinDataBTC.askPrice.slice(0, 8))}}</b></h3>
                  <h3 :style="CoinDataBTC.priceChangePercent > 0 ? 'color:green;' : 'color:red;'"><b><v-icon color="red" v-if="CoinDataBTC.priceChangePercent <= 0">mdi-menu-down</v-icon> <v-icon color="green" v-if="CoinDataBTC.priceChangePercent >= 0">mdi-menu-up</v-icon>
                    {{CoinDataBTC.priceChangePercent}}%</b></h3>
                </v-card-text>
                <v-card flat max-height="220px">
                </v-card>
              </v-card>
            </v-col>

            <v-col cols="4" md="2" style="margin-bottom: 20px;">
              <v-card height="150px" flat>
                <v-card-title>
                  <b>{{ (CoinDataETH.symbol.substring(0, 3)) }}</b>
                </v-card-title>
                <v-card-text>
                  <h3 :style="CoinDataETH.priceChangePercent > 0 ? 'color:green;' : 'color:red;'"><b>{{(CoinDataETH.askPrice.slice(0, 8))}}</b></h3>
                  <h3 :style="CoinDataETH.priceChangePercent > 0 ? 'color:green;' : 'color:red;'"><b><v-icon color="red" v-if="CoinDataETH.priceChangePercent <= 0">mdi-menu-down</v-icon> <v-icon color="green" v-if="CoinDataETH.priceChangePercent >= 0">mdi-menu-up</v-icon>
                    {{CoinDataETH.priceChangePercent}}%</b></h3>
                </v-card-text>
                <v-card flat max-height="220px">

                </v-card>
              </v-card>
            </v-col>

            <v-col cols="4" md="2" style="margin-bottom: 20px;">
              <v-card height="150px" flat>
                <v-card-title>
                  <b>{{ (CoinDataLTC.symbol.substring(0, 3)) }}</b>
                </v-card-title>
                <v-card-text>
                  <h3 :style="CoinDataLTC.priceChangePercent > 0 ? 'color:green;' : 'color:red;'"><b>{{(CoinDataLTC.askPrice.slice(0, 8))}}</b></h3>
                  <h3 :style="CoinDataLTC.priceChangePercent > 0 ? 'color:green;' : 'color:red;'"><b><v-icon color="red" v-if="CoinDataLTC.priceChangePercent <= 0">mdi-menu-down</v-icon> <v-icon color="green" v-if="CoinDataLTC.priceChangePercent >= 0">mdi-menu-up</v-icon>
                    {{CoinDataLTC.priceChangePercent}}%</b></h3>
                </v-card-text>
                <v-card flat max-height="220px">

                </v-card>
              </v-card>
            </v-col>
          </v-row>
          <br>
          <div>
            <v-toolbar dense flat style="border-radius:10px; background: radial-gradient(circle, #fff 0%, #8ecdf1 100%);">
              
              <img src="wallet.png" title="wallet icons" style="height: 40px;">
              <b> Quick recharge </b>
              <v-spacer></v-spacer>
              <v-btn href="/DepositView" color="primary" width="60px">
                <b>Go</b>
              </v-btn>
            </v-toolbar>
          </div>
          <br>
          <v-simple-table flat >
            <thead>
              <tr>
                <th><center>Name</center></th>
                <th><center>Latest Price</center></th>
                <th><center>24H Up and Down</center></th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(item, i) in cryptoTable" :key="i" class="text-center" @click="toView(item)">
                <td v-if="item.symbol.substring(0, 4) == 'DOGE'">
                  <v-avatar size="30">
                    <img
                      alt="no image found"
                      :src="`https://assets.coincap.io/assets/icons/${ item.symbol.substring(0, 4).toLowerCase()}@2x.png`"
                      width="40"
                      height="40px"
                    />
                  </v-avatar>
                {{ item.symbol.substring(0, 4)}}
                </td>
                <td  v-else-if="item.symbol.substring(0, 4) == 'IOTA'">
                  <v-avatar size="30">
                    <img
                    
                    alt="no image found"
                    :src="`https://assets.coincap.io/assets/icons/m${ item.symbol.substring(0, 4).toLowerCase()}@2x.png`"
                    width="40"
                    height="40px"
                  />
                  </v-avatar>
                {{ item.symbol.substring(0, 4) }}
                </td>
                <td  v-else>
                  <v-avatar size="30">
                    <img
                    
                    alt="no image found"
                    :src="`https://assets.coincap.io/assets/icons/${ item.symbol.substring(0, 3).toLowerCase()}@2x.png`"
                    width="40"
                    height="40px"
                  />
                  </v-avatar>
                {{ item.symbol.substring(0, 3) }}
                </td>
                <td>
                  <center>
                    {{item.lastPrice.slice(0, 8)}}
                  </center>
                </td>
                <td>
                  <center>
                    <!-- red -->
                    <v-chip dark v-if="item.priceChangePercent <= 0" :color="item.priceChangePercent < 0 ? 'error' : '#12a36e'">
                      {{item.priceChangePercent}}%
                    </v-chip>
                    <!-- green -->
                    <v-chip dark v-if="item.priceChangePercent > 0" :color="item.priceChangePercent > 0 ? '#12a36e' : 'error'">
                      {{item.priceChangePercent}}%
                    </v-chip>
                  </center>
                </td>
              </tr>
            </tbody>
          </v-simple-table><!--end of simple table-->

          <template>
            <v-footer plain padless class="footer">
              <v-bottom-navigation  color="primary" fixed>
                <v-row no-gutters>
                  <v-col class="text-center" cols="4">
                    <v-btn @click="Home" block>
                      <v-icon>
                        mdi-home-analytics
                      </v-icon>
                      Home
                    </v-btn>
                  </v-col>
                  <v-col class="text-center" cols="4">
                    <v-btn block @click="Order">
                      <v-icon>
                        mdi-chart-line-stacked
                      </v-icon>
                      Order
                    </v-btn>
                  </v-col>
                  <v-col class="text-center" cols="4">
                    <v-btn @click="Center" block>
                      <v-icon>
                        mdi-account
                      </v-icon>
                      My Center
                    </v-btn>
                  </v-col>
                </v-row>
              </v-bottom-navigation>
            </v-footer>
          </template>
          <v-overlay :value="overlay">
            <v-progress-circular
            color="white"
            indeterminate
            :size="150"
            ></v-progress-circular>
        </v-overlay>
        </div>
      </div>
    </div>
  </v-container>
</template>

<script>
import Sparkline from './Sparkline.vue'
// import { getTradeOrder } from '../tradeOrderService';
import moment from "moment";
import Swal from "sweetalert2";
// const proxyUrl = 'https://proxy.mysoftnotes.com/proxy.php?curl=';
let cryptoData = [];

export default {
  sockets: {
        // NOTE : SOCKET 
        updateReceived: function(socket) {
            console.log(socket)
            if( socket.updateType && socket.updateType == 'GetTradeDetails'){
                console.log('GetTradeDetails')
                this.GetTradeDetails();
            }
        }
    },
    data:()=>({
        CoinDataETH : {},
        CoinDataBTC : {},
        CoinDataLTC : {},
        img: {},
        ticker : {},
        btc : '',
        currentcy : '',
        last_value: '',
        showDropDown: false,
        percent : 0,
        volume : '',
        php : 0,
        cryptoTable: {},
        overlay : false,

    }),

    created(){
      // const loggedInUserId = this.loggedInUser.id
      //  getTradeOrder(loggedInUserId);
      this.GetTradeDetails();
      this.getTradeOrder();
      // setInterval(() => { this.GetTradeDetails();}, 2000);
        
    },

    methods:{

      Home(){
            this.$router.push('/')
            location.reload();
      },
      Center(){
        this.$router.push('/AccountInfo')
        location.reload();
      },
      Order(){
        this.$router.push('/Order')
        location.reload();
      },

        GetTradeDetails(){
          fetch(`https://data.binance.com/api/v3/ticker/24hr`).then((response)=>{
            response.json().then((data)=>{
              
              console.log(data)
              
              this.cryptoTable = data.filter((rec) => {
              return ['BTCUSDT', 'LTCUSDT', 'ETHUSDT','NEOUSDT' ,
                      'IOTAUSDT' ,'BCHUSDT','SNTUSDT' ,'XRPUSDT' ,
                      'DOGEUSDT','CHZUSDT','ETCUSDT','EOSUSDT','TRBUSDT',
                      'WICCUSDT','HTUSDT'].includes(rec.symbol);
            });

                console.log('getGetTradeDetails',this.cryptoTable)
                this.CoinDataBTC = this.cryptoTable[0]
                this.CoinDataETH = this.cryptoTable[1]
                this.CoinDataLTC = this.cryptoTable[3]
                // for(let i=0; i<this.cryptoTable.length; i++){
                //     if(this.cryptoTable[i].symbol == 'LTCUSDT'){
                //       this.CoinDataLTC = this.cryptoTable[i]
                //       console.log(this.CoinDataLTC)
                //     }
                // }
            }) 
          })
            // this.cryptoTable = thiss.cryptoTable
            console.log('1',this.cryptoTable)
        },// dto sa get nato lagi my nag babago sa na geget nya kaya na ttriger lagi ung emit socket

        toView(value){
          console.log(value)
          value.interval = '1d'
          // value.symbol = value.symbol.substring(0, 3).toLowerCase()
          // console.log('value',value)
          this.$store.commit("STORE_TRADING", value);
          this.$router.push("/ViewTrade");
          
          // const url = `hello/ViewTrade`;
          // open(url);
          // window.open(`hello/ViewTrade`)

        },
     
        closeDropDown() {
        this.showDropDown = false;
        },
         //++++++++++++++++++++++++++++++++Sample +++++++++++++++++++++++++++++++++++++
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

        

        GotoRecharge(){
          this.$router.push("/DepositView");
        }
    },

    components: {
      Sparkline
    }
        
    
}



</script>
<style scoped>

.home {
  overflow: auto;
  height: 750px;
  padding: 20px;
  margin: auto;
  width: 80%;
}

@media (max-width: 768px) {
  .home {
    height: auto;
    width: 100%;
  }
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

@media only screen and (min-width: 1025px) {
  .v-simple-table {
    /* Default table width for larger screens */
    width: 60%;
  }
}

@media only screen and (min-width: 601px) and (max-width: 1024px) {
  .v-simple-table {
    /* Adjust table width for tablets */
    width: 80%;
  }
}

@media only screen and (max-width: 600px) {
  .v-simple-table {
    /* Adjust table width for mobile devices */
    width: 100%;
  }
}
</style>