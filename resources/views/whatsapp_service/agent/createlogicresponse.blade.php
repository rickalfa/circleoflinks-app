<x-admindashboard>


    <div class="container">

        <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{url('/admindashboard')}}">Dashboardadmin</a></li>
          <li class="breadcrumb-item"><a href="{{route('/admindashboard/bots-r')}}">Bots-r</a></li>
          <li class="breadcrumb-item active" aria-current="page">create - Logic response</li>
        </ol>
      </nav>

    <div class="container">
        
        <h2>Create Logic Response for <span class="badge bg-dark">{{ $agent->name }}</span></h2>
        <h3> now create LogicResponse for new Bot</h3>
    
    
        <form action="{{ route('logicresponse.store') }}" method="POST" >
            @csrf
    
    
    
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="key_trigger">Key Trigger</label>
                <input type="text" name="key_trigger" class="form-control @error('key_trigger') is-invalid @enderror" value="{{ old('key_trigger') }}" required>
                @error('key_trigger')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="response">Response</label>
                <textarea name="response" class="form-control @error('response') is-invalid @enderror" required>{{ old('response') }}</textarea>
                @error('response')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
    
    
            <input type="hidden" name="agent_id" value="{{$agent->id}}">
    
            <button type="submit" class="btn btn-primary"> crear logic Response</button>
        </form>
    </div>
    
    
    </x-admindashboard>