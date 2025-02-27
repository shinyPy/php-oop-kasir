<?php $title = "Laporan Penjualan" ?>
<?php include('../../../layout/header.php'); ?>
<?php include('../../../layout/navbar.php'); ?>
<?php include('../../../layout/sidebar.php'); ?>
<?php
include('../../../function/config.php');
$db = new DB();
?>

<main id="main" class="main">
    <div class="pagetitle">
        <h1>Laporan Penjualan</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= route('dashboard') ?>">Home</a></li>
                <li class="breadcrumb-item active">Laporan Penjualan</li>
            </ol>
        </nav>
    </div>
    <!-- End Page Title -->

    <section class="section dashboard">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="card-title">Laporan Penjualan Keseluruhan</div>
                    <div class="d-flex justify-content-end p-2">
                        <a href="cetak"><button class="btn btn-success"><i class="bi bi-printer"></i>&nbsp;&nbsp;Cetak</button></a>
                    </div>
                   
                        <table id="data-table" class="table">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>ID Transaksi</th>
                                    <th>Tanggal dan Waktu</th>
                                    <th>Total Harga</th>
                                </tr>
                            </thead>
                            <tbody id="laporan-list">
                            <?php foreach ($db->select('penjualan', '*', '', '', '', 'tanggal', 'DESC') as $index => $value) : ?>
                                    <tr class="laporan-row">
                                        <td><?= ($index + 1) ?></td>
                                        <td>KSRID/<?= $value['id'] ?></td>
                                        <td><?= date('d/m/y', strtotime($value['tanggal'])) ?></td>
                                        <td data-harga-total-transaksi="<?= $value['total_harga'] ?>"><?= 'Rp ' . number_format($value['total_harga'], 0, ',', '.'); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    // Set the default date format for the input field
    document.getElementById("hari-tanggal").valueAsDate = new Date();
</script>



</main>
<!-- End #main -->
<?php include('../../../layout/footer.php'); ?>
<script>
document.addEventListener("DOMContentLoaded", function () {
    const tanggalInput = document.getElementById("hari-tanggal");
    const laporanRows = document.querySelectorAll(".laporan-row");

    tanggalInput.addEventListener("input", function () {
        const selectedDate = tanggalInput.value;
        laporanRows.forEach(function (row) {
            const rowDataTanggal = row.querySelector("td:nth-child(3)").textContent.trim(); // Adjust the index based on your actual structure
            if (selectedDate !== "" && rowDataTanggal !== selectedDate) {
                row.style.display = "none";
            } else {
                row.style.display = "";
            }
        });
    });
});
</script>

<script>
    $(document).ready(function() {
        var table = new DataTable('#data-table', {
            paging: false,
            searching: false,
            info: false,
        });

        $('#formModal').on('hidden.bs.modal', function(e) {
            $('#modal-title').text('Tambah Data');
            $('#email').attr('disabled', false);
            $('#username').attr('disabled', false);
            $('#password').attr('required', true);
            $('#ajaxForm').trigger('reset');
        });

        var totalHarga = 0;
        $('#laporan-list tr').each(function() {
            var subtotalText = $(this).find('td:eq(3)').data('harga-total-transaksi');
            totalHarga += parseInt(subtotalText);
        });

        const formattedNumber = new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR'
        }).format(totalHarga);

        $('#laporan-list').append(`<tr>
        <td class="fw-bold">TOTAL</td>
        <td></td>
        <td></td>
        <td class="fw-bold" id="total-laporan-text">Rp.</td>
        </tr>`);

        $('#total-laporan-text').text(formattedNumber);
    });
</script>