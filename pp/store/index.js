
// import { createPinia } from 'pinia'
// import piniaPluginPersistedstate from 'pinia-plugin-persistedstate'

// const pinia = createPinia()
// pinia.use(piniaPluginPersistedstate)
// import defineStore from "@pinia/nuxt";
export const userStore = defineStore('user', () => {
    const loggedIn = ref(false);
    const user = ref();
    const notification=ref('');
    const isLoading=ref(false);
    function setNotification(data) {
        notification.value=data;
    }
    function setLoggedId() {
        loggedIn.value=true;
    }
     function setUser(data)
    {
        user.value=data;
        loggedIn.value=true;
    }
    function logout() {
        loggedIn.value=false;
        user.value=undefined;
    }
    return { loggedIn,setLoggedId,logout,user,notification,setNotification,setUser,isLoading}
},{persist:{
    // storage:persistedState.cookiesWithOptions({expires:new Date(new Date().setDate(new Date().getDate() + 30))}),
    storage:persistedState.cookies
}
})




//   setup
// in setup i can use composable also
// ref become state
// computed become getter
// function become action

// export const useStore = defineStore('user', () => {
//     const count = ref(0)
//     const name = ref('Eduardo')
//     const doubleCount = computed(() => count.value * 2)
//     function increment() {
//         count.value++
//     }

//     return { count, name, doubleCount, increment }
//   })

// user-> has comment
// event->has comments
// comments ->belongs to user
// comments => belongs to event
// comment => has replies
// reply -> belongs to comment
/**
 * 1- to use store we have options::// in this config there is auto import so no need to import
 *  a-  const store=useStore();
 *  ** store.count  store.increment()
 *  // if we distructor it will lose reactivity so to destructor we do this by using storeToRefs
 *  b- const store=useStore();
 *      ** const { name, doubleCount } = storeToRefs(store)
 *      count   increment()
 *  c- also we can useStore().count or useStore().increment
 *
 *
 */













//   export const useCounterStore = defineStore('counter', {
//     state: () => ({ count: 0, name: 'Eduardo' }),
//     getters: {
//       doubleCount: (state) => state.count * 2,
//     },
//     actions: {
//       increment() {
//         this.count++
//       },
//     },
//   })