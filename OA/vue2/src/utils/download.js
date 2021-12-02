import axios from "axios"
import { getToken } from '@/utils/auth'
import { MessageBox, Message } from 'element-ui'

const download = (url,opts={})=>{
    const {type='get',data=''} = opts
    const query = {
        url,
        method:type,
        params:data,
        data,
        headers:{
            Accept: 'application/json',
            'Content-Type': 'application/json; charset=utf-8',
            // withCredentials: true,
            token:getToken(),
        }
    }
    // 这里直接返回的是response整体
    return axios.request(query)
    .then(response=>{
        if(typeof response.data == 'object'){
            let rs = response.data
            if(rs.errCode != 0){
                rs.msg&&Message({
                    message: rs.msg,
                    type: 'error',
                    duration: 5 * 1000
                });
            }
        }else{
            return response;
        }
    })
    .catch(err=>{
        Message({
            message: '下载出错',
            type: 'error',
            duration: 5 * 1000
        });
    })
}

// 拿到response之后我们需要将流文件通过浏览器下载
const  convertRes2Blob = (response,filename)=>{
    
    //提取文件名
    // const fileName = response.headers['content-disposition'].match(/filename=(.*)/)[1]
    // 将二进制流转为blob
    const blob = new Blob([response.data], { type: 'application/octet-stream' })
    if (typeof window.navigator.msSaveBlob !== 'undefined') {
        //兼容IE，window.navigator.msSaveBlob：以本地方式保存文件
        window.navigator.msSaveBlob(blob, decodeURI(filename));
    }else{
        //创建新的URL并指向File对象或者Blob对象的地址
        const blobURL = window.URL.createObjectURL(blob)
        //创建a标签，用于跳转至下载链接
        const tempLink = document.createElement('a')
        tempLink.style.display = 'none'
        tempLink.href = blobURL
        tempLink.setAttribute('download', decodeURI(filename))
        //兼容：某些浏览器不支持HTML5的download属性
        if (typeof tempLink.download === 'undefined') {
            tempLink.setAttribute('target', '_blank')
        }
        //挂载a标签
        document.body.appendChild(tempLink)
        tempLink.click()
        document.body.removeChild(tempLink)
         // 释放blob URL地址
        window.URL.revokeObjectURL(blobURL)
    }
}
const service = (url,filename,data='',type='get')=>{
    const baseURL = 'http://192.168.174.135/index.php/'
    download(baseURL+url,{type,data}).then(response=>{
        if(response){
            convertRes2Blob(response,filename);
        }
    })
    
}
export  default service;