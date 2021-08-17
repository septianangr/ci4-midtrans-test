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
                    <?php if ($password === 'sptanzpto') : ?>
                        <p class="lead text-center">
                            New Order
                        </p>
                        <form class="text-start" method="POST" action="<?= base_url('invoice/store') ?>">
                            <div>
                                <label for="first_name" class="visually-hidden">First Name</label>
                                <input type="text" name="first_name" class="form-control" id="first_name" required>
                            </div>
                            <div class="mt-4">
                                <label for="last_name" class="visually-hidden">Last Name</label>
                                <input type="text" name="last_name" class="form-control" id="last_name">
                            </div>
                            <div class="mt-4">
                                <label for="email" class="visually-hidden">Email</label>
                                <input type="text" name="email" class="form-control" id="email" required>
                            </div>
                            <div class="mt-4">
                                <label for="phone" class="visually-hidden">Phone Number</label>
                                <input type="text" name="phone" class="form-control" id="phone" required>
                            </div>
                            <div class="mt-4">
                                <label for="description" class="visually-hidden">Description</label>
                                <input type="text" name="description" class="form-control" id="description" required>
                            </div>
                            <div class="mt-4">
                                <label for="amount" class="visually-hidden">Total Amount</label>
                                <input type="number" name="amount" class="form-control" id="amount" required>
                            </div>
                            <div class="mt-5 mb-5">
                                <button class="btn btn-primary btn-block" type="submit">Checkout Order</button>
                            </div>
                        </form>
                    <?php else : ?>
                        <form method="GET">
                            <div class="mt-4">
                                <input type="password" name="password" class="form-control text-center" placeholder="Page Password" required>
                            </div>
                            <div class="mt-5 mb-5">
                                <button class="btn btn-primary btn-block" type="submit">Submit</button>
                            </div>
                        </form>
                    <?php endif ?>
                </div>
            </div>
        </div>
    </div>

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