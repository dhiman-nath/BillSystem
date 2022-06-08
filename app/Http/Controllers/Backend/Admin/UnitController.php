<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;
use App\Models\Unit;
use View;
use DB;

class UnitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('backend.admin.unit.index');
    }

    public function getAll(Request $request)
    {
       if ($request->ajax()) {
          $can_edit = $can_delete = '';
          if (!auth()->user()->can('category-edit')) {
             $can_edit = "style='display:none;'";
          }
          if (!auth()->user()->can('category-delete')) {
             $can_delete = "style='display:none;'";
          }
 
          $unit = Unit::orderby('created_at', 'desc')->get();
          return Datatables::of($unit)
           
           
          
            ->addColumn('status', function ($unit) {
               return $unit->status ? '<span class="badge badge-success">Active</span>' : '<span class="badge badge-danger">Inactive</span>';
            })
            ->addColumn('action', function ($unit) use ($can_edit, $can_delete) {
               $html = '<div class="btn-group">';
               $html .= '<a data-toggle="tooltip" ' . $can_edit . '  id="' . $unit->id . '" class="btn btn-xs btn-success mr-1 view" title="View"><i class="fa fa-eye"></i> </a>';
               $html .= '<a data-toggle="tooltip" ' . $can_edit . '  id="' . $unit->id . '" class="btn btn-xs btn-info mr-1 edit" title="Edit"><i class="fa fa-edit"></i> </a>';
               $html .= '<a data-toggle="tooltip" ' . $can_delete . ' id="' . $unit->id . '" class="btn btn-xs btn-danger delete" title="Delete"><i class="fa fa-trash"></i> </a>';
               $html .= '</div>';
               return $html;
            })
            ->rawColumns(['action', 'status'])
            ->addIndexColumn()
            ->make(true);
       } else {
          return response()->json(['status' => 'false', 'message' => "Access only ajax request"]);
       }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        if ($request->ajax()) {
            $haspermision = auth()->user()->can('category-create');
            if ($haspermision) {
               $view = View::make('backend.admin.unit.create')->render();
               
               return response()->json(['html' => $view]);
            } else {
               abort(403, 'Sorry, you are not authorized to access the page');
            }
         } else {
            return response()->json(['status' => 'false', 'message' => "Access only ajax request"]);
         }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->ajax()) {
            $haspermision = auth()->user()->can('category-create');
            if ($haspermision) {
   
               $rules = [
                 'unit_name' => 'required',
                
                 
               ];
   
               $validator = Validator::make($request->all(), $rules);
               if ($validator->fails()) {
                  return response()->json([
                    'type' => 'error',
                    'errors' => $validator->getMessageBag()->toArray()
                  ]);
                } 
                else {
                     $unit = new Unit;
                     $unit->unit_name = $request->input('unit_name');
                     $unit->order_by = $request->input('order_by');
                    
                     $unit->save(); //
                     return response()->json(['type' => 'success', 'message' => "Successfully Created"]);
                  }
               }
            else {
               abort(403, 'Sorry, you are not authorized to access the page');
            }
         } else {
            return response()->json(['status' => 'false', 'message' => "Access only ajax request"]);
         }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Unit  $unit
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Unit $unit)
    {
        if ($request->ajax()) {
            $haspermision = auth()->user()->can('category-view');
            if ($haspermision) {
               $view = View::make('backend.admin.unit.view', compact('unit'))->render();
               return response()->json(['html' => $view]);
            } else {
               abort(403, 'Sorry, you are not authorized to access the page');
            }
         } else {
            return response()->json(['status' => 'false', 'message' => "Access only ajax request"]);
         }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Unit  $unit
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Unit $unit)
    {
        if ($request->ajax()) {
            $haspermision = auth()->user()->can('category-edit');
            if ($haspermision) {
               $view = View::make('backend.admin.unit.edit', compact('unit'))->render();
               return response()->json(['html' => $view]);
            } else {
               abort(403, 'Sorry, you are not authorized to access the page');
            }
         } else {
            return response()->json(['status' => 'false', 'message' => "Access only ajax request"]);
         }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Unit  $unit
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Unit $unit)
    {
        if ($request->ajax()) {
            $haspermision = auth()->user()->can('category-edit');
            if ($haspermision) {
   
               $rules = [
                 'unit_name' => 'required',
                 'order_by'=>'required',
                 
               ];
   
               $validator = Validator::make($request->all(), $rules);
               if ($validator->fails()) {
                  return response()->json([
                    'type' => 'error',
                    'errors' => $validator->getMessageBag()->toArray()
                  ]);
               } 
                else {
                     $unit = Unit::findOrFail($unit->id);
                     $unit->unit_name = $request->input('unit_name');
                     $unit->order_by = $request->input('order_by');
                    
                     $unit->status = $request->input('status');
                     $unit->save(); //
                     return response()->json(['type' => 'success', 'message' => "Successfully Updated"]);
                  }
               }
            else {
               abort(403, 'Sorry, you are not authorized to access the page');
            }
         } else {
            return response()->json(['status' => 'false', 'message' => "Access only ajax request"]);
         }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Unit  $unit
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,Unit $unit)
    {
        if ($request->ajax()) {
            $haspermision = auth()->user()->can('category-delete');
            if ($haspermision) {
               $unit->delete();
               return response()->json(['type' => 'success', 'message' => 'Successfully Deleted']);
            } else {
               abort(403, 'Sorry, you are not authorized to access the page');
            }
         } else {
            return response()->json(['status' => 'false', 'message' => "Access only ajax request"]);
         }
    }
}
