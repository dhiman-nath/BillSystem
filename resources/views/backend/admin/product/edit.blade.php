<form id='edit' action="" enctype="multipart/form-data" method="post" accept-charset="utf-8">
 <div id="status"></div>
    {{method_field('PATCH')}}
    <div class="form-row">

    <div class="form-group col-md-4 col-sm-12">
            <label for=""> Select Category </label>
            <select  id="category_id" name="category_id" class="form-control" required>
                            @foreach($categories as $category)
                               <option value="{{ $category->id }}" {{ $category->id == $product->category_id ? 'selected' : '' }}>{{$category->name}}</option>
                             @endforeach
            </select>
            <span id="error_category_id" class="has-error"></span>
        </div>
       <div class="clearfix"></div>

       <div class="form-group col-md-4 col-sm-12" id="subcategory_dropdown">
            <label for=""> Select Subcategory </label>
            <select id="subcategory_id" name="subcategory_id" class="form-control">
                           
            <option value="{{ $product->subcategory_id }}" selected>{{$product->subcategory_info->subcategory_name}}</option>
                             
            </select>
            <span id="error_subcategory_id" class="has-error"></span>
        </div>
       <div class="clearfix"></div>
        <div class="form-group col-md-4 col-sm-12">
            <label for=""> product_Name </label>
            <input type="text" class="form-control" id="product_name" name="product_name" value="{{ $product->product_name }}"
                   placeholder="" required>
            <span id="error_product_name" class="has-error"></span>
        </div>
        <div class="clearfix"></div>

        <div class="form-group col-md-4 col-sm-12">
            <label for=""> Order_id </label>
            <input type="text" class="form-control" id="order_by" name="order_by" value="{{ $product->order_by }}"
                   placeholder="" required>
            <span id="error_order_by" class="has-error"></span>
        </div>
        <div class="clearfix"></div>

        <div class="form-group col-md-4 col-sm-12">
            <label for="">Buying Price </label>
            <input type="text" class="form-control" id="buying_price" name="buying_price" value="{{ $product->buying_price }}"
                   placeholder="">
            <span id="error_buying_price" class="has-error"></span>
        </div>
       <div class="clearfix"></div>

       <div class="form-group col-md-4 col-sm-12">
            <label for="">Selling Price </label>
            <input type="text" class="form-control" id="selling_price" name="selling_price" value="{{ $product->selling_price }}"
                   placeholder="">
            <span id="error_selling_price" class="has-error"></span>
        </div>
       <div class="clearfix"></div>

       <div class="form-group col-md-4 col-sm-12">
            <label for=""> Select Unit </label>
            <select  id="unit_id" name="unit_id" class="form-control" required>
                            @foreach($units as $unit)
                               <option value="{{ $unit->id }}" {{ $unit->id == $product->unit_id ? 'selected' : '' }}>{{$unit->unit_name}}</option>
                             @endforeach
            </select>
            <span id="error_category_id" class="has-error"></span>
        </div>
       <div class="clearfix"></div>
       
        <div class="form-group col-md-4">
            <label for=""> Status </label><br/>
            <input type="radio" name="status" class="flat-green"
                   value="1" {{ ( $product->status == 1 ) ? 'checked' : '' }} /> Active
            <input type="radio" name="status" class="flat-green"
                   value="0" {{ ( $product->status == 0 ) ? 'checked' : '' }}/> In Active
        </div>
         <div class="clearfix"></div>
        
        <div class="form-group col-md-12 mb-3 mt-3">
            <button type="submit" class="btn btn-success button-submit"
                    data-loading-text="Loading..."><span class="fa fa-save fa-fw"></span> Save
            </button>
        </div>
    </div>
</div>
    

</form>
<script>
    $('input[type="radio"].flat-green').iCheck({
        radioClass: 'iradio_flat-green'
    });
    $('.button-submit').click(function () {
        // route name and record id
        ajax_submit_update('product', "{{ $product->id }}")
    });
</script>

<script type="text/javascript">
$(document).ready(function(){
    $('#category_id').change(function(){
        var id = $(this).val();

        $.ajax({
           url: 'getSubcategory/',
           type: 'get',
           dataType: 'json',
           data:{'category_id':id},
           success: function(response){
               $('#subcategory_dropdown').html(response.html);

           }
     });
    });
});
</script>