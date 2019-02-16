<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Org;
use App\Manager;

class OrganizationController extends Controller
{
    public function index(){
        if(Auth::check()){
            return redirect()->route('OrgManage');
        }else{
            return view("login");
        }
    }

    public function user(Request $request){
        $this->validate($request,[
            'log'=>'required|in:in,out',
        ]);
        $log = $request->only("log")['log'];
        if($log=='in'){
            $this->validate($request,[
                'username'=>'required',
                'password'=>'required',
            ]);
            $credentials = $request->only('username', 'password');
            if (Auth::attempt($credentials)) {
                return redirect()->route('OrgIndex');
            }else{
                return redirect()->route('OrgIndex')->withInput()->withErrors("用户名或密码错误");
            }
        }elseif($log=='out'){
            Auth::logout();
            return redirect()->route('Index');
        }
    }

    public function create_form(){
        return view("org_create");
    }

    public function create(Request $request){
        $this->validate($request,[
            'org_name'=>'required',
            'username'=>'required',
            'email'=>'required|email',
            'password'=>'required',
            'repassword'=>'required|same:password',
        ]);
        $data = $request->except("_token");
        //var_dump($data);
        $org = new Org([
            'name'=>$data['org_name'],
            'code'=>time().substr(microtime(),2,2)
        ]);
        if($org->check_error()){
            return back()->withInput()->withErrors($org->error);
        }
        $org->save();
        $id=$org->where('code',$org->code)->first()->id;
        $manager = new Manager([
            'username'=>$data['username'],
            'email'=>$data['email'],
            'password'=>Hash::make($data['password']),
            'org_id'=>$id,
            'role'=>1
        ]);
        if($manager->check_error()){
            return back()->withInput()->withErrors($manager->error);
        }
        $manager->save();
        return redirect()->route("OrgIndex")->withErrors("注册成功");
    }

    public function manage(){
        if(!Auth::check()){
            return view("login");
        }
        $data['username'] = Auth::user()->username;
        $data['org_id'] = Auth::user()->org_id;
        $data['role'] = Auth::user()->role;
        $result = Org::where('id',$data['org_id'])->first();
        $data['name']=$result->name;
        $data['year']=$result->year;
        $data['term']=$result->term;
        $data['code']=$result->code;
        $data['description']=$result->description;
        $data['personnel']=$this->personnel($data['org_id']);
        return view("org_manage",$data);
    }

    public function manage_edit(Request $request){
        if(!Auth::check()){
            return view("login");
        }
        $data=$request->except("_token");
        $org=Org::find(Auth::user()->org_id);
        $org->description=$data['description'];
        $org->save();
        return redirect()->route("OrgManage");
    }

    private function personnel($org_id){
        $persons=array();
        $result = DB::table("personnel")->where("org_id",$org_id)->get();
        foreach ($result as $person){
            $p['stuid']=$person->stuid;
            $p['name']=$person->name;
            $p['college']=$person->college;
            $p['major']=$person->major;
            $p['class']=$person->class;
            $persons[]=$p;
        }
        return $persons;
    }
}