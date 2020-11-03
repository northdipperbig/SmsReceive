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

/**
 * 过滤手机管理
 * Class Device
 * @package app\numbers\controller
 */
class Device extends Controller
{
    /**
     * 绑定数据表
     * @var string
     */
    protected $table = 'PhoneDevices';

    /**
     * 过滤手机管理
     * @auth true
     * @menu true
     */
    public function index()
    {
        //$this->redirect(sysuri('numbers/index'));
        //return "啦啦啦啦！----- 这是一个测试控制器";
        $this->title = "过滤手机管理";  //只有设置了这个标题才会在页面中进行显示
        //$this->fetch();
        $query = $this->_query($this->table);
        $query->page();
    }

    /**
     * 列表数据处理
     * @param array $data
     
    protected function _index_page_filter(arrsy &d$data){
        //$devs = $this->app->db-name('PhoneDevice')->column('id','deviceid', 'states', 'authorization');
        
    }*/

    /**
     * 启用禁用过滤设备
     * @auth true
     */
    public function enable(){
        $did = $this->request->post("id");
        if(is_numeric($did)){
            $device = $this->app->db->name("PhoneDevices")->where('id', $did)->find();
            if (count($device) > 0 && $device["authorization"] == 1 && $device['states'] == 0){
                $this->app->db->name("PhoneDevices")->where('id', $did)->update(["states"=> 1 ]);
                $this->success("启用成功");
            }elseif(count($device) > 0 && $device["authorization"] == 1 && $device['states'] == 1){
                $this->app->db->name("PhoneDevices")->where('id', $did)->update(["states"=> 0 ]);
                $this->success("禁用成功");
            }else{
                $this->error("设备未授权或者不存在!");
            }
        }else{
            $this->error("参数错误!");
        }
        
    }

    /**
     * 授权设备
     * @auth true
     */
    public function grant(){
        $did = $this->request->post("id");
        if(is_numeric($did)){
            $device = $this->app->db->name($this->table)->where("id", $did)->find();
            if ( count($device) && $device["authorization"] == 0){
                $this->app->db->name($this->table)->where("id", $did)->update(["authorization" => 1]);
                $this->success("设备授权成功!");
            }elseif( count($device) && $device["authorization"] == 1){
                $this->app->db->name($this->table)->where("id", $did)->update(["authorization" => 0]);
                $this->success("取消授权成功!");
            }else{
                $this->error("设备不存在或参数错误");
            }
        }else{
            $this->error("参数错误");
        }
    }

    /**
     * 删除设备
     * @auth true
     */
    public function remove(){
        $did = $this->request->post("id");
        if(is_numeric($did)){
            $this->app->db->name($this->table)->where("id", $did)->delete();
            $this->success("删除设备成功!");
        }else{
            $this->error("参数错误!");
        }
    }

    /**
     * 添加设备
     */
    public function add(){
        $duuid = $this->request->post("uuid");
        if(!empty($duuid)){
            $device = $this->app->db->name($this->table)->where("deviceid", $duuid)->find();
            if( ! is_array($device)){
                $ret = $this->app->db->name($this->table)->insert(["deviceid" => $duuid]);
                if ( $ret ){
                    $this->success("成功添加设备: {$duuid}");
                }else{
                    $this->error("添加设备失败: {$uuid}");
                }
            }else{
                $this->error("设备已经存在,无需重复添加!");
            }
        }else{
            $this->error("参数错误");
        }
    }
}
