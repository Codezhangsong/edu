<?php

namespace App\Http\Controllers;

use App\Model\Students;
use Carbon\Carbon;
use Illuminate\Http\Request;
use mysql_xdevapi\Exception;

class StudentsController extends Controller
{
    public function search(Request $request)
    {
        $id  = $request->input('id');
        $intention  = $request->input('intention');
        $regTime  = $request->input('regTime');

        $where[] = [
            'is_del','=',1
        ];
        if($id){
            $where[] = [
                'id','=',$id
            ];
        }
        if($intention){
            $where[] = [
                'intention','=',$intention
            ];
        }
        if($regTime){
            $where[] = [
                'regTime','=',$regTime
            ];
        }
            $data = Students::where($where)->get()->toArray();

        if($data){
            return response()->json(['code'=>200,'msg'=>'ok','data'=>$data]);
        }else{
            return response()->json(['code'=>404,'msg'=>'暂无数据']);
        }
    }

    public function add(Request $request)
    {
        $name  = $request->input('name','张三');
        $parentName  = $request->input('parentName','张三爹');
        $parentMobile  = $request->input('parentMobile','张三');
        $gender  = $request->input('gender',2);
        $school  = $request->input('school','第一中学');
        $origin  = $request->input('origin','web');
        $intention  = $request->input('intention','雅思');
        $birthday  = $request->input('birthday');
        $datetime = Carbon::now();

        if(!isset($name) || empty($name)){
            return response()->json(['code'=>301,'msg'=>'学生姓名不可为空']);
        }
        if(!isset($parentName) || empty($parentName)){
            return response()->json(['code'=>301,'msg'=>'家长姓名不可为空']);
        }
        if(!isset($parentMobile) || empty($parentMobile)){
            return response()->json(['code'=>301,'msg'=>'家长电话不可为空']);
        }
        if(!isset($gender) || empty($gender)){
            return response()->json(['code'=>301,'msg'=>'性别不可为空']);
        }
        if(!isset($birthday) || empty($birthday)){
            return response()->json(['code'=>301,'msg'=>'生日不可为空']);
        }
        if(!isset($school) || empty($school)){
            return response()->json(['code'=>301,'msg'=>'学校不可为空']);
        }
        if(!isset($origin) || empty($origin)){
            return response()->json(['code'=>301,'msg'=>'来源不可为空']);
        }
        if(!isset($intention) || empty($intention)){
            return response()->json(['code'=>301,'msg'=>'意向课程不可为空']);
        }

        $age = $this->birthdayTransLate($birthday);

        $insert = [
            'name'=>$name,
            'parent_name'=>$parentName,
            'parent_mobile'=>$parentMobile,
            'gender'=>$gender,
            'birthday'=>$birthday,
            'age'=>$age,
            'school'=>$school,
            'origin'=>$origin,
            'intention'=>$intention,
            'created_at'=>$datetime,
            'reg_date'=>$datetime->toDateString(),
            'updated_at'=>$datetime,
        ];
        try{
            $res = Students::insert($insert);
            if(!$res){
            }
        }catch (Exception $e){

        }
        if($res){
            return response()->json(['code'=>200,'msg'=>'ok']);
        }else{
            return response()->json(['code'=>404,'msg'=>'添加失败']);
        }
    }

    public function edit(Request $request)
    {
        $datetime = Carbon::now();
        $id  = $request->input('id',1);
        $name  = $request->input('name','李四');
        $parentName  = $request->input('parentName');
        $parentMobile  = $request->input('parentMobile');
        $gender  = $request->input('gender');
        $birthday  = $request->input('birthday');
        $school  = $request->input('school');
        $origin  = $request->input('origin');
        $intention  = $request->input('intention');

        if(!isset($id) || empty($id)){
            return response()->json(['code'=>301,'msg'=>'id不能为空']);
        }
        if(!isset($name) || empty($name)){
            return response()->json(['code'=>301,'msg'=>'学生姓名不可为空']);
        }
        if(!isset($parentName) || empty($parentName)){
            return response()->json(['code'=>301,'msg'=>'家长姓名不可为空']);
        }
        if(!isset($parentMobile) || empty($parentMobile)){
            return response()->json(['code'=>301,'msg'=>'家长电话不可为空']);
        }
        if(!isset($gender) || empty($gender)){
            return response()->json(['code'=>301,'msg'=>'性别不可为空']);
        }
        if(!isset($birthday) || empty($birthday)){
            return response()->json(['code'=>301,'msg'=>'生日不可为空']);
        }
        if(!isset($school) || empty($school)){
            return response()->json(['code'=>301,'msg'=>'学校不可为空']);
        }
        if(!isset($origin) || empty($origin)){
            return response()->json(['code'=>301,'msg'=>'来源不可为空']);
        }
        if(!isset($intention) || empty($intention)){
            return response()->json(['code'=>301,'msg'=>'意向课程不可为空']);
        }

        $studentObj = Students::find($id);
        if(!$studentObj){
            return response()->json(['code'=>404,'msg'=>'该学生不存在']);
        }
        $studentObj->name = $name;
        $studentObj->parent_name = $parentName;
        $studentObj->parent_mobile = $parentMobile;
        $studentObj->gender = $gender;
        $studentObj->name = $name;
        $studentObj->birthday = $birthday;
        $studentObj->age = $this->birthdayTransLate($birthday);
        $studentObj->school = $school;
        $studentObj->origin = $origin;
        $studentObj->intention = $intention;
        $studentObj->updated_at = $datetime;
        $res = $studentObj->save();
        if($res){
            return response()->json(['code'=>200,'msg'=>'ok']);
        }else{
            return response()->json(['code'=>500,'msg'=>'编辑失败']);
        }
    }

    public function del(Request $request)
    {
        $ids  = $request->input('ids');
        $id_arr = json_decode($ids,true);
        if(empty($id_arr)){
            return response()->json(['code'=>301,'msg'=>'id不能为空']);
        }
        $err = [];
        foreach ($id_arr as $key=>$id)
        {
            $studentObj = Students::find($id);
            if(!$studentObj){
                $err[] = $id;
                continue;
            }
            $studentObj->is_del = 2;
            $studentObj->updated_at = Carbon::now();
            $res = $studentObj->save();
            if(!$res){
                $err[] = $id;
            }
        }
        return response()->json(['code'=>200,'msg'=>'删除成功,失败个数为'.count($err)]);
    }

    public function get(Request $request)
    {
        $id = $request->input('id');
        if(!isset($id) || empty($id)){
            return response()->json(['code'=>301,'msg'=>'id不能为空']);
        }
        $data = Students::find($id)->toArray();
        if(empty($data)){
            return response()->json(['code'=>404,'msg'=>'id不存在']);
        }
        return response()->json(['code'=>200,'msg'=>'查询成功','data'=>$data]);
    }

    public function generate(Request $request)
    {
        $datetime = Carbon::now();
        $name  = $request->input('name','张三');
        if(!isset($name) || empty($name)){
            return response()->json(['code'=>301,'msg'=>'学生姓名不可为空']);
        }
        $parentName  = $request->input('parentName','张三爹');
        $parentMobile  = $request->input('parentMobile','张三');
        $gender  = $request->input('gender',2);
        $birthday  = $request->input('birthday',$datetime);
        $school  = $request->input('school','第一中学');
        $origin  = $request->input('origin','web');
        $intention  = $request->input('intention','雅思');

        $insert = [
            'name'=>$name,
            'parents_name'=>$parentName,
            'parentMobile'=>$parentMobile,
            'gender'=>$gender,
            'birthday'=>$birthday,
            'school'=>$school,
            'origin'=>$origin,
            'intention'=>$intention,
            'created_at'=>$datetime,
            'updated_at'=>$datetime,
        ];

        $res = Students::insert($insert);
    }

    /***
     * @param $birthday Y-m-d
     * @return int
     */
    public function birthdayTransLate($birthday)
    {
        $age = strtotime($birthday);
        if($age === false){
            return false;
        }
        list($y1,$m1,$d1) = explode("-",date("Y-m-d",$age));
        $now = strtotime("now");
        list($y2,$m2,$d2) = explode("-",date("Y-m-d",$now));
        $age = $y2 - $y1;
        if((int)($m2.$d2) < (int)($m1.$d1)){
            $age -= 1;
        }
        return $age;
    }
}
