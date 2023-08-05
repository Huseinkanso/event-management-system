import type {UseFetchOptions} from 'nuxt/app'
import {useRequestHeaders} from "nuxt/app";
import { useCookie,useFetch } from 'nuxt/app';
export  function useApiFetch<T>(path: string, options: UseFetchOptions<T> = {}) {
  let headers: any = {}

  const token = useCookie('XSRF-TOKEN');

  if (token.value) {
    headers['X-XSRF-TOKEN'] = token.value as string;
  }

  // on full page reload usefetch run on the server
  // here run without the headers so we need to add them when it is on server
  if (process.server) {
    headers = {
      ...headers,
      ...useRequestHeaders(["referer", "cookie"])
    }
  }

  return useFetch("http://localhost:8000" + path, {
    credentials: "include",
    watch: false,
    ...options,
    headers: {
      ...headers,
      ...options?.headers
    }
  });
}

// this will let browser store token
// credentials: "include",
