<template>
  <div class="app-container">
    <div class="filter-container">
      <el-input v-model="listQuery.title" placeholder="分组名称" style="width: 200px;" class="filter-item" @keyup.enter.native="handleFilter" />
      <el-button v-waves class="filter-item" type="primary" icon="el-icon-search" @click="handleFilter">
        搜索
      </el-button>
      <el-button class="filter-item" style="margin-left: 10px;" type="primary" icon="el-icon-edit"
      v-permission="['group/add']" @click="handleCreate">
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
          <span>{{ row.id }}</span>
        </template>
      </el-table-column>
      <el-table-column label="分组名称" min-width="150px">
        <template slot-scope="{row}">
          <span class="link-type" @click="handleUpdate(row)">{{ row.title }}</span>
        </template>
      </el-table-column>
      <el-table-column label="分组状态" width="150px" align="center">
        <template slot-scope="{row}">
           <el-tag :type="row.status?'success':'danger'">
            {{ row.status?'正常':'禁用' }}
          </el-tag>
        </template>
      </el-table-column>
      <el-table-column label="操作" align="center" width="230" class-name="small-padding fixed-width"
       v-if="checkPermission(['group/setrules','group/edit','group/delete'])">
        <template slot-scope="{row,$index}">
          <el-button type="warning" size="mini" v-permission="['group/setrules']" @click="handlePermission(row)">
            设置权限
          </el-button>
          <el-button type="primary" size="mini" v-permission="['group/edit']" @click="handleUpdate(row)">
            编辑
          </el-button>
          <el-button v-if="row.status!='deleted'" size="mini" type="danger" v-permission="['group/delete']" @click="handleDelete(row,$index)">
            删除
          </el-button>
        </template>
      </el-table-column>
    </el-table>

    <pagination v-show="total>0" :total="total" :page.sync="listQuery.page" :limit.sync="listQuery.limit" @pagination="getList" />

    <el-dialog :title="textMap[dialogStatus]" :visible.sync="dialogFormVisible" :close-on-click-modal="false">
      <el-form ref="dataForm" :rules="rules" :model="temp" label-position="left" label-width="90px" style="width: 400px; margin-left:50px;">
        <el-input v-model="temp.id" type="hidden"/>
        <el-form-item label="分组名称" prop="title">
          <el-input v-model="temp.title" />
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

  <el-dialog :visible.sync="premissionVisible" :title="'设置权限'" :close-on-click-modal="false" @close="handleClose">
      <el-form :model="temp" label-width="80px" label-position="left" >
        <el-input v-model="temp.id" type="hidden"/>
        <el-form-item label="分组名称">
          {{temp.title}}
        </el-form-item>
        <el-form-item label="权限">
          <el-tree
            ref="tree"
            :check-strictly="false"
            :data="permissionData"
            :props="defaultProps"
            :show-checkbox="true"
            node-key="id"
            class="permission-tree"
          />
        </el-form-item>
      </el-form>
      <div style="text-align:right;">
        <el-button type="danger" @click="premissionVisible=false">取消</el-button>
        <el-button type="primary" @click="setPermiss">确定</el-button>
      </div>
    </el-dialog>

  </div>
</template>

<script>
import { fetchList,createGroup,updateGroup,deleteGroup,getTotal,fetchPermissionList,getPermissionByGroup,setPermission} from '@/api/group'

import waves from '@/directive/waves' // waves directive
import Pagination from '@/components/Pagination' // secondary package based on el-pagination
import checkPermission from '@/utils/permission' // 权限判断函数
import permission from '@/directive/permission/index.js' // 权限判断指令

export default {
  name: 'Group',
  components: { Pagination },
  directives: { waves,permission },
  data() {
    return {
      tableKey: 0,
      list: null,
      total: 0,
      listLoading: true,
      listQuery: {
        page: 1,
        limit: 5,
        title: null,
      },
     temp: {
        id: null,
        title: '',
      },
      dialogFormVisible: false,
      premissionVisible:false,
      dialogStatus: '',
      textMap: {
        update: '编辑分组',
        create: '新增分组'
      },
      dialogPvVisible: false,
      rules: {
        title: [{ required: true, message: '分组名称必填', trigger: 'change' }],
      },
      permissionData:[],
      defaultProps: {
        children: 'children',
        label: 'title'
      }
    }
  },
  created() {
    this.getTotal()
    this.getList()
    this.getPermissionList()
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
    handleFilter() {
      this.listQuery.page = 1
      this.getList()
    },
   
    handleCreate() {
      this.temp = {};
      this.dialogStatus = 'create'
      this.dialogFormVisible = true
      this.$nextTick(() => {
        this.$refs['dataForm'].clearValidate()
      })
    },
    createData() {
      this.$refs['dataForm'].validate((valid) => {
        if (valid) {
            createGroup(this.temp).then(response=>{
              this.dialogFormVisible = false
              this.listQuery.title = null
              this.getList();
              this.getTotal();
            })
        }
      })
    },
    handleUpdate(row) {
      this.temp = Object.assign({}, row) // copy obj
      this.dialogStatus = 'update'
      this.dialogFormVisible = true
      this.$nextTick(() => {
        this.$refs['dataForm'].clearValidate()
      })
    },
    updateData() {
      this.$refs['dataForm'].validate((valid) => {
        if (valid) {
          updateGroup(this.temp).then(response=>{
            this.dialogFormVisible = false
            this.listQuery.title = null
            this.getList();
          })
        }
      })
    },
    handleDelete(row, index) {
      this.$confirm(`确定删除 ${row.title} 分组吗?`, '删除分类', {
            confirmButtonText: '确定',
            cancelButtonText: '取消',
            type: 'warning',
            closeOnClickModal:false,
          }).then(() => {
            deleteGroup(row.id).then(response=>{
                  this.listQuery.page = 1;
                  this.getList();
                  this.getTotal();
            })
          })
    },  
    getPermissionList(){
      fetchPermissionList().then(response=>{
        this.permissionData = response.data
      })
      
    },
    handleClose(){
      this.$refs.tree.setCheckedKeys([]);
    },
    handlePermission(row){
      this.premissionVisible = true;
      this.temp = row;
      this.$nextTick(() => {
        getPermissionByGroup(row.id).then(response=>{
          for (const key in response.data) {
            if (Object.hasOwnProperty.call(response.data, key)) {
              const node = response.data[key];
              this.$refs.tree.setChecked(node,true);
            }
          }
        })
      }) 
      
    },
    setPermiss(){
          let rules = this.$refs.tree.getCheckedNodes(false,true);
          let ids = [];
          for(let i in rules){
            ids.push(rules[i].id)
          }
          setPermission(this.temp.id,ids).then(response=>{
            this.premissionVisible=false;
          })
      
    },
    checkPermission,
  }
}
</script>
