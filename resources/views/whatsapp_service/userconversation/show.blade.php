<x-admindashboard>


<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="#">Dashboardadmin</a></li>
      <li class="breadcrumb-item"><a href="#">Contact</a></li>
      <li class="breadcrumb-item"><a href="#">Conversations</a></li>
      <li class="breadcrumb-item active" aria-current="page">Detail</li>
    </ol>
  </nav>

<h1> Conversation Detail</h1>

<div class="container">


    @php

     // print_r($conversations->messages);

    @endphp

       @foreach($conversations->messages as $message)

            @if($message->sender_type == 'user')
            <div class="row justify-content-start">
              <div class="col-4 bg-success">
                <p> {{$message->content}}</p>
              </div>
            </div>

            @else

        
            <div class="row justify-content-end">
                <div class="col-4 bg-secondary">
                  <p> Bot dice : {{ $message->content }} </p>
                </div>
            </div>

            @endif

    
  
       @endforeach

</x-admindashboard>
