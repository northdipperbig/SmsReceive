# 苹果推号码管理

## 更新记录
- 2020.10.31 文件上传失败问题解决,原因是上传文件输入框参数名称必须为file;导入完成后删除文件
- 2020.10.30 完成设备注册,手机号码删除与清空,导入号码页面及功能完成但存在上传失败问题
- 2020.10.29 完成设备管理页面

## 功能列表
### 后台功能
1. 导入导出号码
2. 清空号码
3. 号码的增删改查
4. 号码浏览及统计
5. 查看设备状态及其正在过滤的号码
6. 设备授权管理
7. 设备启用停用

### 接口功能
1. 获取未过滤号码，每次获取100条
2. 上报号码过滤结果
3. 请求接口需要添加权限

## 数据库设计
```sql
CREATE TABLE IF NOT EXISTS phone_device(
    id int(11) primary key auto_increment,
    deviceid varchar(255) not null,
    states int(1) default 0 comment "0: Disabled, 1: enabled",
    authorization int(1) defalut 0 comment "0: Unauthorized, 1: Authorized"
)

CREATE TABLE IF NOT EXISTS phone_numbers(
    id int(11) primary key auto_increment,
    device int(11) default 0 comment "0: Not device get"
    phone_number varchar(20) comment "like number +639776097178",
    states int(1) default 0 comment "0: Not filter, 1: Is imessage number, 2: Is not imessage number",
)
```
