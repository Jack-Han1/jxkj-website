create table magazine
(
    id          int auto_increment comment '月刊id'
        primary key,
    title       varchar(50)  null comment '标题',
    text        varchar(70)  null comment '介绍',
    date        varchar(20)  null comment '日期',
    url         varchar(100) null comment '链接',
    img         varchar(100) null comment '封面图片链接',
    status      int          not null,
    sort        int          not null,
    update_time datetime     null comment '更新时间'
)
    comment '精信月刊';

 INSERT INTO jxkj_db.magazine (title, text, date, url, img, status, sort, update_time) 
 VALUES (' 精信科技总裁李文帅出席武汉市高新技术产业会...', '6月25日，由武汉市人民政府主办的武汉光谷高新技术产业合作大会在武汉举行。会签武汉市市委书记...',
  '2023-06-25', 'https://s.dps.cn/go/f691afe0322c6e6366088e83d4d81267', 'https://sf.dps.cn/thn/202406/f691afe0322c6e6366088e83d4d81267.jpg', 1, 0, '2024-07-31 21:25:20');


  alter table article
    add clicks int default 0 not null comment '点击量';

create table recruit
(
    id              int auto_increment comment 'id'
        primary key,
    title           varchar(15)  null comment '标题',
    job             varchar(15)  null comment '岗位',
    position        varchar(20)  null comment '地点',
    duty            varchar(50)  null comment '岗位职责',
    emergency       tinyint(1)   not null comment '紧急',
    status          int          not null comment '-1不通过 0删除 1在审核 2通过',
    recruit_time    datetime     null comment '上传时间',
    duty_content    varchar(500) null comment '岗位职责',
    require_content varchar(500) null comment '岗位要求',
    kind            int          null comment '0校招 1社招 2内推',
    pos_id          int          null comment '地址编码'
)
    comment '招聘信息';



UPDATE jxkj_db.menu SET name = '新闻管理', pid = 0, pic_id = null, kind = 3, url = 'News', order_by = 1, head_show = 3, create_id = 1, create_time = '2016-05-23 16:29:36.0', status = 1 WHERE id = 1;
UPDATE jxkj_db.menu SET name = '人才招聘', pid = 0, pic_id = null, kind = 3, url = 'Advertise', order_by = 2, head_show = 3, create_id = 1, create_time = '2016-05-23 16:30:08.0', status = 1 WHERE id = 2;
UPDATE jxkj_db.menu SET name = '新闻列表', pid = 1, pic_id = null, kind = 3, url = 'News/index', order_by = 1, head_show = 3, create_id = 1, create_time = '2016-05-23 16:31:08.0', status = 1 WHERE id = 3;
UPDATE jxkj_db.menu SET name = '新闻添加', pid = 1, pic_id = null, kind = 3, url = 'News/add', order_by = 2, head_show = 3, create_id = 1, create_time = '2016-05-23 16:31:28.0', status = 1 WHERE id = 4;
UPDATE jxkj_db.menu SET name = '首页', pid = 0, pic_id = null, kind = 1, url = null, order_by = 1, head_show = 1, create_id = 1, create_time = '2016-05-24 10:01:26.0', status = 0 WHERE id = 5;
UPDATE jxkj_db.menu SET name = '走进精信', pid = 0, pic_id = 11, kind = 1, url = 'About/Introduce', order_by = 2, head_show = 1, create_id = 1, create_time = '2024-03-18 17:44:50.0', status = 1 WHERE id = 6;
UPDATE jxkj_db.menu SET name = '新闻中心', pid = 0, pic_id = 12, kind = 1, url = 'News/News', order_by = 3, head_show = 1, create_id = 1, create_time = '2024-03-18 17:46:30.0', status = 1 WHERE id = 7;
UPDATE jxkj_db.menu SET name = '产业布局', pid = 0, pic_id = 13, kind = 1, url = 'Industry/Communicate', order_by = 4, head_show = 1, create_id = 1, create_time = '2024-03-18 17:50:25.0', status = 1 WHERE id = 8;
UPDATE jxkj_db.menu SET name = '社会责任', pid = 0, pic_id = 14, kind = 1, url = 'Responsibility/Charitable', order_by = 5, head_show = 1, create_id = 1, create_time = '2024-03-18 17:50:55.0', status = 1 WHERE id = 9;
UPDATE jxkj_db.menu SET name = '人力资源', pid = 0, pic_id = 15, kind = 1, url = 'Recruit/Concept', order_by = 6, head_show = 1, create_id = 1, create_time = '2024-03-18 17:51:16.0', status = 1 WHERE id = 10;
UPDATE jxkj_db.menu SET name = '招聘列表', pid = 2, pic_id = null, kind = 3, url = 'Advertise/index', order_by = 1, head_show = 3, create_id = 1, create_time = '2016-05-24 10:27:44.0', status = 1 WHERE id = 11;
UPDATE jxkj_db.menu SET name = '招聘添加', pid = 2, pic_id = null, kind = 3, url = 'Advertise/add', order_by = 2, head_show = 3, create_id = 1, create_time = '2016-05-24 10:27:47.0', status = 1 WHERE id = 12;
UPDATE jxkj_db.menu SET name = '招才纳士', pid = 9, pic_id = null, kind = 1, url = 'Recruit/index', order_by = 1, head_show = 1, create_id = 1, create_time = '2016-05-24 15:03:23.0', status = 1 WHERE id = 13;
UPDATE jxkj_db.menu SET name = '账号管理', pid = 0, pic_id = null, kind = 3, url = 'User', order_by = 3, head_show = 2, create_id = 1, create_time = '2016-05-27 11:28:53.0', status = 1 WHERE id = 14;
UPDATE jxkj_db.menu SET name = '账号列表', pid = 14, pic_id = null, kind = 3, url = 'User/index', order_by = 1, head_show = 2, create_id = 1, create_time = '2016-05-27 11:30:03.0', status = 1 WHERE id = 15;
UPDATE jxkj_db.menu SET name = '添加账号', pid = 14, pic_id = null, kind = 3, url = 'User/add', order_by = 2, head_show = 2, create_id = 1, create_time = '2016-05-27 11:30:05.0', status = 1 WHERE id = 16;
UPDATE jxkj_db.menu SET name = '精信要闻', pid = 7, pic_id = null, kind = 1, url = 'News/News', order_by = 1, head_show = 1, create_id = 1, create_time = '2016-05-27 09:25:43.0', status = 1 WHERE id = 19;
UPDATE jxkj_db.menu SET name = '精信公告', pid = 7, pic_id = null, kind = 1, url = 'News/notice', order_by = 2, head_show = 1, create_id = 1, create_time = '2016-05-27 09:26:35.0', status = 0 WHERE id = 20;
UPDATE jxkj_db.menu SET name = '行业动态', pid = 7, pic_id = null, kind = 1, url = 'News/trends', order_by = 3, head_show = 1, create_id = 1, create_time = '2016-05-27 09:26:50.0', status = 0 WHERE id = 21;
UPDATE jxkj_db.menu SET name = '领导关怀', pid = 7, pic_id = null, kind = 1, url = 'News/focus', order_by = 4, head_show = 1, create_id = 1, create_time = '2016-05-27 09:27:14.0', status = 0 WHERE id = 22;
UPDATE jxkj_db.menu SET name = '菜单管理', pid = 0, pic_id = null, kind = 3, url = 'Menu', order_by = 4, head_show = 1, create_id = 1, create_time = '2016-05-25 09:57:31.0', status = 1 WHERE id = 24;
UPDATE jxkj_db.menu SET name = '菜单列表', pid = 24, pic_id = null, kind = 3, url = 'Menu/index', order_by = 1, head_show = 1, create_id = 1, create_time = '2016-05-25 09:59:42.0', status = 1 WHERE id = 25;
UPDATE jxkj_db.menu SET name = '菜单添加', pid = 24, pic_id = null, kind = 3, url = 'Menu/add', order_by = 2, head_show = 1, create_id = 1, create_time = '2016-05-25 09:59:44.0', status = 1 WHERE id = 26;
UPDATE jxkj_db.menu SET name = '日志管理', pid = 0, pic_id = null, kind = 3, url = 'Log', order_by = 5, head_show = 1, create_id = 1, create_time = '2016-05-27 17:00:52.0', status = 1 WHERE id = 27;
UPDATE jxkj_db.menu SET name = '集约平台', pid = 8, pic_id = null, kind = 2, url = 'Product/internet', order_by = 1, head_show = 1, create_id = 1, create_time = '2016-06-07 15:35:49.0', status = 0 WHERE id = 37;
UPDATE jxkj_db.menu SET name = '智慧校园', pid = 8, pic_id = null, kind = 2, url = 'Product/school', order_by = 2, head_show = 1, create_id = 1, create_time = '2016-06-07 15:40:00.0', status = 0 WHERE id = 38;
UPDATE jxkj_db.menu SET name = '文化项目', pid = 8, pic_id = null, kind = 2, url = 'Product/culture', order_by = 3, head_show = 1, create_id = 1, create_time = '2016-06-07 15:40:02.0', status = 0 WHERE id = 39;
UPDATE jxkj_db.menu SET name = '电销业务', pid = 8, pic_id = null, kind = 2, url = 'Product/call', order_by = 4, head_show = 1, create_id = 1, create_time = '2016-06-07 15:40:04.0', status = 0 WHERE id = 40;
UPDATE jxkj_db.menu SET name = '增值业务', pid = 8, pic_id = null, kind = 2, url = 'Product/sp', order_by = 5, head_show = 1, create_id = 1, create_time = '2016-06-07 15:40:06.0', status = 0 WHERE id = 41;
UPDATE jxkj_db.menu SET name = '终端销售', pid = 8, pic_id = null, kind = 2, url = 'Product/increment', order_by = 6, head_show = 1, create_id = 1, create_time = '2016-06-07 15:40:08.0', status = 0 WHERE id = 42;
UPDATE jxkj_db.menu SET name = '智慧金融', pid = 8, pic_id = null, kind = 2, url = 'Product/index', order_by = 7, head_show = 1, create_id = 1, create_time = '2016-06-07 15:40:10.0', status = 0 WHERE id = 43;
UPDATE jxkj_db.menu SET name = '精信简介', pid = 6, pic_id = null, kind = 2, url = 'About/Introduce', order_by = 1, head_show = 1, create_id = 1, create_time = '2016-06-08 14:06:00.0', status = 1 WHERE id = 44;
UPDATE jxkj_db.menu SET name = '发展历程', pid = 6, pic_id = null, kind = 2, url = 'About/Development', order_by = 2, head_show = 1, create_id = 1, create_time = '2017-09-30 17:44:40.0', status = 1 WHERE id = 45;
UPDATE jxkj_db.menu SET name = '精信架构', pid = 6, pic_id = null, kind = 2, url = 'About/framework', order_by = 3, head_show = 1, create_id = 1, create_time = '2016-06-08 14:06:05.0', status = 0 WHERE id = 46;
UPDATE jxkj_db.menu SET name = '核心团队', pid = 6, pic_id = null, kind = 2, url = 'About/team', order_by = 4, head_show = 1, create_id = 1, create_time = '2016-06-08 14:06:08.0', status = 0 WHERE id = 47;
UPDATE jxkj_db.menu SET name = '精信荣誉', pid = 6, pic_id = null, kind = 2, url = 'About/Honor', order_by = 5, head_show = 1, create_id = 1, create_time = '2016-06-08 14:06:12.0', status = 1 WHERE id = 48;
UPDATE jxkj_db.menu SET name = '企业文化', pid = 6, pic_id = null, kind = 2, url = 'About/Culture', order_by = 6, head_show = 1, create_id = 1, create_time = '2016-06-08 14:06:14.0', status = 1 WHERE id = 49;
UPDATE jxkj_db.menu SET name = '领导关怀', pid = 6, pic_id = null, kind = 2, url = 'About/care', order_by = 7, head_show = 1, create_id = 1, create_time = '2016-06-08 14:06:16.0', status = 0 WHERE id = 50;
UPDATE jxkj_db.menu SET name = '员工风采', pid = 6, pic_id = null, kind = 2, url = 'About/staff', order_by = 8, head_show = 1, create_id = 1, create_time = '2016-06-08 14:06:18.0', status = 0 WHERE id = 51;
UPDATE jxkj_db.menu SET name = '人才理念', pid = 9, pic_id = null, kind = 1, url = 'Recruit/idea', order_by = 2, head_show = 1, create_id = 1, create_time = '2016-06-17 16:57:42.0', status = 1 WHERE id = 52;
UPDATE jxkj_db.menu SET name = '人才培养', pid = 9, pic_id = null, kind = 1, url = 'Recruit/training', order_by = 3, head_show = 1, create_id = null, create_time = '2016-06-17 16:57:44.0', status = 1 WHERE id = 53;
UPDATE jxkj_db.menu SET name = '产品关键词管理', pid = 0, pic_id = null, kind = 3, url = 'Keyword', order_by = 7, head_show = 3, create_id = 1, create_time = null, status = 1 WHERE id = 54;
UPDATE jxkj_db.menu SET name = '产品关键词列表', pid = 54, pic_id = null, kind = 3, url = 'Keyword/index', order_by = 1, head_show = 3, create_id = 1, create_time = null, status = 1 WHERE id = 55;
UPDATE jxkj_db.menu SET name = '产品关键词添加', pid = 54, pic_id = null, kind = 3, url = 'Keyword/add', order_by = 2, head_show = 3, create_id = 1, create_time = null, status = 1 WHERE id = 56;
UPDATE jxkj_db.menu SET name = '金融类', pid = 8, pic_id = null, kind = 2, url = 'Product/index', order_by = 3, head_show = 1, create_id = 1, create_time = '2017-08-02 09:33:40.0', status = 0 WHERE id = 57;
UPDATE jxkj_db.menu SET name = '教育类', pid = 8, pic_id = null, kind = 2, url = 'Product/school', order_by = 1, head_show = 1, create_id = 1, create_time = '2017-08-02 09:33:40.0', status = 0 WHERE id = 58;
UPDATE jxkj_db.menu SET name = '易信通', pid = 8, pic_id = null, kind = 2, url = 'Product/yxt', order_by = 3, head_show = 1, create_id = 1, create_time = '2017-08-02 09:33:40.0', status = 0 WHERE id = 59;
UPDATE jxkj_db.menu SET name = '易信通', pid = 0, pic_id = null, kind = 1, url = 'Product/yxt', order_by = null, head_show = 0, create_id = 1, create_time = '2017-09-30 17:45:46.0', status = 0 WHERE id = 60;
UPDATE jxkj_db.menu SET name = '易信通', pid = 8, pic_id = null, kind = 1, url = 'Product/yxt', order_by = 4, head_show = 1, create_id = 1, create_time = '2017-09-30 17:47:19.0', status = 0 WHERE id = 61;
UPDATE jxkj_db.menu SET name = '走进精信', pid = 0, pic_id = null, kind = 3, url = 'About', order_by = 2, head_show = 3, create_id = 1, create_time = '2017-10-25 15:08:37.0', status = 1 WHERE id = 62;
UPDATE jxkj_db.menu SET name = '走进精信', pid = 62, pic_id = null, kind = 3, url = 'About/index', order_by = 1, head_show = 3, create_id = 1, create_time = '2017-10-25 15:21:51.0', status = 1 WHERE id = 64;
UPDATE jxkj_db.menu SET name = '员工风采', pid = 62, pic_id = null, kind = 3, url = 'About/staff', order_by = 2, head_show = 3, create_id = 1, create_time = '2017-10-25 15:23:12.0', status = 1 WHERE id = 65;
UPDATE jxkj_db.menu SET name = '商企类', pid = 8, pic_id = null, kind = 2, url = 'Product/business', order_by = 2, head_show = 1, create_id = 1, create_time = '2018-03-22 17:40:13.0', status = 0 WHERE id = 66;
UPDATE jxkj_db.menu SET name = '智慧校园', pid = 8, pic_id = null, kind = 2, url = 'Product/school', order_by = 1, head_show = 1, create_id = 1, create_time = '2018-07-12 15:11:44.0', status = 0 WHERE id = 67;
UPDATE jxkj_db.menu SET name = '光伏电能投资运营', pid = 8, pic_id = null, kind = 2, url = 'Product/index', order_by = 2, head_show = 1, create_id = 1, create_time = '2018-07-12 15:15:44.0', status = 0 WHERE id = 68;
UPDATE jxkj_db.menu SET name = '通信业务', pid = 8, pic_id = null, kind = 2, url = 'Product/yxt', order_by = 3, head_show = 1, create_id = 1, create_time = '2018-07-12 15:51:20.0', status = 0 WHERE id = 69;
UPDATE jxkj_db.menu SET name = '智慧城管', pid = 8, pic_id = null, kind = 2, url = 'Product/zhcg', order_by = 4, head_show = 1, create_id = 1, create_time = '2018-07-12 15:54:11.0', status = 0 WHERE id = 70;
UPDATE jxkj_db.menu SET name = 'admin', pid = 0, pic_id = null, kind = 1, url = 'http://www.55guai.com', order_by = null, head_show = 0, create_id = 1, create_time = '2019-05-13 11:52:41.0', status = 0 WHERE id = 71;
UPDATE jxkj_db.menu SET name = '联系我们', pid = 0, pic_id = null, kind = 1, url = 'Contact/Contact', order_by = null, head_show = 1, create_id = 1, create_time = '2024-03-18 17:51:31.0', status = 0 WHERE id = 72;
UPDATE jxkj_db.menu SET name = '联系我们', pid = 0, pic_id = 16, kind = 1, url = 'Contact/Contact', order_by = 7, head_show = 1, create_id = 1, create_time = '2024-03-18 17:54:17.0', status = 1 WHERE id = 73;
UPDATE jxkj_db.menu SET name = '通讯业务', pid = 8, pic_id = null, kind = 2, url = 'Industry/Communicate', order_by = 1, head_show = 1, create_id = 1, create_time = '2024-03-19 09:23:27.0', status = 1 WHERE id = 74;
UPDATE jxkj_db.menu SET name = '智慧校园', pid = 8, pic_id = null, kind = 2, url = 'Industry/Campus', order_by = 2, head_show = 1, create_id = 1, create_time = '2024-03-19 09:34:41.0', status = 1 WHERE id = 75;
UPDATE jxkj_db.menu SET name = '精信月刊', pid = 0, pic_id = null, kind = 2, url = 'About/magazine', order_by = 8, head_show = 1, create_id = 1, create_time = '2024-07-31 10:26:29.0', status = 1 WHERE id = 76;
UPDATE jxkj_db.menu SET name = '精信月刊', pid = 62, pic_id = null, kind = 3, url = 'About/magazine', order_by = 6, head_show = 1, create_id = 1, create_time = '2024-07-31 10:38:33.0', status = 1 WHERE id = 77;
UPDATE jxkj_db.menu SET name = '精信月刊', pid = 6, pic_id = null, kind = 2, url = 'About/Magazine', order_by = 7, head_show = 1, create_id = 1, create_time = '2024-08-02 16:33:33.0', status = 1 WHERE id = 78;
UPDATE jxkj_db.menu SET name = '光伏电能投资', pid = 8, pic_id = null, kind = 2, url = 'Industry/Energy', order_by = 3, head_show = 1, create_id = 1, create_time = '2024-08-02 17:20:17.0', status = 1 WHERE id = 79;
UPDATE jxkj_db.menu SET name = '智慧城管', pid = 8, pic_id = null, kind = 2, url = 'Industry/Urban', order_by = 4, head_show = 1, create_id = 1, create_time = '2024-08-02 17:20:18.0', status = 1 WHERE id = 80;
UPDATE jxkj_db.menu SET name = '人才理念', pid = 10, pic_id = null, kind = 2, url = 'Recruit/Concept', order_by = 1, head_show = 1, create_id = 1, create_time = '2024-08-02 17:25:46.0', status = 1 WHERE id = 81;
UPDATE jxkj_db.menu SET name = '人才培养', pid = 10, pic_id = null, kind = 2, url = 'Recruit/Promotion', order_by = 1, head_show = 1, create_id = 1, create_time = '2024-08-02 17:26:25.0', status = 1 WHERE id = 82;
UPDATE jxkj_db.menu SET name = '员工风采', pid = 10, pic_id = null, kind = 2, url = 'Recruit/Staff', order_by = 1, head_show = 1, create_id = 1, create_time = '2024-08-02 17:26:57.0', status = 1 WHERE id = 83;
UPDATE jxkj_db.menu SET name = '招贤纳士', pid = 10, pic_id = null, kind = 2, url = 'Recruit/Recruit', order_by = 1, head_show = 1, create_id = 1, create_time = '2024-08-02 17:27:23.0', status = 1 WHERE id = 84;
UPDATE jxkj_db.menu SET name = '薪酬福利', pid = 10, pic_id = null, kind = 2, url = 'Recruit/Salary', order_by = 1, head_show = 1, create_id = 1, create_time = '2024-08-02 17:27:48.0', status = 1 WHERE id = 85;


UPDATE jxkj_db.recruit SET title = '招聘专员', job = '话务专员', position = '武汉.硚口', duty = '1.负责打电话。。。。。。。。。。。。。...', emergency = 1, status = 2, recruit_time = '2024-08-03 17:40:21.0', duty_content = ' <p>1、 负责管理区域内物流相关操作，完成成本、安全、质量、体系等任务；</p>
              <p>2、 仓库日常运作管理（收、发、存、循环盘点及年度盘点）；</p>
              <p>3、负责带领班组仓储人员的日常管理，包括晨会召开、KPI管理、考勤等；</p>
              <p>4、KPI：仓库准确率，安全事故率，仓库相关物流成本，仓库人员效率，仓库设备效率，仓库面积利用率，内部配送准确率。</p>', require_content = ' <p>1、 负责管理区域内物流相关操作，完成成本、安全、质量、体系等任务；</p>
                <p>2、 仓库日常运作管理（收、发、存、循环盘点及年度盘点）；</p>
                <p>3、负责带领班组仓储人员的日常管理，包括晨会召开、KPI管理、考勤等；</p>
                <p>4、KPI：仓库准确率，安全事故率，仓库相关物流成本，仓库人员效率，仓库设备效率，仓库面积利用率，内部配送准确率。</p>', kind = 0, pos_id = 1 WHERE id = 1;
UPDATE jxkj_db.recruit SET title = '招聘专员', job = '话务专员', position = '武汉.硚口', duty = '1.负责打电话。。。。。。。。。。。。。...', emergency = 1, status = 2, recruit_time = '2024-08-03 17:40:21.0', duty_content = ' <p>1、 负责管理区域内物流相关操作，完成成本、安全、质量、体系等任务；</p>
              <p>2、 仓库日常运作管理（收、发、存、循环盘点及年度盘点）；</p>
              <p>3、负责带领班组仓储人员的日常管理，包括晨会召开、KPI管理、考勤等；</p>
              <p>4、KPI：仓库准确率，安全事故率，仓库相关物流成本，仓库人员效率，仓库设备效率，仓库面积利用率，内部配送准确率。</p>', require_content = ' <p>1、 负责管理区域内物流相关操作，完成成本、安全、质量、体系等任务；</p>
                <p>2、 仓库日常运作管理（收、发、存、循环盘点及年度盘点）；</p>
                <p>3、负责带领班组仓储人员的日常管理，包括晨会召开、KPI管理、考勤等；</p>
                <p>4、KPI：仓库准确率，安全事故率，仓库相关物流成本，仓库人员效率，仓库设备效率，仓库面积利用率，内部配送准确率。</p>', kind = 0, pos_id = 1 WHERE id = 2;
UPDATE jxkj_db.recruit SET title = '招聘专员', job = '话务专员', position = '武汉.硚口', duty = '1.负责打电话。。。。。。。。。。。。。...', emergency = 1, status = 2, recruit_time = '2024-08-03 17:40:21.0', duty_content = ' <p>1、 负责管理区域内物流相关操作，完成成本、安全、质量、体系等任务；</p>
              <p>2、 仓库日常运作管理（收、发、存、循环盘点及年度盘点）；</p>
              <p>3、负责带领班组仓储人员的日常管理，包括晨会召开、KPI管理、考勤等；</p>
              <p>4、KPI：仓库准确率，安全事故率，仓库相关物流成本，仓库人员效率，仓库设备效率，仓库面积利用率，内部配送准确率。</p>', require_content = ' <p>1、 负责管理区域内物流相关操作，完成成本、安全、质量、体系等任务；</p>
                <p>2、 仓库日常运作管理（收、发、存、循环盘点及年度盘点）；</p>
                <p>3、负责带领班组仓储人员的日常管理，包括晨会召开、KPI管理、考勤等；</p>
                <p>4、KPI：仓库准确率，安全事故率，仓库相关物流成本，仓库人员效率，仓库设备效率，仓库面积利用率，内部配送准确率。</p>', kind = 0, pos_id = 1 WHERE id = 3;
UPDATE jxkj_db.recruit SET title = '招聘专员', job = '话务专员', position = '武汉.硚口', duty = '1.负责打电话。。。。。。。。。。。。。...', emergency = 1, status = 2, recruit_time = '2024-08-03 17:40:21.0', duty_content = ' <p>1、 负责管理区域内物流相关操作，完成成本、安全、质量、体系等任务；</p>
              <p>2、 仓库日常运作管理（收、发、存、循环盘点及年度盘点）；</p>
              <p>3、负责带领班组仓储人员的日常管理，包括晨会召开、KPI管理、考勤等；</p>
              <p>4、KPI：仓库准确率，安全事故率，仓库相关物流成本，仓库人员效率，仓库设备效率，仓库面积利用率，内部配送准确率。</p>', require_content = ' <p>1、 负责管理区域内物流相关操作，完成成本、安全、质量、体系等任务；</p>
                <p>2、 仓库日常运作管理（收、发、存、循环盘点及年度盘点）；</p>
                <p>3、负责带领班组仓储人员的日常管理，包括晨会召开、KPI管理、考勤等；</p>
                <p>4、KPI：仓库准确率，安全事故率，仓库相关物流成本，仓库人员效率，仓库设备效率，仓库面积利用率，内部配送准确率。</p>', kind = 0, pos_id = 1 WHERE id = 4;
UPDATE jxkj_db.recruit SET title = '招聘专员', job = '话务专员', position = '武汉.硚口', duty = '1.负责打电话。。。。。。。。。。。。。...', emergency = 1, status = 2, recruit_time = '2024-08-03 17:40:21.0', duty_content = ' <p>1、 负责管理区域内物流相关操作，完成成本、安全、质量、体系等任务；</p>
              <p>2、 仓库日常运作管理（收、发、存、循环盘点及年度盘点）；</p>
              <p>3、负责带领班组仓储人员的日常管理，包括晨会召开、KPI管理、考勤等；</p>
              <p>4、KPI：仓库准确率，安全事故率，仓库相关物流成本，仓库人员效率，仓库设备效率，仓库面积利用率，内部配送准确率。</p>', require_content = ' <p>1、 负责管理区域内物流相关操作，完成成本、安全、质量、体系等任务；</p>
                <p>2、 仓库日常运作管理（收、发、存、循环盘点及年度盘点）；</p>
                <p>3、负责带领班组仓储人员的日常管理，包括晨会召开、KPI管理、考勤等；</p>
                <p>4、KPI：仓库准确率，安全事故率，仓库相关物流成本，仓库人员效率，仓库设备效率，仓库面积利用率，内部配送准确率。</p>', kind = 1, pos_id = 1 WHERE id = 5;
UPDATE jxkj_db.recruit SET title = '招聘专员', job = '话务专员', position = '武汉.硚口', duty = '1.负责打电话。。。。。。。。。。。。。...', emergency = 1, status = 2, recruit_time = '2024-08-03 17:40:21.0', duty_content = ' <p>1、 负责管理区域内物流相关操作，完成成本、安全、质量、体系等任务；</p>
              <p>2、 仓库日常运作管理（收、发、存、循环盘点及年度盘点）；</p>
              <p>3、负责带领班组仓储人员的日常管理，包括晨会召开、KPI管理、考勤等；</p>
              <p>4、KPI：仓库准确率，安全事故率，仓库相关物流成本，仓库人员效率，仓库设备效率，仓库面积利用率，内部配送准确率。</p>', require_content = ' <p>1、 负责管理区域内物流相关操作，完成成本、安全、质量、体系等任务；</p>
                <p>2、 仓库日常运作管理（收、发、存、循环盘点及年度盘点）；</p>
                <p>3、负责带领班组仓储人员的日常管理，包括晨会召开、KPI管理、考勤等；</p>
                <p>4、KPI：仓库准确率，安全事故率，仓库相关物流成本，仓库人员效率，仓库设备效率，仓库面积利用率，内部配送准确率。</p>', kind = 1, pos_id = 1 WHERE id = 6;
UPDATE jxkj_db.recruit SET title = '招聘专员', job = '话务专员', position = '武汉.硚口', duty = '1.负责打电话。。。。。。。。。。。。。...', emergency = 1, status = 2, recruit_time = '2024-08-03 17:40:21.0', duty_content = ' <p>1、 负责管理区域内物流相关操作，完成成本、安全、质量、体系等任务；</p>
              <p>2、 仓库日常运作管理（收、发、存、循环盘点及年度盘点）；</p>
              <p>3、负责带领班组仓储人员的日常管理，包括晨会召开、KPI管理、考勤等；</p>
              <p>4、KPI：仓库准确率，安全事故率，仓库相关物流成本，仓库人员效率，仓库设备效率，仓库面积利用率，内部配送准确率。</p>', require_content = ' <p>1、 负责管理区域内物流相关操作，完成成本、安全、质量、体系等任务；</p>
                <p>2、 仓库日常运作管理（收、发、存、循环盘点及年度盘点）；</p>
                <p>3、负责带领班组仓储人员的日常管理，包括晨会召开、KPI管理、考勤等；</p>
                <p>4、KPI：仓库准确率，安全事故率，仓库相关物流成本，仓库人员效率，仓库设备效率，仓库面积利用率，内部配送准确率。</p>', kind = 1, pos_id = 1 WHERE id = 7;
UPDATE jxkj_db.recruit SET title = '招聘专员', job = '话务专员', position = '武汉.硚口', duty = '1.负责打电话。。。。。。。。。。。。。...', emergency = 1, status = 2, recruit_time = '2024-08-03 17:40:21.0', duty_content = ' <p>1、 负责管理区域内物流相关操作，完成成本、安全、质量、体系等任务；</p>
              <p>2、 仓库日常运作管理（收、发、存、循环盘点及年度盘点）；</p>
              <p>3、负责带领班组仓储人员的日常管理，包括晨会召开、KPI管理、考勤等；</p>
              <p>4、KPI：仓库准确率，安全事故率，仓库相关物流成本，仓库人员效率，仓库设备效率，仓库面积利用率，内部配送准确率。</p>', require_content = ' <p>1、 负责管理区域内物流相关操作，完成成本、安全、质量、体系等任务；</p>
                <p>2、 仓库日常运作管理（收、发、存、循环盘点及年度盘点）；</p>
                <p>3、负责带领班组仓储人员的日常管理，包括晨会召开、KPI管理、考勤等；</p>
                <p>4、KPI：仓库准确率，安全事故率，仓库相关物流成本，仓库人员效率，仓库设备效率，仓库面积利用率，内部配送准确率。</p>', kind = 2, pos_id = 1 WHERE id = 8;
UPDATE jxkj_db.recruit SET title = '招聘专员', job = '话务专员', position = '武汉.硚口', duty = '1.负责打电话。。。。。。。。。。。。。...', emergency = 1, status = 2, recruit_time = '2024-08-03 17:40:21.0', duty_content = ' <p>1、 负责管理区域内物流相关操作，完成成本、安全、质量、体系等任务；</p>
              <p>2、 仓库日常运作管理（收、发、存、循环盘点及年度盘点）；</p>
              <p>3、负责带领班组仓储人员的日常管理，包括晨会召开、KPI管理、考勤等；</p>
              <p>4、KPI：仓库准确率，安全事故率，仓库相关物流成本，仓库人员效率，仓库设备效率，仓库面积利用率，内部配送准确率。</p>', require_content = ' <p>1、 负责管理区域内物流相关操作，完成成本、安全、质量、体系等任务；</p>
                <p>2、 仓库日常运作管理（收、发、存、循环盘点及年度盘点）；</p>
                <p>3、负责带领班组仓储人员的日常管理，包括晨会召开、KPI管理、考勤等；</p>
                <p>4、KPI：仓库准确率，安全事故率，仓库相关物流成本，仓库人员效率，仓库设备效率，仓库面积利用率，内部配送准确率。</p>', kind = 2, pos_id = 1 WHERE id = 9;
UPDATE jxkj_db.recruit SET title = '招聘专员', job = '话务专员', position = '武汉.硚口', duty = '1.负责打电话。。。。。。。。。。。。。...', emergency = 1, status = 2, recruit_time = '2024-08-03 17:40:21.0', duty_content = ' <p>1、 负责管理区域内物流相关操作，完成成本、安全、质量、体系等任务；</p>
              <p>2、 仓库日常运作管理（收、发、存、循环盘点及年度盘点）；</p>
              <p>3、负责带领班组仓储人员的日常管理，包括晨会召开、KPI管理、考勤等；</p>
              <p>4、KPI：仓库准确率，安全事故率，仓库相关物流成本，仓库人员效率，仓库设备效率，仓库面积利用率，内部配送准确率。</p>', require_content = ' <p>1、 负责管理区域内物流相关操作，完成成本、安全、质量、体系等任务；</p>
                <p>2、 仓库日常运作管理（收、发、存、循环盘点及年度盘点）；</p>
                <p>3、负责带领班组仓储人员的日常管理，包括晨会召开、KPI管理、考勤等；</p>
                <p>4、KPI：仓库准确率，安全事故率，仓库相关物流成本，仓库人员效率，仓库设备效率，仓库面积利用率，内部配送准确率。</p>', kind = 2, pos_id = 1 WHERE id = 10;
