<template>
    <div class="grid-container" fluid>
        <v-list dense>
            <h3>Order</h3>
            <v-row>
                <v-col>
                    <v-list-item-title class="text-right"
                        ><v-btn style="font-weight: bold; font-size: 12px" text @click="functionName = 'Transaction'"
                            >Transaction</v-btn
                        ></v-list-item-title
                    ></v-col
                >
                <v-col>
                    <v-list-item-title 
                        ><v-btn style="font-weight: bold; font-size: 12px" text  @click="functionName = 'Closed'"
                            >Closed</v-btn
                        ></v-list-item-title
                    ></v-col
                >
            </v-row>
            <v-list-item
                v-for="(item, i) in functionName == 'Transaction'?gettradeorders.filter((r)=>{return r.trading != 'closed'}):gettradeorders.filter((r)=>{return r.trading == 'closed'})"
                :key="i"
                :to="item.to"
            >
                <v-list-item-content>
                    <v-card>
                        <v-card-text>
                            <v-row>
                                <v-col
                                    ><span
                                        :style="
                                            item.type == 'sell'
                                                ? 'font-weight:bold;color: #B31312'
                                                : 'font-weight:bold;color:#609966 '
                                        "
                                        >{{
                                            item.type == "sell"
                                                ? "Down"
                                                : "Up"
                                        }}</span
                                    ><span style="font-size:11px"
                                    
                                        >{{
                                            item.order_time
                                        }}</span
                                    >
                                    <span style="font-size:11px"
                                    
                                        >Close Time {{ 
                                            item.closing_time
                                        }}</span
                                        
                                    >
                                    </v-col>
                            </v-row>
                            <v-row no-gutters>
                            <v-col no-gutters class="text-center"><span><b>{{item.contract}}</b></span><br/></v-col>
                            <v-col no-gutters class="text-center"><span><b>Amount</b> </span><br/></v-col>
                            <v-col no-gutters class="text-center"><span><b>Close Price</b>  </span><br/></v-col>
                            <v-col no-gutters class="text-center"><br/></v-col>
                        
                            </v-row>
                    
                            <v-row>
                            <v-col no-gutters class="text-center">{{item.contract}}</v-col>
                            <v-col no-gutters class="text-center">{{item.quantity}}.000000</v-col>
                            <v-col no-gutters class="text-center">{{item.closing_price}} </v-col>
                            <v-col no-gutters class="text-center"></v-col>
                            </v-row>
                            <v-row>
                            <v-col no-gutters class="text-center"><span><b>time</b> </span><br/></v-col>
                            <v-col no-gutters class="text-center"><span><b>P/L[BTC]</b> </span><br/></v-col>
                            <v-col no-gutters class="text-center"><span><b>Status</b>  </span><br/></v-col>
                            <v-col no-gutters class="text-center"><span><b>Preset</b>  </span><br/></v-col>
                        
                            </v-row>
                    
                            <v-row no-gutters>
                            <v-col no-gutters class="text-center">{{item.seconds}}Sec</v-col>
                            <v-col no-gutters class="text-center">{{item.profit}}</v-col>
                            <v-col no-gutters class="text-center">{{item.trading}}</v-col>
                            <v-col class="text-center"><span
                                :style="
                                    item.preset == 'Lose'   ? 'font-weight:bold;color: #B31312'  : 'font-weight:bold;color:#609966 '
                                "
                                >{{item.preset}}</span
                            ></v-col>
                            </v-row>
                            <v-row>
                                
                            <v-col  class="text-right">{{item.counting <= 0 ? 'closed':item.counting}}</v-col>
                            </v-row>
                        </v-card-text>
                    </v-card>
                </v-list-item-content>
            </v-list-item>
        </v-list>

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


</template>

<script>
import axios from "axios";
import moment from "moment";
import Swal from "sweetalert2";


export default {
  
    sockets: {
        // NOTE : SOCKET 
        updateReceived: function(socket) {
            console.log(socket)
            if( socket.updateType && socket.updateType == 'ProcessBet'){
                console.log('getData')
                this.getTradeOrder();
            }
        }
    },
    data: () => ({
        gettradeorders: [
        ],
        obj:{},
        functionName:'Transaction',
    }),

    created() {
        this.getTradeOrder(); 
    },
    computed: {},

    
    methods: {

        getTradeOrder() {
        let interval= setInterval(() => {
            if(this.functionName != 'Transaction'){
                clearInterval(interval)
            }
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
                        this.getTradeOrder();
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
                this.getTradeOrder(); 
                    })
                    .catch((error) => {
                    console.error(error);
                    });
            },
        // getTradeOrder() {
        // let interval= setInterval(() => {
        //     if(this.functionName != 'Transaction'){
        //         clearInterval(interval)
        //     }
        //     axios.get(`api/TradeOrders/${this.loggedInUser.id}`).then((res) => {
        //                     this.gettradeorders = res.data
                        
        //                     if(this.gettradeorders[0].trading == 'closed'){
        //                         clearInterval(interval)
        //                     }
        //                     console.log('sa order',this.gettradeorders)
        //                         this.gettradeorders.forEach((item,index) => {
        //                             let daycut = moment().format("YYYY-MM-DD HH:mm:ss");
        //                             let string = daycut;
        //                             let targetMoment1 = moment(`${string}`);
        //                             let targetMoment2 = moment(`${item.closing_time}`);
        //                             let diffInSeconds = targetMoment2.diff(targetMoment1, "seconds");
                                    
        //                             item.counting = diffInSeconds +1;
        //                             // console.log(item.counting)
                                    
        //                             // let interval = setInterval(() => {
        //                             if ( item.counting == 0) {
        //                                 console.log('1')
        //                                 clearInterval(interval);
        //                                 this.updateTradingValue(item);
        //                             }else if(item.counting <= 0 && item.trading === 'pending'){
        //                                 console.log('2')
        //                                 clearInterval(interval);
        //                                 this.updateTradingValue(item);
        //                             }
        //                             item.counting--;
        //                     })
        //     });
        // },2000 );
        //     },
        //     updateTradingValue(item) {
        //         var toastMixin = Swal.mixin({
        //         toast: true,
        //         icon: 'success',
        //         title: 'General Title',
        //         animation : false,
        //         position: 'top-right',
        //         showConfirmButton: false,
        //         timer: 1500,
        //         timerProgressBar : true,
        //         dibOpen : (toast) => {
        //         toast.addEventListener('mouseenter', Swal.stopTimer)
        //         toast.addEventListener('mouseleave', Swal.resumeTimer)
        //         }
        //     })
        //         console.log('item',item)
        //         item.result = parseFloat(item.quantity) + parseFloat(item.profit);
        //         console.log('item dto sa order',item)
        //         axios.post(`api/calculateCount`, item).then((res) => {
        //                 //admin win or loost bawas o dagdag ng pera
        //         axios.post(`api/adminprocess`,item).then((res)=>{
        //             setTimeout(() => {
        //                 // this.getTradeOrder();
        //                 toastMixin.fire({
        //                 icon: 'success',
        //                 title : 'Your Bet is Susscessful Done!',
        //                 animation:true,
        //                 text: 'Successfully Done',
        //             })
        //             this.$socket.emit('newUpdate', { updateType: "GetTrade" })
        //             this.$socket.emit('newUpdate', { updateType: "ProcessBet" })
        //             this.$socket.emit('newUpdate', { updateType: "ConfirmRecharge" })
        //             }, 2000);
        //         })
        //         // this.getTradeOrder(); 
        //             })
        //             .catch((error) => {
        //             console.error(error);
        //             });
        //     },
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
    },
};
</script>

<style scoped>
table {
    border-collapse: collapse;
}

th {
    background-color: primary;

    height: 100%;
    width: 100%;
    margin: 0;
    padding: 0;
}

td {
    white-space: nowrap;
    margin-left: 1%;
    text-align: center;
    height: 100%;
    width: 100%;

    text-align: center;
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
