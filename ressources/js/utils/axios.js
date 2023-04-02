import axios from "axios";

const config = {
    headers : {'X-Requested-With': 'XMLHttpRequest', 'Access-Control-Allow-Origin' : '*'}
}

export async function get (url, datas = {}) {
    if(Object.keys(datas).length !== 0) config.params = datas;

    const res = await axios.get(url, config).catch( ({ response }) => response);

    delete config.params;
    return res;
}

// export async function post (url, data) {
//     const hotel2for1_url = getSecureElement('meta[name="hotel2for1"]').content;
//     return await axios.post(hotel2for1_url + url, data, config).catch( ({ response }) => response);
// }

// export async function quickGet (url) {
//     return await axios.get(url, config).catch( ({ response }) => { insertError(response.data.message); return response; });
// }
//
// export async function quickPost (url, data) {
//     return await axios.post(url, data, config).catch( ({ response }) => {
//         if( response.status === 422) { flashLaravelErrors(response.data.errors); }
//         if( response.status !== 422) { insertError(response.data.message);  }
//
//         return response
//     });
// }
