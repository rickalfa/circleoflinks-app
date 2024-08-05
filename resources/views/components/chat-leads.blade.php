<div>
    <!-- Always remember that you are absolutely unique. Just like everyone else. - Margaret Mead -->
    <div class="box-message">
        @php
    
         // print_r($conversations->messages);
    
        @endphp
    
    
           
           @foreach($conversations->messages as $message)
    
                @if($message->sender_type == 'user')
                <div class="row justify-content-start">
                  <div class="col-4 m-3 ">
    
                    <div class="d-inline-flex rounded-pill bg-success"> 
                      <div class="d-flex flex-row p-2 bd-highlight ">
                        <p class="p-1"> {{$message->content}}</p>
                        
                      </div>
    
                      <div class="d-flex align-items-end bd-highlight">
                        <div class=" p-2 bd-highlight">{{ $message->sent_at}}</div>
                      </div>
                   </div>
    
                  </div>
                </div>
    
                @else
    
            
                <div class="row justify-content-end">
                    <div class="col-4 m-2 ">
    
    
                      <div class="d-inline-flex rounded-pill bg-secondary"> 
                        <div class="d-flex flex-row p-2 bd-highlight ">
                          <p class="p-1"> {{$message->content}}</p>
                          
                        </div>
      
                        <div class="d-flex align-items-end bd-highlight">
                          <div class=" p-2 bd-highlight">{{ $message->sent_at}}</div>
                        </div>
                     </div>
    
    
                    </div>
                </div>
    
                @endif
    
        
      
           @endforeach
    
      </div>

      <form action="" method="post">
        <input type="text" name="message" id="">

        <button type="submit" class="btn btn-primary">Submit</button>

      </form>

</div>