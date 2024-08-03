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


            <input type="radio" class="btn-check" name="btnradio" id="btnradio1" autocomplete="off" >
            <label class="btn btn-outline-primary" for="btnradio1">
              <a href="{{route('/admindashboard/bots-r') }}"> Bots-R </a>
            </label>
          

            <input type="radio" class="btn-check" name="btnradio" id="btnradio1" autocomplete="off" checked>
            <label class="btn btn-outline-primary" for="btnradio2">
              Bots-R Actives
            </label>
          
            
            
          </div>
      </div>

  </div>

  @isset($success)
    <div class="row">
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
          <strong> Bots-r State</strong> {{$success}}
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    </div>

@endisset
<div class="row">
  <div class="alert alert-warning alert-dismissible fade show" role="alert">
    <strong> Bots-r State</strong> 
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
</div>


  @foreach($Bots as $Bot)

        @php

        $name_modal = "#staticBackdrop".$Bot->id;
        $name_modal_target = "staticBackdrop".$Bot->id;

      @endphp
        <!-- Vertically centered scrollable modal -->
    
        <div class="modal fade" id={{$name_modal_target}}  data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby={{$name_modal_target}} aria-hidden="true">
 
     
          <div class="modal-dialog modal-dialog-centered">
           <div class="modal-content">
            <div class="modal-body">
 
 
             <form action="{{ route('bot-r.update', $Bot->id) }}" method="POST">
               @csrf
               @method('PUT')
               <div class="form-group">
                   <label for="bot_name">Bot Name</label>
                   <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $Bot->name) }}" required>
                   @error('bot_name')
                       <div class="invalid-feedback">{{ $message }}</div>
                   @enderror
               </div>
               <div class="form-group">
                   <label for="description">Description</label>
                   <textarea name="description" class="form-control @error('description') is-invalid @enderror" required>{{ old('description', $Bot->description) }}</textarea>
                   @error('description')
                       <div class="invalid-feedback">{{ $message }}</div>
                   @enderror
               </div>
               <div class="form-group">
                   <label for="version">Version</label>
                   <input type="number" step="0.1" name="version" class="form-control @error('version') is-invalid @enderror" value="{{ old('version', $Bot->version) }}" required>
                   @error('version')
                       <div class="invalid-feedback">{{ $message }}</div>
                   @enderror
               </div>
               <div class="form-group">
                   <label for="status">Status</label>
                   <select name="status" class="form-control @error('status') is-invalid @enderror" required>
                       <option value="active" {{ old('status', $Bot->status) == 'active' ? 'selected' : '' }}>Active</option>
                       <option value="no-active" {{ old('status', $Bot->status) == 'no-active' ? 'selected' : '' }}>No-Active</option>
                   </select>
                   @error('status')
                       <div class="invalid-feedback">{{ $message }}</div>
                   @enderror
               </div>
               <button type="submit" class="btn btn-primary">Update</button>
             </form>
 
             <div class="modal-footer">
               <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
               
             </div>
       
             </div>
            </div>
          </div>
       </div>
@endforeach

    <table class="table table-dark table-striped">
        
        <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">Bot-name</th>
              <th scope="col">version</th>
              <th scope="col">Status</th>
              <th scope="col">Actions</th>
              
            </tr>
          </thead>
          <tbody>
       @php

            $count = ($Bots->currentPage() - 1) * $Bots->perPage() + 1;
        @endphp



            @foreach ($Bots as $Bot)

      
            @php

            $name_modal = "#staticBackdrop".$Bot->id;
         
    
          @endphp

            <tr>
              <th scope="row">{{ $count++}}</th>
              <td><i class="bi bi-robot" style="font-size: 2rem; color: rgb(252, 160, 54);"></i> {{ $Bot->name}}</td>
              <td>{{ $Bot->version}}</td>
              <td> {{ $Bot->status}}

                @if( $Bot->status == "active")
                <div class="light-point-green"></div>
                @else
                <div class="light-point-red"></div>
                @endif
              

              </td>

              <td>
              <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target={{$name_modal }}>
                Update Status
              </button>
              </td>
              
              <td> <a href="{{ route('/admindashboard/bots-r/', $Bot->id) }}">Details</a> </td>
            </tr>


                <!-- Modal Actualziacion -->





            @endforeach
   
          </tbody>
        </table>

            <!-- Agregar enlaces de paginación -->
      <div class="d-flex justify-content-center">
        {{ $Bots->links('pagination::bootstrap-5') }}
      </div>


  

</x-admindashboard>