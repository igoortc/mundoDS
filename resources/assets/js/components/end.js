// export default {
//     endpoint () {
//         return {
//             api_default: 'https://mundo-ds.herokuapp.com'
//         }
//     }
// }

var axios = require('axios');

var axiosInstance = axios.create({
  baseURL: 'https://mundo-ds.herokuapp.com',
});

module.exports = axiosInstance;