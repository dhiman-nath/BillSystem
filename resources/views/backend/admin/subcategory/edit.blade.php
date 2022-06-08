<form id='edit' action="" enctype="multipart/form-data" method="post" accept-charset="utf-8">
 <div id="status"></div>
    {{method_field('PATCH')}}
    <div class="form-row">

    <div class="form-group col-md-4 col-sm-12">
            <label for=""> Select Category </label>
            <select name="category_id" class="form-control" required>
                            @foreach($categories as $category)
                               <option value="{{ $category->id }}" {{ $category->id == $subcategory->category_id ? 'selected' : '' }}>{{$category->name}}</option>
                             @endforeach
            </select>
            <span id="error_category_id" class="has-error"></span>
        </div>
       <div class="clearfix"></div>
        <div class="form-group col-md-4 col-sm-12">
            <label for=""> Subcategory_Name </label>
            <input type="text" class="form-control" id="subcategory_name" name="subcategory_name" value="{{ $subcategory->subcategory_name }}"
                   placeholder="" required>
            <span id="error_subcategory_name" class="has-error"></span>
        </div>
        <div class="clearfix"></div>

        <div class="form-group col-md-4 col-sm-12">
            <label for=""> Order_id </label>
            <input type="text" class="form-control" id="order_by" name="order_by" value="{{ $subcategory->order_by }}"
                   placeholder="" required>
            <span id="error_order_by" class="has-error"></span>
        </div>
        <div class="clearfix"></div>
       
        <div class="form-group col-md-4">
            <label for=""> Status </label><br/>
            <input type="radio" name="status" class="flat-green"
                   value="1" {{ ( $subcategory->status == 1 ) ? 'checked' : '' }} /> Active
            <input type="radio" name="status" class="flat-green"
                   value="0" {{ ( $subcategory->status == 0 ) ? 'checked' : '' }}/> In Active
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
        ajax_submit_update('subcategory', "{{ $subcategory->id }}")
    });
</script>