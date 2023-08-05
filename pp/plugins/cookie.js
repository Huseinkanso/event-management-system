import Cookies from "js-cookie";

export default defineNuxtPlugin(()=>{
    return {
        provide:{
            cookie: Cookies
        }
    }
})