<x-admindashboard>



    <div class="card" style="width: 18rem;">
        <div class="card-header">
          Name : {{ $Bot->name}}
        </div>
        <ul class="list-group list-group-flush">
          <li class="list-group-item">Cras justo odio</li>
          <li class="list-group-item">Dapibus ac facilisis in</li>
          <li class="list-group-item">Vestibulum at eros</li>
        </ul>
      </div>



      <div class="card text-white bg-dark mb-3" style="width: 100%;">
        <div class="card-header"><i class="bi bi-robot" style="font-size: 2rem; color: rgb(252, 249, 54);"></i>  Name : {{ $Bot->name}}</div>
        <div class="card-body">
          <h5 class="card-title">Dark card title</h5>
          <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
        </div>
      </div>




</x-admindashboard>