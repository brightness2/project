/*
 * @Author: Brightness
 * @Date: 2021-11-12 10:33:33
 * @LastEditors: Brightness
 * @LastEditTime: 2021-11-23 10:54:19
 * @Description:  
 */
import request from '@/utils/request'

export function getGroup(id) {
  return request({
    url: 'group/get',
    method: 'get',
    params:{id:id}
  })
}


export function getTotal() {
  return request({
    url: 'group/getTotal',
    method: 'get'
  })
}

export function fetchList(query) {
  return request({
    url: 'group/getList',
    method: 'get',
    params: query

  })
}

export function createGroup(query) {
  return request({
    url: 'group/add',
    method: 'post',
    params: query

  })
}

export function updateGroup(query) {
  return request({
    url: 'group/edit',
    method: 'post',
    params: query

  })
}

export function deleteGroup(id) {
  return request({
    url: 'group/delete',
    method: 'post',
    params: {id:id}

  })
}

/**
 * 所有权限列表
 * @returns 
 */
export function fetchPermissionList() {
  return request({
    url: 'permission/getList',
    method: 'get',
    params: {}

  })
}
/**
 * 当前用户权限列表
 * @returns 
 */
export function getPermissionByGroup(groupId) {
  return request({
    url: 'group/getRules',
    method: 'get',
    params: {id:groupId}

  })
}

export function setPermission(groupId,rules) {
  return request({
    url: 'group/setRules',
    method: 'post',
    data:{id:groupId,rules:rules}

  })
}



