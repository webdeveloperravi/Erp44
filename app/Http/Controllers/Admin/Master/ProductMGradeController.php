<?php
namespace App\Http\Controllers\Admin\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Master\Grade as req;
use App\Model\Admin\Master\ProductMGrade as Model;
use Session;

class ProductMGradeController extends Controller
{
    public function index()
    {

        $data = Model::all()->sortBy('grade');
        return view('admin.amaster.grade.index', compact('data'));
    }

    public function store(Request $request)
    {

        $validatedData = $request->validate(['grade' => "required|unique:product_m_grades", 'alias' => "required|unique:product_m_grades", 'desc' => "required", ]);

        // to fetch parent_sort Max Value
        $parentsort_value = Model::latest()->value('id');
        if ($parentsort_value == '')
        {
            $flag = 1;
        }
        else
        {
            $flag = $parentsort_value + 1;
        }

        //  dd($request->all(),$parentsort_value);
        

        $obj = new Model;
        $obj->grade = $request->grade;
        $obj->alias = $request->alias;
        $obj->descr = $request->desc;
        $obj->parent_sort = $flag;
        $obj->save();

        $obj->masterIds()->create([
            'created_id' => auth('admin')->user()->id
          ]);

        Session::flash("success", " Record Saved.");
        return back();

    }

    public function parentSort(Request $request)
    { 
        $psort = $request->parent_id;
        $parentsort = 1;
        foreach ($psort as $ps_key => $ps_val)
        {
            Model::where(['id' => $ps_val])->update(['parent_sort' => $parentsort]);
            $parentsort++;
        }
        return response()->json(["success" => "Parent Sort Updated"]);
    }

    protected function gradeExist($name)
    {

        $flag = 0;
        $grade_del = Model::where(['grade' => $name, 'status' => 0])->whereNotNull('deleted_at')
            ->withTrashed()
            ->get();
        if ($grade_del->isNotEmpty())
        {
            $flag = 2;
            return response()->json($flag);
        }
        else {

            $grade_res = Model::where(['grade' => $name]);
            if ($grade_res->exists())
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

        $grade_del = Model::where(['alias' => $name, 'status' => 0])->whereNotNull('deleted_at')
            ->withTrashed()
            ->get();
        if ($grade_del->isNotEmpty())
        {
            $flag = 2;
            return response()->json($flag);

        }
        else
        {
            $grade_res = Model::where(['alias' => $name]);
            if ($grade_res->exists())
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

    protected function gradeEditExist($id, $name)
    {

        $flag = 0;

        $grade_del = Model::where(['grade' => $name, 'status' => 0])->whereNotNull('deleted_at')
            ->withTrashed()
            ->get();

        if ($grade_del->isNotEmpty())
        {

            $flag = 3;
            return response()->json($flag);
        }

        else
        {

            $clarity_edit = Model::where(['id' => $id, 'grade' => $name]);

            if ($clarity_edit->exists())
            {
                $flag = 0;
                return response()->json($flag);
            }
            else
            {
                $clarity_edit = Model::where(['grade' => $name]);

                if ($clarity_edit->exists())
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

        $grade_del = Model::where(['alias' => $name, 'status' => 0])->whereNotNull('deleted_at')
            ->withTrashed()
            ->get();

        if ($grade_del->isNotEmpty())
        {

            $flag = 3;
            return response()->json($flag);
        }

        else
        {

            $clarity_edit = Model::where(['id' => $id, 'alias' => $name]);

            if ($clarity_edit->exists())
            {
                $flag = 0;
                return response()->json($flag);
            }
            else
            {
                $clarity_edit = Model::where(['alias' => $name]);

                if ($clarity_edit->exists())
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

        $grade_id = $request->id; // get color  id
        // validation is part
        $validatedData = $request->validate([

        'grade' => "required|unique:product_m_grades,grade,$grade_id", 'alias' => "required|unique:product_m_grades,alias,$grade_id", ]);

        $grade = Model::where(['id' => $request
            ->id])->first();
            $grade->update(['grade' => $request->grade, 'alias' => $request->alias, 'descr' => $request->desc]);
            
        $grade->masterIds()->create([
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
        Session::flash("success", " Record Updated.");
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

