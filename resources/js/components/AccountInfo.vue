<template>
  <v-container fluid >
      <div class="bg" >
        <!-- User information -->

        <center>
          <img src="https://cryptobtc01.com/imgs/user.png" alt="" width="80px" height="80px">
          <br>
          <span style="font-weight: bold;">{{ Account.email }}</span>
          <br>
          <span class="user-id">ID:{{ Account.id }}</span>
          <br>
        <span class="user-id1">{{ Account.remarks }}</span>

        </center>
  
        <!-- Asset Center -->
        <v-card flat>
          <span>Asset Center</span>
          <br>
          <span style="color: #f09e23;">=</span>
          <span v-if="this.Account.Asset == 0" class="amount" style="font-size: 45px; font-weight: bold; color: #f09e23;">0.00</span>
          <span v-else-if="this.Account.Asset == null" class="amount" style="font-size: 45px; font-weight: bold; color: #f09e23;">0.00</span>
          <span v-else class="amount" style="font-size: 45px; font-weight: bold; color: #f09e23;">{{ Account.Asset }}</span>
          <v-row>
            <v-col cols="12" sm="6">
              <v-btn block color="success" class="ml-2" style="border-radius:10px" @click="GotoRecharge()">
                DEPOSIT
              </v-btn>
            </v-col>
  
            <v-col cols="12" sm="6">
              <v-btn block color="primary" class="mr-3 pr-3" style="border-radius:10px" @click="GotoWithdrawal()">
                WITHDRAW
              </v-btn>
            </v-col>
          </v-row>
        </v-card>
        <br>
        <v-card flat class="user-id">
          <v-simple-table>
            <tbody>
              <tr @click="GotoRechargeHistory" >
                <td>Recharge Record</td>
              </tr>
              <tr>
                <td>Withdrawal Record</td>
              </tr>
              <tr>
                <td>SGR Invite</td>
              </tr>
            </tbody>
          </v-simple-table>
          </v-card >
          <br>
          <v-card flat class="user-id"> 
            <v-simple-table>
              <tbody>
                <tr>
                  <td @click="BankCard()">Bank Card</td>
                </tr>
              </tbody>
            </v-simple-table>
          </v-card>
          
          <br>
          <v-card flat class="user-id">
            <v-simple-table>
              <tbody>
                <tr>
                  <td>My Promotion History</td>
                </tr>
                <tr>
                  <td>Complaint Suggestion</td>
                </tr>
                <tr>
                  
                  <td>  
                    <v-form id="logOut" method="POST" action="logout" >
                    <input type="hidden" name="_token" :value="csrf">
                    <input type="submit" value="Logout" depressed class="amount" >
                 </v-form>
                </td>
                </tr>
              </tbody>
            </v-simple-table>
          </v-card>
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
      </div>
  </v-container>
</template>

<script>
// import { getTradeOrder } from '../tradeOrderService';
import moment from "moment";
import Swal from "sweetalert2";
export default {
  sockets: {
        // NOTE : SOCKET 
        updateReceived: function(socket) {
            console.log(socket)
            if( socket.updateType && socket.updateType == 'ConfirmRecharge'){
                console.log('getData')
                  this.GetUser()
            }
        }
    },

  data:()=>({
    Account : [],
    csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
  }),

  created(){
     
      //  this.GetUserMain()
      this.getTradeOrder()
       this.GetUser()
      
       
      //  const loggedInUserId = this.loggedInUser.id
      //  getTradeOrder(loggedInUserId);
       
    },
    

    methods:{

      GetUser(){
        axios.get(`/api/AccountInfo`).then((res) => {
          for(let i = 0; i < res.data.length; i++){
            if(this.loggedInUser.id == res.data[i].id){
              this.Account = res.data[i];
              console.log('gethere',this.Account)
            }
          }
          });
        // let interval = setInterval(() => { 
        //   console.log('interval',this.ASSET !=  this.Account.Asset)
        //   if(this.ASSET !=  this.Account.Asset){
        //     clearInterval(interval);
        //   }else{
        //     axios.get(`/api/AccountInfo`).then((res) => {
        //   for(let i = 0; i < res.data.length; i++){
        //     if(this.loggedInUser.id == res.data[i].id){
        //       this.Account = res.data[i];
        //     }
        //   }
        //   });
        //   }
        // }, 5000);
      },

    //   GetUserMain(){
    //     axios.get(`/api/AccountInfo`).then((res) => {
    //       for(let i = 0; i < res.data.length; i++){
    //         if(this.loggedInUser.id == res.data[i].id){
    //           this.Account = res.data[i]
    //           this.$store.commit("STORE_ASSET", this.Account.Asset);
    //         }
    //       }
    //     });
    // },
    GotoRecharge(){
      this.$router.push("/DepositView");
      location.reload();
    },
    GotoWithdrawal(){
      this.$router.push("/Withdrawal");
      location.reload();
    },
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

    BankCard(){
      this.$router.push('/BankCard')
      location.reload();
    },
    GotoRechargeHistory(){
      this.$router.push("/RechargeHistory");
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
    },
}
</script>

<style scoped>

.bg{
  background: url(https://cryptobtc01.com/assets/images/userbg.f932ed4.png) no-repeat center/cover;
  height: 500px;
  background-color: #f5f5f5;
  border-radius: 10px;
}
.user-id{
  color: #676767;
  font-family: -apple-system,BlinkMacSystemFont,PingFang SC,Helvetica Neue,STHeiti,Microsoft Yahei,Tahoma,Simsun,sans-serif;
}
.user-id1{
  color: #eb2424;
  font-family: -apple-system,BlinkMacSystemFont,PingFang SC,Helvetica Neue,STHeiti,Microsoft Yahei,Tahoma,Simsun,sans-serif;
}
p {
  display: block;
  margin-block-start: 1em;
  margin-block-end: 1em;
  margin-inline-start: 0px;
  margin-inline-end: 0px;
  font-family: -apple-system,BlinkMacSystemFont,PingFang SC,Helvetica Neue,STHeiti,Microsoft Yahei,Tahoma,Simsun,sans-serif;
}

.amount{
  font-family: -apple-system,BlinkMacSystemFont,PingFang SC,Helvetica Neue,STHeiti,Microsoft Yahei,Tahoma,Simsun,sans-serif;
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

.user-info {
  text-align: center;
  margin-bottom: 20px;
}

.asset-center {
  text-align: center;
  margin-bottom: 20px;
}

.amount {
  font-size: 45px;
  font-weight: bold;
  color: #f09e23;
}

.asset-buttons {
  display: flex;
  justify-content: center;
  margin-top: 20px;
}

.user-actions {
  margin-bottom: 20px;
}

.user-actions td {
  cursor: pointer;
}

.footer {
  margin-top: 20px;
}

/* Responsive Styles */

@media (max-width: 376px) {
  .bg {
    padding: 10px;
  }
  
  .amount {
    font-size: 30px;
  }
}

@media (min-width: 377px) and (max-width: 600px) {
  .bg {
    padding: 15px;
  }
  
  .amount {
    font-size: 35px;
  }
}

@media (min-width: 601px) and (max-width: 1024px) {
  .bg {
   width: 100%;
  }
}

@media (min-width: 1025px) and (max-width: 1280px) {
  .bg {
    margin: auto;
    width: 80%;
  }
}

@media (min-width: 1281px) and (max-width: 1920px) {
  .bg {
    margin: auto;
    width: 80%;
  }
}

@media (min-width: 1921px) and (max-width: 2560px) {
  .bg {
    margin: auto;
    width: 70%;
    
  }
}

@media (min-width: 2561px) {
  .bg {
    margin: auto;
    width: 60%;

  }
}
</style>