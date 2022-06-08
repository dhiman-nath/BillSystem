<form id='edit' action="" enctype="multipart/form-data" method="post" accept-charset="utf-8">
 <div id="status"></div>
    {{method_field('PATCH')}}
    <div class="form-row">
        <div class="form-group col-md-4 col-sm-12">
            <label for=""> Vendor_Name </label>
            <input type="text" class="form-control" id="name" name="name" value="{{ $vendor->name }}"
                   placeholder="" required>
            <span id="error_name" class="has-error"></span>
        </div>
        <div class="clearfix"></div>

       

        <div class="form-group col-md-4 col-sm-12">
            <label for=""> Mobile </label>
            <input type="text" class="form-control" id="mobile" name="mobile" value="{{ $vendor->mobile }}"
                   placeholder="" required>
            <span id="error_mobile" class="has-error"></span>
        </div>
        <div class="clearfix"></div>

        <div class="form-group col-md-4 col-sm-12">
            <label for=""> Email </label>
            <input type="text" class="form-control" id="email" name="email" value="{{ $vendor->email }}"
                   placeholder="" required>
            <span id="error_email" class="has-error"></span>
        </div>
        <div class="clearfix"></div>

        <div class="form-group col-md-12 col-sm-12">
            <label for=""> Address </label>
            <!-- <input type="text" class="form-control" id="address" name="address" value=""
                   placeholder="" required> -->
            <textarea class="form-control" id="address" name="address"  value="" rows="2"  placeholder="" required>{{ $vendor->address }}</textarea>
            <span id="error_address" class="has-error"></span>
        </div>
        
        <div class="clearfix"></div>
        <div class="form-group col-md-6 col-sm-12">
            <label for=""> Contact_person </label>
            <input type="text" class="form-control" id="contactperson" name="contactperson" value="{{ $vendor->contactperson }}" placeholder="" required>
            <span id="error_contactperson" class="has-error"></span>
        </div>
        <div class="clearfix"></div>

        <div class="form-group col-md-6 col-sm-12">
            <label for=""> Order_id </label>
            <input type="text" class="form-control" id="order_by" name="order_by" value="{{ $vendor->order_by }}"
                   placeholder="" required>
            <span id="error_order_by" class="has-error"></span>
        </div>
        <div class="clearfix"></div>
       
        <div class="form-group col-md-4">
            <label for=""> Status </label><br/>
            <input type="radio" name="status" class="flat-green"
                   value="1" {{ ( $vendor->status == 1 ) ? 'checked' : '' }} /> Active
            <input type="radio" name="status" class="flat-green"
                   value="0" {{ ( $vendor->status == 0 ) ? 'checked' : '' }}/> In Active
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
        ajax_submit_update('vendor', "{{ $vendor->id }}")
    });
</script>