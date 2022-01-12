<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SB Admin 2 - Login</title>

    <!-- Custom fonts for this template-->
    <link href="<?php echo base_url() ?>/public/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="<?php echo base_url() ?>/public/css/sb-admin-2.min.css" rel="stylesheet">
    <style>
        .borderya {
            border: 0.001em solid #36b9cc;
        }

        .borderya td {
            border: 0.001em solid #36b9cc;
        }

        .borderya th {
            border: 0.001em solid #36b9cc;
        }
    </style>

</head>

<body>
    <input type="hidden" id="noWarna" value="0">
    <a href="#" class="badge badge-info float-right m-4" onclick="tryLogin()">Admin</a>
    <div class="container-fluid pt-3 bg-light">
        <h1 class="text-center">Daftar pesan lapangan di <?= $pengaturan["nama"] ?></h1>

        <table id="tabelPesan" class="display table table-hover text-center table-striped border-danger borderya text-dark">

            <?php
            $kumpulanJam = [];
            if ($pengaturan["jamBuka"] > $pengaturan["jamTutup"]) {
                for ($i = $pengaturan["jamBuka"]; $i < 25; $i++) {
                    array_push($kumpulanJam, $i);
                }
                for ($i = 1; $i <= $pengaturan["jamTutup"]; $i++) {
                    array_push($kumpulanJam, $i);
                }
            } else {
                for ($i = $pengaturan["jamBuka"]; $i <= $pengaturan["jamTutup"]; $i++) {
                    array_push($kumpulanJam, $i);
                }
            }

            for ($hari = -1; $hari < 7; $hari++) {
                if ($hari == -1) {
                    $jmlLap = 1;
                } else {
                    $jmlLap = $pengaturan["jmlLap"];
                }
                for ($lap = 0; $lap < $jmlLap; $lap++) {
                    echo "<tr>";
                    for ($jam = -2; $jam < count($kumpulanJam); $jam++) {
                        if ($jam == -2 and $hari == -1) {
                            echo "<th>HARI/JAM</th>";
                        } elseif ($hari == -1 and $jam == -1) {
                            echo "<th> Lap </th>";
                        } elseif ($hari == -1) {
                            echo "<th> " . $kumpulanJam[$jam] . ".00 </th>";
                        } elseif ($jam == -2 and $lap == 0) {
                            echo "<th rowspan='" . $jmlLap . "'> " . $tglHari[$hari][0] .  " </th>";
                        } elseif ($jam == -2 and $lap != 0) {
                        } elseif ($jam == -1) {
                            echo "<th> " . ($lap + 1) . " </th>";
                        } else {
                            $jamid = $kumpulanJam[$jam];
                            $tglid = date("Y-m-d", strtotime($tglHari[$hari][1]));
                            echo "<th id='k" . $tglid . $jamid . ($lap + 1) . "'> </th>";
                        }
                    }
                    echo "</tr>";
                }
            } ?>
        </table>

    </div>

    <!-- Modal -->
    <div class="modal fade" id="modalLogin" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Log in Admin</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p id="pesanError" class="badge badge-danger"></p>
                    <div class="form-group row">
                        <label for="password" class="col-sm-2 col-form-label">Password</label>
                        <div class="col-sm-10">
                            <input type="password" class="form-control" id="pass" name="password">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="login" onClick="login()" class="btn btn-info">Log in</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="<?php echo base_url() ?>/public/vendor/jquery/jquery.min.js"></script>

    <script>
        tampilkan()

        function tryLogin() {
            $("#pass").val("")
            $("#pesanError").html("")
            $("#modalLogin").modal("show")
            $("#pass").focus()
        }

        function login() {
            var pass = $("#pass").val()
            $.ajax({
                url: '<?= base_url() ?>/beranda/login',
                method: 'post',
                data: "pass=" + pass,
                dataType: 'json',
                success: function(data) {
                    if (data) {
                        $("#pesanError").html(data)
                    } else {
                        $("#modalLogin").modal("hide")
                        window.location.href = "<?= base_url("/admin") ?>"
                    }
                }
            });
        }

        function tampilkan() {
            var tanggal, jam = "";

            $.ajax({
                url: '<?= base_url() ?>/beranda/pesanan',
                method: 'post',
                data: "",
                dataType: 'json',
                success: function(data) {
                    for (let i = 0; i < data.length; i++) {
                        tanggal = data[i].tanggal;
                        jam = data[i].jam;
                        $("#k" + tanggal + jam + data[i].lapangan).html(data[i].nama)

                    }
                }
            });
        }

        function ubahWarna() {
            noWarna = parseInt($("#noWarna").val(), 10)
            var warna = ["#ADFF2F", "#7FFF00", "#7CFC00", "#00FF00", "#32CD32", "#98FB98", "#90EE90", "#00FA9A", "#00FF7F", "#3CB371", "#2E8B57", "#228B22", "#008000", "#006400", "#9ACD32", "#6B8E23", "#556B2F", "#66CDAA", "#8FBC8F", "#20B2AA", "#008B8B", "#008080", "#00FFFF", "#00FFFF", "#E0FFFF", "#AFEEEE", "#7FFFD4", "#40E0D0", "#48D1CC", "#00CED1", "#5F9EA0", "#4682B4", "#B0C4DE", "#ADD8E6", "#B0E0E6", "#87CEFA", "#87CEEB", "#6495ED", "#00BFFF", "#1E90FF", "#4169E1", "#0000FF", "#0000CD", "#00008B", "#000080", "#191970"]
            $(".borderya td").css({
                "border": "1px solid " + warna[noWarna]
            })
            $(".borderya th").css({
                "border": "1px solid " + warna[noWarna]
            })
            if (noWarna >= warna.length) {
                noWarna = -1
            }
            noWarna += 1
            $("#noWarna").val(noWarna)
        }

        // const interval = setInterval(function() {
        //     ubahWarna()
        // }, 2000);
    </script>

    <script src="<?php echo base_url() ?>/public/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="<?php echo base_url() ?>/public/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="<?php echo base_url() ?>/public/js/sb-admin-2.min.js"></script>

</body>

</html>