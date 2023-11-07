<?php

namespace App\Http\Controllers\Tasks;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\UpdateStatusrequest;
use App\Http\Requests\task\createReaquest;
use App\Http\Requests\task\UpdateReaquest;
use App\Http\Traits\Api_designtrait;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class TaskController extends Controller
{
    use Api_designtrait;

    public function index()
    {
        $this->authorize("view", Task::class);
        $Task=Task::get()->all();
            return $this->api_design(200,'All users',$Task,null);

    }
   public function create(createReaquest $createReaquest)
   {
    $this->authorize("createTask", Task::class);

     $id=Auth::user()->id;
     $create=new Task();
     $create->title=$createReaquest->title;
     $create->describtion=$createReaquest->describtion;
     $create->deadline=$createReaquest->deadline;
     $create->status=$createReaquest->status;
     $create->user_id=$createReaquest->user_id;
     $create->created_by=$id;
    $create->save();
    return $this->api_design(200,"task create succsefully",$create,null);

}


public function show(){
    $user=Auth::user();
    $task = Task::where('user_id',$user->id)->orWhere('name', 'John')->get();
    return $this->api_design(200,'my tasks', $task);
}

        public function updateStatus(UpdateStatusrequest $request, Task $task)
        {
            $this->authorize('updateStatus', Task::class);
            $task->update(['status' => $request->status]);
            return $this->api_design(200,'All users',$task,null);
        }

}
