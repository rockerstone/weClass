<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Manager extends Authenticatable
{
    protected $table = 'manager';
    protected $primaryKey="id";
    public $incrementing=true;
    public $timestamps=false;
    protected $hidden=['password'];
    protected $rememberTokenName = '';
    protected $guarded=[];
    public $error;

    public function check_error(){
        $result=Manager::where('username',$this->username)->get()->count();
        if($result) {
            $this->error = ["用户名已存在，请更换"];
            return true;
        }
        return false;
    }

}
