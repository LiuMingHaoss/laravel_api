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

    //curl
    public function test(){
        $url='http://www.apitest.com/user?id=1';
        //初始化 cURL会话
        $ch=curl_init();
        //设置需要的全部选项
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        //执行会话
        curl_exec($ch);
        //关闭会话
        curl_close($ch);
    }

    //curl post传值
    public function curlPost(){     //  form-data
        $url='http://www.apitest.com/test/curlPost';
        $data=[
          'username'=>'Liuminghao',
          'email'=>'234@qq.com'
        ];
        $ch=curl_init();
        //设置需要的全部选项
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POSTFIELDS,  $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);    //获取页面内容 不直接输出
        //执行会话
        $info=curl_exec($ch);
        echo $info;
        //关闭会话
        curl_close($ch);
    }

    public function curlPost2(){    //application/x-www-form-urlencoded
        $url='http://www.apitest.com/test/curlPost';
        $data='username=chenyy&email=234@qq.com';
        $ch=curl_init();
        //设置url 相应的选项
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_POSTFIELDS,$data);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
        //执行会话
        $info =curl_exec($ch);
        echo $info;
        curl_close($ch);
    }

    public function curlPost3(){        //raw
        $url='http://www.apitest.com/test/curlPost';
        $data=[
            'username'=>'Liuminghao',
            'email'=>'234@qq.com'
        ];
        $json_post=json_encode($data);
        $ch=curl_init();
        //设置需要的全部选项
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POSTFIELDS,  $json_post);
        curl_setopt($ch,CURLOPT_HTTPHEADER,['Content-Type:text/plain']);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);    //获取页面内容 不直接输出
        //执行会话
        $info=curl_exec($ch);
        echo $info;
        //关闭会话
        curl_close($ch);
    }

    //中间件
    public function testMid(){
        echo __METHOD__;
    }
}
