<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Product;
use App\Models\Unit;
use View;
use DB;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('backend.admin.product.index');
    }

    public function getAll(Request $request)
    {
       if ($request->ajax()) {
         $can_view = $can_edit = $can_delete = '';
         if (!auth()->user()->can('product-view')) {
            $can_view = "style='display:none;'";
         }
          if (!auth()->user()->can('product-edit')) {
             $can_edit = "style='display:none;'";
          }
          if (!auth()->user()->can('product-delete')) {
             $can_delete = "style='display:none;'";
          }
 
          $product = Product::orderby('created_at', 'desc')->get();
          return Datatables::of($product)
           
          ->addColumn('category_name', function ($product) {
            return $product->category_info->name ;
         })

         ->addColumn('subcategory_name', function ($product) {
            return $product->subcategory_info->subcategory_name ;
         })

         ->addColumn('unit_name', function ($product) {
            return $product->unit_info->unit_name ;
         })
          
            ->addColumn('status', function ($product) {
               return $product->status ? '<span class="badge badge-success">Active</span>' : '<span class="badge badge-danger">Inactive</span>';
            })
            ->addColumn('action', function ($product) use ( $can_view, $can_edit, $can_delete) {
               $html = '<div class="btn-group">';
               $html .= '<a data-toggle="tooltip" ' . $can_view . '  id="' . $product->id . '" class="btn btn-xs btn-success mr-1 view" title="View"><i class="fa fa-eye"></i> </a>';
               $html .= '<a data-toggle="tooltip" ' . $can_edit . '  id="' . $product->id . '" class="btn btn-xs btn-info mr-1 edit" title="Edit"><i class="fa fa-edit"></i> </a>';
               $html .= '<a data-toggle="tooltip" ' . $can_delete . ' id="' . $product->id . '" class="btn btn-xs btn-danger delete" title="Delete"><i class="fa fa-trash"></i> </a>';
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
            $haspermision = auth()->user()->can('product-create');
            if ($haspermision) {
                $categories=Category::where('status',1)->orderby('order_by', 'asc')->get();
                $units=Unit::where('status',1)->orderby('order_by', 'asc')->get();
               
               $view = View::make('backend.admin.product.create',compact('categories','units'))->render();

               
               return response()->json(['html' => $view]);
            } else {
               abort(403, 'Sorry, you are not authorized to access the page');
            }
         } else {
            return response()->json(['status' => 'false', 'message' => "Access only ajax request"]);
         }
    }

    public function getSubcategory(Request $request)
    {
       //dd($request->category_id);
       if ($request->ajax()) {
        $haspermision = auth()->user()->can('product-create');
        if ($haspermision) {
            
            $subcategories=Subcategory::where('category_id',$request->category_id)->orderby('order_by', 'asc')->get();
           $view = View::make('backend.admin.product.subcategory_dropdown',compact('subcategories'))->render();

           
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
            $haspermision = auth()->user()->can('product-create');
            if ($haspermision) {
   
               $rules = [
                'category_id' => 'required',
                 'subcategory_id' => 'required',
                 'product_name' => 'required',
                 'buying_price' => 'required',
                 'selling_price' => 'required',
                 'unit_id' => 'required',
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
                     $product = new Product;
                     $product->category_id= $request->input('category_id');
                     $product->subcategory_id= $request->input('subcategory_id');
                     $product->product_name = $request->input('product_name');
                     $product->order_by = $request->input('order_by');
                     $product->buying_price = $request->input('buying_price');
                     $product->selling_price = $request->input('selling_price');
                     $product->unit_id = $request->input('unit_id');
                    
                     $product->save(); //
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
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request,Product $product)
    {
      if ($request->ajax()) {
         $haspermision = auth()->user()->can('product-create');
         if ($haspermision) {
             $categories=Category::where('status',1)->get();
             $units=Unit::where('status',1)->get();
           
            $view = View::make('backend.admin.product.view',compact('categories','units','product'))->render();

            
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
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request,Product $product)
    {
        if ($request->ajax()) {
            $haspermision = auth()->user()->can('product-create');
            if ($haspermision) {
                $categories=Category::where('status',1)->get();
                $units=Unit::where('status',1)->get();
              
               $view = View::make('backend.admin.product.edit',compact('categories','units','product'))->render();

               
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
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
      if ($request->ajax()) {
         $haspermision = auth()->user()->can('product-edit');
         if ($haspermision) {

            $rules = [
             'category_id' => 'required',
              'subcategory_id' => 'required',
              'product_name' => 'required',
              'buying_price' => 'required',
                 'selling_price' => 'required',
                 'unit_id' => 'required',
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
                  $product = Product::findOrFail($product->id);
                  $product->category_id = $request->input('category_id');
                  $product->subcategory_id = $request->input('subcategory_id');
                  $product->product_name = $request->input('product_name');
                  $product->order_by = $request->input('order_by');
                  $product->buying_price = $request->input('buying_price');
                  $product->selling_price = $request->input('selling_price');
                  $product->unit_id = $request->input('unit_id');
                 
                  $product->status = $request->input('status');
                  $product->save(); 
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
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,Product $product)
    {
        if ($request->ajax()) {
            $haspermision = auth()->user()->can('product-delete');
            if ($haspermision) {
               $product->delete();
               return response()->json(['type' => 'success', 'message' => 'Successfully Deleted']);
            } else {
               abort(403, 'Sorry, you are not authorized to access the page');
            }
         } else {
            return response()->json(['status' => 'false', 'message' => "Access only ajax request"]);
         }
      }
    
}
