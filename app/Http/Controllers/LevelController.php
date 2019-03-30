<?php

namespace App\Http\Controllers;

use App\Model\Level;
use Carbon\Carbon;
use Illuminate\Http\Request;

class LevelController extends Controller
{
    public function search()
    {
        $where = [
            ['is_show','=',1],
            ['is_del','=',1],
        ];

        $data = Level::where($where)->get()->toArray();

        if(empty($data)){
            return response()->json(['code'=>404,'msg'=>'暂无数据']);
        }

        return response()->json(['code'=>200,'msg'=>'查询成功','data'=>$data]);
    }

    public function add(Request $request)
    {
        $levelName = $request->input('levelName');
        $desc = $request->input('desc');

        if(!isset($levelName) || empty($levelName)){
            return response()->json(['code'=>301,'msg'=>'等级未填写']);
        }

        $insert = [
            'level_name'=>$levelName,
            'desc'=>$desc,
            'updated_at'=>Carbon::now(),
            'created_at'=>Carbon::now(),
        ];
        $res = Level::insert($insert);
        if(!$res){
            return response()->json(['code'=>500,'msg'=>'新增失败']);
        }else{
            return response()->json(['code'=>200,'msg'=>'新增成功']);
        }
    }

    public function edit(Request $request)
    {
        $id = $request->input('id');
        $levelName = $request->input('levelName');
        $desc = $request->input('desc');
        $isShow = $request->input('isShow',1);
        if(!isset($id) || empty($id)){
            return response()->json(['code'=>301,'msg'=>'id未填写']);
        }
        if(!isset($levelName) || empty($levelName)){
            return response()->json(['code'=>301,'msg'=>'等级未填写']);
        }
        $tagObj = Level::find($id);
        if(!$tagObj){
            return response()->json(['code'=>404,'msg'=>'该id不存在']);
        }
        $tagObj->level_name = $levelName;
        $tagObj->desc = $desc;
        $tagObj->updated_at = Carbon::now();
        $tagObj->is_show = $isShow;
        $res = $tagObj->save();
        if(!$res){
            return response()->json(['code'=>500,'msg'=>'编辑失败']);
        }else{
            return response()->json(['code'=>200,'msg'=>'编辑成功']);
        }
    }

    public function del(Request $request)
    {
        $ids  = $request->input('ids');
        $err = [];
        $id_arr = json_decode($ids,true);
        if(empty($id_arr)){
            return response()->json(['code'=>301,'msg'=>'id不能为空']);
        }

        foreach ($id_arr as $key=>$id)
        {
            $tagObj = Level::find($id)->first();
            if(!$tagObj){
                $err[] = $id;
                continue;
            }
            $tagObj->is_del = 2;
            $tagObj->updated_at = Carbon::now();
            $res = $tagObj->save();
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
        $data = Level::find($id);
        if(empty($data)){
            return response()->json(['code'=>404,'msg'=>'id不存在']);
        }
        $data = $data->toArray();
        return response()->json(['code'=>200,'msg'=>'查询成功','data'=>$data]);
    }
}
