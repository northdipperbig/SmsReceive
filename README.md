# 短信接收管理平台

## 更新记录
- 2020.11.04 修复短信内容显示长度问题
- 2020.11.03 增加接收短信时间
- 2020.11.02 正式上线使用

## 功能
1. 接收并存储手机转发的短信
2. 可对接收短信进行删除操作
3. 将接收到的短信转发到TG

## 未来可能的功能
1. 后台可配置短信转发方式及参数

## 已知问题
- 20201103001 短信内容显示表格未自动换行
    - 2020.11.04 修复

## 数据库结构设计
```sql
CREATE TABLE IF NOT EXISTS reveice_sms(
    id int(11) primary key auto_increment,
    reveice_number varchar(50) not null comment "Reveiced messsage numbers",
    send_number varchar(50) not null comment "Where are messages from?",
    reveice_message text,
    reveice_time datetime
) CHARACTER SET utf8
```