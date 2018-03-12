// export default {
//     endpoint () {
//         return {
//             api_default: 'https://mundo-ds.herokuapp.com'
//         }
//     }
// }

import axios from 'axios'
export default axios.create({
  baseURL: 'https://mundo-ds.herokuapp.com'
})