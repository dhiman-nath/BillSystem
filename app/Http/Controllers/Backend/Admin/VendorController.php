<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;
use App\Models\Vendor;
use View;
use DB;

class VendorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('backend.admin.vendor.index'); 
    }

    public function getAll(Request $request)
    {
       if ($request->ajax()) {
         $can_view = $can_edit = $can_delete = '';
         if (!auth()->user()->can('vendor-view')) {
            $can_view = "style='display:none;'";
         }
          if (!auth()->user()->can('vendor-edit')) {
             $can_edit = "style='display:none;'";
          }
          if (!auth()->user()->can('blog-delete')) {
             $can_delete = "style='display:none;'";
          }
 
          $vendor = Vendor::orderby('created_at', 'desc')->get();
          return Datatables::of($vendor)
           
           
          
            ->addColumn('status', function ($vendor) {
               return $vendor->status ? '<span class="badge badge-success">Active</span>' : '<span class="badge badge-danger">Inactive</span>';
            })
            ->addColumn('action', function ($vendor) use ( $can_view ,$can_edit, $can_delete) {
               $html = '<div class="btn-group">';
               $html .= '<a data-toggle="tooltip" ' . $can_view . '  id="' . $vendor->id . '" class="btn btn-xs btn-success mr-1 view" title="View"><i class="fa fa-eye"></i> </a>';
               $html .= '<a data-toggle="tooltip" ' . $can_edit . '  id="' . $vendor->id . '" class="btn btn-xs btn-info mr-1 edit" title="Edit"><i class="fa fa-edit"></i> </a>';
               $html .= '<a data-toggle="tooltip" ' . $can_delete . ' id="' . $vendor->id . '" class="btn btn-xs btn-danger delete" title="Delete"><i class="fa fa-trash"></i> </a>';
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
            $haspermision = auth()->user()->can('notice-create');
            if ($haspermision) {
               $view = View::make('backend.admin.vendor.create')->render();
               
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
            $haspermision = auth()->user()->can('blog-create');
            if ($haspermision) {
   
               $rules = [
                 'name' => 'required',
                 'address'=>'required',
                 'mobile'=>'required',
                 'email'=>'required',
                 'contactperson'=>'required',
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
                   if($request->input('order_by')){
                     $vendor = new Vendor;
                     $vendor->name = $request->input('name');
                     $vendor->address = $request->input('address');
                     $vendor->mobile = $request->input('mobile');
                     $vendor->email = $request->input('email');
                     $vendor->contactperson = $request->input('contactperson');
                     $vendor->order_by = $request->input('order_by');
                    
                     $vendor->save(); //
                     return response()->json(['type' => 'success', 'message' => "Successfully Created"]);
                   }
                   else{
                     $vendor = new Vendor;
                     $vendor->name = $request->input('name');
                     $vendor->address = $request->input('address');
                     $vendor->mobile = $request->input('mobile');
                     $vendor->email = $request->input('email');
                     $vendor->contactperson = $request->input('contactperson');
                    
                    
                     $vendor->save(); //
                     return response()->json(['type' => 'success', 'message' => "Successfully Created"]);
                   }
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
     * @param  \App\Models\Vendor  $vendor
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request,Vendor $vendor)
    {
      if ($request->ajax()) {
         $haspermision = auth()->user()->can('notice-view');
         if ($haspermision) {
            $view = View::make('backend.admin.vendor.view', compact('vendor'))->render();
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
     * @param  \App\Models\Vendor  $vendor
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request,Vendor $vendor)
    {
        if ($request->ajax()) {
            $haspermision = auth()->user()->can('notice-edit');
            if ($haspermision) {
               $view = View::make('backend.admin.vendor.edit', compact('vendor'))->render();
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
     * @param  \App\Models\Vendor  $vendor
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Vendor $vendor)
    {
        if ($request->ajax()) {
            $haspermision = auth()->user()->can('blog-edit');
            if ($haspermision) {
   
               $rules = [
                 'name' => 'required',
                 'address' => 'required',
                 'mobile' => 'required',
                 'email' => 'required',
                 'contactperson' => 'required',
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
                     $vendor = Vendor::findOrFail($vendor->id);
                     $vendor->name = $request->input('name');
                     $vendor->address = $request->input('address');
                     $vendor->mobile = $request->input('mobile');
                     $vendor->email = $request->input('email');
                     $vendor->contactperson = $request->input('contactperson');
                     $vendor->order_by = $request->input('order_by');
                    
                     $vendor->status = $request->input('status');
                     $vendor->save(); //
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
     * @param  \App\Models\Vendor  $vendor
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,Vendor $vendor)
    {
        if ($request->ajax()) {
            $haspermision = auth()->user()->can('notice-delete');
            if ($haspermision) {
               $vendor->delete();
               return response()->json(['type' => 'success', 'message' => 'Successfully Deleted']);
            } else {
               abort(403, 'Sorry, you are not authorized to access the page');
            }
         } else {
            return response()->json(['status' => 'false', 'message' => "Access only ajax request"]);
         }
    }
}
