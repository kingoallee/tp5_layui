<?php /*a:3:{s:62:"/www/php/work/tp5_layui/app/admin/view/sys/database/index.html";i:1607481621;s:57:"/www/php/work/tp5_layui/app/admin/view/common/header.html";i:1607481621;s:57:"/www/php/work/tp5_layui/app/admin/view/common/footer.html";i:1607481621;}*/ ?>
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
<style>#repair{ margin-left: 10px;}</style>
<div class="LM-container">
    <div class="LM-main">

        <fieldset class="layui-elem-field LM-search layui-field-title">
            <legend>数据库<?php echo lang('list'); ?></legend>
        </fieldset>

        <blockquote class="layui-elem-quote">
            数据库中共有<i class="count"></i> 张表，共计<i class="size"></i>
            <a href="javascript:void(0)" id="repair" class="layui-btn layui-btn-sm layui-btn-warm">修复</a>
            <a href="javascript:void(0)" id="optimize" class="layui-btn  layui-btn-sm  layui-btn-normal">优化</a>
            <a href="javascript:void(0)" id="backUp" class="layui-btn layui-btn-sm">备份</a>
        </blockquote>
        <table class="layui-hide" id="list" lay-filter="list"></table>

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


<script type="text/html" id="size">
    {{d.size}}
</script>

<script>
    layui.use(['form', 'table'], function () {
        var $ = layui.jquery,
            form = layui.form,
            table = layui.table;

        var tableIn = table.render({
            elem: '#list',
            url: '<?php echo url("index"); ?>',
            method: 'post',
            cols: [[
                {checkbox: true, fixed: true},
                {field: 'name', title: '数据库表', width: 150, fixed: true, sort: true},
                {field: 'rows', title: '记录条数', width: 150, sort: true},
                {field: 'size', title: '大小', width: 150, templet: '#size', sort: true},
                {field: 'engine', title: '类型', width: 110, sort: true},
                {field: 'collation', title: '编码', width: 150, sort: true},
                {field: 'create_time', title: '创建时间', width: 180, sort: true},
                {field: 'comment', title: '说明', width: 180},
            ]],
            done: function(res, curr, count){
                $('.count').html(res.tableNum);
                $('.size').html(res.total);
            },
            //
            limits: [10, 15, 20, 25, 50, 100],
            limit: 50,
            page: true
        });

        $('#backUp').click(function(){
            var obj = $(this);
            var checkStatus = table.checkStatus('list'); //test即为参数id设定的值
            var a = [];
            $(checkStatus.data).each(function(i,o){
                a.push(o.name);
            });
            obj.addClass('layui-btn-disabled');
            obj.html('备份进行中...');
            $.post("<?php echo url('admin/sys.database/backup'); ?>",{tables:a},function(data){
                if(data.code==1){
                    layer.msg(data.msg,{time:1000,icon:1},function(){
                        tableIn.reload();
                    });
                }else{
                    layer.msg(data.msg,{time:1000,icon:2});
                }
                obj.removeClass('layui-btn-disabled');
                obj.html('备份');
            });
        });
        $('#optimize').click(function(){
            var obj = $(this);
            var checkStatus = table.checkStatus('list'); //test即为参数id设定的值
            var a = [];
            $(checkStatus.data).each(function(i,o){
                a.push(o.name);
            });
            obj.addClass('layui-btn-disabled');
            obj.html('优化进行中...');
            $.post("<?php echo url('admin/sys.database/optimize'); ?>",{tables:a},function(data){
                if(data.code==1){
                    layer.msg(data.msg,{time:1000,icon:1},function(){
                        tableIn.reload();
                    });
                }else{
                    layer.msg(data.msg,{time:1000,icon:2});
                }
                obj.removeClass('layui-btn-disabled');
                obj.html('优化');
            });
        });
        $('#repair').click(function(){
            var obj = $(this);
            var checkStatus = table.checkStatus('list'); //test即为参数id设定的值
            var a = [];
            $(checkStatus.data).each(function(i,o){
                a.push(o.name);
            });
            obj.addClass('layui-btn-disabled');
            obj.html('修复进行中...');
            $.post("<?php echo url('admin/sys.database/repair'); ?>",{tables:a},function(data){
                if(data.code==1){
                    layer.msg(data.msg,{time:1000,icon:1},function(){
                        tableIn.reload();
                    });
                }else{
                    layer.msg(data.msg,{time:1000,icon:2});
                }
                obj.removeClass('layui-btn-disabled');
                obj.html('修复');
            });
        })
    })

</script>