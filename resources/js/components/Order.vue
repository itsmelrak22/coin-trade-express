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
                                            item.direction == 'sell'
                                                ? 'font-weight:bold;color: #B31312'
                                                : 'font-weight:bold;color:#609966 '
                                        "
                                        >{{
                                            item.direction == "sell"
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
          
                                    </v-col
                                >
                            </v-row>
                            <v-row>
                            <v-col><span>{{item.contract}}</span><br/></v-col>
                            <v-col><span>Amount</span><br/></v-col>
                            <v-col><span>Close Price </span><br/></v-col>
                        
                            </v-row>
                    
                            <v-row>
                            <v-col>BTC/USDT</v-col>
                            <v-col>{{item.quantity}}.000000</v-col>
                            <v-col>{{item.closing_price}} </v-col>
                            </v-row>
                            <v-row>
                            <v-col><span>time</span><br/></v-col>
                            <v-col><span>P/L[BTC]</span><br/></v-col>
                            <v-col><span>status </span><br/></v-col>
                        
                            </v-row>
                    
                            <v-row>
                            <v-col>{{item.seconds}}Sec</v-col>
                            <v-col>{{item.profit}}</v-col>
                            <v-col>{{item.trading}}</v-col>
                            </v-row>
                            <v-row>
                           
                            <v-col class="text-right">{{item.counting <= 0 ? 'closed':item.counting}}</v-col>
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


export default {
    data: () => ({
        gettradeorders: [
        ],
        obj:{},
        functionName:'Transaction',
    }),

    created() {
        // this.getTradeOrder(); 
   
this.getTradeOrder(); 

    },
    computed: {},

    methods: {
        getTradeOrder() {
        let interval= setInterval(() => {
            if(this.functionName != 'Transaction'){
                clearInterval(interval)
            }
                axios.get(`http://127.0.0.1:8000/api/TradeOrders`).then((res) => {
                this.gettradeorders = res.data
    


    this.gettradeorders.forEach((item,index) => {
        let daycut = moment().format("YYYY-MM-DD HH:mm:ss");
        let string = daycut;
        let targetMoment1 = moment(`${string}`);
        let targetMoment2 = moment(`${item.closing_time}`);

        let diffInSeconds = targetMoment2.diff(targetMoment1, "seconds");

        item.counting = diffInSeconds +1;

        // let interval = setInterval(() => {

        if ( item.counting == 0) {
        alert('1')
            clearInterval(interval);
            this.updateTradingValue(item);

        }else if(item.counting <= 0 && item.trading === 'pending'){
            alert('2')
            clearInterval(interval);

            this.updateTradingValue(item);

        }
        item.counting--;
    
    })


    });
        },2000 );
            },
            updateTradingValue(item) {
            
                item.result = parseFloat(item.quantity) + parseFloat(item.profit);
                console.log('item dto sa order',item)
                axios.post(`http://127.0.0.1:8000/api/calculateCount`, item)
                    .then((response) => {
                        this.getTradeOrder(); 
                        //admin win or loost bawas o dagdag ng pera

                axios.post(`http://127.0.0.1:8000/api/adminprocess`,item).then((res)=>{
                    alert('success')
                })

                    })
                    .catch((error) => {
                    console.error(error);
                    });
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
