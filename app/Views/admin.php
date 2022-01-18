<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SB Admin 2 - Login</title>

    <!-- Font Awesome -->
    <link href="<?= base_url() ?>/public/vendor/fontawesome-free/css/fontawesome.min.css" rel="stylesheet">

    <!-- Custom fonts for this template-->
    <link href="<?php echo base_url() ?>/public/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="<?php echo base_url() ?>/public/css/sb-admin-2.min.css" rel="stylesheet">

    <link href="<?= base_url() ?>/public/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
</head>

<body>
    <div class="container-fluid pt-3 bg-light">
        <div class="row">
            <div class="col-sm-12 text-center mb-3">
                <h3>Manajemen Pemesanan Lapangan</h3>
                <a href="#" onclick="tryLaporan()" class="badge badge-info">Laporan</a>
                <a href="#" onclick="tryPengaturan()" class="badge badge-info">Pengaturan</a>
                <a href="#" onclick="tryPass()" class="badge badge-info">Password</a>
                <a href="<?= base_url("/beranda/logout") ?>" class="badge badge-info">Logout</a>
            </div>
            <div class="col-md-5">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Tambah Pesanan</h4>
                        <p class="badge badge-danger" id="pesanError"></p>
                    </div>
                    <div class="card-body">
                        <form>
                            <div class="form-group row">
                                <label for="inputEmail3" class="col-sm-2 col-form-label">Nama</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="nama" name="nama">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="inputPassword3" class="col-sm-2 col-form-label">Tanggal</label>
                                <div class="col-sm-10">
                                    <input type="date" class="form-control" id="tanggal" name="tanggal">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="inputPassword3" class="col-sm-2 col-form-label">Jam</label>
                                <div class="col-sm-10">
                                    <select class="form-control" id="jam" name="jam">
                                        <?php if ($pengaturan["jamBuka"] > $pengaturan["jamTutup"]) {
                                            for ($i = $pengaturan["jamBuka"]; $i < 24; $i++) {
                                                echo "<option value='" . $i . "'>" . $i . ":00</option>";
                                            }
                                            for ($i = 1; $i < $pengaturan["jamTutup"] + 1; $i++) {
                                                echo "<option value='" . $i . "'>" . $i . ":00</option>";
                                            }
                                        } else {
                                            for ($i = $pengaturan["jamBuka"]; $i < $pengaturan["jamTutup"] + 1; $i++) {
                                                echo "<option value='" . $i . "'>" . $i . ":00</option>";
                                            }
                                        } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="inputPassword3" class="col-sm-2 col-form-label">Lapangan</label>
                                <div class="col-sm-10">
                                    <select id="lapangan" class="form-control">
                                        <?php for ($i = 0; $i < $pengaturan["jmlLap"]; $i++) : ?>
                                            <option value="<?= $i + 1 ?>">Lapangan <?= $i + 1 ?></option>
                                        <?php endfor; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="inputPassword3" class="col-sm-2 col-form-label">Bayar/DP</label>
                                <div class="col-sm-10">
                                    <input type="number" class="form-control" id="bayar" name="bayar">
                                </div>
                            </div>
                        </form>
                        <div class="form-group row">
                            <div class="col-sm-12 text-center">
                                <button class="btn btn-info" onclick="tambah()" id="tambah">Tambah</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-7">
                <div class="card mb-5">
                    <div class="card-header">
                        <h4 class="card-title">Daftar Pesanan</h4>
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <thead class=" text-info">
                                <th>Nama</th>
                                <th>Tanggal</th>
                                <th>Jam</th>
                                <th>Lapangan</th>
                                <th>Bayar</th>
                                <th>Tindakan</th>
                            </thead>
                            <tbody id="tabelPesanan">
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Daftar Pesanan Lunas Hari ini</h4>
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <thead class=" text-info">
                                <th>Nama</th>
                                <th>Tanggal</th>
                                <th>Jam</th>
                                <th>Lapangan</th>
                                <th>Bayar</th>
                            </thead>
                            <tbody id="tabelLunas">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="modalPelunasan" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Pelunasan</h5>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <input type="hidden" name="idPelunasan" id="idPelunasan">
                        <div class="col-sm-8">
                            <p class="badge badge-info">Pembayaran / Pelunasan pemesanan atas nama : </p>
                        </div>
                        <div class="col-sm-4">
                            <h5 id="namaPemesan"></h5>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="password" class="col-sm-3 col-form-label">Total Bayar</label>
                        <div class="col-sm-9">
                            <input type="number" class="form-control" id="pelunasan" name="pelunasan">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-4">
                        </div>
                        <div class="col-sm-8">
                            <input type="checkbox" class="form-check-input" id="lunas" name="lunas">
                            <label for="lunas">Lunas dan Selesai.</label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="login" onClick="bayar()" class="btn btn-info">Selesai</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalPengaturan" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Pengaturan</h5>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <label for="password" class="col-sm-3 col-form-label">Nama Usaha</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="namaUsaha" name="namaUsaha">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="password" class="col-sm-3 col-form-label">Jumlah Lapangan</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="jmlLapangan" name="jmlLapangan">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="password" class="col-sm-3 col-form-label">Jam Buka</label>
                        <div class="col-sm-9">
                            <select name="jamBuka" id="jamBuka" class="form-control">
                                <?php for ($i = 1; $i < 25; $i++) : ?>
                                    <option value="<?= $i ?>"><?= $i ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="password" class="col-sm-3 col-form-label">Jam Tutup</label>
                        <div class="col-sm-9">
                            <select name="jamTutup" id="jamTutup" class="form-control">
                                <?php for ($i = 1; $i < 25; $i++) : ?>
                                    <option value="<?= $i ?>"><?= $i ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="login" onClick="simpanPengaturan()" class="btn btn-info">Selesai</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade bd-example-modal-xl" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="modalLaporan">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                <div class="d-flex align-items-center">
                                    <div class="col-sm-4">
                                        <h2 class="card-title">Laporan</h2>
                                    </div>
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label for="pillInput" class="badge badge-info">Dari tgl</label>
                                            <input type="date" class="form-control input-pill" id="tanggalMulai" onChange="laporan()" placeholder="Rp">
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label for="pillInput" class="badge badge-info">Sampai tgl</label>
                                            <input type="date" class="form-control input-pill" onChange="laporan()" id="tanggalSelesai" placeholder="Rp">
                                        </div>
                                    </div>
                                    <div class="col-2">
                                        <div class="form-group">
                                            <p class="badge badge-info">Pemasukan :</p>
                                            <h5 class="card-title" id="pemasukan">Rp. 0</h5>
                                        </div>
                                    </div>

                                </div>
                                <div id="pesanErrorLaporan" class="badge badge-danger"></div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive" id="tempatTabelLaporan">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalPass" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ubah Password</h5>
                    <p class="badge badge-danger" id="pesanErrorPass"></p>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <label for="password" class="col-sm-3 col-form-label">Password Baru</label>
                        <div class="col-sm-9">
                            <input type="password" class="form-control" id="passBaru" name="passBaru">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="password" class="col-sm-3 col-form-label">Konfirmasi Password</label>
                        <div class="col-sm-9">
                            <input type="password" class="form-control" id="konfirPass" name="konfirPass">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="password" class="col-sm-3 col-form-label">Password Lama</label>
                        <div class="col-sm-9">
                            <input type="password" class="form-control" id="passLama" name="passLama">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="login" onClick="ubahPass()" class="btn btn-info">Ubah</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalHapus" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Hapus Pesanan</h5>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="idHapus" name="idHapus">
                    <p class="badge badge-danger" id="teksHapus"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" id="login" onClick="hapus()" class="btn btn-info">Hapus</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="<?php echo base_url() ?>/public/vendor/jquery/jquery.min.js"></script>

    <script>
        tampilkan()
        tampilLunas()

        function tambah() {
            $("#pesanError").html("")
            var nama = $("#nama").val()
            var tanggal = $("#tanggal").val()
            var jam = $("#jam").val()
            var lapangan = $("#lapangan").val()
            var bayar = $("#bayar").val()
            if (nama == "") {
                $("#nama").focus()
            } else if (tanggal == "") {
                $("#tanggal").focus()
            } else if (bayar == "") {
                $("#bayar").focus()
            } else {
                $.ajax({
                    url: '<?= base_url() ?>/admin/tambah',
                    method: 'post',
                    data: "nama=" + nama + "&tanggal=" + tanggal + "&jam=" + jam + "&lapangan=" + lapangan + "&bayar=" + bayar,
                    dataType: 'json',
                    success: function(data) {
                        console.log(data)
                        if (data) {
                            $("#pesanError").html(data)
                        } else {
                            $("#nama").val("")
                            $("#tanggal").val("")
                            $("#bayar").val("")
                            tampilkan()
                        }
                    }
                });
            }

        }

        function settanggal() {
            var now = new Date();
            var day = ("0" + now.getDate()).slice(-2);
            var month = ("0" + (now.getMonth() + 1)).slice(-2);
            var today = now.getFullYear() + "-" + (month) + "-" + (day);

            $("#tanggalMulai").val(today)
            $("#tanggalSelesai").val(today)
        }

        function laporan() {
            // tampilkanChart()
            var tanggalMulai = $("#tanggalMulai").val()
            var tanggalSelesai = $("#tanggalSelesai").val()

            if (tanggalMulai > tanggalSelesai) {
                $("#pesanErrorLaporan").html("Tanggal Mulai tidak Boleh Melebihi tanggal Selesai")
            } else {
                $("#pesanErrorLaporan").html("")

                var keuntungan = 0;
                var totalKeuntungan = 0;

                var tabel = '<table id="tabelLaporan" class="display table table-striped table-hover" ><thead><tr><th>NO</th><th>NAMA</th><th>TANGGAL</th><th>JAM</th><th>LAP</th><th>BAYAR</th></tr></thead><tbody>'

                $.ajax({
                    url: '<?= base_url() ?>/admin/laporan',
                    method: 'post',
                    data: "tanggalMulai=" + tanggalMulai + "&tanggalSelesai=" + tanggalSelesai,
                    dataType: 'json',
                    success: function(data) {
                        for (let i = 0; i < data.length; i++) {
                            totalKeuntungan += parseInt(data[i].bayar)
                            tabel += '<tr><td>' + (i + 1) + '</td><td>' + data[i].nama + '</td><td>' + data[i].tanggal + '</td><td>' + data[i].jam + ':00 </td><td>' + data[i].lapangan + '</td><td>' + formatRupiah(data[i].bayar.toString()) + '</td></tr>'
                        }

                        tabel += '</tbody></table>'
                        $("#tempatTabelLaporan").html(tabel)
                        $("#pemasukan").html('Rp. ' + formatRupiah(totalKeuntungan.toString()))

                        $('#tabelLaporan').DataTable({
                            "pageLength": 10,
                        });
                    }
                });

            }
        }

        function tryLaporan() {
            settanggal()
            laporan()
            $("#modalLaporan").modal("show")
        }

        function tryPengaturan() {
            $.ajax({
                url: '<?= base_url() ?>/admin/getPengaturan',
                method: 'post',
                data: "",
                dataType: 'json',
                success: function(data) {
                    $("#namaUsaha").val(data.nama)
                    $("#jmlLapangan").val(data.jmlLap)
                    $("#jamBuka").val(data.jamBuka)
                    $("#jamTutup").val(data.jamTutup)
                    $("#modalPengaturan").modal("show")
                }
            });
        }

        function simpanPengaturan() {
            var nama = $("#namaUsaha").val()
            var jmlLap = $("#jmlLapangan").val()
            var jamBuka = $("#jamBuka").val()
            var jamTutup = $("#jamTutup").val()

            if (nama == "") {
                $("#namaUsaha").focus()
            } else if (jmlLap == "") {
                $("#jmlLapangan").focus()
            } else {
                $.ajax({
                    url: '<?= base_url() ?>/admin/simpanPengaturan',
                    method: 'post',
                    data: "nama=" + nama + "&jmlLap=" + jmlLap + "&jamBuka=" + jamBuka + "&jamTutup=" + jamTutup,
                    dataType: 'json',
                    success: function(data) {
                        tampilkan()
                        tampilLunas()
                        $("#modalPengaturan").modal("hide")
                    }
                });

            }
        }

        function tryBayar(id, bayar, nama) {
            $("#lunas").prop("checked", false)
            $("#namaPemesan").html(nama)
            $("#pelunasan").val(bayar)
            $("#idPelunasan").val(id)
            $("#modalPelunasan").modal("show")
        }

        function bayar() {
            var id = $("#idPelunasan").val()
            var bayar = $("#pelunasan").val()
            var selesai = 0
            if ($("#lunas").prop("checked")) {
                selesai = 1
            }
            console.log(selesai)
            if (bayar == "") {
                $("#pelunasan").focus()
            } else {
                $.ajax({
                    url: '<?= base_url() ?>/admin/bayar',
                    method: 'post',
                    data: "id=" + id + "&bayar=" + bayar + "&selesai=" + selesai,
                    dataType: 'json',
                    success: function(data) {
                        $("#lunas").prop("checked", false)
                        $("#modalPelunasan").modal("hide")
                        tampilkan()
                        tampilLunas()
                    }
                });

            }
        }

        function tampilkan() {
            var baris = "";
            $.ajax({
                url: '<?= base_url() ?>/admin/pesanan',
                method: 'post',
                data: "",
                dataType: 'json',
                success: function(data) {
                    for (let i = 0; i < data.length; i++) {
                        baris += "<tr><td>" + data[i].nama + "</td><td>" + data[i].tanggal + "</td><td>" + data[i].jam + ".00 </td><td>" + data[i].lapangan + "</td><td>" + formatRupiah(data[i].bayar.toString()) + "</td><td> <a href='#' id='bayar" + data[i].id + "' class='badge badge-info p-2' onclick='tryBayar(" + data[i].id + ", \"" + data[i].bayar + "\", \"" + data[i].nama + "\")'><i class='fa fa-dollar-sign'></i></a> <a href='#' id='bayar" + data[i].id + "' class='badge badge-danger p-2' onclick='tryHapus(" + data[i].id + ", \"" + data[i].nama + "\", \"" + data[i].lapangan + "\", \"" + data[i].tanggal + "\", \"" + data[i].jam + ":00\"  )'><i class='fa fa-trash'></i></a></td></tr>"
                    }
                    if (data == "") {
                        baris = "<td colspan='6' class='text-center'>Data Masih Kosong :)</td>"
                    }
                    $("#tabelPesanan").html(baris)
                }
            });
        }


        function tampilLunas() {
            var baris = "";
            $.ajax({
                url: '<?= base_url() ?>/admin/lunasHariIni',
                method: 'post',
                data: "",
                dataType: 'json',
                success: function(data) {
                    for (let i = 0; i < data.length; i++) {
                        baris += "<tr><td>" + data[i].nama + "</td><td>" + data[i].tanggal + "</td><td>" + data[i].jam + ".00 </td><td>" + data[i].lapangan + "</td><td>" + formatRupiah(data[i].bayar.toString()) + "</td></tr>"
                    }

                    if (data == "") {
                        baris = "<td colspan='5' class='text-center'>Data Masih Kosong :)</td>"
                    }
                    $("#tabelLunas").html(baris)
                }
            });
        }

        function tryHapus(id, nama, lap, tgl, jam) {
            $("#idHapus").val(id)
            $("#teksHapus").html("Hapus pesanan '" + nama + "' lapangan " + lap + ", tanggal : " + tgl + " jam : " + jam + " ?")
            $("#modalHapus").modal("show")
        }

        function hapus() {
            var id = $("#idHapus").val()
            $.ajax({
                url: '<?= base_url() ?>/admin/hapus',
                method: 'post',
                data: "id=" + id,
                dataType: 'json',
                success: function(data) {
                    $("#modalHapus").modal("hide")
                    tampilkan()
                }
            });
        }

        function tryPass() {
            $("#passBaru").val("")
            $("#konfirPass").val("")
            $("#passLama").val("")
            $("#pesanErrorPass").html("")
            $("#modalPass").modal("show")
        }

        function ubahPass() {
            $("#pesanErrorPass").html("")
            var passBaru = $("#passBaru").val()
            var konfirPass = $("#konfirPass").val()
            var passLama = $("#passLama").val()
            if (passBaru == "") {
                $("#passBaru").focus()
            } else if (konfirPass == "") {
                $("#konfirPass").focus()
            } else if (passBaru == "") {
                $("#passLama").focus()
            } else {
                $.ajax({
                    url: '<?= base_url() ?>/admin/ubahPass',
                    method: 'post',
                    data: "passBaru=" + passBaru + "&konfirPass=" + konfirPass + "&passLama=" + passLama,
                    dataType: 'json',
                    success: function(data) {
                        if (data) {
                            $("#pesanErrorPass").html(data)
                        } else {
                            $("#modalPass").modal("hide")
                        }
                    }
                });
            }
        }

        function formatRupiah(angka, prefix) {
            var number_string = angka.replace(/[^,\d]/g, '').toString(),
                split = number_string.split(','),
                sisa = split[0].length % 3,
                rupiah = split[0].substr(0, sisa),
                ribuan = split[0].substr(sisa).match(/\d{3}/gi);

            if (ribuan) {
                separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }

            rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
            return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
        }
    </script>

    <script src="<?php echo base_url() ?>/public/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <script src="<?= base_url() ?>/public/vendor/datatables/jquery.dataTables.min.js"></script>


    <!-- Core plugin JavaScript-->
    <script src="<?php echo base_url() ?>/public/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="<?php echo base_url() ?>/public/js/sb-admin-2.min.js"></script>

</body>

</html>