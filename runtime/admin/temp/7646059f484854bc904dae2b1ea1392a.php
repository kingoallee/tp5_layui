<?php /*a:3:{s:64:"/www/php/work/tp5_layui/app/admin/view/sys/database/restore.html";i:1607481621;s:57:"/www/php/work/tp5_layui/app/admin/view/common/header.html";i:1607481621;s:57:"/www/php/work/tp5_layui/app/admin/view/common/footer.html";i:1607481621;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title><?php echo config('admin.sys_name'); ?>后台管理</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="format-detection" content="telephone=no">
    <link rel="stylesheet" href="/static/plugins/layui/css/layui.css" media="all" />
    <link rel="stylesheet" href="/static/admin/css/main.css?v=<?php echo time(); ?>" media="all">
    <link rel="stylesheet" href="/static/plugins/font-awesome-4.7.0/css/font-awesome.min.css" media="all">
    <!--[if lt IE 9]>
    <script src="https://cdn.staticfile.org/html5shiv/r29/html5.min.js"></script>
    <script src="https://cdn.staticfile.org/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style id="lemo-bg-color">
    </style>
</head>
<div class="LM-container">
    <div class="LM-main">

    <div class="admin-main layui-anim layui-anim-upbit">
    <fieldset class="layui-elem-field layui-field-title">
        <legend>备份文件<?php echo lang('list'); ?></legend>
    </fieldset>
    <table class="layui-table" id="list" lay-filter="list"></table>
</div>
    </div>
</div>
<script src="/static/plugins/layui/layui.js" charset="utf-8"></script>
<!--<script>-->
<!--    layui.config({-->
<!--        base: "/static/admin/js/",-->
<!--        version: true-->
<!--    }).extend({-->
<!--        Admin: 'Admin'-->
<!--    }).use(['Admin'], function () {-->
<!--        Admin = layui.Admin;-->
<!--    });-->
<!--</script>-->

<script type="text/html" id="action">
    <a class="layui-btn layui-btn-normal layui-btn-xs" lay-event="recover">恢复</a>
    <a href="<?php echo url('downFile'); ?>?time={{d.time}}" class="layui-btn layui-btn-xs">下载</a>
    <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del"><?php echo lang('del'); ?></a>
</script>
<script type="text/html" id="time">
    {{layui.util.toDateString(d.time*1000, 'yyyy-MM-dd HH:mm:ss')}}
</script>
<script>
    layui.use('table', function() {
        var table = layui.table, $ = layui.jquery;
        table.render({
            elem: '#list'
            ,url: '<?php echo url("restore"); ?>',
            method:'post'
            ,cols: [[
                {field:'name', title: '文件名称', width:250},
                {field:'size', title: '文件大小', width:200,sort:true},
                {field:'time', title: '备份时间', width:200,sort:true,templet: '#time'},
                {title:'操作',minWidth:150, toolbar: '#action',align:"center"} ,           ]]
        });
        table.on('tool(list)', function(obj) {
            var data = obj.data;
            if (obj.event === 'recover') {
                layer.confirm('确认要导入数据吗？',{icon: 0}, function (index) {
                    loading = layer.load(1, {shade: [0.1, '#fff']});
                    $.post("<?php echo url('import'); ?>",{time:data.time},function(res){
                        layer.close(loading);
                        if(res.code>0){
                            layer.msg(res.msg, {time: 1000,icon:1});
                        }else{
                            layer.msg(res.msg, {time: 1000,icon:2});
                        }
                    });
                    layer.close(index);
                });
            }else if(obj.event === 'del'){
                layer.confirm('确认要删除该备份文件吗？', {icon: 3}, function (index) {
                    loading = layer.load(1, {shade: [0.1, '#fff']});
                    $.post('<?php echo url("delSqlFiles"); ?>',{time: data.time}, function (res) {
                        layer.close(loading);
                        if (res.code > 0) {
                            layer.msg(res.msg, {time: 1000,icon:1});
                            obj.del();
                        }else{
                            layer.msg(res.msg,{time: 1000,icon:2});
                        }
                    });
                    layer.close(index);
                });
            }
        });
    });
</script>