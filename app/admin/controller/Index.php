<?php

namespace app\admin\controller;
use app\admin\model\AuthRule;
use app\common\controller\Backend;
use http\Cookie;
use think\facade\View;
use think\facade\Db;
use think\facade\Cache;
use think\facade\Session;
use app\common\lib\Menu;
class Index extends Backend{

    public function initialize()
    {
        parent::initialize(); // TODO: Change the autogenerated stub

    }

    /**
     * @return string
     * @throws \Exception
     * 首页
     */
    public function index(){
        // 所有显示的菜单；
        $admin_id = Session::get('admin.id');
//        $menus = Cache::get('adminMenus_'.$admin_id);
//        if(!$menus){
//            $cate = AuthRule::where('menu_status',1)->order('sort asc')->select()->toArray();
//            $menus = Menu::authMenu($cate);
//            cache('adminMenus_'.$admin_id,$menus,['expire'=>3600]);
//
//        }
//        $href = (string)url('main');
//        $home = ["href"=>$href,"icon"=>"fa fa-home","title"=>"首页"];
//        $menusinit =['menus'=>$menus,'home'=>$home];
//        View::assign('menus',json_encode($menusinit));
        return view();
    }
    public function menus(){
        $admin_id = Session::get('admin.id');
        $menus = json_decode(cookie('adminMenus_'.$admin_id));
        if(!$menus){
            $cate = AuthRule::where('menu_status',1)->order('sort asc')->select()->toArray();
            $menus = Menu::authMenu($cate);
//            cookie('adminMenus_'.$admin_id,json_encode($menus),['expire'=>3600]);
        }
        $href = (string)url('main');
        $home = ["href"=>$href,"icon"=>"fa fa-home","title"=>"首页"];
        $logoInfo = ["title"=> "CMS", "image"=> "/static/admin/images/logo.png", "href"=>"/"];
        $menusinit =['menuInfo'=>$menus,'homeInfo'=>$home,'logoInfo'=>$logoInfo];
       return  json($menusinit);

    }

    /**
     * @return string
     * @throws \think\db\exception\BindParamException
     * @throws \think\db\exception\PDOException
     * 主页面
     */
    public function main(){
//        $version = Db::query('SELECT VERSION() AS ver');
//        $version = [0=>1];
        $config = Cache::get('main_config');
        if(!$config){
            $config  = [
                'url'             => $_SERVER['HTTP_HOST'],
                'document_root'   => $_SERVER['DOCUMENT_ROOT'],
                'document_protocol'   => $_SERVER['SERVER_PROTOCOL'],
                'server_os'       => PHP_OS,
                'server_port'     => $_SERVER['SERVER_PORT'],
                'server_ip'       => $_SERVER['REMOTE_ADDR'],
                'server_soft'     => $_SERVER['SERVER_SOFTWARE'],
                'server_file'     => $_SERVER['SCRIPT_FILENAME'],
                'php_version'     => PHP_VERSION,
//                'mysql_version'   => $version[0]['ver'],
                'max_upload_size' => ini_get('upload_max_filesize'),
            ];
            Cache::set('main_config',$config,3600);
        }

        View::assign('config', $config);

        return view();
    }



}