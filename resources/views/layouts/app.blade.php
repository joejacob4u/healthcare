<!DOCTYPE html>
<html>
<!-- Head -->
@include('layouts.head')

<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">
  <!-- Header -->
  @include('layouts.header')

  @if(Auth::check() or Auth::guard('contractor')->check())

  @include('layouts.sidebar')

  @endif


  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        @yield('page_title')
        <small>@yield('page_description')</small>
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
