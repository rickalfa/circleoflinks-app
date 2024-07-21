<x-admindashboard>
 

    <h1> user Table </h1>

    <table class="table table-dark table-striped">
        
        <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">name</th>
              <th scope="col">email</th>
              <th scope="col">phone</th>
              <th scope="col">address</th>
            </tr>
          </thead>
          <tbody>
            @php
             $count = 1;   
            @endphp
            @foreach ($users as $user)
            <tr>
              <th scope="row">{{ $count++}}</th>
              <td>{{ $user->name}}</td>
              <td>{{ $user->email}}</td>
              <td>{{ $user->phone}}</td>
              <td>{{ $user->address}}</td>
              <td> <a href="{{ route('/admindashboard/user/', $user->id) }}">Details</a> </td>
            </tr>
            @endforeach
   
          </tbody>
      </table>

</x-admindashboard>
