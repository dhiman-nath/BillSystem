<div class="row">
    <div class="col-md-12 col-sm-12 table-responsive">
        <table id="view_details" class="table table-bordered table-hover">
            <tbody>
            <tr>
                <td> ClientName</td>
                <td> :</td>
                <td> {{ $client->name }} </td>
            </tr>
            <tr>
                <td> Address</td>
                <td> :</td>
                <td> {{ $client->address }} </td>
            </tr>
            <tr>
                <td> Mobile</td>
                <td> :</td>
                <td> {{ $client->mobile }} </td>
            </tr>
            <tr>
                <td> Email</td>
                <td> :</td>
                <td> {{ $client->email }} </td>
            </tr>

            <tr>
                <td> ContactPerson</td>
                <td> :</td>
                <td> {{ $client->contactperson }} </td>
            </tr>

            <tr>
                <td> OrderID</td>
                <td> :</td>
                <td> {{ $client->order_by }} </td>
            </tr>
            
           
            </tbody>
        </table>
    </div>
</div>