<?php
namespace App\Http\Controllers\Admin\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Admin\Master\AccountGroup;
use Validator;
class AccountGroupController extends Controller
{

    public function index()
    {
        return view('admin.amaster.account_group.index');
    }

    public function all()
    {
        $groups = AccountGroup::where('parent_id', 0)->orderBy('name', 'asc')->get();
        return view('admin.amaster.account_group.all', compact('groups'));

    }

    public function create()
    {

        $accountGroups = AccountGroup::where('status', 1)->get();
        return view('admin.amaster.account_group.create', compact('accountGroups'));
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all() , ['name' => 'required', 'alias' => 'required', 'description' => 'required', 'primary' => 'required|not_in:Select Primary', ]);
        if ($validator->passes())
        {
            $managerRole = AccountGroup::create(['name' => $request->name, 'alias' => $request->alias, 'description' => $request->description, 'account_primary' => $request->primary??1, 'parent_id' => $request->parent_id??0,

            ]);
            return response()
                ->json(['success' => true]);
        }
        else
        {
            $keys = $validator->errors()
                ->keys();
            $vals = $validator->errors()
                ->all();
            $errors = array_combine($keys, $vals);

            return response()->json(['errors' => $errors]);
        }
    }

    public function edit($id)
    {
        $groupEdit = AccountGroup::where('id', $id)->first();

        $accountGroups = AccountGroup::where('status', 1)->get();
        return view('admin.amaster.account_group.edit', compact('accountGroups', 'groupEdit'));

    }

    public function update(Request $request)
    {
        
        $validator = Validator::make($request->all() , ['name' => 'required', 'alias' => 'required', 'description' => 'required', ]);
        if ($validator->passes())
        {
            $accountGroup = AccountGroup::where('id', $request->groupId)->first();
            $accountGroup->update(['name' => $request->name, 
            'alias' => $request->alias, 
            'description' => $request->description, 
            'primary' => $request->primary??1, 
            'parent_id' => $request->parent_id??0, 
            ]);
            return response()
                ->json(['success' => true]);
        }
        else
        {
            $keys = $validator->errors()->keys();
            $vals = $validator->errors()->all();
            $errors = array_combine($keys, $vals);

            return response()->json(['errors' => $errors]);
        }
    }

    public function statusUpdate($accountGroupId,$status){
        AccountGroup::where('id',$accountGroupId)->update(['status'=> $status]);
    }
}

