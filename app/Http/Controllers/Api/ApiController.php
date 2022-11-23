<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\admin;
use Validator;
use Auth;
use DB;


class ApiController extends Controller{

    protected $admin;

    public function __construct(){
        $this->admin = new admin();
    }


    public function login(Request $request){
        try {
            $validateUser = Validator::make($request->all(),
            [
                'username' => 'required',
                'deviceId' => 'required',
                'email' => 'required|email',
            ]);
            if($validateUser->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 401);
            }
            if(!Auth::attempt($request->only(['email','password']))){
                $result = $this->registration($request);
                $user = User::where('email',$result)->first();
                $data['id'] = $user->id;
                $data['username'] = $user->name;
                $data['email'] = $user->email;
                $data['deviceId'] = $user->deviceId;
                $data['isUser'] = $user->isUser;
                $data['token'] = $user->createToken("API TOKEN")->accessToken;
                return response()->json([
                    'status' => 200,
                    'data'=>$data,
                ], 200);
            }
        $user = User::where('email', $request->email)->first();
        $data['id'] = $user->id;
        $data['username'] = $user->name;
        $data['email'] = $user->email;
        $data['deviceId'] = $user->deviceId;
        $data['isUser'] = $user->isUser;

        $data['token'] = $user->createToken("API TOKEN")->accessToken;
            return response()->json([
                'status' => 200,
                'data'=>$data,
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function registration($request){
        $check = DB::table('users')->where('email',$request->email)->first();
        if(empty($check)){
            $data['name'] = $request->username;
            $data['email'] = $request->email;
            $data['deviceId'] = $request->deviceId;
            $data['isUser'] = $request->isUser;
            $data['password'] = bcrypt($request->username);
            $result = $this->admin->InsertData('users',$data);
            return $request->email;
        } else {
           return false;
        }
    }

    //Spendtime

    public function Spendtime(){
        try{
        $result = DB::table('spendtime')->select('id','title','value')->get();
        if($result->count()>0){
            return response()->json([
                'status'=>200,
                'spendTime'=>$result
            ]);
        } else {
            return response()->json([
                'status'=>201,
                'spendTime'=>[]
            ]);
        }
    }catch(\Throwable $th){
        return response()->json([
            'status' => false,
            'message' => $th->getMessage()
        ], 500);
      }
    }

    public function Education(){
        try{
        $result = DB::table('education')->select('id','title','value')->get();
        if($result->count()>0){
            return response()->json([
                'status'=>200,
                'spendTime'=>$result
            ]);
        } else {
            return response()->json([
                'status'=>201,
                'spendTime'=>[]
            ]);
        }
    }catch(\Throwable $th){
        return response()->json([
            'status' => false,
            'message' => $th->getMessage()
        ], 500);
      }
    }

    public function SignUp(Request $request){
        try{
         $check = $this->admin->GetDataByConditionSingal('profile',['userid'=>$request->userid]);
          if(empty($check)){
            $data['userid'] =  $request->userid;
            $data['cnctfrnd'] =  json_encode($request->cnctFrnd);
            $data['desc'] = $request->desc;
            $data['dob'] = $request->dob;
            $data['mobileNum'] = $request->mobileNum;
            $data['whatsappNum'] = $request->whatsappNum;
            $data['drinking'] = json_encode($request->drinking);
            $data['education'] = json_encode($request->education);
            $data['email'] = $request->email;
            $data['findPartner'] = json_encode($request->findPartner);
            $data['gender'] = $request->gender;
            $data['height'] = $request->height;
            $data['location'] = $request->location;
            $data['maritalStatus'] = json_encode($request->maritalStatus);
            $data['smoking'] = json_encode($request->smoking);
            $data['spendTime'] = json_encode($request->spendTime);
            $data['username'] = $request->username;
            $data['weight'] = $request->weight;
            $result = $this->admin->InsertData('profile',$data);
            if($result==1){
                $data1['isUser'] = "1";
                $this->admin->UpdateDate('users','id',$request->userid,$data1);

                $data4['userid'] = $request->userid;
                $data4['like'] = "0";
                $data4['isLike'] = "false";
                $this->admin->InsertData('islike',$data4);

                $data5['userid'] = $request->userid;
                $data5['likes'] = "0";
                $data5['SuperLike'] = "false";
                $this->admin->InsertData('lssuperlike',$data5);
                $this->CoinWallet($request->userid);
                return response()->json(['status'=>200,'success'=>"Your Profile Save Successful!"]);
            } else {
                return response()->json(['status'=>201,'success'=>"AlReady Profile Update!"]);
            }
          } else {
                $data['userid'] =  $request->userid;
                $data['cnctfrnd'] =  json_encode($request->cnctFrnd);
                $data['desc'] = $request->desc;
                $data['dob'] = $request->dob;
                $data['mobileNum'] = $request->mobileNum;
                $data['whatsappNum'] = $request->whatsappNum;
                $data['drinking'] = json_encode($request->drinking);
                $data['education'] = json_encode($request->education);
                $data['email'] = $request->email;
                $data['findPartner'] = json_encode($request->findPartner);
                $data['gender'] = $request->gender;
                $data['height'] = $request->height;
                $data['location'] = $request->location;
                $data['maritalStatus'] = json_encode($request->maritalStatus);
                $data['smoking'] = json_encode($request->smoking);
                $data['spendTime'] = json_encode($request->spendTime);
                $data['username'] = $request->username;
                $data['weight'] = $request->weight;
            $result = $this->admin->UpdateDate('profile','userid',$request->userid,$data);
            if($result==1){
                return response()->json(['status'=>200,'success'=>"Your Profile Update Successful!"]);
            } else {
                return response()->json(['status'=>201,'success'=>"AlReady Profile Update!"]);
            }
          }
        }catch(\Throwable $th){
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

     // add Gallery
     public function UserGallery(Request $request){
        try{
         $i = 1;
         $image = $request->file('galleryImage');
         if(is_array($image)){
           $a = array();
             foreach ($image as $files) {
                 $destinationPath = 'public/admin/images';
                 $file_name = $i.time() . "." . $files->getClientOriginalExtension();
                 $files->move($destinationPath, $file_name);
                 //array_push($a,asset('public/admin/images').'/'.$file_name);
                 DB::table('profilegallery')->insert(['userid'=>$request->userid,'image'=>asset('public/admin/images').'/'.$file_name]);
                 $i++;
             }
         }

       $check = $this->admin->GetDataByConditionSingal('profileimage',['userid'=>$request->userid]);
         if(empty($check)){
             if(request()->hasFile('image')){
                 $image = $request->file('image');
                 $name = time().'.'.$image->getClientOriginalExtension();
                 $destinationPath = public_path('/admin/images');
                 $image->move($destinationPath, $name);
                 $data['image'] = asset('public/admin/images').'/'.$name;
                 $data['userid'] = $request->userid;
                 $this->admin->InsertData('profileimage',$data);
             }
         } else {
             if(request()->hasFile('image')){
                 $image = $request->file('image');
                 $name = time().'.'.$image->getClientOriginalExtension();
                 $destinationPath = public_path('/admin/images');
                 $image->move($destinationPath, $name);
                 $data['image'] = asset('public/admin/images').'/'.$name;
                 $data['userid'] = $request->userid;
                 $this->admin->UpdateDate('profileimage','userid',$request->userid,$data);
             }
         }

         //return request()->json(['status'=>200,'success'=>"Add Pitching Profile Successful!"]);
       } catch(\Throwable $th) {
         return response()->json([
             'status' => false,
             'message' => $th->getMessage()
         ], 500);
       }
     }

    public function ProfileGet($id=""){
        try{
        $result = $this->admin->GetDataByConditionSingal('profile',['userid'=>$id]);
        if(!empty($result)){
            $a = array();
            $images = $this->admin->GetDataByConditionSingal('profileimage',['userid'=>$id]);
            $gallerys = $this->admin->GetDataByCondition('profilegallery',['userid'=>$id]);
            foreach($gallerys as $items){
                array_push($a,$items->image);
            }
            $data['id'] = $result->id;
            $data['userid'] = $result->userid;
            $data['cnctFrnd'] = json_decode($result->cnctFrnd);
            $data['desc'] = $result->desc;
            $data['dob'] = $result->dob;
            $data['mobileNum'] = $result->mobileNum;
            $data['whatsappNum'] = $result->whatsappNum;
            $data['drinking'] = json_decode($result->drinking);
            $data['education'] = json_decode($result->education);
            $data['email'] = $result->email;
            $data['findPartner'] = json_decode($result->findPartner);
            $data['gender'] = $result->gender;
            $data['height'] = $result->height;
            $data['image'] = @$images->image;
            $data['galleryImage'] = @$a;
            $data['location'] = $result->location;
            $data['maritalStatus'] = json_decode($result->maritalStatus);
            $data['smoking'] = json_decode($result->smoking);
            $data['spendTime'] = json_decode($result->spendTime);
            $data['username'] = $result->username;
            $data['weight'] = $result->weight;
            return response()->json(['status'=>200,'data'=>$data]);
        } else {
            return response()->json(['status'=>201,'data'=>[]]);
        }
    } catch(\Throwable $th){
        return response()->json([
            'status' => false,
            'message' => $th->getMessage()
        ], 500);
    }
    }

    public function HomeScreen($any){
        try{
            $data1 = $this->admin->GetDataByConditionSingal('profile',['userid'=>$any]);
            $findpartner = json_decode($data1->findPartner);
            $result = $this->admin->GetDataByCondition('profile',['gender'=>$findpartner->title]);
            $idm = array();
             if($result->count()>0){
                foreach($result as $itemss){
                    $data['id'] = $itemss->id;
                    $data['userid'] = $itemss->userid;
                    $data['cnctFrnd'] = json_decode($itemss->cnctFrnd);
                    $data['desc'] = $itemss->desc;
                    $data['dob'] = $itemss->dob;
                    $data['mobileNum'] = $itemss->mobileNum;
                    $data['whatsappNum'] = $itemss->whatsappNum;
                    $data['drinking'] = json_decode($itemss->drinking);
                    $data['education'] = json_decode($itemss->education);
                    $data['email'] = $itemss->email;
                    $data['findPartner'] = json_decode($itemss->findPartner);
                    $data['gender'] = $itemss->gender;
                    $data['height'] = $itemss->height;

                    $images = $this->admin->GetDataByConditionSingal('profileimage',['userid'=>$itemss->userid]);
                    $data['image'] = @$images->image;


                    $data['location'] = $itemss->location;
                    $data['maritalStatus'] = json_decode($itemss->maritalStatus);
                    $data['smoking'] = json_decode($itemss->smoking);
                    $data['spendTime'] = json_decode($itemss->spendTime);
                    $data['username'] = $itemss->username;
                    $data['weight'] = $itemss->weight;



                    $data['isLock'] = $itemss->isLock;
                    $data['isFriend'] = $itemss->isFriend;
                    $data['isBlock'] = $itemss->isBlock;


                     $islike = $this->admin->GetDataByConditionSingal('islike',['likerid'=>$itemss->userid]);
                        $data['likes'] = @$islike->like;
                        $data['isLike'] = @$islike->isLike;

                        $Superislike = $this->admin->GetDataByConditionSingal('lssuperlike',['userid'=>$itemss->userid]);
                        $data['superLike'] = @$Superislike->likes;
                        $data['isSuperLike'] = @$Superislike->SuperLike;


                     $offer = $this->admin->GetDataByCondition('profilegallery',['userid'=>$itemss->userid]);

                    $res1 = array();
                    if($offer->count()>0){
                        foreach($offer as $items){
                            $res3['id'] = $items->id;
                            $res3['image'] = $items->image;
                            $res1[] = $res3;
                        }
                        $data['gallery'] = $res1;
                        unset($res1);
                        } else {
                           $data['gallery'] = [];
                        }
                    $idm[] = $data;
                }
                return response()->json(['status'=>200,'cardData'=>$idm]);
             } else {
                return response()->json(['status'=>200,'cardData'=>[]]);
             }
        }catch(Throwable $th){
            return response()->json([
                'status'=>false,
                'message'=> $th->getMessage()
            ],500);
        }
    }

    public function CoinWallet($userid){
        try{
            $data['status'] = "1";
            $data['coin'] = "10";
            $data['userid'] = $userid;
            $data['datetimes'] = date("m/d/Y h:i:s");
            $result = $this->admin->InsertData('coinwallet',$data);
            return $result;
        }catch(Throwable $th){
            return response()->json([
                "status" => false,
                "message" =>$th->getMessage()
            ]);
        }
    }

    public function UserCoin($userid=""){
        $total = 0;
        $result = DB::table("coinwallet")->select("id","userid","coin","status","datetimes")->where('userid',$userid)->get();
        if($result->count()> 0){
            foreach($result as $item){
                if($item->status==1){
                    $total += $item->coin;
                }
            }
          return response()->json(['status'=>200,'totalCoin'=>$total,'data'=>$result]);
        } else {
          return response()->json(['status'=>200,'totalCoin'=>"0",'data'=>[]]);
        }
    }

    public function RazorpayOrder($userid=""){
        $result = DB::table("users")->select("id","name","email","deviceId")->where('id',$userid)->first();
        if(!empty($result)){
            $data['id'] = $result->id;
            $data['name'] = $result->name;
            $data['email'] = $result->email;
            $data['deviceId'] = $result->deviceId;
            $data['orderid'] = random_int(100000, 999999);
          return response()->json(['status'=>200,'data'=>$data]);
        } else {
          return response()->json(['status'=>201,'data'=>[]]);
        }
    }

    public function SuperLike(Request $request){
        $checkbalance = $this->GetCoineUser($request->userid);
         if($checkbalance > 0){
            $checkLike = $this->CheckUserSuperLike($request->userid,$request->likerid);
            if(empty($checkLike)){
              $data['likerid'] = $request->likerid;
              $data['userid'] = $request->userid;
              $data['likes'] = "1";
              $data['SuperLike'] = "true";
              $Insert = $this->admin->InsertData('lssuperlike',$data);
              if($Insert==1){
                 $data1['coin'] = 10;
                 $data1['status'] = 0;
                 $data1['userid'] = $request->userid;

                 $data2['coin'] = 10;
                 $data2['status'] = 1;
                 $data2['userid'] = $request->likerid;
                  $this->admin->InsertData('coinwallet',$data1);
                  $this->admin->InsertData('coinwallet',$data2);
                 return response()->json(['status'=>200,'msg'=>"Like Successful!"]);
              } else {
                return response()->json(['status'=>201,'msg'=>"Query Not Run!"]);
              }
            } else {
                return response()->json(['status'=>201,'msg'=>"You have Already like"]);
            }
        } else {
          return response()->json(['status'=>201,'msg'=>"You have Not Sufficient Balance"]);
        }
    }



    public function Islike(Request $request){
        $checkbalance = $this->GetCoineUser($request->likerid);
        if($checkbalance > 0){
            $checkLike = $this->CheckUserLike($request->userid,$request->likerid);
            if(empty($checkLike)){
              $data['likerid'] = $request->likerid;
              $data['userid'] = $request->userid;
              $data['like'] = "1";
              $data['isLike'] = "true";
              $Insert = $this->admin->InsertData('islike',$data);
              if($Insert==1){
                 $data1['coin'] = 1;
                 $data1['status'] = 0;
                 $data1['userid'] = $request->userid;

                 $data2['coin'] = 1;
                 $data2['status'] = 1;
                 $data2['userid'] = $request->likerid;
                  $this->admin->InsertData('coinwallet',$data1);
                  $this->admin->InsertData('coinwallet',$data2);
                 return response()->json(['status'=>200,'msg'=>"Like Successful!"]);
              } else {
                return response()->json(['status'=>200,'msg'=>"Query Not Run!"]);
              }
            } else {
              return response()->json(['status'=>201,'msg'=>"You have Already like"]);
            }
        } else {
          return response()->json(['status'=>201,'msg'=>"You have Not Sufficient Balance"]);
        }
    }


    public function GetCoineUser($uid){
        $result = DB::table('coinwallet')->where(['userid'=>$uid,"status"=>"1"])->sum('coin');
        return $result;
    }



    public function CheckUserLike($uid,$likerid){
        $result = DB::table('islike')->where(['userid'=>$uid,'likerid'=>$likerid])->first();
        return $result;
    }


    public function CheckUserSuperLike($uid,$likerid){
        $result = DB::table('lssuperlike')->where(['userid'=>$uid,'likerid'=>$likerid])->first();
        return $result;
    }

    public function UnlockProfile(Request $request){
        $checkUnlock = $this->GetCoineUserForUnlock($request->userid,$request->likerid);
        if($checkUnlock>0){
            $check = $this->ChekUnlock($request->userid,$request->likerid);
             if(empty($check)){
                $data['likerid'] =$request->likerid;
                $data['userid'] =$request->userid;
                $data['isUnlock'] ="true";

                 $data1['coin'] = 50;
                 $data1['status'] = 0;
                 $data1['userid'] = $request->userid;

                 $data2['coin'] = 50;
                 $data2['status'] = 1;
                 $data2['userid'] = $request->likerid;


                 $result = $this->admin->InsertData('unlock',$data);
                 $result = $this->admin->InsertData('coinwallet',$data1);
                 $result = $this->admin->InsertData('coinwallet',$data2);
                 if($result==1){
                    return response()->json(['status'=>200,'msg'=>"You have Unlocak!"]);
                 }else {
                    return response()->json(['status'=>201,'msg'=>"Query not Run!"]);
                 }
              } else{
               return response()->json(['status'=>201,'msg'=>"You have Already Unlocak!"]);
             }
        } else {
            return response()->json(['status'=>201,'You have Not Sufficient Balance!']);
        }
    }


    public function ChekUnlock($uid="",$likerid=""){
        $result = DB::table('unlock')->where(['userid'=>$uid,'likerid'=>$likerid])->first();
        return $result;
    }

    public function GetCoineUserForUnlock($uid){
        $result = DB::table('coinwallet')->where(['userid'=>$uid,"status"=>"1"])->sum('coin');
        return $result;
    }



    public function UserChat(Request $request){
        $data['myid'] = $request->myid;
        $data['userid'] = $request->userid;
        $data['createdAt'] = $request->createdAt;
        $data['user'] = $request->user;
        $data['text'] = $request->text;
        $data['coin'] = $request->coin;
        if(request()->hasFile('image')){
            $image = $request->file('image');
            $name = time().'.'.$image->getClientOriginalExtension();
            $destinationPath = public_path('/admin/images');
            $image->move($destinationPath, $name);
            $data['image'] = asset('public/admin/images').'/'.$name;
        }
        $result = $this->admin->InsertData('userchat',$data);

        if($result==1){
            return response()->json(['status'=>200,'response'=>true]);
        } else {
            return response()->json(['status'=>201,'response'=>false]);
        }
    }

    public function MyuserChart($userid,$myid){
       $chat = DB::table('userchat')->where(['myid'=>$myid,'userid'=>$userid])->orWhere(['myid'=>$userid,'userid'=>$myid])->get();
        $arrays = array();
         if($chat->count()> 0){
            foreach($chat as $items){
                    $data['id'] = $items->id;
                    $data['createdAt'] = $items->createdAt;
                    $data['text'] = $items->text;
                    $data['userid'] = $items->userid;
                    $data['myid'] = $items->myid;
                    $data['user'] = json_decode($items->user);
                    $data['coin'] = $items->coin;
                    $data['image'] = $items->image;
                    $arrays[] = $data;
                }
            return response()->json([
                "status"=>200,
                "chat"=>$arrays
               ]);
       } else {
        return response()->json([
            "status"=>201,
            "chat"=>[]
           ]);
       }
    }


    public function ChatList($userid){
        $result = $this->admin->GetDataByCondition('userchat',['myid'=>$userid]);
        $array = array();
        if($result->count()> 0){
           foreach($result as $items){
            $ddd = DB::table('users')
            ->join('profileimage', 'profileimage.userid', '=', 'users.id')
            ->where('users.id', '=', $items->userid)
            ->first();
            $res['id'] = $ddd->id;
            $res['userid'] = $ddd->userid;
            $res['username'] = $ddd->name;
            $res['image'] = $ddd->image;
            $array[] = $res;
           }
           return response()->json(['status'=>200,'data'=>$array]);
        } else {
            return response()->json(['status'=>201,'data'=>[]]);
        }
    }

}



