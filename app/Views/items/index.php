<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Manajemen Barang</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css" rel="stylesheet">
</head>

<body class="p-4">
    <div class="container">
        <h2 class="mb-4">Manajemen Barang</h2>
        <button id="addBtn" class="btn btn-primary mb-3">Tambah Barang</button>
        <table id="itemsTable" class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama Barang</th>
                    <th>Kategori</th>
                    <th>Jumlah</th>
                    <th>Aksi</th>
                </tr>
            </thead>
        </table>

        <hr class="my-5">
        <h4 class="mb-3">Manajemen Kategori</h4>
        <button id="addCategoryBtn" class="btn btn-success mb-3">Tambah Kategori</button>
        <table id="categoriesTable" class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama Kategori</th>
                    <th>Aksi</th>
                </tr>
            </thead>
        </table>

    </div>
    <?php echo view('items/form_modal'); ?>
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
    <script>
        let table;
        let modal = new bootstrap.Modal(document.getElementById('itemModal'));

        $(document).ready(function() {
            table = $('#itemsTable').DataTable({
                ajax: {
                    url: '<?= site_url('items/data') ?>',
                    dataSrc: ''
                },
                columns: [{
                        data: 'id'
                    },
                    {
                        data: 'name'
                    },
                    {
                        data: 'category_name'
                    },
                    {
                        data: 'quantity'
                    },
                    {
                        data: null,
                        render: function(data, type, row) {
                            return `
                                <button class="btn btn-sm btn-warning editBtn" data-id="${row.id}">Edit</button>
                                <button class="btn btn-sm btn-danger deleteBtn" data-id="${row.id}">Hapus</button>
                            `;
                        }
                    }
                ]
            });

            $('#itemModal').on('show.bs.modal', function() {
                $.get('<?= site_url('items/categories') ?>', function(data) {
                    $('#category_id').html('');
                    data.forEach(c => {
                        $('#category_id').append(`<option value="${c.id}">${c.name}</option>`);
                    });
                });
            });

            $('#addBtn').click(function() {
                $('#itemForm')[0].reset();
                $('#id').val('');
                modal.show();
            });

            $('#itemForm').submit(function(e) {
                e.preventDefault();
                const formData = $(this).serialize();
                $.post('<?= site_url('items/save') ?>', formData, function() {
                    modal.hide();
                    table.ajax.reload();
                });
            });

            $('#itemsTable').on('click', '.editBtn', function() {
                const id = $(this).data('id');
                $.get(`<?= site_url('items/show') ?>/${id}`, function(data) {
                    $('#id').val(data.id);
                    $('#name').val(data.name);
                    $('#quantity').val(data.quantity);
                    $('#category_id').val(data.category_id);
                    modal.show();
                });
            });

            $('#itemsTable').on('click', '.deleteBtn', function() {
                const id = $(this).data('id');
                if (confirm('Yakin hapus data?')) {
                    $.post(`<?= site_url('items/delete') ?>/${id}`, function() {
                        table.ajax.reload();
                    });
                }
            });
        });

        let categoryModal = new bootstrap.Modal(document.getElementById('categoryModal'));

        let categoryTable = $('#categoriesTable').DataTable({
            ajax: {
                url: '<?= site_url('categories/fetch') ?>',
                dataSrc: ''
            },
            columns: [{
                    data: 'id'
                },
                {
                    data: 'name'
                },
                {
                    data: null,
                    render: function(data, type, row) {
                        return `
                    <button class="btn btn-sm btn-warning editCatBtn" data-id="${row.id}">Edit</button>
                    <button class="btn btn-sm btn-danger deleteCatBtn" data-id="${row.id}">Hapus</button>
                `;
                    }
                }
            ]
        });

        $('#addCategoryBtn').click(function() {
            $('#categoryForm')[0].reset();
            $('#category_id').val('');
            categoryModal.show();
        });

        $('#categoryForm').submit(function(e) {
            e.preventDefault();
            const formData = $(this).serialize();
            const id = $('#category_hidden_id').val();
            const url = id ? `<?= site_url('categories/update') ?>/${id}` : `<?= site_url('categories/create') ?>`;

            $.post(url, formData, function() {
                categoryModal.hide();
                categoryTable.ajax.reload();
            });
        });

        $('#categoriesTable').on('click', '.editCatBtn', function() {
            const id = $(this).data('id');
            $.get(`<?= site_url('categories/show') ?>/${id}`, function(data) {
                $('#category_hidden_id').val(data.id);
                $('#category_name').val(data.name);
                categoryModal.show();
            });
        });


        $('#categoriesTable').on('click', '.deleteCatBtn', function() {
            const id = $(this).data('id');
            if (confirm('Yakin ingin menghapus kategori ini?')) {
                $.post(`<?= site_url('categories/delete') ?>/${id}`, function() {
                    categoryTable.ajax.reload();
                });
            }
        });
    </script>
</body>

</html>