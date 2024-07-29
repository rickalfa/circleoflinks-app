<x-admindashboard>

  
<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{url('/admindashboard')}}">Dashboardadmin</a></li>
    <li class="breadcrumb-item"><a href="{{route('/admindashboard/bots-r')}}">Bots-r</a></li>
    <li class="breadcrumb-item active" aria-current="page">create</li>
  </ol>
</nav>

    <h2> Create Bot </h2>
  <div class="container">
    <div class="row">
    <form action="{{route('bot.store')}}" method="post" >

         
              <div class="row d-flex justify-content-center align-items-center p-3 ">
                <div class="col-xl-9">
          
                  <h1 class="text-white mb-4">Bot Form</h1>
          
                  <div class="card" style="border-radius: 15px;">
                    <div class="card-body">
          
                      <div class="row align-items-center pt-4 pb-3">
                        <div class="col-md-3 ps-5">
          
                          <h6 class="mb-0">name BOT</h6>
          
                        </div>
                        <div class="col-md-9 pe-5">
          
                          <input type="text" name="name" class="form-control form-control-lg" />
                          @error('name')
                           <div class="invalid-feedback">{{ $message }}</div>
                         @enderror
                          @csrf
                        </div>
                      </div>
          
                      <hr class="mx-n3">
          
                      <div class="row align-items-center py-3">
                        <div class="col-md-3 ps-5">
          
                          <h6 class="mb-0">Description </h6>
          
                        </div>
                        <div class="col-md-9 pe-5">
          
                          <input type="text" name="description" class="form-control form-control-lg" placeholder="bot para presentacion" />
          
                        </div>
                      </div>



                      
                      <hr class="mx-n3">
          
                      <div class="row align-items-center py-3">
                        <div class="col-md-3 ps-5">
          
                          <h6 class="mb-0">Version Bot </h6>
          
                        </div>
                        <div class="col-md-9 pe-5">
          
                          <input type="text" name="version" class="form-control form-control-lg" placeholder="1.3 v" />
          
                        </div>
                      </div>

          
                      <hr class="mx-n3">
          
                      <div class="px-5 py-4">
                        <button type="submit" data-mdb-button-init data-mdb-ripple-init class="btn btn-primary btn-lg">create Bot</button>
                      </div>
          
                    </div>
                  </div>
          
                </div>
              </div>
           
        
    </form>
   </div>
  </div>


</x-admindashboard>