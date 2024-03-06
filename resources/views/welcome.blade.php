<x-guest-layout>

  <div class="container-fluid">
   <x-navbar-user/>
  </div>
  <div class="container">
        <!-- Content here -->


    

    <!-- START Main secctions -->
    <div class="pt-5" data-bs-spy="scroll" data-bs-target="#navbar-example2" data-bs-offset="0" class="scrollspy-example" tabindex="0">

     <!--- START HOME SECCITION-->
     <div class="row">
      <div class="col-md-7 col-xs-7 pt-5">
         <div id="scrollspyHeading1">

         
        <!-- Scrollable modal -->
<!-- Button trigger modal -->


<!-- Modal REGISTER START -->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Modal title</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <!--- FORMULARIO  -->
        <div class="input-group mb-3">
          <span class="input-group-text" id="basic-addon1">@</span>
          <input type="text" class="form-control" placeholder="Username" aria-label="Username" aria-describedby="basic-addon1">
        </div>
        
        <div class="input-group mb-3">
          <input type="text" class="form-control" placeholder="Recipient's username" aria-label="Recipient's username" aria-describedby="basic-addon2">
          <span class="input-group-text" id="basic-addon2">@example.com</span>
        </div>
        
        <label for="basic-url" class="form-label">Your vanity URL</label>
        <div class="input-group mb-3">
          <span class="input-group-text" id="basic-addon3">https://example.com/users/</span>
          <input type="text" class="form-control" id="basic-url" aria-describedby="basic-addon3">
        </div>
        
        <div class="input-group mb-3">
          <span class="input-group-text">$</span>
          <input type="text" class="form-control" aria-label="Amount (to the nearest dollar)">
          <span class="input-group-text">.00</span>
        </div>
        
        <div class="input-group mb-3">
          <input type="text" class="form-control" placeholder="Username" aria-label="Username">
          <span class="input-group-text">@</span>
          <input type="text" class="form-control" placeholder="Server" aria-label="Server">
        </div>
        
        <div class="input-group">
          <span class="input-group-text">With textarea</span>
          <textarea class="form-control" aria-label="With textarea"></textarea>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Understood</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal REGISTER END -->


<!-- Modal LOGIN START-->
<div class="modal fade" id="staticBackdrop01" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel01" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Login</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">

        <!-- Formulario LOGIN-->
        <form action="/action_page.php" class="was-validated">
          <div class="mb-3 mt-3">
            <label for="uname" class="form-label">Email:</label>
            <input type="email" class="form-control" id="uname" placeholder="Enter email" name="uname" required>
            <div class="valid-feedback">Valid.</div>
            <div class="invalid-feedback">Please fill out this field.</div>
          </div>
          <div class="mb-3">
            <label for="pwd" class="form-label">Password:</label>
            <input type="password" class="form-control" id="pwd" placeholder="Enter password" name="pswd" required>
            <div class="valid-feedback">Valid.</div>
            <div class="invalid-feedback">Please fill out this field.</div>
          </div>
          <div class="form-check mb-3">
            <input class="form-check-input" type="checkbox" id="myCheck"  name="remember" required>
            <label class="form-check-label" for="myCheck">I agree on blabla.</label>
            <div class="valid-feedback">Valid.</div>
            <div class="invalid-feedback">Check this checkbox to continue.</div>
          </div>
        <button type="submit" class="btn btn-primary">Submit</button>
        </form>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Understood</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal LOGIN END-->


            
             <h2>Circle of Links: La API pública para aprender y probar APIs</h2>
             <div>
                 <a href="#">
                     <x-application-logo  />
                 </a>
             </div>

          </div>
       </div>
       <!-- SubSeccion Card info-->
       <div class="col">

        <div class="card pt-5">
            <div class="card-header">
                ¿Para quién es Circle of Links?
            </div>
            <div class="card-body text-white-50 bg-dark">
              <blockquote class="blockquote mb-0 ">
                <p>Circle of Links es ideal para desarrolladores, estudiantes y cualquier persona interesada 
                    en aprender sobre APIs. Si estás buscando una forma fácil y rápida de probar APIs y aprender a usarlas, entonces Circle of Links es la solución perfecta para ti.</p>
                <footer class="blockquote-footer">Ricardo B. Dev <cite title="Source Title">S de  Conscientiamstudios</cite></footer>
              </blockquote>
            </div>
          </div>
       </div>

     </div>
      <!--- END HOME SECCITION-->

        <div id="scrollspyHeading2">

          <div class="backbody">
         
            <h2>seccion Project</h2>
            
          </div>

        </div>

        <div id="scrollspyHeading3">

            <h2>seccion API Doc</h2>

        </div>



    </div>
    <!-- END Main secctions -->
   
  </div>






</x-guest-layout>
