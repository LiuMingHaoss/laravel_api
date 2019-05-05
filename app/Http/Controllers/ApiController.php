<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\UserModel;
class ApiController extends Controller
{
    //用户信息接口
    public function userApi(Request $request){
        $uid=$request->input('id');
        $user_info=UserModel::where('id',$uid)->first();
        $data=[];
        if($user_info){
            $data=[
                'errno'=>0,
                'msg'=>'ok',
                'data'=>$user_info
            ];
        }
        die(json_encode($data));
    }

    //用户注册接口
    public function userReg(Request $request){
        $userInfo=$request->input();
        $res=UserModel::insertGetId($userInfo);
        $data=[];
        if($res){
            $data=[
              'errno'=>0,
              'msg' =>'ok'
            ];
        }else{
            $data=[
              'errno'=>40001,   //错误返回码
              'msg'=>'no'
            ];
        }
        die(json_encode($data));
    }

}
