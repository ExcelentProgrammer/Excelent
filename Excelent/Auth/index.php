<?php

use Excelent\Helpers\Session;
use App\Model\User;

class Auth
{
    static public function signup($data)
    {
        $res = User::insert($data)->run();
        if ($res) {
            $data['id'] = $res->InsertId;
            Session::create("AUTH", $data);
            return true;
        }
        return false;
    }
    static public function check()
    {
        if ((count(Session::get("AUTH")) != 0))
            return true;
        return false;
    }
    static public function login(array $user)
    {
        $res = User::select()->where($user)->run();
        if ($res->RowCount > 0) {
            Session::create("AUTH", $res->Data[0]);
            return true;
        }
        return false;
    }
    static public function logout()
    {
        Session::del("AUTH");
    }
    static public function getData($Data = ["*"])
    {
        $ID = Session::get("AUTH")['ID'];
        $res = User::select($Data)->where(['ID' => $ID])->run()->Data[0];
        if (is_array($Data)) {
            if (count($Data) <= 1 and $Data[0] != "*") {
                $res = $res[$Data[0]];
            }
        }else{
            $res = $res[$Data];
        }
        return $res;
    }
    static public function guest(){
        if(self::check()){
            return false;
        }else{
            return true;
        }
    }
    static public function user(){
        if(self::check()){
            return true;
        }else{
            return false;
        }
    }
}
