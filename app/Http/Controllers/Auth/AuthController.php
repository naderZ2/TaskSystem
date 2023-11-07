<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\createEmployeeReaquest;
use App\Http\Requests\Auth\LoginReaquest;
use App\Http\Requests\Auth\RegisterReaquest;
use App\Http\Requests\Auth\Updaterequest;
use App\Http\Requests\Auth\UpdateStatusrequest;
use App\Http\Traits\Api_designtrait;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    use Api_designtrait;

    public function register(RegisterReaquest $registerReaquest){

        $newUser=new User;
        $newUser->name=$registerReaquest->name;
        $newUser->email=$registerReaquest->email;
        $newUser->password=$registerReaquest->password;
        $newUser->img_path=$registerReaquest->img_path;
        $newUser->role=$registerReaquest->role;
        $newUser->leader_id=$registerReaquest->leader_id;
        $newUser->save();

            return $this->api_design(200,"user was registed successfully", $newUser);

    }

    public function createEmployee(createEmployeeReaquest $createEmployeeReaquest){
        $employee=new User;
        $employee->name=$createEmployeeReaquest->name;
        $employee->email=$createEmployeeReaquest->email;
        $employee->password=$createEmployeeReaquest->password;
        $employee->img_path=$createEmployeeReaquest->img_path;
        $employee->leader_id=$createEmployeeReaquest-> Auth::user()->id;
        $employee->save();
        return $this->api_design(200,"employee was created successfully", $employee);
    }

    public function login(LoginReaquest $loginReaquest){
            $token = JWTAuth::attempt([
            "email"=> $loginReaquest->email,
            "password"=> $loginReaquest->password
        ]);
        if (!empty($token)) {
            $data= User::where('email', $loginReaquest->email)->first();
            return $this->api_design(200,"login succesfull", [$data,$token],null);
        }else {
            return $this->api_design(400,'eror',null, $token->errors());
        }
}
public function update(Updaterequest $updaterequest)
{
    $this->authorize('update', User::class);
    $user=User::where('id',$updaterequest->id)->first();
    $user->name= $updaterequest->name;
    $user->email= $updaterequest->email;
    $user->password= bcrypt($updaterequest->password);
    $user->img_path= $updaterequest->img_path;
    $user->role= $updaterequest->role;
    $user->leader_id= $updaterequest->leader_id;
    $user->save();
        return $this->api_design(200,'user updated successfully', [$user,],null);
    }

public function delete(Request $request){
    $this->authorize('delete', User::class);
    $user=User::where('id',$request->id)->first();

    $user->delete();
    return $this->api_design(200,'user deleted successfully',$user,null);
}

}
