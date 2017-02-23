<!DOCTYPE html>
<html>
<!-- Head -->
@include('layouts.head')

<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">
  <!-- Header -->
  @include('layouts.header')

  @include('layouts.sidebar')


  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        {{$page_title or ''}}
        <small>{{$page_description or ''}}</small>
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
      @yield('content')
    </section>
        <!-- right col -->
      </div>
      <!-- /.row (main row) -->
    <!-- /.content -->
  <!-- /.content-wrapper -->
  @include('layouts.footer')

</div>

</body>
</html>
