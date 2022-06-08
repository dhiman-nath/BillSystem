<div class="col-md-12">

@php $i=1 @endphp
<table class="table table-bordered" width="100%">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Product Name</th>
      <th scope="col">Quantity</th>
      <th scope="col">Unit</th>
      <th scope="col">Buying Price</th>
      <th scope="col">Unit price</th>
      <th scope="col">Total</th>
    </tr>
  </thead>
  <tbody>
 
  @foreach($products as $product)
    <tr id="data">
      <th scope="row">{{ $i++ }}</th>
      <td><input type="text" class="form-control" id="product_name" name="product_name" value="{{ $product->product_name }}" readonly></td>
      <td> <input type="text" class="form-control" id="quantity_{{ $product->id }}" name="quantity" onkeyup="math(this)" value="1"></td>
      <td> <input type="text" class="form-control" id="unit" name="unit" value="{{ $product->unit_info->unit_name }}"  readonly></td>
      <td> <input type="text" class="form-control" id="buying_price" name="buying_price" value="{{ $product->buying_price }}"  readonly></td>
      <td> <input type="text" class="form-control" id="unitprice_{{ $product->id }}" name="unitprice" onkeyup="math(this)" value="{{ $product->selling_price }}"></td>
      <td> <input type="text" class="form-control" id="result_{{ $product->id }}" name="result" value="{{ $product->selling_price }}"  readonly></td>
      
    </tr>
    @endforeach
    <tr>
    <td colspan=5></td>
    <td> <label for="total"> Total</label></td>
    <td> <input type="text" class="form-control" id="nettotal" name="mobile" value=""placeholder="" readonly></td>
    </tr>
    
  </tbody>
</table>
<button type="button" class="btn btn-primary">Submit</button>
</div>

<script>
 function math(arg){
   
     var id=arg.getAttribute('id');
     var y=id.split("_");
   var total= Number($("#quantity_"+y[1]).val()) * Number($("#unitprice_"+y[1]).val());
  // console.log(total);
   $("#result_"+y[1]).val(total);
  
   
      var value=0;
     $('input[name=result]').each(function(){
      
   
       value +=  + $(this).val();
      });
      $("#nettotal").val(value);
  }

  var value=0;
     $('input[name=result]').each(function(){
      
   
       value +=  + $(this).val();
      });
      $("#nettotal").val(value);

</script>
