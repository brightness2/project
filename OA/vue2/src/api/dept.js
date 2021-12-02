/*
 * @Author: Brightness
 * @Date: 2021-11-12 10:33:33
 * @LastEditors: Brightness
 * @LastEditTime: 2021-11-17 16:08:51
 * @Description:  
 */
import request from '@/utils/request'

export function getDept(id) {
  return request({
    url: 'dept/get',
    method: 'get',
    params:{id:id}
  })
}


export function getTotal() {
  return request({
    url: 'dept/getTotal',
    method: 'get'
  })
}

export function fetchList(query) {
  return request({
    url: 'dept/getList',
    method: 'get',
    params: query

  })
}

export function createDept(query) {
  return request({
    url: 'dept/add',
    method: 'post',
    params: query

  })
}

export function updateDept(query) {
  return request({
    url: 'dept/edit',
    method: 'post',
    params: query

  })
}

export function deleteDept(id) {
  return request({
    url: 'dept/delete',
    method: 'post',
    params: {id:id}

  })
}


