<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>Edit anggota | {{$anggota->nama}}</title>

  <!-- General CSS Files -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

  <!-- CSS Libraries -->
  <link rel="stylesheet" href="../node_modules/selectric/public/selectric.css">

  <!-- Template CSS -->
  <link rel="stylesheet" href="{{asset('assets/css/style.css')}}">
  <link rel="stylesheet" href="{{asset('assets/css/components.css')}}">

  <style>
    .name-ketua{
      font-size: 12px;
    }
    .profile{
      font-size: 12pt;
    }
  </style>
</head>
{{--Kurang breadcrumb--}}
<body class="layout-3">
  <div id="app">
    <div class="main-wrapper container">
      <x-navbar-2 nama="{{session()->get('nama')[0]}}" foto="{{session()->get('foto')[0]??'default.png'}}" time="{{date_diff(new DateTime(session()->get('sessiontime')[0]),new DateTime())->i}}"></x-navbar-2>
      
      <!-- Main Content -->
      <div class="main-content">
        <section class="section">
          <div class="section-header">
            <h1>Profile</h1>
            <div class="section-header-breadcrumb">
            <div class="breadcrumb-item"><a href="{{route('showInfoKomunitas.anggota',[$anggota->komunitasId])}}">Beranda Komunitas</a></div>
              <div class="breadcrumb-item">Edit anggota</div>
            </div>
          </div>
          @if($errors->any())
            <x-alert type="danger" title="Data tidak valid" msg="{{$errors->first()}}"></x-alert>
          @endif
          <div class="section-body">
            <div class="row mt-sm-4">
              <div class="col-12 col-md-12 col-lg-12">
                <div class="card profile-widget">
                  <div class="profile-widget-header">
                    <?php $profil = isset($anggota->foto)?$anggota->foto:'default.png'?>
                    <img alt="image" src="{{asset("assets/img/profil/$profil")}}" class="rounded-circle profile-widget-picture">
                    <div class="profile-widget-items">
                      <div class="profile-widget-item">
                        <div class="profile-widget-item-label ">Divisi</div>
                        <div class="profile-widget-item-value">{{$anggota->divisiNama??'-'}}</div>
                      </div>
                      <div class="profile-widget-item">
                        <div class="profile-widget-item-label">Jabatan</div>
                        <div class="profile-widget-item-value">{{$anggota->jabatan}}</div>
                      </div>
                      <div class="profile-widget-item">
                        <div class="profile-widget-item-label">Status</div>
                        <div class="badge badge-{{($anggota->statusacc==1)?'success':'danger'}}">{{($anggota->statusacc==1)?'Joined':'Not Joined'}}</div>
                      </div>
                    </div>
                  </div>
                  <div class="profile-widget-description">
                    <div class="profile-widget-name">{{$anggota->nama}} <div class="text-muted d-inline font-weight-normal"></div></div>
                    {{$anggota->deskripsi??'Anggota ini malas isi deskripsi'}}
                  </div>
                </div>
              </div>
              <div class="col-12 col-md-12 col-lg-12">
              @if ($errors->any())
                <x-alert type="danger" title="Data tidak valid" msg="{{$errors->first()}}"></x-alert>
              @endif  
              <div class="card">
                <div class="card-body">
                  <form action="{{route('updateAnggota.anggota',[$anggota->anggotaId])}}" method="post"  enctype="multipart/form-data">
                    @csrf
                    <div class="section-title mt-0">Data Diri</div>
                    <div class="row">
                      <div class="form-group col-12">
                        <label for="nama">Nama Lengkap</label>
                        <input type="text" class="form-control" value="{{$anggota->nama}}" name="nama">
                      </div>
                      <div class="form-group col-6">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" value="{{$anggota->email}}" name="email">
                      </div>
                      <div class="form-group col-6">
                        <label for="telepon">No Telepon</label>
                        <input type="tel" class="form-control phone-number" value="{{$anggota->noTelp}}" name="noTelp">
                      </div>
                      <div class="form-group col-6">
                        <label>Fakultas</label>
                        <select class="form-control selectric" name="fakultas">
                          @foreach($listFakultas as $fakultas)
                            @if($fakultas==$anggota->fakultas)
                              <option selected="selected">{{$fakultas}}</option>
                            @else
                              <option>{{$fakultas}}</option>
                            @endif
                          @endforeach
                        </select>
                      </div>
                      <div class="form-group col-6">
                        <label for= "domisili">Domisili</label>
                        <input type="text" class="form-control" value="{{$anggota->domisili}}" name="domisili">
                      </div>
                      <div class="form-group col-6">
                        <label for= "jenisK">Jenis Kelamin</label>
                        <select class="form-control selectric" name="jenisK">
                          @if($anggota->jenisKelamin=='Laki-laki')
                            <option selected="selected">Laki-laki</option>
                            <option>Perempuan</option>
                          @else
                            <option selected="selected">Perempuan</option>
                            <option>Laki-laki</option>
                          @endif
                        </select>
                      </div>
                      <div class="form-group col-6">
                        <label for= "foto">Foto profil</label>
                        <input type="file" class="form-control" name="foto">
                      </div>
                    </div>
                    <div class="section-title mt-0">Sosial Media</div>
                    <div class="row">
                      <div class="form-group col-6">
                        <label for="nama">Instagram</label>
                        <input type="text" class="form-control" value="{{$anggota->ig??'-'}}" name="ig">
                      </div>
                      <div class="form-group col-6">
                        <label for="nama">Linkedin</label>
                        <input type="text" class="form-control" value="{{$anggota->linkedin??'-'}}" name="linkedin">
                      </div>
                      <div class="form-group col-6">
                        <label for="nama">Line</label>
                        <input type="text" class="form-control" value="{{$anggota->line??'-'}}" name="line">
                      </div>
                      <div class="form-group col-6">
                        <label for="nama">Whatsapp</label>
                        <input type="text" class="form-control" value="{{$anggota->wa??'-'}}" name="wa">
                      </div>
                    </div>
                    <div class="section-title mt-0">Data Keanggotaan</div>
                    <div class="row">
                      <div class="form-group col-6">
                        <label for="nama">Jabatan</label>
                        <input type="text" class="form-control" value="{{$anggota->jabatan}}" name="jabatan" readonly>
                      </div>
                      <div class="form-group col-6">
                        <label for="nama">Divisi</label>
                        <input type="text" class="form-control" value="{{$anggota->divisiNama??'-'}}" name="divisi" readonly>
                      </div>
                      <div class="form-group col-12">
                        <label for="nama">Deskripsi</label>
                        <input type="textarea" class="form-control" value="{{$anggota->deskripsi??'-'}}" name="desc">
                      </div>
                    </div>
                    <button type="submit" class="btn btn-primary btn-lg btn-block">
                      Simpan
                    </button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </section>
      </div>
      <x-footer></x-footer>
      
    </div>
  </div>

  <!-- General JS Scripts -->
  <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.nicescroll/3.7.6/jquery.nicescroll.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
  <script src="{{asset('assets/js/stisla.js')}}"></script>

  <!-- JS Libraies -->
  <script src="../node_modules/selectric/public/jquery.selectric.min.js"></script>

  <!-- Page Specific JS File -->

  <!-- Template JS File -->
  <script src="{{asset('assets/js/scripts.js')}}"></script>
  <script src="{{asset('assets/js/custom.js')}}"></script>
</body>
</html>
