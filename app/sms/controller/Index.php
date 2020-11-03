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

namespace app\sms\controller;

use think\admin\Controller;

/**
 *接收短信
 * Class Index
 * @package app\index\controller
 */
class Index extends Controller
{

    /**
     * 绑定数据表
     * @var string
     */
    protected $table = "ReveiceSms";

    /**
     * 接收短信管理
     * @auth true
     * @menu true
     */
    public function index()
    {
        //$this->redirect(sysuri('numbers/index'));
        //return "啦啦啦啦！----- 这是一个测试控制器";
        $this->title = "接收短信";  //只有设置了这个标题才会在页面中进行显示
        $this->_query($this->table)->order("reveice_time desc")->page();
    }

    /**
     * 上报短信
     */
    public function smsReceive(){
        if ( $this->request->isPost() ){
            $s = $this->request->post('s');
            $d = $this->request->post('d');
            $msg = '+'.$this->request->post('msg');
            $ret = $this->app->db->name($this->table)->insert([
                "send_number" => $s,
                "reveice_number" => $d,
                "reveice_message" => $msg,
                //"reveice_time" => $rtime;
            ]);

            //Request send message to telegram
            $requestData = '{"Fr":"'.$s.'","To":"'.$d.'","Msg":"'.$msg.'"}';
            $this->smsSend($requestData);
            if ($ret){
                $this->success("短信接收成功");
            }else{
                $this->error("短信接收失败");
            }
        }else{
            $this->error("短信接收失败");
        }
        
    }

    /**
     * 删除短信
     * @auth true
     */
    public function remove(){
        $this->_applyFormToken();
        $this->_delete($this->table);
    }

    /**
     * 清空短信
     * @auth true
     */
    public function clearall(){
        $this->_applyFormToken();
        $this->app->db->execute("truncate table reveice_sms");
        $this->success("短信清空完成");
    }

    /**
     * 发送短信
     */
    private function smsSend($data){
        $url = "http://127.0.0.1:11020/v1/smssend";
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Content-Length:' . strlen($data)));
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, True);
        curl_exec($curl);
        curl_close($curl);
        return true;
    }
}
