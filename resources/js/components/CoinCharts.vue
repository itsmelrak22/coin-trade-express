<template>
    <div class="info-card" style="max-height: 500px!mportant;">
        <div class="row">
            <div class="col-12  align-items-center">
                <div class="row chart-bar">
                    <div class="chart-type">
                        <button class="btn btn-primary btn-sm mr-2" :class="[{'active': chartType==='cs'}]" @click="toCandleStickChart">Candlestick Chart</button>
                        <button class="btn btn-primary btn-sm" :class="[{'active': chartType==='lc'}]" @click="toLineChart">Line Chart</button>
                    </div>
                </div>
            </div>
            <div class="chart-panel col" ref="chartdiv" id="chartdiv" style="max-height: 400px!important;">

            </div>
            <div class="col-12 p-2 text-right">
                <button class="btn btn-primary btn-sm mr-2" :class="[{'active': interval==='1h'}]" @click="updateTimeInterval('1h')">1H</button>
                <button class="btn btn-primary btn-sm mr-2" :class="[{'active': interval==='1d'}]" @click="updateTimeInterval('1d')">1D</button>
                <button class="btn btn-primary btn-sm mr-2" :class="[{'active': interval==='1w'}]" @click="updateTimeInterval('1w')">1W</button>
                <button class="btn btn-primary btn-sm mr-2" :class="[{'active': interval==='1M'}]" @click="updateTimeInterval('1M')">1M</button>
            </div>
        </div>
        <v-overlay :value="overlay">
          <v-progress-circular
          color="white"
          indeterminate
          :size="150"
          ></v-progress-circular>
      </v-overlay>
        <!-- <div class="spinner" v-if="chartLoading">
            <div class="circle-spinner"></div>
        </div> -->
    </div>
</template>
<script>
  import 'amcharts3/amcharts/amcharts'
  // eslint-disable-next-line
  import 'amcharts3/amcharts/serial'
  // eslint-disable-next-line
  import 'amstock3/amcharts/amstock'

  const proxyUrl = 'https://proxy.mysoftnotes.com/proxy.php?curl=';

  export default {
    name: 'coin-charts',
    data:() => ({
      
      interval:'1d',
        chartData: [],
        chart: null,
        // chartLoading: true,
        chartType: 'cs',
        overlay: false,
       

      
    }),
    mounted() {
      console.log('here', this.toTrading)
      this.fetchChartData();
      console.log('symbol',this.toTrading.symbol)
      console.log(this.toTrading.interval)
      // console.log('chartData',this.chartData)
    },
    beforeDestroy() {
      if(this.chart) {
        this.chart.clear();
        this.chart = null;
        this.chartData = [];
      }
    },
    methods: {
    zoomChart() {

        if(this.chartData.length > 50){
          this.chart.scrollbarChart.zoomToIndexes(this.chartData.length - 40, this.chartData.length - 1);
        }

      },
      fetchChartData(isUpdate = false) {
        this.overlay = true
        //proxyuUrl is done to avoid cross-origin error as it is directly called from javascript.
        // const apiurl = encodeURIComponent(`https://api.binance.com/api/v1/klines?symbol=${this.toTrading.symbol}&interval=${this.toTrading.interval}`);
        fetch(`https://api.binance.com/api/v1/klines?symbol=${this.toTrading.symbol}&interval=${this.toTrading.interval}`).then(
          
          function (response) {
            if (response.status !== 200) {
              console.log('Looks like there was a problem. Status Code: ' + response.status);
              return;
            }
            // console.log('res',response)
            response.json().then(function (data) {
              // console.log('data',data)
              this.chartData = data.map((val) => {
                return {
                  "date": new Date(val[0]),
                  "open": parseFloat(val[1]),
                  "high": parseFloat(val[2]),
                  "low": parseFloat(val[3]),
                  "close": parseFloat(val[4]),
                  "volume": parseFloat(val[5]),
                  "value": parseFloat(val[4])
                }
              })
              if (isUpdate) {
                this.chart.dataSets[0].dataProvider = this.chartData;
                this.chart.validateData()
              }
              else {
                this.showChart();
              }
              this.overlay = false
              this.zoomChart();
            }.bind(this));
          }.bind(this)
        ).catch(function (err) {
          this.overlay = false
          console.log('Fetch Error :-S', err);
        });
      },
      updateTimeInterval(ti) {
        this.interval = ti;
        this.fetchChartData(true)
      },
      toCandleStickChart() {
        this.chartType = 'cs';
        const dataSet = this.chart.dataSets[0];
        const panel = this.chart.panels[0];
        dataSet.fieldMappings = [];
        dataSet.fieldMappings.push({
          fromField: "close",
          toField: "close",
        });
        dataSet.fieldMappings.push({
          fromField: "open",
          toField: "open"
        });
        dataSet.fieldMappings.push({
          fromField: "high",
          toField: "high"
        });
        dataSet.fieldMappings.push({
          fromField: "low",
          toField: "low"
        });
        dataSet.fieldMappings.push({
          fromField: "volume",
          toField: "volume"
        });
        dataSet.fieldMappings.push({
          fromField: "value",
          toField: "value"
        });
        panel.stockGraphs[0] = {
          id: "g1",
          type: "candlestick",
          balloonText: "Open:<b>[[open]]</b><br>Low:<b>[[low]]</b><br>High:<b>[[high]]</b><br>Close:<b>[[close]]</b>",
          closeField: "close",
          fillColors: "#00a928",
          highField: "high",
          lineColor: "#00a928",
          lineAlpha: 1,
          lowField: "low",
          fillAlphas: 1,
          negativeFillColors: "#db4c3c",
          negativeLineColor: "#db4c3c",
          openField: "open",
          valueField: "value",
          proCandlesticks: false,
          useDataSetColors: false
        };
        panel.stockLegend.valueTextRegular = "[[close]] ";
        this.chart.validateNow()
      },
      toLineChart() {
        this.chartType = 'lc';
        const dataSet = this.chart.dataSets[0];
        const panel = this.chart.panels[0];
        dataSet.fieldMappings = [];
        dataSet.fieldMappings.push({
          fromField: "value",
          toField: "value",
        });
        dataSet.fieldMappings.push({
          fromField: "volume",
          toField: "volume"
        });
        panel.stockGraphs[0] = {
          id: "g1",
          type: "line",
          valueField: "value",
          lineThickness: 1,
          useDataSetColors: false,
          lineColor: "#00a928",
          showBalloon: true,
          balloonText: "<b>[[value]]</b>"
        };
        panel.stockLegend.periodValueTextRegular = "[[value.close]] ";
        this.chart.validateNow()
      },
      showChart() {
        this.chart = window.AmCharts.makeChart("chartdiv", {
          "type": "stock",
          "theme": "light",
          "dataDateFormat": "YYYY-MM-DD HH",
          "mouseWheelZoomEnabled": true,
          "pathToImages": "http://cdn.amcharts.com/lib/3/images/",
          "categoryAxesSettings": {
            "minPeriod": "hh"
          },
          "dataSets": [{
            "fieldMappings": [{
              "fromField": "open",
              "toField": "open"
            }, {
              "fromField": "close",
              "toField": "close"
            }, {
              "fromField": "high",
              "toField": "high"
            }, {
              "fromField": "low",
              "toField": "low"
            }, {
              "fromField": "volume",
              "toField": "volume"
            }, {
              "fromField": "value",
              "toField": "value"
            }],
            "color": "#7f8da9",
            "dataProvider": this.chartData,
            "title": this.toTrading.symbol,
            "categoryField": "date"
          }],
          "panels": [
            {
              "title": "Price",
              "showCategoryAxis": true,
              "percentHeight": 70,
              "valueAxes": [{
                "id": "v1",
                "dashLength": 5
              }],

              "categoryAxis": {
                "dashLength": 5,
                "parseDates": true
              },

              "stockGraphs": [{
                "type": "candlestick",
                "id": "g1",
                "openField": "open",
                "closeField": "close",
                "highField": "high",
                "lowField": "low",
                "valueField": "close",
                "lineColor": "#00a928",
                "fillColors": "#00a928",
                "negativeLineColor": "#db4c3c",
                "negativeFillColors": "#db4c3c",
                "fillAlphas": 1,
                "useDataSetColors": false,
                "showBalloon": true,
                "useNegativeColorIfDown": false,
                "balloonText": "Open:<b>[[open]]</b><br>Low:<b>[[low]]</b><br>High:<b>[[high]]</b><br>Close:<b>[[close]]</b>",
              }],

              "stockLegend": {
                "valueTextRegular": undefined,
                "periodValueTextComparing": "[[percents.value.close]]%"
              }
            },
            {
              "title": "Volume",
              "percentHeight": 30,
              "marginTop": 1,
              "showCategoryAxis": true,
              "valueAxes": [{
                "dashLength": 5
              }],
              "categoryAxis": {
                "dashLength": 5
              },

              "stockGraphs": [{
                "valueField": "volume",
                "type": "column",
                "fillColors": '#7f8da9',
                "showBalloon": true,
                "fillAlphas": 1
              }],

              "stockLegend": {
                "markerType": "none",
                "markerSize": 0,
                "labelText": "",
                "periodValueTextRegular": "[[value.close]]"
              }
            }
          ],
          "chartScrollbarSettings": {
            "graph": "g1",
            "graphType": "line",
            "usePeriod": "DD"
          },
          "chartCursorSettings": {
            "valueBalloonsEnabled": true,
            "valueLineBalloonEnabled": true,
            "valueLineEnabled": true
          },
          "legendSettings": {
            "useMarkerColorForLabels": true
          }
        });
      }
    }
  }
</script>