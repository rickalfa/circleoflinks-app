  
          <nav class="sidebar bg-dark text-white p-3">

            <div class="bg-info rounded-pill p-2">
              <a class="text-white" href="{{ url('/')}}">Demo Service</a>
      
            </div>

            <h2 class="text-center">Panel </h2>
            <button class="w3-bar-item w3-button w3-large"
            onclick="w3_close()">Close</button>
            <a href="#" class="w3-bar-item w3-button">Secure</a>
       
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link text-white" href="#">Inicio</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white w3-button" href="#submenu1" data-bs-toggle="collapse">Servicios</a>
                    <ul class="collapse nav flex-column ms-3" id="submenu1">
                        <li class="nav-item">
                            <a class="nav-link text-white w3-button" href="{{ url('/admindashboard')}}">Dashboard Admin</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="#">Servicio 2</a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item">
                  <a class="nav-link text-white w3-button" href="#submenu2" data-bs-toggle="collapse">Segurity</a>
                  <ul class="collapse nav flex-column ms-3" id="submenu2">
                      <li class="nav-item">
                          <a class="nav-link text-white w3-button" href="{{ url('/profile/accesstoken')}}">API Token</a>
                      </li>
                      <li class="nav-item">
                          <a class="nav-link text-white" href="#">Servicios 2</a>
                      </li>
                  </ul>
              </li>

                <li class="nav-item">
                    <a class="nav-link text-white" href="#">Contacto</a>
                </li>
            </ul>
        </nav>