<x-admindashboard>

    <h3> Contact app </h3>

    
    <h1> Contacts app Table </h1>

  
    <table class="table table-dark table-striped">
        
        <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">phone</th>
              <th scope="col">status user contact</th>
            </tr>
          </thead>
          <tbody>
            @php
             $count = 1;   
            @endphp
            @foreach ($Contacts as $Contact)
            <tr>
              <th scope="row">{{ $count++}}</th>
         
              <td>{{  $Contact->phone_number}}</td>
              <td>{{  $Contact->status}}</td>
              <td> <a href="{{ route('/admindashboard/contacts', $Contact->id) }}">Details</a> </td>
            </tr>
            @endforeach
   
          </tbody>
      </table>

</x-admindashboard>