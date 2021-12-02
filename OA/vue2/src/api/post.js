/*
 * @Author: Brightness
 * @Date: 2021-11-12 10:33:33
 * @LastEditors: Brightness
 * @LastEditTime: 2021-11-17 17:06:45
 * @Description:  
 */
import request from '@/utils/request'

export function getPost(id) {
  return request({
    url: 'post/get',
    method: 'get',
    params:{id:id}
  })
}


export function getTotal() {
  return request({
    url: 'post/getTotal',
    method: 'get'
  })
}

export function fetchList(query) {
  return request({
    url: 'post/getList',
    method: 'get',
    params: query

  })
}

export function createPost(query) {
  return request({
    url: 'post/add',
    method: 'post',
    params: query

  })
}

export function updatePost(query) {
  return request({
    url: 'post/edit',
    method: 'post',
    params: query

  })
}

export function deletePost(id) {
  return request({
    url: 'post/delete',
    method: 'post',
    params: {id:id}

  })
}


