<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
class admin extends Model
{
    use HasFactory;


    //insertdata get id

    public function InserDataGetId($table,$data){
        $result = DB::table($table)->insertGetId($data);
        return $result;
    }

    //insert function
    public function InsertData($table,$data){
        $result = DB::table($table)->insert($data);
        return $result;
    }

    //update data
    public function UpdateDate($table,$key,$id,$data){
        $result = DB::table($table)->where($key,$id)->update($data);
        return $result;
    }
    //getalldata

    public function GetAllData($table){
        $result = DB::table($table)->get();
        return $result;
    }
    public function GetDataByConditionSingal($table,$key){
        $result = DB::table($table)->where($key)->first();
        return $result;
    }
    public function GetDataByCondition($table,$key){
        $result = DB::table($table)->where($key)->get();
        return $result;
    }

}
