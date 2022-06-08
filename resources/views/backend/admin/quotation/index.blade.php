@extends('backend.layouts.master')
@section('title', 'Category')
@section('content')
<div class="row">
  <div class="col-md-12 col-sm-12">
    <div class="main-card mb-3 card">
      <div class="card-body">
        <form id='create' action="" enctype="multipart/form-data" method="post" accept-charset="utf-8" class="needs-validation" novalidate>
                <div id="status"></div>
                  <div class="form-row">
                    <div class="form-group col-md-6 col-sm-12">
                        <label for=""> Select Client </label>
                          <select name="client_id" id="client_id" class="form-control">
                              <option value="">----Select Client----</option>
                                @foreach($clients as $client)
                                  <option value="{{ $client->id }}">{{$client->name}}</option>
                                @endforeach
                          </select>
                          <span id="error_name" class="has-error"></span>
                    </div>
                    <div class="clearfix"></div>
                    <div class="form-group col-md-6 col-sm-12">
                      <label for="category_id">Category</label>
                      <select id='category_id' name='category' class="form-control dynamic">
                          <option value=''>-- Select Category --</option>
                          @foreach($categories as $category)
                            <option value='{{ $category->id }}'>{{ $category->name }}</option>
                          @endforeach
                      </select>
                  </div>
                  <div class="clearfix"></div>
                 
                  <!-- <div class="clearfix"></div> -->
                  
                  </div>
                  <div  id="subcategory_product"></div>
         
            </form>
          
            
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
$(document).ready(function(){
      $('#category_id').change(function(){
          var id = $(this).val();
          var client_id=$("#client_id").val();
          $.ajax({
            url: 'getSub/',
            type: 'get',
            dataType: 'json',
            data:{'category_id':id,'client_id':client_id},
            success: function(response){
                $('#subcategory_product').html(response.html);
              }
          });
      });
    });
</script>
@stop 

