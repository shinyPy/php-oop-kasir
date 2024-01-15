<?php $title = "Penjualan" ?>
<?php include('../../layout/header.php'); ?>
<?php include('../../layout/navbar.php'); ?>
<?php include('../../layout/sidebar.php'); ?>
<?php
include('../../function/config.php');
$db = new DB();
?>

<main id="main" class="main">
    <div class="pagetitle">
        <h1>Penjualan</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= route('dashboard') ?>">Home</a></li>
                <li class="breadcrumb-item active">Penjualan</li>
            </ol>
        </nav>
    </div>
    <!-- End Page Title -->

    <section class="section dashboard">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title">Data Penjualan</div>
                        <div class="d-flex justify-content-end mb-2">
                            <button class="btn btn-primary " type="button" data-bs-toggle="modal" data-bs-target="#formModal">Tambah Data</button>
                        </div>
                        <div class="table-responsive p-1">
                            <table id="data-table" class="table">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Tanggal</th>
                                        <th>Total Harga</th>
                                        <th>Pelanggan</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <?php foreach ($db->select('penjualan', '*', "", 'pelanggan', 'penjualan.id_pelanggan = pelanggan.id') as $index => $value) : ?>
                                        <tr>
                                            <td><?= ($index + 1) ?></td>
                                            <td><?= $value['tanggal'] ?></td>
                                            <td><?= 'Rp ' . number_format($value['total_harga'], 0, ',', '.'); ?></td>
                                            <td><?= $value['nama'] ?></td>
                                            <td>
                                                <div class="d-flex gap-1">
                                                    <button id="btn-detail" data-id="<?= $value['id'] ?>" class="btn btn-info btn-sm"><i class="bi bi-list-ul text-white"></i></button>
                                                    <button id="btn-delete" data-id="<?= $value['id'] ?>" class="btn btn-danger btn-sm"><i class="bi bi-trash"></i></button>
                                                    <button id="btn-edit" data-id="<?= $value['id'] ?>" class="btn btn-warning btn-sm"><i class="bi bi-pen text-white"></i></button>
                                                </div>
                                            </td>
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
</main>
<!-- End #main -->
<?php include('modal.php'); ?>
<?php include('../../layout/footer.php'); ?>

<script>
    $(document).ready(function() {
        var table = new DataTable('#data-table');

        $('#formModal').on('hidden.bs.modal', function(e) {
            $('#modal-title').text('Tambah Data');
            $('#email').attr('disabled', false);
            $('#username').attr('disabled', false);
            $('#password').attr('required', true);
            $('#ajaxForm').trigger('reset');
        });
    });

    $('body').on('click', '#btn-delete', function() {
        var id = $(this).data('id');
        Swal.fire({
            icon: 'info',
            title: 'Konfirmasi',
            text: 'Yakin ingin menghapus data ini?',
            showCancelButton: true,
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `api.php?action=delete&id=${id}`,
                    type: 'GET',
                    dataType: 'json',
                    success: function(res) {
                        console.log(res);
                        if (res.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: res.message
                            }).then((result) => {
                                if (result) {
                                    window.location.reload();
                                }
                            });
                        } else if (!res.success) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal',
                                text: res.message
                            }).then((result) => {
                                if (result) {
                                    window.location.reload();
                                }
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });
            }
        })
    });

    $('body').on('click', '#btn-edit', function() {
        var id = $(this).data('id');

        $.ajax({
            url: `api.php?action=show&id=${id}`,
            type: 'GET',
            dataType: 'json',
            success: function(res) {
                if (res.success) {
                    $('#data-id').val(res.data.id);
                    $('#nama').val(res.data.nama);
                    $('#alamat').val(res.data.alamat);
                    $('#email').val(res.data.email).attr('readonly', true);
                    $('#username').val(res.data.username).attr('readonly', true);
                    $('#role').val(res.data.role);
                    $('#status').val(res.data.status);

                    $('#password').attr('required', false);
                    $('#modal-title').text("Edit Data");
                    $('#formModal').modal('show');

                } else if (!res.success) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: res.message
                    }).then((result) => {
                        if (result) {
                            window.location.reload();
                        }
                    });
                }
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });


    });

    $('body').on('submit', '#ajaxForm', function(e) {
        e.preventDefault();
        var formData = $("#ajaxForm").serialize();
        if ($('#data-id').val() === '') {
            $.ajax({
                url: 'api.php?action=add',
                type: 'POST',
                data: formData,
                dataType: 'json',
                success: function(res) {
                    console.log(res);
                    if (res.success) {
                        $('#formModal').modal('hide');
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: res.message
                        }).then((result) => {
                            if (result) {
                                window.location.reload();
                            }
                        });
                    } else if (!res.success) {
                        Swal.fire({
                            icon: 'error',
                            title: 'error',
                            text: res.message
                        });
                    }
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        } else {
            $.ajax({
                url: `api.php?action=update&id=${$('#data-id').val()}`,
                type: 'POST',
                data: formData,
                dataType: 'json',
                success: function(res) {
                    console.log(res);
                    if (res.success) {
                        $('#formModal').modal('hide');
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: res.message
                        }).then((result) => {
                            if (result) {
                                window.location.reload();
                            }
                        });
                    } else if (!res.success) {
                        Swal.fire({
                            icon: 'error',
                            title: 'error',
                            text: res.message
                        });
                    }
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        }
    });
</script>