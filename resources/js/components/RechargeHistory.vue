<template>
  <v-container fluid>
    <div  class="grid-container">
      <v-list dense>
        <v-toolbar flat>
          <v-btn plain @click="GoBack">
            <v-icon>mdi-arrow-left</v-icon>
          </v-btn>
        </v-toolbar>
        <v-list-item v-for="(item, i) in RechargeHistory" :key="i">
            <v-list-item-content>
                <v-card >
                    <v-card-text>
                        <v-row>
                            <!-- <v-col>
                                <v-btn plain color="success" @click="Handle_Edit(item)"><v-icon>mdi-pencil</v-icon></v-btn>
                                <v-btn plain color="error" @click="Handle_Delete(item)"><v-icon>mdi-trash-can</v-icon></v-btn>
                                </v-col> -->
                        </v-row>
                        <v-row>
                            <v-col><span>
                              <v-chip v-if="item.State == 'Paid'" color="#12a36e" dark> {{item.State}}</v-chip>
                              <v-chip v-if="item.State == 'Cancelled Order Client'" color="#d72015" dark> {{item.State}}</v-chip>
                              <v-chip v-if="item.State == 'Cancelled Order Admin'" color="#d72015" dark> {{item.State}}</v-chip>
                              <v-chip v-if="item.State == 'Waiting for Payment'" color="#178bf6" dark> {{item.State}}</v-chip>
                              <v-chip v-if="item.State == 'PENDING'" color="orange" dark> {{item.State}}</v-chip>
                              
                            </span><br/></v-col>
                            <!-- <v-col><span>Bank Name</span><br/></v-col>
                            <v-col><span>Branch Branch</span><br/></v-col>
                            <v-col><span>Bank Account</span><br/></v-col> -->
                            <v-spacer></v-spacer>
                            <span>{{item.created_at}}</span>
                            </v-row>
                            <v-divider></v-divider>
                            <v-row>
                                <v-col><span>{{item.Amount}}.000000</span><br/></v-col>
                                <!-- <v-col><span>{{item.bankdeposit}}</span><br/></v-col>
                                <v-col><span>{{item.depositbranch}}</span><br/></v-col>
                                <v-col><span>{{item.bankaccount}} </span><br/></v-col> -->
                                <!-- <v-col><span>{{item.created_at}} </span><br/></v-col> -->
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
    </div>
  </v-container>
</template>

<script>
export default {
  data: () => ({
    RechargeHistory: [],
  }),

  created(){
    this.GetHistory()
  },

  methods:{
    GetHistory(){
      axios.get(`api/GetHistory/${this.loggedInUser.id}`).then((res)=>{
        this.RechargeHistory = res.data
      })
    },
    GoBack(){
      this.$router.push('/AccountInfo')
    }
  }
}
</script>

<style>

</style>