<x-guest-layout>
    <title>Service-DemoWsp</title>

   
    <div class="container-fluid">
    
        <div  class="row justify-content-center align-items-center " style="height: 50px">
    
            <x-navbar-user/>
        </div>
        
       

        <div class="row vh-100">
            <div class="col-3 col-md-2">
                <x-navadmindashboard.nav-admindashboard/>
                
            </div>
            <div class="col bg-warning">
               
                    <!-- Page Content -->
         
                {{ $slot }}
           


            </div>
         
        
        </div>


    </div>
    


</x-guest-layout>