<div class="row">
    <div class="col-md-12 col-sm-12 table-responsive">
        <table id="view_details" class="table table-bordered table-hover">
            <tbody>
            <tr>
                <td> Product</td>
                <td> :</td>
                <td> {{ $product->product_name }} </td>
            </tr>
            <tr>
                <td> Category</td>
                <td> :</td>
                <td> {{ $product->category_info->name }} </td>
            </tr>

            <tr>
                <td> Subcategory</td>
                <td> :</td>
                <td> {{ $product->subcategory_info->subcategory_name }} </td>
            </tr>
            <tr>
                <td> Order ID</td>
                <td> :</td>
                <td> {{ $product->order_by }} </td>
            </tr>
            
    
            
            </tbody>
        </table>
    </div>
</div>