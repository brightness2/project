<!--
 * @Author: Brightness
 * @Date: 2021-11-17 09:35:01
 * @LastEditors: Brightness
 * @LastEditTime: 2021-11-17 17:26:30
 * @Description:  
-->
<template>
  <div class="app-container">
    <div class="filter-container">
      <el-input v-model="listQuery.name" placeholder="账号名称" style="width: 200px;" class="filter-item" @keyup.enter.native="handleFilter" />
      <el-button v-waves class="filter-item" type="primary" icon="el-icon-search" @click="handleFilter">
        搜索
      </el-button>
      <el-button class="filter-item" style="margin-left: 10px;" type="primary" icon="el-icon-edit" @click="handleCreate">
        新增
      </el-button>
    </div>

    <el-table
      :key="tableKey"
      v-loading="listLoading"
      :data="list"
      border
      fit
      highlight-current-row
      style="width: 100%;"
    >
      <el-table-column label="ID" prop="id" sortable="custom" align="center" width="80">
        <template slot-scope="{row}">
          <span>{{ row.user_id }}</span>
        </template>
      </el-table-column>
      <el-table-column label="账号名称" min-width="150px">
        <template slot-scope="{row}">
          <span class="link-type" @click="handleUpdate(row)">{{ row.name }}</span>
        </template>
      </el-table-column>
      <el-table-column label="性别" width="150px" align="center">
        <template slot-scope="{row}">
          <span>{{ row.sex?'女':'男' }}</span>
        </template>
      </el-table-column>
      <el-table-column label="状态" class-name="status-col" width="100">
        <template slot-scope="{row}">
          <el-tag :type="row.status?'success':'danger'">
            {{ row.status?'正常':'禁用' }}
          </el-tag>
        </template>
      </el-table-column>
      <el-table-column label="操作" align="center" width="230" class-name="small-padding fixed-width">
        <template slot-scope="{row,$index}">
           <el-button type="warning" size="mini" @click="handleGroup(row)">
            设置分组
          </el-button>
          <el-button type="primary" size="mini" @click="handleUpdate(row)">
            编辑
          </el-button>
          <el-button v-if="row.status!='deleted'" size="mini" type="danger" @click="handleDelete(row,$index)">
            删除
          </el-button>
        </template>
      </el-table-column>
    </el-table>

    <pagination v-show="total>0" :total="total" :page.sync="listQuery.page" :limit.sync="listQuery.limit" @pagination="getList" />

    <el-dialog :title="textMap[dialogStatus]" :visible.sync="dialogFormVisible" :close-on-click-modal="false">
      <el-form ref="dataForm" :rules="rules" :model="temp" label-position="left" label-width="90px" style="width: 400px; margin-left:50px;">
          <el-input v-model="temp.user_id" type="hidden"/>
       
        <el-form-item label="账号名称" prop="name">
          <el-input v-model="temp.name" />
        </el-form-item>
       <el-form-item label="性别" prop="sex">
          <el-select v-model="temp.sex" class="filter-item">
            <el-option v-for="item in sexOptions" :key="item.val" :label="item.title" :value="item.val" />
          </el-select>
        </el-form-item>
        
      </el-form>
      <div slot="footer" class="dialog-footer">
        <el-button @click="dialogFormVisible = false">
          取消
        </el-button>
        <el-button type="primary" @click="dialogStatus==='create'?createData():updateData()">
          确定
        </el-button>
      </div>
    </el-dialog>

    <el-dialog :visible.sync="groupVisible" :title="'设置分组'" :close-on-click-modal="false">
      <el-form :model="temp" label-width="80px" label-position="left" >
        <el-input v-model="temp.user_id" type="hidden"/>
        <el-form-item label="用户名称">
          {{temp.name}}
        </el-form-item>
        <el-form-item label="分组">
          <el-tree
            ref="tree"
            :check-strictly="false"
            :data="groupData"
            :props="defaultProps"
            show-checkbox
            node-key="id"
            class="group-tree"
          />
        </el-form-item>
      </el-form>
      <div style="text-align:right;">
        <el-button type="danger" @click="groupVisible=false">取消</el-button>
        <el-button type="primary" @click="setGroup">确定</el-button>
      </div>
    </el-dialog>
  </div>
</template>

<script>
import { fetchList,createUser,updateUser,deleteUser,getTotal,getUser,getGroupByUser,setGroup} from '@/api/user'
import {fetchList as fetchGroupList} from '@/api/group'
import waves from '@/directive/waves' // waves directive
import Pagination from '@/components/Pagination' // secondary package based on el-pagination
export default {
  name: 'User',
  components: { Pagination },
  directives: { waves },
  data() {
    return {
      tableKey: 0,
      list: null,
      total: 0,
      listLoading: true,
      listQuery: {
        page: 1,
        limit: 5,
        name: null,
      },
     temp: {
        user_id: null,
        name: '',
        sex:0,
      },
      sexOptions:[
          {
              title:'男',
              val:0,
          },
          {
              title:'女',
              val:1,
          }
      ],
      dialogFormVisible: false,
      dialogStatus: '',
      textMap: {
        update: '编辑账号',
        create: '新增账号'
      },
      dialogPvVisible: false,
      rules: {
        name: [{ required: true, message: '账号名称必填', trigger: 'change' }],
        sex: [{ required: true, message: '性别必选', trigger: 'change' }],

      },
      groupVisible:false,
      groupData:[],
      defaultProps: {
        children: 'children',
        label: 'title'
      }

    }
  },
  created() {
    this.getTotal()
    this.getList()
    this.getGroupList()
  },
  methods: {
    getTotal(){
      getTotal().then(response=>{
        this.total = response.data;
      })
    },
    getList() {
      this.listLoading = true
      fetchList(this.listQuery).then(response => {
        this.list = response.data
        // Just to simulate the time of the request
        setTimeout(() => {
          this.listLoading = false
        }, 1.5 * 1000)
      })
    },
    // getParentOptions(id=null){
    //   fetchList({exc:id}).then(response => {
    //     this.parentOptions = response.data;
    //   })
    // },
    handleFilter() {
      this.listQuery.page = 1
      this.getList()
    },
   
    handleCreate() {
      this.temp = {sex:0};
    //   this.getParentOptions();
      this.dialogStatus = 'create'
      this.dialogFormVisible = true
      this.$nextTick(() => {
        this.$refs['dataForm'].clearValidate()
      })
    },
    createData() {
      this.$refs['dataForm'].validate((valid) => {
        if (valid) {
            createUser(this.temp).then(response=>{
              this.dialogFormVisible = false
              this.listQuery.name = null
              this.getList();
              this.getTotal();
            })
        }
      })
    },
    handleUpdate(row) {
    //   this.getParentOptions(row.dc_id);
        getUser(row.user_id).then(response=>{
            this.temp = response.data
            this.dialogStatus = 'update'
            this.dialogFormVisible = true
            this.$nextTick(() => {
                this.$refs['dataForm'].clearValidate()
            })
        })
    },
    updateData() {
      this.$refs['dataForm'].validate((valid) => {
        if (valid) {
          updateUser(this.temp).then(response=>{
            this.dialogFormVisible = false
            this.listQuery.name = null
            this.getList();
          })
        }
      })
    },
    handleDelete(row, index) {
      this.$confirm(`确定删除 ${row.name} 账号吗?`, '删除分类', {
            confirmButtonText: '确定',
            cancelButtonText: '取消',
            type: 'warning',
            closeOnClickModal:false,
          }).then(() => {
            deleteUser(row.user_id).then(response=>{
                  this.listQuery.page = 1;
                  this.getList();
                  this.getTotal();
            })
          })
    },
    getGroupList(){
      fetchGroupList().then(response=>{
        this.groupData = response.data
      })
    },
    handleGroup(row){
      this.groupVisible = true;
      this.temp = row;
      this.$nextTick(() => {
        getGroupByUser(row.user_id).then(response=>{
          this.$refs.tree.setCheckedKeys(response.data);
        })
      }) 
    },
    setGroup(){
       let groups = this.$refs.tree.getCheckedKeys();
      setGroup(this.temp.user_id,groups).then(response=>{
        this.groupVisible = false;
      })
    }
  }
}
</script>
