<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\UserModel;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Redis;
class UserController extends Controller
{
    //用户注册
    public function userReg(Request $request){
        $email=$request->input('email');
        $pass1=$request->input('password');
        $pass2=$request->input('repwd');

        //验证两次密码一致
        if($pass1!==$pass2){
            $response=[
                'errno'=>40002,
                'msg'=>'两次密码不一致',
            ];
            die(json_encode($response,JSON_UNESCAPED_UNICODE));
        }
        $password=password_hash($request->input('password'),PASSWORD_DEFAULT);  //密码加密
        $res=UserModel::where('email',$email)->first();

        if($res){       //验证邮箱唯一性
            $response=[
                'errno'=>40001,
                'msg'=>'该邮箱已注册',
            ];
            die(json_encode($response,JSON_UNESCAPED_UNICODE));
        }else{
            $info=[
                'username'=>$request->input('username'),
                'email'=>$email,
                'age'=>$request->input('age'),
                'sex'=>$request->input('sex'),
                'password'=>$password,
                'create_time'=>time(),
            ];
            $uid=UserModel::insertGetId($info);     //信息入库
            if($uid){
                $response=[
                    'errno'=>0,
                    'msg'=>'ok',
                ];
                die(json_encode($response,JSON_UNESCAPED_UNICODE));
            }else{
                $response=[
                    'errno'=>50001,
                    'msg'=>'注册失败',
                ];
                die(json_encode($response,JSON_UNESCAPED_UNICODE));
            }
        }
    }

    //用户登录
    public function userLogin(Request $request){
        //接收用户名 密码
        $email=$request->input('email');
        $password=$request->input('password');
        $res=UserModel::where('email',$email)->first();
        //判断用户是否存在
        if($res){
            $a=password_verify($password,$res->password);
            $uid=$res->id;
            if($a){     //判断密码是否正确
                $access_token=$this->getAccessToken($uid);
                $key='token:uid:'.$uid;
                Redis::set($key,$access_token);
                Redis::expire($key,604800);
                $response=[
                    'errno'=>0,
                    'msg'=>'ok',
                    'data'=>[
                        'access_token'=>$access_token
                    ]
                ];
                die(json_encode($response,JSON_UNESCAPED_UNICODE));
            }else{
                $response=[
                    'errno'=>60003,
                    'msg'=>'密码不正确',
                ];
                die(json_encode($response,JSON_UNESCAPED_UNICODE));
            }
        }else{
            $response=[
              'errno'=>60001,
              'msg'=>'用户名不存在',
            ];
            die(json_encode($response,JSON_UNESCAPED_UNICODE));
        }
    }

    //生成access_token
    public function getAccessToken($uid){
        return substr(md5($uid.time().Str::random(10)),5,15);
    }

    //个人中心
    public function userMy(){
        echo __METHOD__;
    }
}
