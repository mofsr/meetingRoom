<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meeting Room Booking App</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <!-- Responsive Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="#">Meeting Room Booking</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="/">Home</a></li>

                    <?php if(auth()->guard()->guest()): ?>  <!-- If user is not logged in -->
                        <li class="nav-item"><a class="nav-link" href="/login">Login</a></li>
                        <li class="nav-item"><a class="nav-link" href="/register">Register</a></li>
                    <?php endif; ?>

                    <?php if(auth()->guard()->check()): ?>  <!-- If user is logged in -->
                        <li class="nav-item">
                            <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" class="d-inline">
                                <?php echo csrf_field(); ?>
                                <button type="submit" class="nav-link btn btn-link text-white">Logout</button>
                            </form>
                        </li>

                         
                           <li class="nav-item"><a class="nav-link" href="/bookmeeting">Bookmeeting</a></li>
                           <li class="nav-item"><a class="nav-link" href="/mybooking">Mybooking</a></li>
                        
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Vue App Mount -->
    <div id="app" class="container mt-4">
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo e(mix('js/app.js')); ?>"></script>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\meetingroomBooking\resources\views/app.blade.php ENDPATH**/ ?>