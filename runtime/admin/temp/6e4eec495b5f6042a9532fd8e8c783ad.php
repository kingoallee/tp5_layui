<?php /*a:1:{s:54:"/www/php/work/tp5_layui/app/admin/view/index/main.html";i:1607481621;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>主页面</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="stylesheet" href="/static/plugins/font-awesome-4.7.0/css/font-awesome.min.css" media="all">
    <link rel="stylesheet" href="/static/admin/css/main.css" media="all">
    <link rel="stylesheet" href="/static/plugins/layui/css/layui.css" media="all">
    <style>
        .layui-card {border:1px solid #f2f2f2;border-radius:5px;}
        .icon {margin-right:10px;color:#1aa094;}
        .icon-cray {color:#ffb800!important;}
        .icon-blue {color:#1e9fff!important;}
        .icon-tip {color:#ff5722!important;}
        .lemo-qiuck-module {text-align:center;margin-top: 10px}
        .lemo-qiuck-module a i {display:inline-block;width:100%;height:60px;line-height:60px;text-align:center;border-radius:2px;font-size:30px;background-color:#F8F8F8;color:#333;transition:all .3s;-webkit-transition:all .3s;}
        .lemo-qiuck-module a cite {position:relative;top:2px;display:block;color:#666;text-overflow:ellipsis;overflow:hidden;white-space:nowrap;font-size:14px;}
        .welcome-module {width:100%;height:210px;}
        .panel {background-color:#fff;border:1px solid transparent;border-radius:3px;-webkit-box-shadow:0 1px 1px rgba(0,0,0,.05);box-shadow:0 1px 1px rgba(0,0,0,.05)}
        .panel-body {padding:10px}
        .panel-title {margin-top:0;margin-bottom:0;font-size:12px;color:inherit}
        .label {display:inline;padding:.2em .6em .3em;font-size:75%;font-weight:700;line-height:1;color:#fff;text-align:center;white-space:nowrap;vertical-align:baseline;border-radius:.25em;margin-top: .3em;}
        .layui-red {color:red}
        .main_btn > p {height:40px;}
        .box3{text-align: center;line-height: 200px;}
        .layui-bg-number {background-color:#F8F8F8;}
        .lemo-notice:hover {background:#f6f6f6;}
        .lemo-notice {padding:7px 16px;clear:both;font-size:12px !important;cursor:pointer;position:relative;transition:background 0.2s ease-in-out;}
        .lemo-notice-title,.lemo-notice-label {
            padding-right: 70px !important;text-overflow:ellipsis!important;overflow:hidden!important;white-space:nowrap!important;}
        .lemo-notice-title {line-height:28px;font-size:14px;}
        .lemo-notice-extra {position:absolute;top:50%;margin-top:-8px;right:16px;display:inline-block;height:16px;color:#999;}
    </style>
</head>
<body>
<div class="box3">
    欢迎使用内容管理系统
</div>

<script src="/static/plugins/layui/layui.js" charset="utf-8"></script>
<script src="/static/plugins/echarts/echarts.min.js" charset="utf-8"></script>
<script src="/static/plugins/echarts/echarts-theme.js" charset="utf-8"></script>

<script>
    layui.config({
        base: "/static"
    }).extend({
        "Admin": "/admin/js/Admin",
        "miniTab": "/plugins/lay-module/layuimini/miniTab"
    });
    layui.use(['layer', 'Admin','miniTab','element'], function () {
        var $ = layui.jquery,
            layer = layui.layer;
        var miniTab = layui.miniTab;
        var element  = layui.element ;

        $('body').on('click', '[lemo-href]', function () {
            var loading = layer.load(0, {shade: false, time: 2 * 1000});
            var tabId = $(this).attr('lemo-href'),
                href = $(this).attr('lemo-href'),
                title = $(this).text(),
                target = $(this).attr('target');
            if (target === '_blank') {
                layer.close(loading);
                window.open(href, "_blank");
                return false;
            }
            if (tabId === null || tabId === undefined) tabId = new Date().getTime();
            var checkTab = miniTab.check(tabId);
            if (!checkTab) miniTab.create(tabId, href, title, true,1);
            parent.layui.element.tabChange('lemoTab', tabId);
            layer.close(loading);
        });
        /**
         * 查看公告信息
         **/
        $('body').on('click', '.lemo-notice', function () {
            var title = $(this).children('.lemo-notice-title').text(),
                noticeTime = $(this).children('.lemo-notice-extra').text(),
                content = $(this).children('.lemo-notice-content').html();
            var html = '<div style="padding:15px 20px; text-align:justify; line-height: 22px;border-bottom:1px solid #e2e2e2;background-color: #2f4056;color: #ffffff">\n' +
                '<div style="text-align: center;margin-bottom: 20px;font-weight: bold;border-bottom:1px solid #718fb5;padding-bottom: 5px"><h4 class="text-danger">' + title + '</h4></div>\n' +
                '<div style="font-size: 12px">' + content + '</div>\n' +
                '</div>\n';
            parent.layer.open({
                type: 1,
                title: '系统公告'+'<span style="float: right;right: 1px;font-size: 12px;color: #b1b3b9;margin-top: 1px">'+noticeTime+'</span>',
                area: '300px;',
                shade: 0.8,
                id: 'lemo-notice',
                btn: ['查看', '取消'],
                btnAlign: 'c',
                moveType: 1,
                content:html,
                success: function (layero) {
                    var btn = layero.find('.layui-layer-btn');
                    btn.find('.layui-layer-btn0').attr({
                        href: '/',
                        target: '_blank'
                    });
                }
            });
        });

        /**
         * 报表功能
         */
        var echartsRecords = echarts.init(document.getElementById('echarts-records'), 'walden');
        var optionRecords = {
            tooltip: {
                trigger: 'axis'
            },
            legend: {
                data:['邮件营销','联盟广告','视频广告','直接访问','搜索引擎']
            },
            grid: {
                left: '3%',
                right: '4%',
                bottom: '3%',
                containLabel: true
            },
            toolbox: {
                feature: {
                    saveAsImage: {}
                }
            },
            xAxis: {
                type: 'category',
                boundaryGap: false,
                data: ['周一','周二','周三','周四','周五','周六','周日']
            },
            yAxis: {
                type: 'value'
            },
            series: [
                {
                    name:'邮件营销',
                    type:'line',
                    stack: '总量',
                    data:[120, 132, 101, 134, 90, 230, 210]
                },
                {
                    name:'联盟广告',
                    type:'line',
                    stack: '总量',
                    data:[220, 182, 191, 234, 290, 330, 310]
                },
                {
                    name:'视频广告',
                    type:'line',
                    stack: '总量',
                    data:[150, 232, 201, 154, 190, 330, 410]
                },
                {
                    name:'直接访问',
                    type:'line',
                    stack: '总量',
                    data:[320, 332, 301, 334, 390, 330, 320]
                },
                {
                    name:'搜索引擎',
                    type:'line',
                    stack: '总量',
                    data:[820, 932, 901, 934, 1290, 1330, 1320]
                }
            ]
        };
        echartsRecords.setOption(optionRecords);

        // echarts 窗口缩放自适应
        window.onresize = function(){
            echartsRecords.resize();
        }

    });
</script>
</body>
</html>