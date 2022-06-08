<form id='create' action="" enctype="multipart/form-data" method="post" accept-charset="utf-8" class="needs-validation"
      novalidate>
    <div id="status"></div>
    <div class="form-row">

    <div class="form-group col-md-4 col-sm-12">
            <label for=""> Select Category </label>
            <select name="category_id" class="form-control">
                            @foreach($categories as $category)
                               <option value="{{ $category->id }}">{{$category->name}}</option>
                             @endforeach
            </select>
            <span id="error_name" class="has-error"></span>
        </div>
       <div class="clearfix"></div>
        <div class="form-group col-md-4 col-sm-12">
            <label for=""> Subcategory Name </label>
            <input type="text" class="form-control" id="subcategory_name" name="subcategory_name" value=""
                   placeholder="" required>
            <span id="error_subcategory_name" class="has-error"></span>
        </div>
       <div class="clearfix"></div>


       <div class="form-group col-md-4 col-sm-12">
            <label for="">Order ID </label>
            <input type="text" class="form-control" id="order_by" name="order_by" value="1"
                   placeholder="" >
            <span id="error_order_by" class="has-error"></span>
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
        ajax_submit_store('subcategory')
    });
</script>