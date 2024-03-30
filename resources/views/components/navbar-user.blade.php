<!-- Barra de navegacion -->  
<nav id="navebar" class="navbar navbar-expand-lg fixed-top p-3 backopa" 
>
    <div class="container">
      <a class="navbar-brand text-white" href="{{ url('/')}}">Circle of links</a>

      <button id="buttonnav" class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse " id="navbarTogglerDemo02">
        <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
          <li class="nav-item ">
            <a class="nav-link " aria-current="page" href="#scrollspyHeading1">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link " href="#scrollspyHeading2">Project</a>
          </li>
          <li class="nav-item">
            <a class="nav-link " href="#scrollspyHeading3" >API V1 Doc</a>
         
          </li>

        </ul>

        @php
                  
        $user = Auth::user()

        @endphp

        <div class="align-items-center py-2">
          <div id="dropmenunav" class="dropdown dropstart">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">

              @auth

               {{ $user->name}}

              @endauth

              @unless (Auth::check())
                

              @endunless

              <i class="bi bi-person" style="font-size: 1.1rem; color: rgb(179, 13, 179);"> 
              </i>
              </a>


               <ul class="dropdown-menu dropdown-menu-dark">
             
              @auth
                  <li> 
                    <a class="dropdown-item" href="#">{{ $user->name}} </a>
                 </li>

                 <li><a class="dropdown-item" href="{{ route('profile.edit')}}">Perfil</a></li>
          
                     
               <form method="POST" action="{{ route('logout') }}">
                  @csrf

                  <x-dropdown-link :href="route('logout')"
                          onclick="event.preventDefault();
                                      this.closest('form').submit();">
                      {{ __('Log Out') }}
                  </x-dropdown-link>
                </form>

              @endauth
           
        
              @guest
                 
              <li>
                <!-- Button REGISTER Modal-->
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                  Register
                 </button>
              </li>
              
              <li> 
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop01">
                 Login
               </button>
              </li>
              @endguest
        

          </ul>
          </div>

        </div>
   

      </div>
 
    </div>

  </nav>