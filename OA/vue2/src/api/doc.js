/*
 * @Author: Brightness
 * @Date: 2021-11-15 16:59:24
 * @LastEditors: Brightness
 * @LastEditTime: 2021-11-16 17:13:54
 * @Description:  
 */
import request from '@/utils/request'
import download from '@/utils/download'

export function fetchCateList(query) {
  return request({
    url: 'DocCate/getList',
    method: 'get',
    params: query
  })
}

export function fetchCateTree(query) {
  return request({
    url: 'DocCate/getTree',
    method: 'get',
    params: query
  })
}

export function createCate(query) {
  return request({
    url: 'DocCate/add',
    method: 'post',
    params: query
  })
}

export function updateCate(query) {
  return request({
    url: 'DocCate/edit',
    method: 'post',
    params: query
  })
}

export function deleteCate(id) {
  return request({
    url: 'DocCate/delete',
    method: 'post',
    params: {id:id}
  })
}

export function getCateTotal() {
  return request({
    url: 'DocCate/getTotal',
    method: 'get',
  
  })
}

export function fetchDocList(query) {
  return request({
    url: 'Doc/getList',
    method: 'get',
    params:query
  
  })
}

export function getDocTotal(query) {
  return request({
    url: 'Doc/getTotal',
    method: 'get',
    params:query
  
  })
}

export function downloadDoc(id,filename) {
  download('doc/download',filename,{id:id});
}

export function deleteDoc(id) {
  return request({
    url: 'Doc/delete',
    method: 'get',
    params:{id:id}
  
  })
}