/*
 * @Author: Brightness
 * @Date: 2021-11-12 10:33:33
 * @LastEditors: Brightness
 * @LastEditTime: 2021-11-17 14:09:52
 * @Description:  
 */
import request from '@/utils/request'

export function login(data) {
  return request({
    url: 'account/login',
    method: 'post',
    data
  })
}

export function getInfo(token) {
  return request({
    url: 'account/info',
    method: 'get',
    params: { token }
  })
}

export function logout() {
  return request({
    url: 'account/logout',
    method: 'post'
  })
}

export function getTotal() {
  return request({
    url: 'user/getTotal',
    method: 'get'
  })
}

export function fetchList(query) {
  return request({
    url: 'user/getList',
    method: 'get',
    params: query

  })
}

export function createUser(query) {
  return request({
    url: 'user/add',
    method: 'post',
    params: query

  })
}

export function updateUser(query) {
  return request({
    url: 'user/edit',
    method: 'post',
    params: query

  })
}

export function deleteUser(id) {
  return request({
    url: 'user/delete',
    method: 'post',
    params: {id:id}

  })
}

export function getUser(id) {
  return request({
    url: 'user/get',
    method: 'get',
    params: {id:id}
  })
}

export function getGroupByUser(id) {
  return request({
    url: 'user/getGroupByUser',
    method: 'get',
    params: {id:id}
  })
}

export function setGroup(id,groups) {
  return request({
    url: 'user/setGroup',
    method: 'post',
    data:{id:id,group_ids:groups}
    
  })
}

