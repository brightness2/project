/*
 * @Author: Brightness
 * @Date: 2021-11-12 10:33:33
 * @LastEditors: Brightness
 * @LastEditTime: 2021-11-23 11:15:40
 * @Description:  
 */
import axios from 'axios'
import { MessageBox, Message } from 'element-ui'
import store from '@/store'
import { getToken } from '@/utils/auth'

// create an axios instance
const service = axios.create({
  baseURL: 'http://192.168.174.135/index.php/', // url = base url + request url
  // withCredentials: true, // send cookies when cross-domain requests
  timeout: 5000 // request timeout
})

// request interceptor
service.interceptors.request.use(
  config => {
    // do something before request is sent

    if (store.getters.token) {
      // let each request carry token
      // ['X-Token'] is a custom headers key
      // please modify it according to the actual situation
      config.headers['token'] = getToken()
    }
    return config
  },
  error => {
    // do something with request error
    console.log(error) // for debug
    return Promise.reject(error)
  }
)

// response interceptor
service.interceptors.response.use(
  /**
   * If you want to get http information such as headers or status
   * Please return  response => response
  */

  /**
   * Determine the request status by custom code
   * Here is just an example
   * You can also judge the status by HTTP Status Code
   */
  response => {
    const res = response.data

    // if the custom code is not 0, it is judged as an error.
  
    if(res.errCode != 0){
      res.msg&&Message({
            message: res.msg || '错误',
            type: 'error',
            duration: 5 * 1000
      });
      if (res.errCode === 403 || res.errCode === 500 || res.errCode === 50014) {
          // to re-login
          MessageBox.confirm('登录已过期，请重新登录', '重新登录', {
            confirmButtonText: '重新登录',
            cancelButtonText: '取消',
            type: 'warning'
          }).then(() => {
            store.dispatch('user/resetToken').then(() => {
              location.reload()
            })
          })
      }
      return Promise.reject(new Error(res.msg || 'Error'))
    }else{
      res.msg&& Message({
            message: res.msg || '操作成功',
            type: 'success',
            duration: 5 * 1000
      });
      return res;
    }

  },
  error => {
    console.log('err' + error) // for debug
    Message({
      message: error.message,
      type: 'error',
      duration: 5 * 1000
    })
    return Promise.reject(error)
  }
)

export default service
