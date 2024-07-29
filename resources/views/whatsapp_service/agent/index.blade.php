<x-admindashboard>

    <h3> Bots service Whatsapp </h3>

    
    <h1> Bots Table </h1>

    <a class="btn btn-primary btn-lg" href="{{url('/admindashboard/bots-r-fabric')}}"> Fabric-bot</a>

    <table class="table table-dark table-striped">
        
        <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">Bot-name</th>
              <th scope="col">version</th>
              <th scope="col">description</th>
            </tr>
          </thead>
          <tbody>
            @php

            $count = ($Bots->currentPage() - 1) * $Bots->perPage() + 1;
        @endphp



            @foreach ($Bots as $Bot)
            <tr>
              <th scope="row">{{ $count++}}</th>
              <td><i class="bi bi-robot" style="font-size: 2rem; color: rgb(252, 160, 54);"></i> {{ $Bot->name}}</td>
              <td>{{ $Bot->version}}</td>
              <td>{{ $Bot->description}}</td>
              <td> <a href="{{ route('/admindashboard/bots-r/', $Bot->id) }}">Details</a> </td>
            </tr>
            @endforeach
   
          </tbody>
      </table>

            <!-- Agregar enlaces de paginación -->
      <div class="d-flex justify-content-center">
        {{ $Bots->links('pagination::bootstrap-5') }}
      </div>

</x-admindashboard>