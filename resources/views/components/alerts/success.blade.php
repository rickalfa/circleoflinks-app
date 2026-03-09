
@props(['key'])

@if(session()->has($key)) 



<div id="alert-box" class="container mt-3">
<div class="alert alert-success alert-dismissible fade show">

<div>
{{ session($key) }}
</div>

<button class="btn-close" data-bs-dismiss="alert"></button>

</div>

</div>

@endif