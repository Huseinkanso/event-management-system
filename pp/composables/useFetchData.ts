import Cookie from "js-cookie";
export const useFetchData=(url:string,me:String)=>{
    const baseUrl='http://localhost/api/'
    return useAsyncData(
        ()=> $fetch(url,
            {baseURL:baseUrl,
                headers:{
                    'XSRF-TOKEN':Cookie.get('XSRF-TOKEN'),
                    'laravel_session':Cookie.get('laravel_session'),
                    Authorization: `Bearer ${Cookie.get('token')} `,
                },
                method:me
            }
            )
        )
}