<x-admindashboard>
 

    <h1> user Table </h1>
    <h2> user Detail </h2>

    @php

    

    @endphp
    <div class="card" style="width:400px">
      <img class="card-img-top" src="https://avatar.vercel.sh/rauchg.svg?text=User" alt="Card image" style="width:100%">
      <div class="card-body">
        <h4 class="card-title">{{ $user->name}}</h4>
        <p class="card-text">.
        
          Email : {{ $user->email}} <br>
          Address : {{ $user->address}}
          
        </p>
        <a href="#" class="btn btn-primary">See Contact</a>
      </div>
    </div>

</x-admindashboard>
