<?php


return [
     \think\middleware\LoadLangPack::class,

     \think\middleware\SessionInit::class,
    //访问频率
    \think\middleware\Throttle::class,
    //跨域
    \think\middleware\AllowCrossDomain::class

];

