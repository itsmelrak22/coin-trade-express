<template>
    <v-container>
        <div>
            <v-simple-table>
                <thead>
                    <tr>
                        <th>Serial No.</th>
                        <th>Order Number</th>
                        <th>User ID</th>
                        <th>User Account</th>
                        <th>Type</th>
                        <th>Ammount Deposit</th>
                        <th>Deposit Screenshot</th>
                        <th>State</th>
                        <th>Payment Methods</th>
                        <th>Purchase Time</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(item , i) in deposit" :key="i">
                        <td>{{  item.id }}</td>
                        <td>{{  item.OrderNumber }}</td>
                        <td>{{  item.UserID }}</td>
                        <td>{{  item.UserAccount }}</td>
                        <td>{{  item.Type }}</td>
                        <td>{{  item.Amount }}</td>
                        <td></td>
                        <td>{{  item.State }}</td>
                        <td>{{  item.Methods }}</td>
                        <td>{{  item.created_at.slice(0,10) }}</td>
                        <td v-if="item.State == 'Process Completed' || item.State == 'Cancelled Order Admin' || item.State == 'Cancelled Order Client' || item.State == 'Paid'">
                          
                        </td>
                        <td v-else>
                            <v-btn  x-small @click="ConfirmPayment(item)"> 
                                Cofirm Payment
                            </v-btn>
                            <v-btn @click="cancelorder(item)" x-small>
                                Cancel Payment
                            </v-btn>
                        </td>
                    </tr>
                </tbody>
            </v-simple-table>
        </div>
    </v-container>
</template>

<script>

import axios from "axios";
export default {
    data:()=>({
        
    }),

    created(){
       
    },

    methods:{

    },
    
}
</script>

<style>

</style>