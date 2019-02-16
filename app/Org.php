<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Org extends Model
{
    protected $table = 'org';
    protected $primaryKey='id';
    public $incrementing=true;
    public $timestamps=false;
    protected $guarded=['id'];
    public $error;

    public function check_error(){
        var_dump($this->name);
        var_dump($this->code);
        $result=Org::where('name',$this->name)->get();
        if($result->count()) {
            $this->error = ["组织名称已存在，请更换"];
            return true;
        }elseif(Org::where('code',$this->code)->get()->count()){
            $this->error = ["服务器已超过最大负荷，请稍后重试"];
            return true;
        }
        return false;
    }
}
