<form id='create' action="" enctype="multipart/form-data" method="post" accept-charset="utf-8" class="needs-validation"
      novalidate>
    <div id="status"></div>
    <div class="form-row">

    <div class="form-group col-md-4 col-sm-12">
            <label for=""> Select Category </label>
            <select id="category_id" name="category_id" class="form-control">
            <option value="">----Select Ctegory-----</option>
                            @foreach($categories as $category)
                               <option value="{{ $category->id }}">{{$category->name}}</option>
                             @endforeach
            </select>
            <span id="error_category_id" class="has-error"></span>
        </div>
       <div class="clearfix"></div>

       <div class="form-group col-md-4 col-sm-12" id="subcategory_dropdown">
            <label for=""> Select Subcategory </label>
            <select id="subcategory_id" name="subcategory_id" class="form-control">
                           
            <option >-- Select SubCategory --</option>
                             
            </select>
            <span id="error_subcategory_id" class="has-error"></span>
        </div>
       <div class="clearfix"></div>

        <div class="form-group col-md-4 col-sm-12">
            <label for=""> Product Name </label>
            <input type="text" class="form-control" id="product_name" name="product_name" value=""
                   placeholder="" required>
            <span id="error_product_name" class="has-error"></span>
        </div>
       <div class="clearfix"></div>


       <div class="form-group col-md-4 col-sm-12">
            <label for="">Order ID </label>
            <input type="text" class="form-control" id="order_by" name="order_by" value="1"
                   placeholder="">
            <span id="error_order_by" class="has-error"></span>
        </div>
       <div class="clearfix"></div>

       <div class="form-group col-md-4 col-sm-12">
            <label for="">Buying Price </label>
            <input type="text" class="form-control" id="buying_price" name="buying_price" value=""
                   placeholder="">
            <span id="error_buying_price" class="has-error"></span>
        </div>
       <div class="clearfix"></div>

       <div class="form-group col-md-4 col-sm-12">
            <label for="">Selling Price </label>
            <input type="text" class="form-control" id="selling_price" name="selling_price" value=""
                   placeholder="">
            <span id="error_selling_price" class="has-error"></span>
        </div>
       <div class="clearfix"></div>

       <div class="form-group col-md-4 col-sm-12">
            <label for=""> Select Unit </label>
            <select id="unit_id" name="unit_id" class="form-control">
            <option value="">----Select Unit-----</option>
                            @foreach($units as $unit)
                               <option value="{{ $unit->id }}">{{$unit->unit_name}}</option>
                             @endforeach
            </select>
            <span id="error_unit_id" class="has-error"></span>
        </div>
       <div class="clearfix"></div>
        
        <div class="form-group col-md-12">
            <button type="submit" class="btn btn-success button-submit"
                    data-loading-text="Loading..."><span class="fa fa-save fa-fw"></span> Save
            </button>
        </div>
    </div>
</form>
<script>
    $('.button-submit').click(function () {
        // route name
        ajax_submit_store('product')
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