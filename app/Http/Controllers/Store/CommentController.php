<?php

namespace App\Http\Controllers\Store;

use App\Model\Comment;
use Illuminate\Http\Request;
use App\Model\Guard\UserStore;
use App\Model\Store\AccountComment;
use App\Model\Store\AccountManager;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class CommentController extends Controller
{
    

   public function index($managerId){

   	$managerId = UserStore::find($managerId);

  return view('store.account.manager.managerView.comments.index',compact('managerId'));

   }

  public function store(Request $request){
        
       
            $validator = Validator::make($request->all(),[
                'body' => 'required',
        ]);

        if($validator->passes()){

        $lead  = UserStore::find($request->manager_id);
        $lead->comments()->create(['body'=> $request->body,'store_user_id'=> auth('store')->user()->id]);
        return response()->json(['success',true]);
      }
      else
      {
            $keys = $validator->errors()->keys();
            $vals  = $validator->errors()->all();
            $errors = array_combine($keys,$vals);
            return response()->json(['errors'=>$errors]);  
      }
    }

    public function all($managerId){
        
        $managerId = UserStore::with('comments')->where('id',$managerId)->first();
        return view('store.account.manager.managerView.comments.all',compact('managerId'));
    }

    public function edit($managerId){
        
         $comment = Comment::find($managerId);
        
         return view('store.account.manager.managerView.comments.edit',compact('comment')); 
    }


    public function update(Request $request){
        
        $comment = AccountComment::where('id',$request->commentId)->first();
        $comment->update(['body'=>$request->body]);
        return response()->json(['success',true]);
    }






}
