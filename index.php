<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        .wrapper {
            padding: 20px;
            position: relative;
        }

        .download-icon {
            position: absolute;
            top: 10px;
            right: 10px;
            font-size: 24px;
            color: #000;
        }

        .table td,
        .table th {
            text-align: center;
        }

        .table-responsive {
            overflow-x: auto;
        }

        .page-header h2 {
            margin-top: 0;
        }

        table tr td:last-child a {
            margin-right: 15px;
        }

        .section-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            margin-left: -14px;
        }

        @media (max-width: 767px) {
            .section-content input {
                width: 100%;
                margin-bottom: 10px;
            }
        }
    </style>

    <script type="text/javascript">
        $(document).ready(function () {
            $('[data-toggle="tooltip"]').tooltip();

            // Function to fetch and display filtered data
            function fetchFilteredData(keyword) {
                // Perform AJAX request to fetch filtered data
                $.ajax({
                    url: 'fetch_filtered_data-prestamo.php',
                    type: 'POST',
                    data: {
                        search: keyword
                    },
                    success: function (data) {
                        $('#table-container').html(data);
                    }
                });
            }

            // Add event listener for search input
            $('#search').on('input', function () {
                // Get the search keyword
                let keyword = $(this).val();
                fetchFilteredData(keyword);
            });

            // Add event listener for download icon
            $('.download-icon').on('click', function () {
                // Get the search keyword
                let keyword = $('#search').val();
                // Redirect to the PHP script to generate PDF with search parameter
                window.location.href = 'informe-prestamo.php?search=' + encodeURIComponent(keyword);
            });
        });
    </script>
</head>

<body>

    <div class="wrapper">
        <!-- Enlace al script PHP que genera el PDF -->
        <a href="#" class="download-icon" title="Descargar informe">
            <i class="fa fa-download" style="color: black;"></i>
        </a>
        <div class="container">
            <div class="row">
                <div class="col-md-12">

                    <div class="section-content">
                        <div class="col-md-6">
                            <input type="text" id="search" placeholder="Buscar..." class="form-control">
                        </div>
                        <div class="col-md-6">
                            <a href="create-prestamo.php" class="btn btn-success">
                                Agregar
                            </a>
                        </div>
                    </div>

                    <!-- Container to hold filtered data -->
                    <div id="table-container">
                        <?php include 'fetch_filtered_data-prestamo.php'; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

</html>
