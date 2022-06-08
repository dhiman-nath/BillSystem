<form id='create' action="" enctype="multipart/form-data" method="post" accept-charset="utf-8" class="needs-validation"
      novalidate>
    <div id="status"></div>
    <div class="form-row">
        <div class="form-group col-md-4 col-sm-12">
            <label for=""> Client Name </label>
            <input type="text" class="form-control" id="name" name="name" value=""
                   placeholder="" required>
            <span id="error_name" class="has-error"></span>
        </div>
        <div class="clearfix"></div>

       
        
     
       
        <div class="form-group col-md-4 col-sm-12">
            <label for=""> Mobile</label>
            <input type="text" class="form-control" id="mobile" name="mobile" value=""
                   placeholder="" required>
            <span id="error_mobile" class="has-error"></span>
        </div>
        <div class="clearfix"></div>

       
        <div class="form-group col-md-4 col-sm-12">
            <label for="">Email</label>
            <input type="text" class="form-control" id="email" name="email" value=""
                   placeholder="" required>
            <span id="error_email" class="has-error"></span>
        </div>
        <div class="clearfix"></div>
        <div class="form-group col-md-12 col-sm-12">
            <label for=""> Address </label>
            <!-- <input type="text" class="form-control" id="address" name="address" value=""
                   placeholder="" required> -->
            <textarea class="form-control" id="address" name="address"  value="" rows="2"  placeholder="" required></textarea>
            <span id="error_address" class="has-error"></span>
        </div>
        
        <div class="clearfix"></div>

     
        <div class="form-group col-md-6 col-sm-12">
            <label for=""> Contact_person </label>
            <input type="text" class="form-control" id="contactperson" name="contactperson" value=""
                   placeholder="" required>
            <span id="error_contactperson" class="has-error"></span>
        </div>
        <div class="clearfix"></div>

       <div class="form-group col-md-6 col-sm-12">
            <label for="">Order ID </label>
            <input type="text" class="form-control" id="order_by" name="order_by" value=""
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
        ajax_submit_store('client')
    });
</script>