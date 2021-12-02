<!--
 * @Author: Brightness
 * @Date: 2021-11-15 10:57:27
 * @LastEditors: Brightness
 * @LastEditTime: 2021-11-15 11:08:13
 * @Description:  
-->
<template>
  <div class="doc-container">
    <el-row>
      <el-col  :span="4">
        <div class="col left">
            <el-tree
              ref="tree"
              default-expand-all
              :expand-on-click-node="false"
              :check-strictly="false"
              :data="categories"
              :props="defaultProps"
              node-key="dc_id"
              class="category-tree"
              @node-click="clickNode"
            />
        </div>
      </el-col>
      <el-col  :span="20">
        <div class="col right">
              <div class="filter-container">
                <el-input v-model="listQuery.name" placeholder="文档名称" style="width: 200px;" class="filter-item" @keyup.enter.native="handleFilter" />
                <el-button class="filter-item" type="primary" icon="el-icon-search" @click="handleFilter">
                  搜索
                </el-button>
                <el-button class="filter-item" style="margin-left: 10px;" type="primary" icon="el-icon-upload" @click="handleCreate">
                  上传文件
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
                  <el-table-column label="ID" prop="d_id" sortable="custom" align="center" width="80">
                    <template slot-scope="{row}">
                      <span>{{ row.d_id }}</span>
                    </template>
                  </el-table-column>
                  <el-table-column label="文档名称" min-width="150px">
                    <template slot-scope="{row}">
                      <span class="link-type">{{ row.d_name }}</span>
                    </template>
                  </el-table-column>
                  <el-table-column label="直属分类" width="150px" align="center">
                    <template slot-scope="{row}">
                      <span>{{ row.category.dc_name }}</span>
                    </template>
                  </el-table-column>
                  
                  <el-table-column label="操作" align="center" width="230" class-name="small-padding fixed-width">
                    <template slot-scope="{row,$index}">
                      <el-button type="primary" size="mini" @click="handleDownload(row)">
                        下载
                      </el-button>
                      <el-button v-if="row.status!='deleted'" size="mini" type="danger" @click="handleDelete(row,$index)">
                        删除
                      </el-button>
                    </template>
                  </el-table-column>
              </el-table>

              <pagination v-show="total>0" :total="total" :page.sync="listQuery.page" :limit.sync="listQuery.limit" @pagination="getDocList" />

              <el-dialog title="上传图片" :visible.sync="dialogUploadVisible" :close-on-click-modal="false" @close="handleCloseDialog">
                <h3>当前分类：{{listQuery.cate_name}}</h3>
                <dropzone ref="dropzon" id="myVueDropzone" url="http://192.168.174.135/index.php/doc/upload" :params="{cate_id:listQuery.cate_id}"
                   @dropzone-complete="dropzoneComplete" />
                <div slot="footer" class="dialog-footer">
                  <el-button @click="dialogUploadVisible = false">
                    取消
                  </el-button>
                  
                </div>
              </el-dialog>

        </div>
      </el-col>
    </el-row>
  </div>
</template>

<script>
import {fetchDocList,fetchCateTree,getDocTotal,downloadDoc,deleteDoc} from '@/api/doc'
import Pagination from '@/components/Pagination' // secondary package based on el-pagination
import Dropzone from '@/components/Dropzone'
export default {
  name: 'Doc',
  components: { Pagination,Dropzone },

  data() {
    return {
      categories:[],
      defaultProps: {
        children: 'children',
        label: 'dc_name'
      },
       tableKey: 0,
      list: null,
      total: 0,
      listLoading: true,
      listQuery: {
        cate_id:null,
        cate_name:null,
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
      dialogUploadVisible:false,
      
    }
  },
  created(){
    this.getCategoryData();
  },
  methods:{
    getCategoryData(){
      fetchCateTree().then(response=>{
        this.categories = response.data;
        if(!this.listQuery.cate_id){
          this.listQuery.cate_id = response.data[0].dc_id;
          this.listQuery.cate_name = response.data[0].dc_name;

        }
        this.getDocList();
      })
    },
    getDocList(){
      fetchDocList(this.listQuery).then(response=>{
          this.list = response.data;
          this.listLoading = false;
          this.getDocTotal();

      });
    },
    getDocTotal(){
      getDocTotal(this.listQuery).then(response=>{
        this.total = response.data;
      })
    },
    handleCreate(){
        this.dialogUploadVisible = true;
    },
    handleDownload(row){
      downloadDoc(row.d_id,row.d_name);
    },
    handleDelete(row){
      this.$confirm(`确定要删除 ${row.d_name} 文件吗?`,"删除文件",{type:'warning'}).then(()=>{
        deleteDoc(row.d_id).then(response=>{
          this.handleFilter()
        })
      })
      
    },
    handleFilter(){
      this.listQuery.page = 1;
      this.getDocList();
    },
    handleCloseDialog(){
      this.$refs.dropzon.removeAllFiles();

    },
    clickNode(node){
      if(this.listQuery.cate_id != node.dc_id){
        this.listQuery.page = 1;
        this.listQuery.cate_id = node.dc_id;
        this.listQuery.cate_name = node.dc_name;

        this.getDocList();
      }
    },
    dropzoneComplete(response) {
      let status = response.xhr.status;
      let rs = JSON.parse(response.xhr.response);
      if(status == 200 && rs.errCode == 0){
        this.$message.success("上传成功")
        this.handleFilter()
        return;
      }
      this.$refs.dropzon.removeFile(response);

      if(status != 200){
        this.$message.error("上传异常");
      }
      if(rs.errCode != 0){
        this.$notify({
          title: `${response.name} ,上传失败`,
          message: `失败原因：${rs.msg}`,
          duration: 0,
          type:'error',
        });
      }
      
    },
    
  }

}
</script>

<style  scoped>
  .doc-container{
    background: #eee;
  }
  .col{
    background: #fff;
    min-height: 88vh;
    padding-top: 20px;
  }

  .left {
    margin-right: 10px;
  }
  .right {
    padding-left: 20px;
  }

 
</style>
