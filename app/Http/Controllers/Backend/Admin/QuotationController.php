<?php


namespace App\Http\Controllers\Backend\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Client;
use App\Models\Product;
use App\Models\Unit;
use App\Models\Order;
use View;
use DB;

class QuotationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $clients=Client::where('status',1)->get();
        $categories=Category::where('status',1)->get();
        return view('backend.admin.quotation.index', compact('clients','categories'));
        
    }

    public function getClientinfo(Request $request){
       // dd($id);
    
       $clients=Client::where('id',$request->client_id)->get();
        return response()->json($clients);
    }

     public function getProduct(Request $request){
    //    dd($request->product_id);
     
    if ($request->ajax()) {
        $item = $request->product_id;
         $val = explode(",", $item);
        $products = Product::find($val);
        $view = View::make('backend.admin.quotation.productinfo',compact('products'))->render();
        return response()->json(['html' => $view]);
    
  } else {
     return response()->json(['status' => 'false', 'message' => "Access only ajax request"]);
  }
  }

    
     public function getProductinfo(Request $request){
        // dd($id);
     
        $products=Product::where('id',$request->productinfo_id)->get();
       // dd($products[0]->unit_id);
        $units=Unit::where('id',$products[0]->unit_id)->get();
       $data=[$products,$units];
       // dd($data);
         return response()->json($data);
     }

     


     public function getSub(Request $request)
    {
       //dd($request->client_id,$request->category_id);
       if ($request->ajax()) {
           $client = ($request->client_id);
           //dd($client);
           $subcategories = Subcategory::where('category_id',$request->category_id)->get();
           $products = Product::where('category_id',$request->category_id)->get();
           $view = View::make('backend.admin.quotation.subcategoryname',compact('subcategories','products','client'))->render();return response()->json(['html' => $view]);
       
     } else {
        return response()->json(['status' => 'false', 'message' => "Access only ajax request"]);
     }

    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            //dd($request);
            $haspermision = auth()->user()->can('product-create');
            if ($haspermision) {
           
                $rules = [
                    'client_id' => 'required',
                     'buying' => 'required',
                     'nettotal' => 'required',
                     'discount' => 'required',
                     'payamount' => 'required',
                     'paidamount' => 'required',
                     'due' => 'required',
                     //'order_by'=>'required',
                     
                   ];
                   $validator = Validator::make($request->all(), $rules);
                   if ($validator->fails()) {
                      return response()->json([
                        'type' => 'error',
                        'errors' => $validator->getMessageBag()->toArray()
                      ]);
                    } 
                else{
                    $order = new Order;
                    $order->client_id= $request->input('client_id');
                    $order->buying= $request->input('buying');
                    $order->nettotal= $request->input('nettotal');
                    $order->discount= $request->input('discount');
                    $order->payamount= $request->input('payamount');
                    $order->paidamount= $request->input('paidamount');
                    $order->due= $request->input('due');
                    $order->save(); //
                   // $data->save();
                    $order->id;
                     return response()->json(['type' => 'success', 'message' => "Successfully Created"]);
                }
            }
            else {
                abort(403, 'Sorry, you are not authorized to access the page');
             }
            
        }
        else {
            return response()->json(['status' => 'false', 'message' => "Access only ajax request"]);
         }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Quotation  $quotation
     * @return \Illuminate\Http\Response
     */
    public function show(Quotation $quotation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Quotation  $quotation
     * @return \Illuminate\Http\Response
     */
    public function edit(Quotation $quotation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Quotation  $quotation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Quotation $quotation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Quotation  $quotation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Quotation $quotation)
    {
        //
    }
}
