<div class="c-wrapper">
  <header class="c-header c-header-light c-header-fixed c-header-with-subheader">
    <button class="c-header-toggler c-class-toggler d-lg-none mr-auto" type="button" data-target="#sidebar" data-class="c-sidebar-show"><span class="c-header-toggler-icon"></span></button><a class="c-header-brand d-sm-none" href="#"><img class="c-header-brand" src="{{ asset('/assets/brand/coreui-base.svg') }}" width="97" height="46" alt="CoreUI Logo"></a>
    <button class="c-header-toggler c-class-toggler ml-3 d-md-down-none" type="button" data-target="#sidebar" data-class="c-sidebar-lg-show" responsive="true"><span class="c-header-toggler-icon"></span></button> 
    <ul class="c-header-nav ml-auto mr-4">
      <li class="c-header-nav-item dropdown"><a class="c-header-nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
        <div class="c-avatar"><i class="fa fa-user"></i></div>
        Halo, {{ Auth::user()->nama }}
        <div class="dropdown-menu dropdown-menu-right pt-0">
          <div class="dropdown-header bg-light py-2"><strong>Settings</strong></div>
          <a class="dropdown-item" href="{{ route('profile.index') }}">
            <svg class="c-icon mr-2">
              <use xlink:href="{{ asset('/assets/icons/coreui/free-symbol-defs.svg#cui-user') }}"></use>
            </svg> Profile</a>
          <a class="dropdown-item" href="{{ route('profile.ubahpassword') }}">
            <svg class="c-icon mr-2">
              <use xlink:href="{{ asset('/assets/icons/coreui/free-symbol-defs.svg#cui-settings') }}"></use>
            </svg> Ubah Password</a>
          <a class="dropdown-item" href="#">
            <svg class="c-icon mr-2">
              <use xlink:href="{{ asset('/assets/icons/coreui/free-symbol-defs.svg#cui-account-logout') }}"></use>
            </svg><form action="{{ route('logout') }}" method="POST"> @csrf <button type="submit" class="btn btn-ghost-dark btn-block">Logout</button></form></a>
        </div>
      </li>
    </ul>
    <div class="c-subheader px-3">
      <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="">Home</a></li>
        <?php $segments = ''; ?>
        @for($i = 1; $i <= count(Request::segments()); $i++)
            <?php $segments .= '/'. Request::segment($i); ?>
            @if($i < count(Request::segments()))
                <li class="breadcrumb-item">{{ ucwords(Request::segment($i)) }}</li>
            @else
                <li class="breadcrumb-item active">{{ ucwords(Request::segment($i)) }}</li>
            @endif
        @endfor
      </ol>
    </div>
</header>