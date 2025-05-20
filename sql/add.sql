create table article
(
    id           int auto_increment
        primary key,
    name         varchar(255)  null comment '文章名称',
    abstract     text          null comment '摘要',
    content      text          null comment '文章内容',
    menu_id      int           null comment '所属菜单id',
    file_id      varchar(50)   null comment '附加id。多个附近用“,”链接',
    top          int           null comment '置顶。1，置顶，0，不置顶',
    create_id    int           null comment '最后修改者',
    create_time  datetime      null comment '最后修改时间',
    article_time datetime      null,
    status       int           null comment '状态。-1，不通过。0，删除。1，待审核。2，通过。',
    sort         int(8)        null comment '升序',
    top_title    varchar(255)  null comment '首页推荐标题',
    clicks       int default 0 not null comment '点击量'
)
    engine = InnoDB
    row_format = DYNAMIC;

create table content
(
    id          int auto_increment
        primary key,
    name        varchar(255) null comment '文章名称',
    content     text         null comment '文章内容',
    url         varchar(255) null comment '链接地址',
    menu_id     int          null comment '所属菜单id',
    create_id   int          null comment '最后修改者',
    create_time datetime     null comment '创建时间',
    update_time datetime     null comment '修改时间',
    status      int          null comment '状态。-1，不通过。0，删除。1，待审核。2，通过。',
    sort        int(8)       null comment '置顶排序顺序（小号排前）'
)
    engine = InnoDB
    row_format = DYNAMIC;

create table extend
(
    id          int auto_increment
        primary key,
    eng_name    varchar(50)  null comment '英文代号（唯一）',
    cha_name    varchar(50)  null comment '中文名称',
    content     text         null comment '内容',
    note        varchar(255) null comment '注释',
    create_id   int          null comment '最后修改者',
    create_time datetime     null comment '最后修改时间',
    status      varchar(255) null comment '状态。1，可用。0，删除。'
)
    engine = InnoDB
    row_format = DYNAMIC;

create table file
(
    id          int auto_increment
        primary key,
    file_name   varchar(255) null comment '文件名',
    file_path   varchar(255) null comment '文件路径',
    file_size   int          null comment '文件大小（字节）',
    file_ext    varchar(20)  null comment '文件扩展名',
    create_time datetime     null comment '最后修改时间'
)
    engine = InnoDB
    row_format = DYNAMIC;

create table log
(
    id          int auto_increment
        primary key,
    content     text     null comment '具体操作',
    create_id   int      null comment '最后修改者',
    create_time datetime null comment '最后修改时间'
)
    engine = InnoDB
    row_format = DYNAMIC;

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
    update_time datetime     null comment '更新时间',
    create_id   int          null
)
    comment '精信月刊';

create table menu
(
    id          int auto_increment
        primary key,
    name        varchar(50)  null comment '菜单名称',
    pid         int          null comment '父级菜单',
    pic_id      int          null comment '菜单图片的id',
    kind        int          null comment '菜单类型。1，前台列表菜单。2，前台内容菜单。3，后台菜单。',
    url         varchar(255) null comment '菜单链接',
    order_by    int          null comment '排序',
    head_show   int          null comment '是否头部显示。1，显示。0，不显示。',
    create_id   int          null comment '最后修改者',
    create_time datetime     null comment '最后修改时间',
    status      int          null comment '状态。1，可用。0，删除。'
)
    engine = InnoDB
    row_format = DYNAMIC;

create table pic_dir
(
    id          int(8) auto_increment
        primary key,
    title       varchar(255) null comment '名称',
    status      tinyint(2)   null comment '状态（1:正常；0：删除）',
    sort        int          null comment '升序',
    create_id   int(8)       null comment '创建人id',
    create_time datetime     null comment '创建时间',
    update_time datetime     null comment '修改时间'
)
    engine = InnoDB
    row_format = DYNAMIC;

create table product
(
    id          int auto_increment
        primary key,
    name        varchar(255) null comment '产品名称',
    abstract    text         null comment '产品摘要',
    url         varchar(255) null comment '产品链接',
    status      int          null comment '状态。-1，不通过。0，删除。1，待审核。2，通过。',
    update_time datetime     null comment ' 修改时间'
)
    engine = InnoDB
    row_format = DYNAMIC;

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
    pos_id          int          null comment '地址编码',
    sort            int          null,
    create_id       int          null comment '最后修改者'
)
    comment '招聘信息';

create table staff
(
    id          int(8) auto_increment
        primary key,
    title       varchar(255)         null comment '名称',
    url         varchar(255)         not null comment '图片链接',
    pid         int(8)               null comment '目录id',
    status      tinyint(2)           null comment '状态（1：正常；0：删除）',
    is_cover    tinyint(2) default 0 null comment '是否封面（1：是；0：否）',
    sort        int                  null comment '升序',
    create_id   int(8)               null comment '创建人id',
    create_time datetime             null comment '创建时间',
    update_time datetime             null comment '修改时间'
)
    engine = InnoDB
    row_format = DYNAMIC;

create table user
(
    id          int auto_increment
        primary key,
    name        varchar(20) null comment '用户昵称',
    pwd         varchar(50) null comment '用户密码',
    role        int         null comment '1,管理员。2，总办。3，人事',
    create_id   int         null comment '最后修改者',
    create_time datetime    null comment '最后修改时间',
    status      int         null comment '用户状态。1，可用。0，删除。'
)
    engine = InnoDB
    row_format = DYNAMIC;

create table user_role_value
(
    id      int(8) auto_increment
        primary key,
    role    int(8)               null comment '1,管理员。2，总办。3，人事',
    menu_id int(8)               null comment '菜单id',
    status  tinyint(2) default 1 null comment '状态（1：正常；2：不显示）',
    sort    tinyint(2)           null comment '排序'
)
    engine = InnoDB
    row_format = DYNAMIC;