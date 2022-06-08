<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;
use App\Models\Client;
use View;
use DB;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('backend.admin.client.index'); 
    }


    public function getAll(Request $request)
    {
       if ($request->ajax()) {
         $can_view = $can_edit = $can_delete = '';

         if (!auth()->user()->can('client-view')) {
            $can_view = "style='display:none;'";
         }
          if (!auth()->user()->can('client-edit')) {
             $can_edit = "style='display:none;'";
          }
          if (!auth()->user()->can('client-delete')) {
             $can_delete = "style='display:none;'";
          }
 
          $client = Client::orderby('created_at', 'desc')->get();
          return Datatables::of($client)
           
           
          
            ->addColumn('status', function ($client) {
               return $client->status ? '<span class="badge badge-success">Active</span>' : '<span class="badge badge-danger">Inactive</span>';
            })
            ->addColumn('action', function ($client) use ($can_view ,$can_edit, $can_delete) {
               $html = '<div class="btn-group">';
               $html .= '<a data-toggle="tooltip" ' . $can_view  . '  id="' . $client->id . '" class="btn btn-xs btn-success mr-1 view" title="View"><i class="fa fa-eye"></i> </a>';
               $html .= '<a data-toggle="tooltip" ' . $can_edit . '  id="' . $client->id . '" class="btn btn-xs btn-info mr-1 edit" title="Edit"><i class="fa fa-edit"></i> </a>';
               $html .= '<a data-toggle="tooltip" ' . $can_delete . ' id="' . $client->id . '" class="btn btn-xs btn-danger delete" title="Delete"><i class="fa fa-trash"></i> </a>';
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
            $haspermision = auth()->user()->can('client-create');
            if ($haspermision) {
               $view = View::make('backend.admin.client.create')->render();
               
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
            $haspermision = auth()->user()->can('client-create');
            if ($haspermision) {
   
               $rules = [
                 'name' => 'required',
                 'address'=>'required',
                 'mobile'=>'required',
                 'email'=>'required',
                 'contactperson'=>'required',
                // 'order_by'=>'required',
                 
               ];
   
               $validator = Validator::make($request->all(), $rules);
               if ($validator->fails()) {
                  return response()->json([
                    'type' => 'error',
                    'errors' => $validator->getMessageBag()->toArray()
                  ]);
                } 
                else {
                    //dd($request->input('order_by'));
                    if($request->input('order_by')){
                     $client = new Client;
                     $client->name = $request->input('name');
                     $client->address = $request->input('address');
                     $client->mobile = $request->input('mobile');
                     $client->email = $request->input('email');
                     $client->contactperson = $request->input('contactperson');
                     $client->order_by = $request->input('order_by');
                     
                    
                     $client->save(); //
                     return response()->json(['type' => 'success', 'message' => "Successfully Created"]);
                  }
                  else{
                     $client = new Client;
                     $client->name = $request->input('name');
                     $client->address = $request->input('address');
                     $client->mobile = $request->input('mobile');
                     $client->email = $request->input('email');
                     $client->contactperson = $request->input('contactperson');
                    
                     
                    
                     $client->save(); //
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
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request,Client $client)
    {
      if ($request->ajax()) {
         $haspermision = auth()->user()->can('client-edit');
         if ($haspermision) {
            $view = View::make('backend.admin.client.view', compact('client'))->render();
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
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request,Client $client)
    {
        if ($request->ajax()) {
            $haspermision = auth()->user()->can('client-edit');
            if ($haspermision) {
               $view = View::make('backend.admin.client.edit', compact('client'))->render();
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
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Client $client)
    {
        if ($request->ajax()) {
            $haspermision = auth()->user()->can('client-edit');
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
                     $client = Client::findOrFail($client->id);
                     $client->name = $request->input('name');
                     $client->address = $request->input('address');
                     $client->mobile = $request->input('mobile');
                     $client->email = $request->input('email');
                     $client->contactperson = $request->input('contactperson');
                     $client->order_by = $request->input('order_by');
                    
                     $client->status = $request->input('status');
                     $client->save(); //
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
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,Client $client)
    {
        if ($request->ajax()) {
            $haspermision = auth()->user()->can('client-delete');
            if ($haspermision) {
               $client->delete();
               return response()->json(['type' => 'success', 'message' => 'Successfully Deleted']);
            } else {
               abort(403, 'Sorry, you are not authorized to access the page');
            }
         } else {
            return response()->json(['status' => 'false', 'message' => "Access only ajax request"]);
         }
      }
    
}
