@if (session('warning'))
<div class="alert alert-warning alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    <h4><i class="fa fa-check" aria-hidden="true"></i> Warning</h4>
    <ul>
      <li>{{ session('warning') }}</li>
    </ul>
</div>
@endif
