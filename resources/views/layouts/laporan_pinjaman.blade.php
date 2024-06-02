@extends('main')

@section('title', 'Laporan Pinjaman')
@section('title2', 'Laporan Pinjaman')
@section('judul', 'Laporan Pinjaman')

@section('page-js-files')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
@stop

@section('content')
    <section class="content">
        <div id="xtest" style="font-size: 14px"></div>
        <div class="callout callout-warning">
            <i class="fas fa-info-circle"></i>
            Halaman untuk melihat dan mencetak data transaksi Pinjaman
        </div>
        @if ($message = Session::get('success'))
            <div class="alert alert-success alert-block">
                <button type="button" class="close" data-dismiss="alert">×</button>
                <strong>{{ $message }}</strong>
            </div>
        @endif

        @if ($message = Session::get('error'))
            <div class="alert alert-danger alert-block">
                <button type="button" class="close" data-dismiss="alert">×</button>
                <strong>{{ $message }}</strong>
            </div>
        @endif

        <div class="card">
            <!-- Navbar Content -->
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h2 class="card-title font-weight-bold">FILTER PINJAMAN</h2>
                    <div class="d-flex justify-content-center">
                        <div class="input-group w-100 mr-1">
                            <input type="text" class="form-control" name="date-range" id="date-range" placeholder="Pilih Tanggal">
                            <div class="input-group-append">
                                <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                            </div>
                        </div>
                        <div class="btn-group d-flex align-items-center w-100 mr-1" role="group">
                            <button id="download-laporan-pdf" class="btn btn-warning form-control" role="button">
                                CETAK LAPORAN
                                <span class="btn-group-text"><i class="fas fa-print"></i></span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /Navbar Content -->

            <!-- Page Content -->
            <div class="card-body">
                <table id="resume-pinjaman-table" class="table table-bordered table-striped mb-4">
                    <thead>
                        <tr>
                            <th>Total Pinjaman</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Rp{{ $totalNilaiPinjaman }}</td>
                        </tr>
                    </tbody>
                </table>

                <table id="detail-pinjaman-table" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>ID Anggota</th>
                            <th>Nama Anggota</th>
                            <th>Nominal Pinjaman</th>
                            <th>Tanggal Pinjaman</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $no = 1; @endphp
                        @foreach ($getPinjaman as $pinjaman)
                            <tr>
                                <th>{{ $no++ }}</th>
                                <th>{{ $pinjaman->author_id }}</th>
                                <td>{{ $pinjaman->author_name }}</td>
                                <td>{{ $pinjaman->nominal_pinjaman }}</td>
                                <td>{{ \Carbon\Carbon::parse($pinjaman->tanggal_pinjaman)->formatLocalized('%d %B %Y') ?? '' }}</td>
                                <td>{{ $pinjaman->status_credit }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    <script>
        $(document).ready(function(){
            // Initialize the date range picker
            $('#date-range').daterangepicker({
                autoUpdateInput: false,
                locale: {
                    cancelLabel: 'Clear'
                }
            });

            // Event handler for when the date range is applied
            $('#date-range').on('apply.daterangepicker', function(ev, picker) {
                $(this).val(picker.startDate.format('DD-MM-YYYY') + ' - ' + picker.endDate.format('DD-MM-YYYY'));
                fetchFilteredData();
            });

            // Event handler for when the date range is cleared
            $('#date-range').on('cancel.daterangepicker', function(ev, picker) {
                $(this).val('');
                fetchFilteredData();
            });

            function getFilteredData() {
                var dateRange = $('#date-range').val().split(' - ');
                var startDate = dateRange[0] ? moment(dateRange[0], 'DD-MM-YYYY').format('YYYY-MM-DD') : null;
                var endDate = dateRange[1] ? moment(dateRange[1], 'DD-MM-YYYY').format('YYYY-MM-DD') : null;

                // Prepare data object
                var data = {};

                if (startDate) data.start_date = startDate;
                if (endDate) data.end_date = endDate;

                return data;
            }

            function fetchFilteredData(){
                var data = getFilteredData();
                // Send the data to the controller via AJAX
                $.ajax({
                    url: '/laporan_pinjaman',
                    method: 'GET',
                    data: data,
                    success: function(response) {
                        // Handle the response here, such as updating the page with the new data
                        console.log(response);

                        // Clear existing content
                        $('#detail-pinjaman-table tbody').empty();
                        $('#resume-pinjaman-table tbody').empty();

                        // Initialize a counter for row numbers
                        var counter = 1;

                        // Iterate over each object in the response array
                        response.getPinjaman.forEach(function(getPinjaman) {
                            // Extract relevant data from the object
                            var authorid = getPinjaman.author_id ? getPinjaman.author_id : '';
                            var authorname = getPinjaman.author_name ? getPinjaman.author_name : '';
                            var nominalpinjaman = getPinjaman.nominal_pinjaman ? getPinjaman.nominal_pinjaman : '';
                            var tanggalpinjaman = getPinjaman.tanggal_pinjaman ? moment(getPinjaman.tanggal_pinjaman).format('MMMM YYYY') : '';
                            var status = getPinjaman.status_credit ? getPinjaman.status_credit.toUpperCase() : '';

                            // Create a new table row with the extracted data
                            var row = '<tr>' +
                                    '<td>' + (counter || '') + '</td>' +
                                    '<td>' + (authorid || '') + '</td>' +
                                    '<td>' + (authorname || '') + '</td>' +
                                    '<td>' + (nominalpinjaman || '') + '</td>' +
                                    '<td>' + (tanggalpinjaman || '') + '</td>' +
                                    '<td>' + (status || '') + '</td>' +
                                '</tr>';

                            // Append the new row to the table body
                            $('#detail-pinjaman-table tbody').append(row);

                            // Increment the counter
                            counter++;

                            // Create a new table row with the extracted data
                            var rowResume = '<tr>' +
                                    '<td>' + (response.totalNilaiPinjaman || '') + '</td>'
                                '</tr>';

                            // Append the new row to the table body
                            $('#resume-pinjaman-table tbody').append(rowResume);
                        });
                    },
                    error: function(xhr, status, error) {
                        // Handle any errors here
                        console.error(xhr.responseText);
                    }
                });
            }

            // Event handler for when the button is clicked
            $('#download-laporan-pdf').click(function(e) {
                e.preventDefault(); // Prevent the default action of the link
                
                var data = getFilteredData();

                // Generate the URL with the query parameters
                var url = "{{ route('export_pinjaman') }}?" + $.param(data);

                // Redirect the user to the generated URL
                window.location.href = url;
            });
        });
    </script>

    <style>
        /* Override default styles for Bootstrap Datepicker */
        .datepicker-dropdown.show {
            background-color: #fff !important; /* Set background color to white */
            border: 1px solid #ced4da !important; /* Add border */
            color: #000 !important; /* Set text color to black */
        }

        /* Override text color for Bootstrap Datepicker input */
        .datepicker-dropdown.show .datepicker-days .datepicker-switch,
        .datepicker-dropdown.show .datepicker-days .table-condensed>thead>tr>th,
        .datepicker-dropdown.show .datepicker-days .table-condensed>tbody>tr>td,
        .datepicker-dropdown.show .datepicker-days .table-condensed>tbody>tr>th,
        .datepicker-dropdown.show .datepicker-months .datepicker-switch,
        .datepicker-dropdown.show .datepicker-months .table-condensed>thead>tr>th,
        .datepicker-dropdown.show .datepicker-months .table-condensed>tbody>tr>td,
        .datepicker-dropdown.show .datepicker-months .table-condensed>tbody>tr>th,
        .datepicker-dropdown.show .datepicker-years .datepicker-switch,
        .datepicker-dropdown.show .datepicker-years .table-condensed>thead>tr>th,
        .datepicker-dropdown.show .datepicker-years .table-condensed>tbody>tr>td,
        .datepicker-dropdown.show .datepicker-years .table-condensed>tbody>tr>th {
            color: #000 !important; /* Set text color to black */
        }
    </style>
@endsection