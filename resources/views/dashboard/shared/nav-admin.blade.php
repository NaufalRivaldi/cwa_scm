          
     
      <div class="c-sidebar-brand"><img class="c-sidebar-brand-full" src="{{ asset('img/logo/logo.png') }}" width="70%" alt="CoreUI Logo"><img class="c-sidebar-brand-minimized" src="{{ asset('img/logo/logo-min.png') }}" width="80%" alt="CoreUI Logo"></div>
      <ul class="c-sidebar-nav">
        <li class="c-sidebar-nav-item">
          <a href="{{ route('dashboard') }}" class="c-sidebar-nav-link">
            <i class="c-sidebar-nav-icon cil-home"></i>
            Dashboard
          </a>
        </li>
        <li class="c-sidebar-nav-title">MASTER</li>
        <li class="c-sidebar-nav-item">
          <a href="{{ route('user.index') }}" class="c-sidebar-nav-link">
            <i class="cil-user c-sidebar-nav-icon"></i>
            User
          </a>
        </li>
        <li class="c-sidebar-nav-item">
          <a href="{{ route('supplier.index') }}" class="c-sidebar-nav-link">
          <i class="cil-truck c-sidebar-nav-icon"></i>
          Supplier
          </a>
        </li>
        <li class="c-sidebar-nav-item">
          <a href="{{ route('cabang.index') }}" class="c-sidebar-nav-link">
          <i class="cil-factory c-sidebar-nav-icon"></i>
          Cabang
          </a>
        </li>
        <li class="c-sidebar-nav-item">
          <a href="{{ route('wilayah.index') }}" class="c-sidebar-nav-link">
          <i class="cil-send c-sidebar-nav-icon"></i>
          Wilayah
          </a>
        </li>
        <li class="c-sidebar-nav-dropdown">
          <a href="" class="c-sidebar-nav-dropdown-toggle">
          <i class="cil-barcode c-sidebar-nav-icon"></i>
          Barang
          </a>
          <ul class="c-sidebar-nav-dropdown-items">
            <li class="c-sidebar-nav-item">
              <a href="{{ route('merk.index') }}" class="c-sidebar-nav-link">
                <i class="cil-circle c-sidebar-nav-icon"></i>
                Merk
              </a>
              <a href="{{ route('barang.index') }}" class="c-sidebar-nav-link">
                <i class="cil-circle c-sidebar-nav-icon"></i>
                List Barang
              </a>
            </li>
          </ul>
        </li>
        <li class="c-sidebar-nav-title">PEMBELIAN</li>
        <li class="c-sidebar-nav-item">
          <a href="{{ route('po.index') }}" class="c-sidebar-nav-link">
          <i class="cil-file c-sidebar-nav-icon"></i>
          PO
          </a>
        </li>
        <li class="c-sidebar-nav-item">
          <a href="{{ route('verifikasi.index') }}" class="c-sidebar-nav-link">
          <i class="cil-file c-sidebar-nav-icon"></i>
          Verifikasi PO
          </a>
        </li>
        <li class="c-sidebar-nav-title">PENGATURAN</li>
        <li class="c-sidebar-nav-item">
          <a href="{{ route('perusahaan.index') }}" class="c-sidebar-nav-link">
          <i class="cil-bank c-sidebar-nav-icon"></i>
          Perusahaan
          </a>
        </li>
      </ul>

      <button class="c-sidebar-minimizer c-class-toggler" type="button" data-target="_parent" data-class="c-sidebar-minimized"></button>
    </div>