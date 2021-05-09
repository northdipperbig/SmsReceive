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

## Air chat select user message
```sql
select m.create_time, p.account,p1.account, m.body 
	from user_message as m left join user_profile as p on m.from_user_id = p.id 
			       left join user_profile as p1 on m.receive_user_id = p1.id
	where (m.from_user_id = 151 or m.receive_user_id = 151)
		and m.body like '%content%'
	order by m.create_time asc
```
