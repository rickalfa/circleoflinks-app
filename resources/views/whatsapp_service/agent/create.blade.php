<x-admindashboard>

    <h2> Create Bot </h2>

    <form action="{{url('/admindashboard/bots-r')}}" method="post">

        
        <section style="background-color: #2779e2;">
            <div class="container h-100">
              <div class="row d-flex justify-content-center align-items-center p-3 h-100">
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
                          @csrf
                        </div>
                      </div>
          
                      <hr class="mx-n3">
          
                      <div class="row align-items-center py-3">
                        <div class="col-md-3 ps-5">
          
                          <h6 class="mb-0">Description </h6>
          
                        </div>
                        <div class="col-md-9 pe-5">
          
                          <input type="text" name="description" class="form-control form-control-lg" placeholder="example@example.com" />
          
                        </div>
                      </div>



                      
                      <hr class="mx-n3">
          
                      <div class="row align-items-center py-3">
                        <div class="col-md-3 ps-5">
          
                          <h6 class="mb-0">Version Bot </h6>
          
                        </div>
                        <div class="col-md-9 pe-5">
          
                          <input type="text" name="version" class="form-control form-control-lg" placeholder="example@example.com" />
          
                        </div>
                      </div>

          
                      <hr class="mx-n3">
          
                      <div class="row align-items-center py-3">
                        <div class="col-md-3 ps-5">
          
                          <h6 class="mb-0">logic response</h6>
          
                        </div>
                        <div class="col-md-9 pe-5">
          
                          <textarea name="json_logic_response" class="form-control" rows="3" placeholder="Message sent to the employer"></textarea>
          
                        </div>
                      </div>
          
                      <hr class="mx-n3">
          
                      <div class="row align-items-center py-3">
                        <div class="col-md-3 ps-5">
          
                          <h6 class="mb-0">Upload CV</h6>
          
                        </div>
                        <div class="col-md-9 pe-5">
          
                          <input class="form-control form-control-lg" id="formFileLg" type="file" />
                          <div class="small text-muted mt-2">Upload your CV/Resume or any other relevant file. Max file
                            size 50 MB</div>
          
                        </div>
                      </div>
          
                      <hr class="mx-n3">
          
                      <div class="px-5 py-4">
                        <button type="submit" data-mdb-button-init data-mdb-ripple-init class="btn btn-primary btn-lg">Send application</button>
                      </div>
          
                    </div>
                  </div>
          
                </div>
              </div>
            </div>
          </section>
    </form>



</x-admindashboard>