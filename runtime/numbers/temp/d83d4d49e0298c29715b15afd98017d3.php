<?php /*a:1:{s:60:"/home/ChineseMan/ThinkAdmin/app/numbers/view/index/form.html";i:1604120269;}*/ ?>
<script type="text/javascript">
    function filepath(fileurl, ret){
        if(fileurl){
            layer.msg("文件上传完成,点击[开始导入]进行导入",{time:2000})
            $("#filepath").val(fileurl)
        }else{
            layer.msg("上传文件失败,请重试")
        }
    }
</script><form class="layui-form layui-card" action="<?php echo url('import'); ?>" data-auto="true" method="post" autocomplete="off"><div class="layui-card-body padding-left-40"><div class="layui-row layui-col-space15"><div class="layui-col-xs2 text-center"><input type="hidden" id="filepath" name="filepath"><input type="file" name="file" value=""><script>$('[name=file]').uploadFile(filepath)</script></div></div><div class="hr-line-dashed"></div><div class="layui-form-item text-center"><button class="layui-btn" type='submit'>开始导入</button><button class="layui-btn layui-btn-danger" type='button' data-close>取消导入</button></div></div></form>
