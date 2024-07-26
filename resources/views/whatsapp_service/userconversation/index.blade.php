
<x-admindashboard>

    <h3> Conversation Service WhatsApp </h3>

    
    <h1> Conversation Table from :</h1>
    @php
    $total_con = 0;

  @endphp
  
    @foreach ( $conversationsuser as $conversation)

    @php
      $total_con++;

     // print_r( $conversationsuser);
    @endphp
    @endforeach

    

    <div class="card">
        <h3> total conversation user : </h3>

       <p> total conversation : {{$total_con}}</p> 

    </div>

    <table class="table table-dark table-striped">
        
        <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">Type</th>
              <th scope="col">user</th>
              <th scope="col">agent - name</th>
              <th scope="col">date - create </th>
              <th scope="col">Detail </th>

            </tr>
          </thead>
          <tbody>
            @php
             $count = 1;   
             $total = 0;
            @endphp
            @foreach ( $conversationsuser as $conversation)

        
            <tr>
              <th scope="row">{{ $count++}}</th>
              <td>{{ $conversation->type}}</td>
              <td>{{ $conversation->user->name}}</td>
              <td>{{ $conversation->agent->name}}</td>
              <td>{{ $conversation->created_at}}</td>
              <td> <a class="button" href="{{ route('/admindashboard/userconversation-detail/', $conversation->id) }}">Details</a> </td>
            </tr>
            @endforeach
   
          </tbody>
      </table>

</x-admindashboard>






