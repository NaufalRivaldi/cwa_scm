@extends('dashboard.base')

@section('content')

<div class="container-fluid">
  <div class="fade-in">
    <div class="row">
      <div class="col-md-12">

        <div class="card">
          <div class="card-header">
            <div class="row">
              <?php 
                $id = '';
                if(!empty($perusahaan)){
                  $id = $perusahaan->id;
                }
              ?>
              <div class="col-md-6">
                <a href="{{ route('perusahaan.form') }}" class="btn btn-primary {{ (!empty($perusahaan))? 'disabled' : '' }}">
                  <i class="cil-pencil"></i> Set Data
                </a>
                <a href="{{ route('perusahaan.edit', ['id' => $id]) }}" class="btn btn-success {{ (empty($perusahaan))? 'disabled' : '' }}">
                  <i class="cil-cog"></i> Edit Data
                </a>
              </div>

            </div>
          </div>
          <div class="card-body">
            @if (!empty($perusahaan))
            <div class="row">
              <div class="col-md-2 text-right">
                Nama Perusahaan :
              </div>
              <div class="col-md-10">
                {{ $perusahaan->nama }}
              </div>
              <hr>
            </div>
            <div class="row">
              <div class="col-md-2 text-right">
                Alamat :
              </div>
              <div class="col-md-10">
                {{ $perusahaan->alamat }}
              </div>
              <hr>
            </div>
            <div class="row">
              <div class="col-md-2 text-right">
                Telepon :
              </div>
              <div class="col-md-10">
                {{ $perusahaan->telp }}
              </div>
              <hr>
            </div>
            <div class="row">
              <div class="col-md-2 text-right">
                Fax :
              </div>
              <div class="col-md-10">
                {{ $perusahaan->fax }}
              </div>
              <hr>
            </div>
            <div class="row">
              <div class="col-md-2 text-right">
                Email :
              </div>
              <div class="col-md-10">
                {{ $perusahaan->email }}
              </div>
              <hr>
            </div>
            <div class="row">
              <div class="col-md-2 text-right">
                PIC :
              </div>
              <div class="col-md-10">
                {{ $perusahaan->pic }}
              </div>
              <hr>
            </div>
            <div class="row">
              <div class="col-md-2 text-right">
                Logo :
              </div>
              <div class="col-md-10">
                <img src="{{ asset('upload/logo/'.$perusahaan->logo) }}" alt="logo-perusahaan" width="100px" class="mb-3">
              </div>
              <hr>
            </div>
            <div class="row">
              <div class="col-md-2 text-right">
                Cap :
              </div>
              <div class="col-md-10">
                <img src="{{ asset('upload/cap/'.$perusahaan->cap) }}" alt="logo-perusahaan" width="100px" class="mb-3">
              </div>
              <hr>
            </div>
            @else
            <p class="text-danger">Tidak ada data, segera set data perusahaan.</p>    
            @endif
          </div>
        </div>

      </div>
    </div>
  </div>
</div>

@endsection

@section('javascript')

  <script>
    $(document).on('click', '.btn-delete', function(e){
      e.preventDefault();

      var id = $(this).data('id');
      console.log(id);
      swal({
        title: "Hapus Data Wilayah?",
        text: "Data akan terhapus secara permanen.",
        icon: "warning",
        buttons: true,
        dangerMode: true,
      })
      .then((willDelete) => {
        if (willDelete) {
          $.ajax({
            type: 'POST',
            data: {
              'id': id,
              '_token': '{{ csrf_token() }}'
            },
            url: "{{ route('wilayah.destroy') }}",
            success: function(data){
              location.reload();
              // console.log(data);
            }
          });
        }
      });
    });
  </script>
  
@endsection
