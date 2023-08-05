import axios from "axios";
import Cookies from "js-cookie";
export default defineNuxtPlugin((nuxtApp) => {
    let api = axios.create({

        baseURL: `${useRuntimeConfig().public.API_URL}`,

        headers: {
            common: {
                Authorization: `Bearer ${Cookies.get('token')} `,
                'XSRF-TOKEN':Cookies.get('XSRF-TOKEN'),
                // 'laravel_session':Cookies.get('laravel_session')
            },
        },
        withCredentials:true
    });
    api.interceptors.response.use((response)=>{
        
        return response;
    },(error)=>{

        // destructoring
        const {response} = error;

        // user not authorize (token dosent exist)

        // 419 unknown status
        // 401 unothorized
        if(response.status==401 || response.status==419)
        {
            useNuxtApp().$cookie.remove('token')
            userStore().logout();
            return navigateTo('/auth/login')
        }

        throw error;
    })

    return {
        provide: {
            api: api,
        },
    };

});
