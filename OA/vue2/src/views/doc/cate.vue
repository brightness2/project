<template>
  <div class="app-container">
    <div class="filter-container">
      <el-input v-model="listQuery.name" placeholder="分类名称" style="width: 200px;" class="filter-item" @keyup.enter.native="handleFilter" />
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
          <span>{{ row.dc_id }}</span>
        </template>
      </el-table-column>
      <el-table-column label="分类名称" min-width="150px">
        <template slot-scope="{row}">
          <span class="link-type" @click="handleUpdate(row)">{{ row.dc_name }}</span>
        </template>
      </el-table-column>
      <el-table-column label="上级分类" width="150px" align="center">
        <template slot-scope="{row}">
          <span>{{ row.parent?row.parent.dc_name:null }}</span>
        </template>
      </el-table-column>
      <el-table-column label="备注" min-width="200px" align="center">
        <template slot-scope="{row}">
          <span>{{ row.dc_memo }}</span>
        </template>
      </el-table-column>
      <el-table-column label="操作" align="center" width="230" class-name="small-padding fixed-width">
        <template slot-scope="{row,$index}">
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
          <el-input v-model="temp.dc_id" type="hidden"/>
       
        <el-form-item label="分类名称" prop="dc_name">
          <el-input v-model="temp.dc_name" />
        </el-form-item>
       <el-form-item label="上级分类">
          <el-select v-model="temp.dc_pid" class="filter-item" placeholder="无上级">
            <el-option v-for="item in parentOptions" :key="item.key" :label="item.dc_name" :value="item.dc_id" />
          </el-select>
        </el-form-item>
        <el-form-item label="备注">
          <el-input v-model="temp.dc_memo" type='textarea' />
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
  </div>
</template>

<script>
import { fetchCateList,createCate,updateCate,deleteCate,getCateTotal} from '@/api/doc'
import waves from '@/directive/waves' // waves directive
import Pagination from '@/components/Pagination' // secondary package based on el-pagination
export default {
  name: 'DocCate',
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
        dc_id: null,
        dc_name: '',
        dc_pid:null,
        dc_memo:null,
      },
      parentOptions:[],
      dialogFormVisible: false,
      dialogStatus: '',
      textMap: {
        update: '编辑文档分类',
        create: '新增文档分类'
      },
      dialogPvVisible: false,
      rules: {
        dc_name: [{ required: true, message: '分类名称必填', trigger: 'change' }],
      },
    }
  },
  created() {
    this.getTotal()
    this.getList()
  },
  methods: {
    getTotal(){
      getCateTotal().then(response=>{
        this.total = response.data;
      })
    },
    getList() {
      this.listLoading = true
      fetchCateList(this.listQuery).then(response => {
        this.list = response.data
        // Just to simulate the time of the request
        setTimeout(() => {
          this.listLoading = false
        }, 1.5 * 1000)
      })
    },
    getParentOptions(id=null){
      fetchCateList({exc:id}).then(response => {
        this.parentOptions = response.data;
      })
    },
    handleFilter() {
      this.listQuery.page = 1
      this.getList()
    },
   
    handleCreate() {
      this.temp = {};
      this.getParentOptions();
      this.dialogStatus = 'create'
      this.dialogFormVisible = true
      this.$nextTick(() => {
        this.$refs['dataForm'].clearValidate()
      })
    },
    createData() {
      this.$refs['dataForm'].validate((valid) => {
        if (valid) {
            createCate(this.temp).then(response=>{
              this.dialogFormVisible = false
              this.listQuery.name = null
              this.getList();
              this.getTotal();
            })
        }
      })
    },
    handleUpdate(row) {
      this.getParentOptions(row.dc_id);
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
          updateCate(this.temp).then(response=>{
            this.dialogFormVisible = false
            this.listQuery.name = null
            this.getList();
          })
        }
      })
    },
    handleDelete(row, index) {
      this.$confirm(`确定删除 ${row.dc_name} 分类吗?`, '删除分类', {
            confirmButtonText: '确定',
            cancelButtonText: '取消',
            type: 'warning',
            closeOnClickModal:false,
          }).then(() => {
            deleteCate(row.dc_id).then(response=>{
                  this.listQuery.page = 1;
                  this.getList();
                  this.getTotal();
            })
          })
    },
  }
}
</script>
