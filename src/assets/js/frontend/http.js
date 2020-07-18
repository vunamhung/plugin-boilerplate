import axios from "axios";

export default axios.create({ baseURL: apiUrl, headers: { "X-WC-Store-API-Nonce": wcStoreApiNonce } });
