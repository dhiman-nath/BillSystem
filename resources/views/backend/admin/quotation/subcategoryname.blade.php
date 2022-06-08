
@foreach($subcategories as $subcategory)
  <p id="subcategory_id"> {{$subcategory->subcategory_name}}</p>
  <div class="form-group col-md-12">
    @foreach($products as $product)
      @if($product->subcategory_id == $subcategory->id)
        <div class="form-check form-check-inline">
          <input class="form-check-input" type="checkbox" id="inlineCheckbox1" value="{{ $product->id }}">
          <label class="form-check-label" for="inlineCheckbox1"> {{ $product->product_name }} </label>
        </div>
      @endif
    @endforeach
  </div>
@endforeach
<input type="hidden"  id="client" name="client" value="{{$client}}"> 

<div id="product_info" class="col-md-12 table-responsive">
  <table class="table table-bordered">
    <thead>
      <tr>
        <th scope="col">Product Name</th>
        <th scope="col">Quantity</th>
        <th scope="col">Unit</th>
        <th scope="col">Buying Price</th>
        <th scope="col">Unit price</th>
        <th scope="col">Total</th>
      </tr>
    </thead>
    <tbody id="Slip"></tbody>
 </table>

  <table  class="table table-bordered">
    <tbody>
      <tr>
         <td><label for="buying">Total Buying Price</label>
          <input type="text" class="form-control" id="buying" name="buying" value=""readonly></td>
          
          <td> <label for="nettotal"> Net Total</label>
          <input type="text" class="form-control" id="nettotal" name="nettotal" value=""readonly></td>
          
          <td><label for="discount">Discount</label>
          <input type="text" class="form-control" id="discount" name="discount" onkeyup=math(this) value=""></td>
          <td><label for="payamount">Payable Amount</label>
          <input type="text" class="form-control" id="payamount" name="payamount" value=""readonly></td>

          <td><label for="paidamount">Paid Amount</label>
          <input type="text" class="form-control" id="paidamount" name="paidamount" onkeyup=math(this)  value="" ></td>

          <td><label for="due">Due</label>
          <input type="text" class="form-control" id="due" name="due" value=""readonly></td>
      </tr>
    </tbody>
  </table>
</div>
<div class="col-md-12">
  <button type="submit" class="btn btn-success button-submit" data-loading-text="Loading...">
  <span class="fa fa-save fa-fw"></span> Save </button>
</div>







<script type="text/javascript">
  $('.form-check-input').click(function(){
    if($(this).is(':checked')){
      var str = $(this).val();
      $.ajax({
        url: 'getProductinfo/',
        type: 'get',
        dataType: 'json',
        data:{'productinfo_id':str},
        success: function(response){
          $('#product_info').html(response.html);
          $('#Slip').append("<tr id=data_"+response[0][0].id+" class=data><input type=hidden class=form-control id=product_id name=product_id[] value="+response[0][0].id+" readonly><td><input type=text class=form-control id=product name=product[] value="+response[0][0].product_name+" readonly></td><td><input type=text class=form-control name=quantity[]  id=quantity_"+response[0][0].id+" onkeyup=math(this) value=1></td><td><input type=text class=form-control id=unit value="+response[1][0].unit_name+" readonly></td><td><input type=text class=form-control value="+response[0][0].buying_price+" id=buyingprice_"+response[0][0].id+" name=buying_price readonly></td><td><input type=text class=form-control value="+response[0][0].selling_price+" id=unitprice_"+response[0][0].id+" name=unit_price[]  onkeyup=math(this)></td><td><input  name=total  type=text class=form-control  id=total_"+response[0][0].id+" value="+response[0][0].selling_price+" readonly></td><input  name=buyingtotal  type=hidden class=form-control  id=buyingtotal_"+response[0][0].id+" value="+response[0][0].buying_price+" ></tr>");

          var value=0;
          $('input[name=total]').each(function(){
            value +=  + $(this).val();
          });
          $("#nettotal").val(value);

          // var buying_total=0;
          // $('input[name=buying_price]').each(function(){
          //   buying_total +=  + ( $('input[name=quantity[]]').val() * $(this).val());
          // });
          // $("#buying").val(buying_total);

          var b_total=0;
          $('input[name=buyingtotal]').each(function(){
            b_total +=  +$(this).val();
          });
           $("#buying").val(b_total);

          var discount=$('#discount').val();
          var payable_amount= Number($("#nettotal").val()) - (Number($("#nettotal").val()) * Number(discount/100));
          $("#payamount").val(payable_amount);

          var paid = $('#paidamount').val();
          var due = Number($("#payamount").val()) - Number(paid);
          $("#due").val(due);
        }
      });
    }
    else{
      var val=$(this).val();
      $("#data_"+val).remove();

      var value=0;
      $('input[name=total]').each(function(){
        value +=  + $(this).val();
      });
      $("#nettotal").val(value);

      var b_total=0;
      $('input[name=buyingtotal]').each(function(){
        b_total +=  +$(this).val();
      });
      $("#buying").val(b_total);

      var discount=$('#discount').val();
      var payable_amount= Number($("#nettotal").val()) - (Number($("#nettotal").val()) * Number(discount/100));
      $("#payamount").val(payable_amount);
      
      var paid = $('#paidamount').val();
      var due = Number($("#payamount").val()) - Number(paid);
      $("#due").val(due);
    }
  });
  

  function math(arg){
    var id=arg.getAttribute('id');
    var y=id.split("_");
    var buyingtotal = Number($("#quantity_"+y[1]).val()) * Number($("#buyingprice_"+y[1]).val());
    var total= Number($("#quantity_"+y[1]).val()) * Number($("#unitprice_"+y[1]).val());
    $("#total_"+y[1]).val(total);
    $("#buyingtotal_"+y[1]).val(buyingtotal);

    var value=0;
    $('input[name=total]').each(function(){
      value +=  + $(this).val();
    });
    $("#nettotal").val(value);

    var b_total=0;
    $('input[name=buyingtotal]').each(function(){
      b_total +=  +$(this).val();
    });
    $("#buying").val(b_total);

    var discount=$('#discount').val();
    var payable_amount= Number($("#nettotal").val()) - (Number($("#nettotal").val()) * Number(discount/100));
    $("#payamount").val(payable_amount);

    var paid = $('#paidamount').val();
    var due = Number($("#payamount").val()) - Number(paid);
    $("#due").val(due);

  }
</script>

<!-- <script>
    $('.button-submit').click(function () {
        // route name
        ajax_submit_store('quotation')
    });
</script> -->

<script type="text/javascript">


    $(document).ready(function () {

        /*$("select option").val(function (idx, val) {
            $(this).siblings("[value='" + this.value + "']").remove();
            return val;
        });*/


        $('.button-submit').click(function () {

           // var schedule_id = $("#schedule_id").val();
            //var subject_id = $("#subject_id").val();
           //var exam_type = $("#exam_type").val();

           

                $('#create').validate({
                    submitHandler: function (form) {

                        var myData = new FormData($("#create")[0]);
                        myData.append('_token', CSRF_TOKEN);

                        swal({
                            title: "Are you sure to submit?",
                            text: "Confirm To make order",
                            type: "warning",
                            showCancelButton: true,
                            closeOnConfirm: false,
                            showLoaderOnConfirm: true,
                            confirmButtonClass: "btn-danger",
                            confirmButtonText: "Yes, Submit!"
                        }, function () {
                            $.ajax({
                                url: '/admin/quotation',
                                type: 'POST',
                                data: myData,
                                dataType: 'json',
                                cache: false,
                                processData: false,
                                contentType: false,
                                success: function (data) {
                                    if (data.type === 'success') {
                                        swal("Done!", data.message, "success");
                                    } else if (data.type === 'error') {
                                        if (data.errors) {
                                            $.each(data.errors, function (key, val) {
                                                $('#error_' + key).html(val);
                                            });
                                        }
                                        $("#status").html(data.message);
                                        swal("Error sending!", "Please fix the errors", "error");
                                    }
                                }
                            });
                        });
                    }
                });


            

        });
    });

</script>




       
