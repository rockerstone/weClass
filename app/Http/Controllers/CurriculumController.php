<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class CurriculumController extends Controller
{
    public function index(){
        if(Auth::check()){
            return redirect()->route('CurQuery');
        }else{
            return redirect()->route('CurImportF');
        }
    }

    public function query(){
        if(!Auth::check()){
            return redirect()->route('OrgIndex');
        }
        $course = $this->curriculum();
        $data = $this->check($course);
        return view("curriculum_query")->with('data', $data);
    }

    public function import_form(){
        return view("curriculum_import");
    }

    public function import(Request $request){
        $data = $request->except("_token");
        $Parameter = $data['org_code'].' '.$data['stuid'].' '.$data['stupwd'];
        $App = env("App");
        $Script = env("Script");
        $String = $App.' '.$Script.' '.$Parameter;
        var_dump($String);
        exec($String,$output);
        $output=mb_convert_encoding($output[0], 'UTF-8', 'UTF-8,GBK,GB2312,BIG5');
        if($output != 'true'){
            $error="录入失败 ".substr($output,6);
        }else{
            $error="录入成功";
        }
        return redirect()->route('CurImportF')->withInput()->withErrors($error);
    }

    private function curriculum(){
        $course=array();
        $data['org_id'] = Auth::user()->org_id;
        $stuids = DB::table("personnel")->where("org_id",$data['org_id'])->pluck('stuid');
        foreach ($stuids as $stuid) {
            $cs= DB::table("course")->where("stuid",$stuid)->get();
            foreach ($cs as $c){
                $curriculum['name']=$c->name;
                $curriculum['day']=$c->day;
                $curriculum['time_start']=$c->time_start;
                $curriculum['time_end']=$c->time_end;
                $curriculum['week']=$c->week;
                $course[]=$curriculum;
            }
        }
        return $course;
    }

    private function check($course){
        $data=array(array(array()));
        for($week=1;$week<=20;$week++){
            for($day=1;$day<=7;$day++){
                for($time=1;$time<=10;$time++){
                    $data[$week][$day][$time]=0;
                }
            }
        }
        foreach ($course as $c){
            $weeks = explode(",",chop($c['week'],","));
            foreach ($weeks as $week){
                for($time=$c['time_start'];$time<=$c['time_end'];$time++){
                    $data[$week][$c['day']][$time]+=1;
                }
            }
        }
        return $data;
    }
}
