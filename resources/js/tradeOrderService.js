const axios = require('axios');
const moment = require('moment');
const Swal = require('sweetalert2');


function getTradeOrder(loggedInUserId) {

    console.log('id',loggedInUserId)
  let interval = setInterval(() => {
    // if(this.functionName != 'Transaction'){
    //   clearInterval(interval)
    // }
    axios.get(`api/TradeOrders/${loggedInUserId}`)
      .then((res) => {
        const gettradeorders = res.data;
        // console.log('getter',gettradeorders[0].trading == 'closed');
        if (gettradeorders && gettradeorders.length > 0) {
            console.log('getter', gettradeorders[0].trading);
          if (gettradeorders[0].trading === 'closed') {
              clearInterval(interval);
            }
          }
        gettradeorders.forEach((item, index) => {
          const daycut = moment().format("YYYY-MM-DD HH:mm:ss");
          const string = daycut;
          const targetMoment1 = moment(`${string}`);
          const targetMoment2 = moment(`${item.closing_time}`);
          const diffInSeconds = targetMoment2.diff(targetMoment1, "seconds");

          item.counting = diffInSeconds + 1;

          if (item.counting === 0) {
            console.log('1');
            clearInterval(interval);
            updateTradingValue(item);
            // updateTradingValue.call(this, item);
          } else if (item.counting <= 0 && item.trading === 'pending') {
            console.log('2');
            clearInterval(interval);
            updateTradingValue(item);
            // updateTradingValue.call(this, item);
          }
          item.counting--;
        });
      })
      .catch((error) => {
        console.error(error);
      });
  }, 2000);
}

function updateTradingValue(item) {
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
  console.log('item', item);
  item.result = parseFloat(item.quantity) + parseFloat(item.profit);
  console.log('item dto sa order', item);
  axios.post(`api/calculateCount`, item)
    .then((res) => {
      axios.post(`api/adminprocess`, item)
        .then((res) => {
          setTimeout(() => {
            getTradeOrder();
            // getTradeOrder.call(this); // Ensure correct 'this' context
            toastMixin.fire({
              icon: 'success',
              title : 'Your Bet is Susscessful Done!',
              animation:true,
              text: 'Successfully Done',
          })
          // $socket.emit('newUpdate', { updateType: "GetTrade" });
          // $socket.emit('newUpdate', { updateType: "ProcessBet" });
          // $socket.emit('newUpdate', { updateType: "ConfirmRecharge" });
          }, 2000);
        })
        .catch((error) => {
          console.error(error);
        });
    })
    .catch((error) => {
      console.error(error);
    });
}



module.exports = {
  getTradeOrder,

};
// const fs = require('fs');
// const https = require('https');
// var options = {
//   key: fs.readFileSync('/etc/httpd/conf/iconn.key'),
//   cert: fs.readFileSync('/etc/httpd/conf/iconn.crt')
// };


// const axios = require('axios');
// const moment = require('moment');
// const Swal = require('sweetalert2');
// const server = https.createServer( options );
// const io = require('socket.io').listen(server, socket); // Import socket.io-client if not already imported

// const socket = io('https://iconntest.hrd-s.com/'); // Replace with your socket.io server URL

// function getTradeOrder(loggedInUserId) {
//   console.log('id', loggedInUserId);
//   let interval = setInterval(() => {
//     axios.get(`api/TradeOrders/${loggedInUserId}`)
//       .then((res) => {
//         const gettradeorders = res.data;
//         if (gettradeorders && gettradeorders.length > 0) {
//           console.log('getter', gettradeorders[0].trading);
//           if (gettradeorders[0].trading === 'closed') {
//             clearInterval(interval);
//           }
//           gettradeorders.forEach((item, index) => {
//             const daycut = moment().format("YYYY-MM-DD HH:mm:ss");
//             const string = daycut;
//             const targetMoment1 = moment(`${string}`);
//             const targetMoment2 = moment(`${item.closing_time}`);
//             const diffInSeconds = targetMoment2.diff(targetMoment1, "seconds");

//             item.counting = diffInSeconds + 1;

//             if (item.counting === 0) {
//               console.log('1');
//               clearInterval(interval);
//               updateTradingValue(item);
//             } else if (item.counting <= 0 && item.trading === 'pending') {
//               console.log('2');
//               clearInterval(interval);
//               updateTradingValue(item);
//             }
//             item.counting--;
//           });
//         }
//       })
//       .catch((error) => {
//         console.error(error);
//       });
//   }, 2000);
// }

// function updateTradingValue(item) {
//   var toastMixin = Swal.mixin({
//     toast: true,
//     icon: 'success',
//     title: 'General Title',
//     animation: false,
//     position: 'top-right',
//     showConfirmButton: false,
//     timer: 1500,
//     timerProgressBar: true,
//     dibOpen: (toast) => {
//       toast.addEventListener('mouseenter', Swal.stopTimer);
//       toast.addEventListener('mouseleave', Swal.resumeTimer);
//     }
//   });
//   console.log('item', item);
//   item.result = parseFloat(item.quantity) + parseFloat(item.profit);
//   console.log('item dto sa order', item);
//   axios.post(`api/calculateCount`, item)
//     .then((res) => {
//       axios.post(`api/adminprocess`, item)
//         .then((res) => {
//           setTimeout(() => {
//             getTradeOrder(); // Ensure correct 'this' context
//             toastMixin.fire({
//               icon: 'success',
//               title: 'Your Bet is Successful!',
//               animation: true,
//               text: 'Successfully Done',
//             });
//             socket.emit('newUpdate', { updateType: "GetTrade" });
//             socket.emit('newUpdate', { updateType: "ProcessBet" });
//             socket.emit('newUpdate', { updateType: "ConfirmRecharge" });
//           }, 2000);
//         })
//         .catch((error) => {
//           console.error(error);
//         });
//     })
//     .catch((error) => {
//       console.error(error);
//     });
// }

// module.exports = {
//   getTradeOrder
// };
