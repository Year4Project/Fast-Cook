@if(!empty(session('success')))
 <div class="alert alert-success" role="alert">
    {{session('success')}}
 </div>
@endif

@if (!empty(session('error')))
<div class="aler alert-danger" role="alert">
    {{session('error')}}
</div>
@endif

@if (!empty(session('payment-error')))
<div class="aler alert-error" role="alert">
    {{session('payment-error')}}
</div>
@endif

@if (!empty(session('warning')))
<div class="aler alert-warning" role="alert">
    {{session('warning')}}
</div>
@endif

@if (!empty(session('info')))
<div class="aler alert-info" role="alert">
    {{session('info')}}
</div>
@endif

@if (!empty(session('secondary')))
<div class="aler alert-secondary" role="alert">
    {{session('secondary')}}
</div>
@endif

@if (!empty(session('primary')))
<div class="aler alert-primary" role="alert">
    {{session('primary')}}
</div>
@endif

@if (!empty(session('light')))
<div class="aler alert-light" role="alert">
    {{session('light')}}
</div>
@endif
