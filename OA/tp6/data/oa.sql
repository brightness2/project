-- phpMyAdmin SQL Dump
-- version 4.9.5
-- https://www.phpmyadmin.net/
--
-- 主机： localhost
-- 生成日期： 2021-12-08 05:13:12
-- 服务器版本： 5.6.50-log
-- PHP 版本： 7.2.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 数据库： `oa`
--

-- --------------------------------------------------------

--
-- 表的结构 `tp_auth_group`
--

CREATE TABLE `tp_auth_group` (
  `id` mediumint(8) UNSIGNED NOT NULL,
  `title` char(100) NOT NULL DEFAULT '',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `rules` varchar(255) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `tp_auth_group`
--

INSERT INTO `tp_auth_group` (`id`, `title`, `status`, `rules`) VALUES
(1, '超级管理员', 1, '1,2,3,4,5,6,7,43,8,9,10,11,12,44,13,14,15,16,17,18,19,20,45,23,24,25,21,22,26,27,28,29,30,46,31,32,33,34,35,36,47,37,38,39,40,41,42,48'),
(3, '游客', 1, '1,2,3,8,9,44');

-- --------------------------------------------------------

--
-- 表的结构 `tp_auth_group_access`
--

CREATE TABLE `tp_auth_group_access` (
  `uid` varchar(10) NOT NULL,
  `group_id` mediumint(8) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `tp_auth_group_access`
--

INSERT INTO `tp_auth_group_access` (`uid`, `group_id`) VALUES
('PM0001', 1),
('PM0001', 2),
('PM0002', 3);

-- --------------------------------------------------------

--
-- 表的结构 `tp_auth_rule`
--

CREATE TABLE `tp_auth_rule` (
  `id` mediumint(8) UNSIGNED NOT NULL,
  `name` char(80) NOT NULL DEFAULT '',
  `title` char(20) NOT NULL DEFAULT '',
  `type` tinyint(1) NOT NULL DEFAULT '1',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `condition` char(100) NOT NULL DEFAULT '',
  `pid` int(11) NOT NULL DEFAULT '0' COMMENT '上级'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `tp_auth_rule`
--

INSERT INTO `tp_auth_rule` (`id`, `name`, `title`, `type`, `status`, `condition`, `pid`) VALUES
(1, 'docCate/getTree', '文档中心', 1, 1, '', 0),
(2, 'docCate/getTotal', '文档分类', 1, 1, '', 1),
(3, 'docCate/getList', '文档分类数据', 1, 1, '', 2),
(4, 'docCate/get', '文档分类获取', 1, 1, '', 3),
(5, 'docCate/add', '新增文档分类', 1, 1, '', 4),
(6, 'docCate/edit', '更新文档分类', 1, 1, '', 4),
(7, 'docCate/delete', '删除文档分类', 1, 1, '', 4),
(8, 'doc/getTotal', '文档列表', 1, 1, '', 3),
(9, 'doc/getList', '文档数据', 1, 1, '', 8),
(10, 'doc/upload', '文档上传', 1, 1, '', 9),
(11, 'doc/download', '文档下载', 1, 1, '', 9),
(12, 'doc/delete', '删除文档', 1, 1, '', 9),
(13, 'system', '系统设置', 1, 1, '', 0),
(14, 'user/getTotal', '用户账号', 1, 1, '', 13),
(15, 'user/getList', '用户数据', 1, 1, '', 14),
(16, 'user/get', '获取用户信息', 1, 1, '', 15),
(17, 'user/add', '新增用户信息', 1, 1, '', 16),
(18, 'user/edit', '更新用户信息', 1, 1, '', 16),
(19, 'user/delete', '删除用户信息', 1, 1, '', 16),
(20, 'user/resetPassword', '重置用户密码', 1, 1, '', 16),
(21, 'user/getGroupByUser', '获取用户分组', 1, 1, '', 25),
(22, 'user/setGroup', '修改用户分组', 1, 1, '', 21),
(23, 'group/getTotal', '分组管理', 1, 1, '', 13),
(24, 'group/getList', '分组数据', 1, 1, '', 23),
(25, 'group/get', '获取分组', 1, 1, '', 24),
(26, 'group/add', '新增分组', 1, 1, '', 25),
(27, 'group/edit', '更新分组', 1, 1, '', 25),
(28, 'group/delete', '删除分组', 1, 1, '', 25),
(29, 'group/getRules', '获取分组权限', 1, 1, '', 25),
(30, 'group/setRules', '设置分组权限', 1, 1, '', 29),
(31, 'dept/getTotal', '部门管理', 1, 1, '', 13),
(32, 'dept/getList', '部门数据', 1, 1, '', 31),
(33, 'dept/get', '获取部门信息', 1, 1, '', 32),
(34, 'dept/add', '新增部门', 1, 1, '', 33),
(35, 'dept/edit', '更新部门', 1, 1, '', 33),
(36, 'dept/delete', '删除部门', 1, 1, '', 33),
(37, 'post/getTotal', '职位管理', 1, 1, '', 13),
(38, 'post/getList', '职位数据', 1, 1, '', 37),
(39, 'post/get', '获取职位信息', 1, 1, '', 38),
(40, 'post/add', '新增职位', 1, 1, '', 39),
(41, 'post/edit', '更新职位', 1, 1, '', 39),
(42, 'post/delete', '删除职位', 1, 1, '', 39),
(43, 'docCate', '查看文档分类', 1, 1, '', 4),
(44, 'doc', '查看文档', 1, 1, '', 9),
(45, 'user', '查看用户信息', 1, 1, '', 16),
(46, 'group', '查看分组', 1, 1, '', 25),
(47, 'dept', '查看部门信息', 1, 1, '', 33),
(48, 'post', '查看职位信息', 1, 1, '', 39);

-- --------------------------------------------------------

--
-- 表的结构 `tp_dept`
--

CREATE TABLE `tp_dept` (
  `dt_id` varchar(15) NOT NULL COMMENT '部门ID',
  `dt_name` varchar(100) NOT NULL COMMENT '部门名称',
  `dt_pid` varchar(15) DEFAULT '0' COMMENT '父级部门',
  `dt_memo` varchar(150) DEFAULT NULL COMMENT '备注'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='部门表';

--
-- 转存表中的数据 `tp_dept`
--

INSERT INTO `tp_dept` (`dt_id`, `dt_name`, `dt_pid`, `dt_memo`) VALUES
('DT0001', '产品2', '0', NULL);

-- --------------------------------------------------------

--
-- 表的结构 `tp_doc`
--

CREATE TABLE `tp_doc` (
  `d_id` varchar(15) NOT NULL COMMENT '文档ID',
  `d_name` varchar(300) NOT NULL COMMENT '文档名称',
  `dc_id` varchar(15) NOT NULL COMMENT '文档分类ID',
  `d_url` varchar(300) NOT NULL COMMENT '文档存储位置',
  `d_type` varchar(150) NOT NULL COMMENT '文件类型',
  `d_ext` varchar(10) NOT NULL COMMENT '文件扩展名',
  `d_create_time` datetime NOT NULL COMMENT '创建时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='文档表';

--
-- 转存表中的数据 `tp_doc`
--

INSERT INTO `tp_doc` (`d_id`, `d_name`, `dc_id`, `d_url`, `d_type`, `d_ext`, `d_create_time`) VALUES
('D0007', 'amazon.xlsx', 'DC0001', 'document/20211130/bc389021004069df37452512fb3116fb.xlsx', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'xlsx', '2021-11-30 15:35:31'),
('D0008', '头像 - 副本.png', 'DC0001', 'document/20211201/61cc40c10e3d2d7a9051624f68cdf7b8.png', 'image/png', 'png', '2021-12-01 00:10:49'),
('D0009', '头像.png', 'DC0001', 'document/20211201/30bc062c3b0a258a4de251090021ae8d.png', 'image/png', 'png', '2021-12-01 00:14:04');

-- --------------------------------------------------------

--
-- 表的结构 `tp_doc_cate`
--

CREATE TABLE `tp_doc_cate` (
  `dc_id` varchar(15) NOT NULL COMMENT '分类ID',
  `dc_name` varchar(50) NOT NULL COMMENT '分类名称',
  `dc_pid` varchar(15) DEFAULT '0' COMMENT '父级分类',
  `dc_memo` varchar(250) DEFAULT NULL COMMENT '备注'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='文档分类表';

--
-- 转存表中的数据 `tp_doc_cate`
--

INSERT INTO `tp_doc_cate` (`dc_id`, `dc_name`, `dc_pid`, `dc_memo`) VALUES
('DC0001', '公司制度', '0', NULL),
('DC0004', '行政制度', 'DC0001', NULL),
('DC0005', '人事制度', 'DC0001', NULL),
('DC0006', 'test', 'DC0004', NULL),
('DC0009', 'demo', 'DC0006', NULL),
('DC0010', 'demo2', 'DC0005', NULL),
('DC0011', 'demo3', 'DC0009', NULL),
('DC0012', 'test2', '0', NULL);

-- --------------------------------------------------------

--
-- 表的结构 `tp_level`
--

CREATE TABLE `tp_level` (
  `level_id` varchar(15) NOT NULL COMMENT '职级编辑',
  `level_name` varchar(20) NOT NULL COMMENT '职级名称',
  `memo` varchar(100) NOT NULL COMMENT '备注'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='职级表';

--
-- 转存表中的数据 `tp_level`
--

INSERT INTO `tp_level` (`level_id`, `level_name`, `memo`) VALUES
('LV0001', 'P1', '测试'),
('LV0002', 'P2', '等级二');

-- --------------------------------------------------------

--
-- 表的结构 `tp_notice`
--

CREATE TABLE `tp_notice` (
  `n_id` varchar(15) NOT NULL COMMENT '公告id',
  `n_create_user` varchar(15) DEFAULT NULL COMMENT '发布人id',
  `nc_id` varchar(15) DEFAULT NULL COMMENT '公告分类id',
  `n_title` varchar(300) NOT NULL COMMENT '公告标题',
  `n_start` date NOT NULL COMMENT '开始时间',
  `n_end` date NOT NULL COMMENT '结束时间',
  `n_content` text NOT NULL COMMENT '公告内容',
  `n_order` int(11) DEFAULT '0' COMMENT '排序',
  `create_time` datetime DEFAULT NULL COMMENT '创建时间',
  `update_time` datetime DEFAULT NULL COMMENT '更新时间',
  `n_update_user` varchar(15) DEFAULT NULL COMMENT '更新人'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='公告信息表';

--
-- 转存表中的数据 `tp_notice`
--

INSERT INTO `tp_notice` (`n_id`, `n_create_user`, `nc_id`, `n_title`, `n_start`, `n_end`, `n_content`, `n_order`, `create_time`, `update_time`, `n_update_user`) VALUES
('N0001', 'PM0001', 'NC0001', '  2021年10月份考勤制度调整', '2021-08-03', '2021-08-03', 'jkfjkdfkdkdkfk&lt;script&gt;alert(111111)&lt;/script&gt;', 0, '2021-08-03 10:51:16', '2021-08-03 10:58:01', 'U_0001'),
('N0006', 'PM0001', 'NC0002', '旅游', '2021-08-27', '2021-08-28', '房价跌幅扩大看看', 0, '2021-08-24 07:02:10', '2021-08-24 07:02:10', 'PM0001'),
('N0007', 'PM0001', 'NC0002', '旅游', '2021-08-27', '2021-08-28', '反对法', 0, '2021-08-24 07:02:48', '2021-08-24 07:02:48', 'PM0001');

-- --------------------------------------------------------

--
-- 表的结构 `tp_notice_cate`
--

CREATE TABLE `tp_notice_cate` (
  `nc_id` varchar(15) NOT NULL COMMENT '公告类别',
  `nc_name` varchar(50) NOT NULL COMMENT '公告类别名称'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='公告类别表';

--
-- 转存表中的数据 `tp_notice_cate`
--

INSERT INTO `tp_notice_cate` (`nc_id`, `nc_name`) VALUES
('NC0001', '公司公告'),
('NC0002', '活动公告');

-- --------------------------------------------------------

--
-- 表的结构 `tp_permission`
--

CREATE TABLE `tp_permission` (
  `per_id` varchar(15) NOT NULL COMMENT '资源编号',
  `per_name` varchar(100) NOT NULL COMMENT '资源名称',
  `type` tinyint(4) NOT NULL COMMENT '资源类型(0-菜单，1-子菜单，2-按钮)',
  `action` varchar(200) NOT NULL COMMENT '操作'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='资源表';

-- --------------------------------------------------------

--
-- 表的结构 `tp_post`
--

CREATE TABLE `tp_post` (
  `post_id` varchar(15) NOT NULL COMMENT '岗位ID',
  `post_name` varchar(100) NOT NULL COMMENT '岗位名称',
  `post_pid` varchar(15) DEFAULT '0' COMMENT '上级岗位',
  `post_memo` varchar(100) NOT NULL COMMENT '备注'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='职位表';

--
-- 转存表中的数据 `tp_post`
--

INSERT INTO `tp_post` (`post_id`, `post_name`, `post_pid`, `post_memo`) VALUES
('PO0001', '产品经理', '0', ''),
('PO0002', '产品组长', 'PO0001', ''),
('PO0003', '开发员', 'PO0002', ''),
('PO0004', '测试组长', 'PO0001', '');

-- --------------------------------------------------------

--
-- 表的结构 `tp_queue`
--

CREATE TABLE `tp_queue` (
  `id` int(11) NOT NULL,
  `type` varchar(50) NOT NULL COMMENT '队列类型',
  `data` text NOT NULL COMMENT '数据'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='队列';

-- --------------------------------------------------------

--
-- 表的结构 `tp_role`
--

CREATE TABLE `tp_role` (
  `role_id` varchar(15) NOT NULL COMMENT '角色编号',
  `role_name` varchar(20) NOT NULL COMMENT '角色名称',
  `memo` varchar(100) DEFAULT NULL COMMENT '角色描述'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='角色表';

--
-- 转存表中的数据 `tp_role`
--

INSERT INTO `tp_role` (`role_id`, `role_name`, `memo`) VALUES
('R0001', '超级管理员', '所有权限'),
('R0002', '管理员', 'dfdf'),
('R0003', '普通角色', '普通权限');

-- --------------------------------------------------------

--
-- 表的结构 `tp_sequence`
--

CREATE TABLE `tp_sequence` (
  `seq_name` varchar(80) NOT NULL,
  `seq_no` int(11) NOT NULL,
  `seq_last_update` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='计数表';

--
-- 转存表中的数据 `tp_sequence`
--

INSERT INTO `tp_sequence` (`seq_name`, `seq_no`, `seq_last_update`) VALUES
('dept', 4, '2021-11-17 03:59:04'),
('doc', 12, '2021-12-01 00:14:22'),
('doc_cate', 13, '2021-12-07 22:16:23'),
('level', 3, '2021-08-20 04:19:16'),
('notice', 7, '2021-08-24 07:02:47'),
('notice_cate', 2, '2021-08-24 01:19:59'),
('post', 7, '2021-11-17 05:05:00'),
('role', 4, '2021-08-20 05:31:31'),
('user', 7, '2021-11-17 01:27:23');

-- --------------------------------------------------------

--
-- 表的结构 `tp_user`
--

CREATE TABLE `tp_user` (
  `user_id` varchar(15) NOT NULL COMMENT '用户id',
  `name` varchar(20) NOT NULL COMMENT '用户名称',
  `sex` tinyint(4) DEFAULT '0' COMMENT '性别(0-男，1女)',
  `dept_id` varchar(15) DEFAULT NULL COMMENT '部门ID',
  `post_id` varchar(15) NOT NULL COMMENT '岗位ID',
  `phone` varchar(30) DEFAULT NULL COMMENT '联系电话',
  `status` tinyint(4) DEFAULT '1' COMMENT '用户状态(0-禁用，1-正常)',
  `password` char(32) DEFAULT NULL COMMENT '密码，md5加密',
  `avatar` varchar(300) DEFAULT NULL COMMENT '用户头像',
  `removed` tinyint(4) DEFAULT '0' COMMENT '是否删除'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='用户表';

--
-- 转存表中的数据 `tp_user`
--

INSERT INTO `tp_user` (`user_id`, `name`, `sex`, `dept_id`, `post_id`, `phone`, `status`, `password`, `avatar`, `removed`) VALUES
('PM0001', 'Brightness', 0, NULL, 'PO0001', '', 1, 'e10adc3949ba59abbe56e057f20f883e', 'https://wpimg.wallstcn.com/f778738c-e4f8-4870-b634-56703b4acafe.gif', 0),
('PM0002', 'test', 0, NULL, 'PO0002', NULL, 1, 'e10adc3949ba59abbe56e057f20f883e', 'https://wpimg.wallstcn.com/f778738c-e4f8-4870-b634-56703b4acafe.gif', 0),
('PM0003', 'demo', 1, NULL, 'PO0003', NULL, 1, 'e10adc3949ba59abbe56e057f20f883e', NULL, 0),
('PM0004', 'test2', 0, NULL, '', NULL, 1, 'e10adc3949ba59abbe56e057f20f883e', NULL, 0),
('PM0005', 'test4', 1, NULL, '', NULL, 1, 'e10adc3949ba59abbe56e057f20f883e', NULL, 1),
('PM0006', 'test3', 1, NULL, '', NULL, 1, 'e10adc3949ba59abbe56e057f20f883e', NULL, 1);

--
-- 转储表的索引
--

--
-- 表的索引 `tp_auth_group`
--
ALTER TABLE `tp_auth_group`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `tp_auth_group_access`
--
ALTER TABLE `tp_auth_group_access`
  ADD UNIQUE KEY `uid_group_id` (`uid`,`group_id`),
  ADD KEY `uid` (`uid`),
  ADD KEY `group_id` (`group_id`);

--
-- 表的索引 `tp_auth_rule`
--
ALTER TABLE `tp_auth_rule`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- 表的索引 `tp_dept`
--
ALTER TABLE `tp_dept`
  ADD PRIMARY KEY (`dt_id`);

--
-- 表的索引 `tp_doc`
--
ALTER TABLE `tp_doc`
  ADD PRIMARY KEY (`d_id`);

--
-- 表的索引 `tp_doc_cate`
--
ALTER TABLE `tp_doc_cate`
  ADD PRIMARY KEY (`dc_id`);

--
-- 表的索引 `tp_level`
--
ALTER TABLE `tp_level`
  ADD PRIMARY KEY (`level_id`);

--
-- 表的索引 `tp_notice`
--
ALTER TABLE `tp_notice`
  ADD PRIMARY KEY (`n_id`);

--
-- 表的索引 `tp_notice_cate`
--
ALTER TABLE `tp_notice_cate`
  ADD PRIMARY KEY (`nc_id`);

--
-- 表的索引 `tp_permission`
--
ALTER TABLE `tp_permission`
  ADD PRIMARY KEY (`per_id`);

--
-- 表的索引 `tp_post`
--
ALTER TABLE `tp_post`
  ADD PRIMARY KEY (`post_id`);

--
-- 表的索引 `tp_queue`
--
ALTER TABLE `tp_queue`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `tp_role`
--
ALTER TABLE `tp_role`
  ADD PRIMARY KEY (`role_id`);

--
-- 表的索引 `tp_sequence`
--
ALTER TABLE `tp_sequence`
  ADD PRIMARY KEY (`seq_name`,`seq_no`);

--
-- 表的索引 `tp_user`
--
ALTER TABLE `tp_user`
  ADD PRIMARY KEY (`user_id`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `tp_auth_group`
--
ALTER TABLE `tp_auth_group`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- 使用表AUTO_INCREMENT `tp_auth_rule`
--
ALTER TABLE `tp_auth_rule`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- 使用表AUTO_INCREMENT `tp_queue`
--
ALTER TABLE `tp_queue`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
