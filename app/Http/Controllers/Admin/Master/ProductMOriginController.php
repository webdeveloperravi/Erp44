<?php
namespace App\Http\Controllers\Admin\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Admin\Master\ProductMOrigin as Model;
use Session;

class ProductMOriginController extends Controller
{

    public function index()
    {

        $data = Model::all()->sortBy('origin');
        return view('admin.amaster.origin.index', compact('data'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate(['origin' => "required|unique:product_m_origins", 'alias' => "required|unique:product_m_origins", ]);

        $obj = new Model;
        $obj->origin = $request->origin;
        $obj->alias = $request->alias;
        $obj->origin_code = $request->origin_code;
        $obj->descr = $request->desc;
        $obj->save();

           //logom history
        $obj->masterIds()->create([
            'created_id' => auth('admin')->user()->id
       ]);

        Session::flash("success", " Record Saved.");
        return back();
    }

    protected function originExist($name)
    {

        $flag = 0;
        $origin_del = Model::where(['origin' => $name, 'status' => 0])->whereNotNull('deleted_at')
            ->withTrashed()
            ->get();

        if ($origin_del->isNotEmpty())
        {
            $flag = 2;
            return response()->json($flag);
        }
        else
        {
            $origin_res = Model::where(['origin' => $name]);
            if ($origin_res->exists())
            {
                $flag = 1;
                return response()->json($flag);
            }
            else
            {
                $flag = 0;
                return response()->json($flag);
            }
        }
    }

    protected function aliasExist($name)
    {

        $flag = 0;
        $origin_del = Model::where(['alias' => $name, 'status' => 0])->whereNotNull('deleted_at')
            ->withTrashed()
            ->get();

        if ($origin_del->isNotEmpty())
        {
            $flag = 2;
            return response()->json($flag);
        }
        else
        {
            $origin_res = Model::where(['alias' => $name]);
            if ($origin_res->exists())
            {
                $flag = 1;
                return response()->json($flag);
            }
            else
            {
                $flag = 0;
                return response()->json($flag);
            }
        }
    }

    protected function originEditExist($id, $name)
    {

        $flag = 0;
        $origin_del = Model::where(['origin' => $name, 'status' => 0])->whereNotNull('deleted_at')
            ->withTrashed()
            ->get();
        if ($origin_del->isNotEmpty())
        {

            $flag = 3;
            return response()->json($flag);
        }
        else
        {

            $origin_edit = Model::where(['id' => $id, 'origin' => $name]);

            if ($origin_edit->exists())
            {
                return response()
                    ->json($flag);
            }
            else
            {
                $origin_edit = Model::where(['origin' => $name]);

                if ($origin_edit->exists())
                {
                    $flag = 1;
                    return response()->json($flag);
                }
                else
                {
                    $flag = 2;

                    return response()->json($flag);
                }
                $flag = 0;
            }

        }
    }

    protected function aliasEditExist($id, $name)
    {

        $flag = 0;

        $origin_del = Model::where(['alias' => $name, 'status' => 0])->whereNotNull('deleted_at')
            ->withTrashed()
            ->get();

        if ($origin_del->isNotEmpty())
        {

            $flag = 3;
            return response()->json($flag);
        }
        else
        {

            $origin_res = Model::where(['id' => $id, 'alias' => $name]);

            if ($origin_res->exists())
            {
                return response()
                    ->json($flag);
            }
            else
            {
                $origin_res = Model::where(['alias' => $name]);

                if ($origin_res->exists())
                {
                    $flag = 1;
                    return response()->json($flag);
                }
                else
                {
                    $flag = 2;

                    return response()->json($flag);
                }
                $flag = 0;
            }

        }

    }

    public function update(Request $request)
    {
 
       
        $origin_id = $request->id;  
        $validatedData = $request->validate([

        'origin' => "required|unique:product_m_origins,origin," . $origin_id, 'alias' => "required|unique:product_m_origins,alias,$origin_id"]);

       $origin = Model::where(['id' => $request ->id])->first();
       $origin->update([
           'origin' => $request->origin,
           'alias' => $request->alias, 
           'origin_code'=> $request->origin_code,
           'descr' => $request->desc
        ]);
       
       $origin->masterIds()->create([
        'updated_id' => auth('admin')->user()->id
   ]);

       
       Session::flash("success", " Record Updated.");
        return back();
    }

    public function status($id, $status)
    {

        if ($status == 1)
        {
            $status = 0;
        }
        else
        {
            $status = 1;
        }
        Model::find($id)->update(['status' => $status]);
        return back();
    }

    public function destroy($id)
    {
        $status = 0;
        Model::find($id)->update(['status' => $status]);
        Model::where('id', $id)->delete();
        Session::flash("error", " Record Deleted.");
        return back();
    }

}

