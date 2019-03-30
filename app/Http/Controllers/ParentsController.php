<?php

namespace App\Http\Controllers;

use App\Model\Parents;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ParentsController extends Controller
{
    public function search(Request $request)
    {
        $id = $request->input('id');
        $level = $request->input('level');
        $regDate = $request->input('regDate');

        $where[] = ['is_del','=',1];
        $where[] = ['use_flag','=',1];
        if($id){
            $where[] = ['id','=',$id];
        }
        if($level){
            $where[] = ['level','=',$level];
        }
        if($regDate){
            $where[] = ['register_date',$regDate];
        }

        $data = Parents::where($where)->get()->toArray();

        if(empty($data)){
            return response()->json(['code'=>404,'msg'=>'暂无数据']);
        }
        return response()->json(['code'=>200,'msg'=>'查询成功','data'=>$data]);

    }

    public function add(Request $request)
    {
        $name  = $request->input('name');
        $password  = $request->input('password');
        $mobile  = $request->input('mobile');
        $birthday  = $request->input('birthday');
        $gender  = $request->input('gender');
        $levelId = $request->input('levelId');
        $level  = $request->input('level');
        $city  = $request->input('city');
        $occupation  = $request->input('occupation');
        $tagId  = $request->input('tagId');
        $tagName  = $request->input('tagName');
        $useFlg = $request->input('useFlag',1);
        $datetime = Carbon::now();
        if(!isset($name) || empty($name)){
            return response()->json(['code'=>301,'msg'=>'家长姓名未填写']);
        }
        if(!isset($password) || empty($password)){
            return response()->json(['code'=>301,'msg'=>'账号密码未填写']);
        }
        if(!isset($mobile) || empty($mobile)){
            return response()->json(['code'=>301,'msg'=>'手机号未填写']);
        }
        if(!isset($birthday) || empty($birthday)){
            return response()->json(['code'=>301,'msg'=>'生日未填写']);
        }
        if(!isset($gender) || empty($gender)){
            return response()->json(['code'=>301,'msg'=>'性别未填写']);
        }
        if(!isset($levelId) || empty($levelId)){
            return response()->json(['code'=>301,'msg'=>'等级Id未填写']);
        }
        if(!isset($level) || empty($level)){
            return response()->json(['code'=>301,'msg'=>'等级未填写']);
        }
        if(!isset($city) || empty($city)){
            return response()->json(['code'=>301,'msg'=>'所在城市未填写']);
        }
        if(!isset($occupation) || empty($occupation)){
            return response()->json(['code'=>301,'msg'=>'职业未填写']);
        }
        if(!isset($tagId) || empty($tagId)){
            return response()->json(['code'=>301,'msg'=>'标签ID未填写']);
        }
        if(!isset($tagName) || empty($tagName)){
            return response()->json(['code'=>301,'msg'=>'标签名未填写']);
        }
        if(!isset($useFlg) || empty($useFlg)){
            return response()->json(['code'=>301,'msg'=>'启用状态未填写']);
        }

        $insert = [
            'name'=>$name,
            'password'=>md5($password),
            'mobile'=>$mobile,
            'gender'=>$gender,
            'birthday'=>$birthday,
            'level'=>$level,
            'city'=>$city,
            'occupation'=>$occupation,
            'tag_id'=>$tagId,
            'tag_name'=>$tagName,
            'use_flag'=>$useFlg,
            'reg_date'=>$datetime->toDateString(),
            'created_at'=>$datetime,
            'updated_at'=>$datetime,
        ];

        $res = Parents::insert($insert);
        if($res){
            return response()->json(['code'=>200,'msg'=>'添加成功']);
        }else{
            return response()->json(['code'=>400,'msg'=>'添加失败']);
        }
    }

    public function edit(Request $request)
    {
        $id  = $request->input('id');
        $name  = $request->input('name');
        $password  = $request->input('password');
        $mobile  = $request->input('mobile');
        $birthday  = $request->input('birthday');
        $gender  = $request->input('gender');
        $levelId = $request->input('levelId');
        $level  = $request->input('level');
        $city  = $request->input('city');
        $occupation  = $request->input('occupation');
        $tagId  = $request->input('tagId');
        $tagName  = $request->input('tagName');
        $useFlg = $request->input('useFlag',1);
        $datetime = Carbon::now();

        if(!isset($id) || empty($id)){
            return response()->json(['code'=>301,'msg'=>'id为空']);
        }
        if(!isset($name) || empty($name)){
            return response()->json(['code'=>301,'msg'=>'家长姓名未填写']);
        }
        if(!isset($password) || empty($password)){
            return response()->json(['code'=>301,'msg'=>'账号密码未填写']);
        }
        if(!isset($mobile) || empty($mobile)){
            return response()->json(['code'=>301,'msg'=>'手机号未填写']);
        }
        if(!isset($birthday) || empty($birthday)){
            return response()->json(['code'=>301,'msg'=>'生日未填写']);
        }
        if(!isset($gender) || empty($gender)){
            return response()->json(['code'=>301,'msg'=>'性别未填写']);
        }
        if(!isset($levelId) || empty($levelId)){
            return response()->json(['code'=>301,'msg'=>'等级Id未填写']);
        }
        if(!isset($level) || empty($level)){
            return response()->json(['code'=>301,'msg'=>'等级名称未填写']);
        }
        if(!isset($city) || empty($city)){
            return response()->json(['code'=>301,'msg'=>'所在城市未填写']);
        }
        if(!isset($occupation) || empty($occupation)){
            return response()->json(['code'=>301,'msg'=>'职业未填写']);
        }
        if(!isset($tagId) || empty($tagId)){
            return response()->json(['code'=>301,'msg'=>'标签ID未填写']);
        }
        if(!isset($tagName) || empty($tagName)){
            return response()->json(['code'=>301,'msg'=>'标签名未填写']);
        }
        if(!isset($useFlg) || empty($useFlg)){
            return response()->json(['code'=>301,'msg'=>'启用状态未填写']);
        }

        $parentObj = Parents::find($id);
        if(!$parentObj){
            return response()->json(['code'=>404,'msg'=>'查询无此id']);
        }
        $parentObj->name = $name;
        $parentObj->password = md5($password);
        $parentObj->mobile = $mobile;
        $parentObj->gender = $gender;
        $parentObj->birthday = $birthday;
        $parentObj->level_id = $levelId;
        $parentObj->level = $level;
        $parentObj->city = $city;
        $parentObj->occupation = $occupation;
        $parentObj->tag_id = $tagId;
        $parentObj->tag_name = $tagName;
        $parentObj->occupation = $occupation;
        $parentObj->use_flag = $useFlg;
        $parentObj->updated_at = $datetime;

        $res = $parentObj->save();

        if($res){
            return response()->json(['code'=>200,'msg'=>'编辑成功']);
        }else{
            return response()->json(['code'=>400,'msg'=>'编辑失败']);
        }
    }

    public function del(Request $request)
    {
        $datetime = Carbon::now();
        $ids  = $request->input('ids');
        $err = [];
        $id_arr = json_decode($ids,true);
        if(empty($id_arr)){
            return response()->json(['code'=>301,'msg'=>'id不能为空']);
        }

        foreach ($id_arr as $key=>$id)
        {
            $parentObj = Parents::find($id)->first();
            if(!$parentObj){
                $err[] = $id;
                continue;
            }
            $parentObj->is_del = 2;
            $parentObj->updated_at = $datetime;
            $res = $parentObj->save();
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
        $data = Parents::find($id)->toArray();
        if(empty($data)){
            return response()->json(['code'=>404,'msg'=>'id不存在']);
        }
        return response()->json(['code'=>200,'msg'=>'查询成功','data'=>$data]);
    }
}
