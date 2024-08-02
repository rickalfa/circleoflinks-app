<x-admindashboard>

    <h3> Bots service Whatsapp </h3>


    <h1> Bots Table </h1>

      <div class="row">
        <div class="d-grid gap-2 d-md-block">

            <a  href="{{url('/admindashboard/bots-r-fabric')}}" class="btn btn-primary" role="button"> 
              Fabric-bot
              <img src="{{ asset('imgs/svg/ampolleta_bot.svg') }}" alt="Descripción de la imagen" width="32px" height="32px">
          
            </a>
        </div>

          
          <div class="d-flex justify-content-center">

            <div class="btn-group" role="group" aria-label="Basic radio toggle button group">


              <input type="radio" class="btn-check" name="btnradio" id="btnradio1" autocomplete="off" checked>
              <label class="btn btn-outline-primary" for="btnradio1">Bots-R</label>
            

              <label class="btn btn-outline-primary" for="btnradio2">
                <a href="{{route('bot.actives') }}"> Bots-R Actives </a>
              </label>
            
              
              
            </div>
        </div>

    </div>

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