<div class="row">
    <div class="col-md-12 col-sm-12 table-responsive">
        <table id="view_details" class="table table-bordered table-hover">
            <tbody>
            <tr>
                <td> Subcategory</td>
                <td> :</td>
                <td> {{ $subcategory->subcategory_name }} </td>
            </tr>
            <tr>
                <td> Category</td>
                <td> :</td>
                <td> {{ $subcategory->category_info->name }} </td>
            </tr>
            <tr>
                <td> Order ID</td>
                <td> :</td>
                <td> {{ $subcategory->order_by }} </td>
            </tr>
            
    
            
            </tbody>
        </table>
    </div>
</div>