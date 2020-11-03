# 短信接收管理

## 变更日志
- 2020.11.03 增加接收短信时间
- 2020.11.02 正式上线使用

## 基本功能
1. 接收终端上报的短信并保存
2. 查看接收到的短信
3. 对已经接收的短信进行管理（清理，删除）
4. 接收短信号码管理
    - 是否需要对特定号码进行拒收
5. 未实现功能
    - 手机在线管理
    - 后台可配置发送方式，及相关参数
        - TG
        - 邮箱
        - 短信（需要短信接口）
        - 微信
        - QQ
    - APK发布
        - 生成下载地址
        - 生成下载二维码

## 可能存在的问题
1. 无人清理短信如何处理
    每月保存到对应的数据库表中，如果表不存在则创建

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