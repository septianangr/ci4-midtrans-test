<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">

    <title><?= $title ?></title>
</head>

<body class="bg-light font-weight-light pt-5">
    <div class="col-6 col-sm-12 col-md-6 col-lg-6 col-xl-6 h-100 m-0 p-2 mx-auto bg-white shadow-lg">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h2 class="mt-5 text-center font-weight-light"><?= $title ?></h2>
                    <hr>
                    <a href="<?= base_url('/') ?>" class="btn btn-secondary">Return</a>
                    <p class="lead text-center">
                        Invoice Detail
                    </p>
                    <?php foreach ($invoices as $invoice) : ?>
                        <?php $snap_token = $invoice->snap_token ?>
                        <table class="table text-left mt-4">
                            <tr>
                                <td>
                                    Invoice Number
                                </td>
                                <td>
                                    <strong><?= $invoice->invoice_code ?></strong>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Client Name
                                </td>
                                <td>
                                    <strong><?= $invoice->client_name ?></strong>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Description
                                </td>
                                <td>
                                    <strong><?= $invoice->description ?></strong>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Total Amount
                                </td>
                                <td>
                                    <strong><?= number_format($invoice->total_amount) ?></strong>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Payment Status
                                </td>
                                <td>
                                    <strong><?= $invoice->invoice_status == 'Lunas' ? '<span class="text-success text-uppercase">' . $invoice->invoice_status . '</span>' : '<span class="text-danger text-uppercase">' . $invoice->invoice_status . '</span>' ?></strong>
                                </td>
                            </tr>
                        </table>
                    <?php endforeach ?>
                    <?php if ($invoice->invoice_status == 'Belum Lunas') : ?>
                    <div class="mt-5 mb-5">
                        <button class="btn btn-primary btn-block" type="button" id="pay-button">Process Payment</button>
                    </div>
                    <?php endif ?>
                </div>
            </div>
        </div>
    </div>
    <?php if ($invoice->invoice_status == 'Belum Lunas') : ?>
    <script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="SB-Mid-client-m6MaEYlak4uXjaql"></script>
    <script type="text/javascript">
        var payButton = document.getElementById('pay-button');
        // For example trigger on button clicked, or any time you need
        payButton.addEventListener('click', function() {
            snap.pay('<?= $snap_token ?>'); // Replace it with your transaction token
        });
    </script>
    <?php endif ?>

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: jQuery and Bootstrap Bundle (includes Popper) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js" integrity="sha384-+YQ4JLhjyBLPDQt//I+STsc9iw4uQqACwlvpslubQzn4u2UU2UFM80nGisd026JF" crossorigin="anonymous"></script>
    -->
</body>

</html>