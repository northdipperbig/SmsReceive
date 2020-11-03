<?php /*a:3:{s:59:"/home/ChineseMan/ThinkAdmin/app/admin/view/oplog/index.html";i:1603870984;s:52:"/home/ChineseMan/ThinkAdmin/app/admin/view/main.html";i:1603870984;s:66:"/home/ChineseMan/ThinkAdmin/app/admin/view/oplog/index_search.html";i:1603870984;}*/ ?>
<div class="layui-card layui-bg-gray"><?php if(!(empty($title) || (($title instanceof \think\Collection || $title instanceof \think\Paginator ) && $title->isEmpty()))): ?><div class="layui-card-header notselect"><span class="layui-icon layui-icon-next font-s10 color-desc margin-right-5"></span><?php echo htmlentities((isset($title) && ($title !== '')?$title:'')); ?><div class="pull-right"><!--<?php if(auth('config')): ?>--><a class="layui-btn layui-btn-sm layui-btn-primary" data-modal="<?php echo url('config'); ?>">日志配置</a><!--<?php endif; ?>--><!--<?php if(auth("clear")): ?>--><button data-load='<?php echo url("clear"); ?>' data-confirm="确定要消除所有日志吗？" class='layui-btn layui-btn-sm layui-btn-primary'>清理日志</button><!--<?php endif; ?>--><!--<?php if(auth("remove")): ?>--><button data-action='<?php echo url("remove"); ?>' data-rule="id#{key}" data-csrf="<?php echo systoken('remove'); ?>" data-confirm="确定要删除日志吗？" class='layui-btn layui-btn-sm layui-btn-primary'>删除日志</button><!--<?php endif; ?>--></div></div><?php endif; ?><div class="layui-card-body"><div class="think-box-shadow table-block"><fieldset><legend>条件搜索</legend><form class="layui-form layui-form-pane form-search" action="<?php echo request()->url(); ?>" onsubmit="return false" method="get" autocomplete="off"><div class="layui-form-item layui-inline"><label class="layui-form-label">操作账号</label><div class="layui-input-inline"><input name="username" value="<?php echo input('get.username'); ?>" placeholder="请输入操作账号" class="layui-input"></div></div><div class="layui-form-item layui-inline"><label class="layui-form-label">操作节点</label><div class="layui-input-inline"><input name="node" value="<?php echo input('get.node'); ?>" placeholder="请输入操作节点" class="layui-input"></div></div><div class="layui-form-item layui-inline"><label class="layui-form-label">操作行为</label><div class="layui-input-inline"><input name="action" value="<?php echo input('get.action'); ?>" placeholder="请输入操作行为" class="layui-input"></div></div><div class="layui-form-item layui-inline"><label class="layui-form-label">操作描述</label><div class="layui-input-inline"><input name="content" value="<?php echo input('get.content'); ?>" placeholder="请输入操作内容" class="layui-input"></div></div><div class="layui-form-item layui-inline"><label class="layui-form-label">位置地址</label><div class="layui-input-inline"><input name="geoip" value="<?php echo input('get.geoip'); ?>" placeholder="请输入位置地址" class="layui-input"></div></div><div class="layui-form-item layui-inline"><label class="layui-form-label">操作时间</label><div class="layui-input-inline"><input data-date-range name="create_at" value="<?php echo input('get.create_at'); ?>" placeholder="请选择操作时间" class="layui-input"></div></div><div class="layui-form-item layui-inline"><button class="layui-btn layui-btn-primary"><i class="layui-icon">&#xe615;</i> 搜 索</button></div></form></fieldset><script>form.render()</script><table class="layui-table margin-top-10" lay-skin="line"><?php if(!(empty($list) || (($list instanceof \think\Collection || $list instanceof \think\Paginator ) && $list->isEmpty()))): ?><thead><tr><th class='list-table-check-td think-checkbox'><label><input data-auto-none data-check-target='.list-check-box' type='checkbox'></label></th><th class='text-left nowrap'>操作权限</th><th class='text-left nowrap'>操作行为</th><th class='text-left nowrap'>地理位置</th><th class='text-left nowrap'>操作时间</th><th></th></tr></thead><tbody><?php foreach($list as $key=>$vo): ?><tr><td class='list-table-check-td think-checkbox'><label><input class="list-check-box" value='<?php echo htmlentities($vo['id']); ?>' type='checkbox'></label></td><td class="text-left nowrap">
                操作账号：<span class="font-w7"><?php echo htmlentities((isset($vo['username']) && ($vo['username'] !== '')?$vo['username']:'-')); ?></span><br>
                操作节点：<span class="color-desc"><?php echo htmlentities((isset($vo['node']) && ($vo['node'] !== '')?$vo['node']:'-')); ?></span></td><td class='text-left nowrap padding-row-0 padding-right-0'><p class="color-text layui-elip" style="max-width:550px"><?php echo htmlentities((isset($vo['action']) && ($vo['action'] !== '')?$vo['action']:'-')); ?></p><?php if(preg_match('|\s+(\w+)\s+数据|', $vo['action'])): ?><label data-tips-desc class="notselect pointer color-blue">
                    查看详情内容<textarea class="layui-hide"><?php echo (isset($vo['content']) && ($vo['content'] !== '')?$vo['content']:''); ?></textarea></label><?php else: ?><span class="color-desc" style="white-space:normal"><?php echo htmlentities((isset($vo['content']) && ($vo['content'] !== '')?$vo['content']:'-')); ?></span><?php endif; ?></td><td class='text-left nowrap'><p class="color-text"><?php echo htmlentities((isset($vo['geoip']) && ($vo['geoip'] !== '')?$vo['geoip']:'-')); ?></p><p class="color-desc"><?php echo htmlentities((isset($vo['isp']) && ($vo['isp'] !== '')?$vo['isp']:'-')); ?></p></td><td class='text-left nowrap'>
                日期：<?php echo str_replace(' ','<br><span class="color-desc">时间：',format_datetime($vo['create_at'])); ?></span></td><td class='text-left nowrap'><!--<?php if(auth("remove")): ?>--><a class="layui-btn layui-btn-xs layui-btn-danger" data-confirm="确定要删除该日志吗？" data-action="<?php echo url('remove'); ?>" data-value="id#<?php echo htmlentities($vo['id']); ?>" data-csrf="<?php echo systoken('remove'); ?>">删 除</a><!--<?php endif; ?>--></td></tr><?php endforeach; ?></tbody><?php endif; ?></table><?php if(empty($list) || (($list instanceof \think\Collection || $list instanceof \think\Paginator ) && $list->isEmpty())): ?><span class="notdata">没有记录哦</span><?php else: ?><?php echo (isset($pagehtml) && ($pagehtml !== '')?$pagehtml:''); ?><?php endif; ?></div></div><script>
    (function (layers) {
        $('body').off('click', '[data-tips-desc]').on('click', '[data-tips-desc]', function () {
            return layers.push(layer.tips($(this).find('textarea').html(), this, {tips: 3, time: 0, maxWidth: 500})), false;
        }).off('click', '.layui-body').on('click', '.layui-body', function () {
            layers.forEach(function (value, index) {
                layer.close(value), delete layers[index];
            });
        });
        $(window).on('hashchange', function () {
            $('.layui-body').trigger('click');
        });
    })([]);
</script></div>