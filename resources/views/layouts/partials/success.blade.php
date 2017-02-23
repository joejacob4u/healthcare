@if (session('success'))
<div class="alert alert-success alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    <h4><i class="fa fa-check" aria-hidden="true"></i> Success!</h4>
    <ul>
      <li>{{ session('success') }}</li>
    </ul>
</div>
@endif
