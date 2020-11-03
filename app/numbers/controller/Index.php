<?php

// +----------------------------------------------------------------------
// | ThinkAdmin
// +----------------------------------------------------------------------
// | 版权所有 2014~2020 广州楚才信息科技有限公司 [ http://www.cuci.cc ]
// +----------------------------------------------------------------------
// | 官方网站: https://thinkadmin.top
// +----------------------------------------------------------------------
// | 开源协议 ( https://mit-license.org )
// +----------------------------------------------------------------------
// | gitee 代码仓库：https://gitee.com/zoujingli/ThinkAdmin
// | github 代码仓库：https://github.com/zoujingli/ThinkAdmin
// +----------------------------------------------------------------------

namespace app\numbers\controller;

use think\admin\Controller;
use think\admin\storage\LocalStorage;

/**
 * 电话号码列表
 * Class Index
 * @package app\index\controller
 */
class Index extends Controller
{
    
    /**
     * 绑定数据表
     * @var string
     */
    protected $table = 'PhoneNumbers';

    /**
     * 过滤号码列表
     * @auth true
     * @menu true
     */
    public function index()
    {
        //$this->redirect(sysuri('numbers/index'));
        //return "啦啦啦啦！----- 这是一个测试控制器";
        $this->title = "号码过滤管理";  //只有设置了这个标题才会在页面中进行显示
        //$this->fetch();
        $query = $this->_query($this->table);
        $query->page();
    }

    /**
     * 删除号码
     * @auth true
     */
    public function remove(){
        $this->_applyFormToken();
        $this->_delete($this->table);
    }

    /**
     * 清空号码
     * @auth true
     */
    public function clearall(){
        $this->_applyFormToken();
        $newtable = "phone_numbers_".date('Ymdhi');
        $this->app->db->execute("rename table phone_numbers to {$newtable}");
        $this->app->db->execute("create table phone_numbers like {$newtable}");
        $this->success("手机号码清空完成");
    }

    /**
     * 添加系统用户
     * @auth true
     */
    public function import(){
        if( request()->isPost() ){
            $file = $this->request->post("filepath");
            if( empty($file) ){
                $this->error("File upload error");
            }elseif( substr($file, 0, 4) == "http" ){
                $file = strtolower(parse_url($file, PHP_URL_PATH));
            }else{
                $file = strtolower("upload/"+$file);
            }
            $file = $this->app->getRootPath()."public/".$file;
            $f = fopen($file, 'r');
            $importfaild = 0;
            $importsuccess = 0;
            $importexists = 0;
            while(!feof($f)){
                $line = fgets($f);
                if(substr($line, 0, 1) == '+' && !empty($line)){
                    $number = $this->app->db->name($this->table)->where("phone_number", $line)->find();
                    if( is_array( $number ) ){ $importexists++; }else{
                        $ret = $this->app->db->name($this->table)->insert(["phone_number"=>$line]);
                        if( $ret ){ $importsuccess++; }else{ $importfaild++; }
                    }
                }else{
                    $importfaild++;
                }
            }
            fclose($f);
            unlink($file);
            $this->success("导入执行完成:<br>导入成功: {$importsuccess} 条<br>重复导入: {$importexists} 条<br>导入失败: {$importfaild} 条");
        }else{
            $this->_applyFormToken();
            $this->_form($this->table, 'form');
        }
    }
}
