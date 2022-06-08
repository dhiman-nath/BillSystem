<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;
use App\Models\Category;
use App\Models\Subcategory;
use View;
use DB;

class SubcategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('backend.admin.subcategory.index');
    }

    public function getAll(Request $request)
    {
       if ($request->ajax()) {
         $can_view = $can_edit = $can_delete = '';
         if (!auth()->user()->can('subcategory-view')) {
            $can_view = "style='display:none;'";
         }
          if (!auth()->user()->can('subcategory-edit')) {
             $can_edit = "style='display:none;'";
          }
          if (!auth()->user()->can('subcategory-delete')) {
             $can_delete = "style='display:none;'";
          }
 
          $subcategory = Subcategory::orderby('created_at', 'desc')->get();
          return Datatables::of($subcategory)
           
          ->addColumn('category_name', function ($subcategory) {
            return $subcategory->category_info->name ;
         })
          
            ->addColumn('status', function ($subcategory) {
               return $subcategory->status ? '<span class="badge badge-success">Active</span>' : '<span class="badge badge-danger">Inactive</span>';
            })
            ->addColumn('action', function ($subcategory) use ($can_view, $can_edit, $can_delete) {
               $html = '<div class="btn-group">';
               $html .= '<a data-toggle="tooltip" ' . $can_view . '  id="' . $subcategory->id . '" class="btn btn-xs btn-success mr-1 view" title="View"><i class="fa fa-eye"></i> </a>';
               $html .= '<a data-toggle="tooltip" ' . $can_edit . '  id="' . $subcategory->id . '" class="btn btn-xs btn-info mr-1 edit" title="Edit"><i class="fa fa-edit"></i> </a>';
               $html .= '<a data-toggle="tooltip" ' . $can_delete . ' id="' . $subcategory->id . '" class="btn btn-xs btn-danger delete" title="Delete"><i class="fa fa-trash"></i> </a>';
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
            $haspermision = auth()->user()->can('subcategory-create');
            if ($haspermision) {
                $categories=category::where('status',1)->orderby('order_by', 'asc')->get();
               $view = View::make('backend.admin.subcategory.create',compact('categories'))->render();

               
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
            $haspermision = auth()->user()->can('subcategory-create');
            if ($haspermision) {
   
               $rules = [
                'category_id' => 'required',
                 'subcategory_name' => 'required',
                 //'order_by'=>'required',
                 
               ];
   
               $validator = Validator::make($request->all(), $rules);
               if ($validator->fails()) {
                  return response()->json([
                    'type' => 'error',
                    'errors' => $validator->getMessageBag()->toArray()
                  ]);
                } 
                else {
                     $subcategory = new Subcategory;
                     $subcategory->category_id= $request->input('category_id');
                     $subcategory->subcategory_name = $request->input('subcategory_name');
                     $subcategory->order_by = $request->input('order_by');
                    
                     $subcategory->save(); //
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
     * @param  \App\Models\Subcategory  $subcategory
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request,Subcategory $subcategory)
    {
      if ($request->ajax()) {
         $haspermision = auth()->user()->can('subcategory-create');
         if ($haspermision) {
             $categories=category::where('status',1)->get();
            $view = View::make('backend.admin.subcategory.view',compact('categories','subcategory'))->render();

            
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
     * @param  \App\Models\Subcategory  $subcategory
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request,Subcategory $subcategory)
    {
        if ($request->ajax()) {
            $haspermision = auth()->user()->can('subcategory-create');
            if ($haspermision) {
                $categories=category::where('status',1)->get();
               $view = View::make('backend.admin.subcategory.edit',compact('categories','subcategory'))->render();

               
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
     * @param  \App\Models\Subcategory  $subcategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Subcategory $subcategory)
    {
        if ($request->ajax()) {
            $haspermision = auth()->user()->can('subcategory-edit');
            if ($haspermision) {
   
               $rules = [
                'category_id' => 'required',
                 'subcategory_name' => 'required',
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
                     $subcategory = Subcategory::findOrFail($subcategory->id);
                     $subcategory->category_id = $request->input('category_id');
                     $subcategory->subcategory_name = $request->input('subcategory_name');
                     $subcategory->order_by = $request->input('order_by');
                    
                     $subcategory->status = $request->input('status');
                     $subcategory->save(); //
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
     * @param  \App\Models\Subcategory  $subcategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,Subcategory $subcategory)
    {
        if ($request->ajax()) {
            $haspermision = auth()->user()->can('subcategory-delete');
            if ($haspermision) {
               $subcategory->delete();
               return response()->json(['type' => 'success', 'message' => 'Successfully Deleted']);
            } else {
               abort(403, 'Sorry, you are not authorized to access the page');
            }
         } else {
            return response()->json(['status' => 'false', 'message' => "Access only ajax request"]);
         }
      }
    
}
