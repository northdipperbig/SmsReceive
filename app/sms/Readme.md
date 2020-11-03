# 短信接收管理

## 基本功能
1. 接收终端上报的短信并保存
2. 查看接收到的短信
3. 对已经接收的短信进行管理（清理，删除）
4. 连接手机管理
5. 接收短信号码管理（自动添加？ 手动添加？不用单独添加？）
    - 是否需要对特定号码进行拒收
    - 

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
)
```