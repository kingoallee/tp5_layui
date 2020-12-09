<?php
namespace app\common\model;

class  User extends Common{

    public function __construct(array $data = [])
    {
        parent::__construct($data);
    }

    public function getProvince(){

        $this->hasOne('Region','province','id');
    }
    public function getCity(){

        $this->hasOne('Region','city','id');
    }
    public function getDistrict(){

        $this->hasOne('Region','district','id');
    }

}