
            <label for=""> Select Subcategory </label>
            <select id="subcategory_id" name="subcategory_id" class="form-control">
            @foreach($subcategories as $subcategory)
                <option value="{{ $subcategory->id }}">{{$subcategory->subcategory_name}}</option>
             @endforeach
                             
            </select>
            <span id="error_subcategory_id" class="has-error"></span>
       
