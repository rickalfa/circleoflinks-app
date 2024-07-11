







<div class="d-flex">
  <nav class="sidebar bg-light " style="top:40px;">
    <ul class="list-unstyled">
      <li>
        <a href="{{ url('/profile')}}" class="d-block py-2 px-3">Profile</a>
      </li>
      <li>
        <a href="#about" class="d-block py-2 px-3">About</a>
      </li>
      <li>
        <a href="#services" class="d-block py-2 px-3" data-bs-toggle="collapse" data-bs-target="#servicesSubmenu" aria-expanded="false">Services</a>
        <ul id="servicesSubmenu" class="collapse list-unstyled">
          <li><a href="#service1" class="d-block py-2 px-4">Service 1</a></li>
          <li><a href="#service2" class="d-block py-2 px-4">Service 2</a></li>
          <li><a href="#service3" class="d-block py-2 px-4">Service 3</a></li>
        </ul>
      </li>

       <li>
        <a class="d-block py-2 px-3" href="{{ url('/profile/accesstoken')}}">Access-API</a>
       </li>

      <li>
        <a href="#contact" class="d-block py-2 px-3">Contact</a>
      </li>

      <li>
        <a href="{{ url('/#about')}}" class="d-block py-2 px-3" >About</a>
      </li>



    </ul>
  </nav>
  <div class="content flex-grow-1 p-3">
    <!-- Main content goes here -->
  </div>
</div>