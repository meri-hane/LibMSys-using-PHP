<?php
session_start();

// Check if admin is not logged in, redirect to login.php if not
if(!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}
?>

<?php include 'includes/header.php'; ?>
<body>
<?php include 'includes/navbar.php'; ?>

    <!-- ***** Welcome Area Start ***** -->
    <div class="welcome-area" id="welcome">
        <!-- ***** Header Text Start ***** -->
        <div class="header-text">
            <div class="container">
                <div class="row">
                    <div class="offset-xl-3 col-xl-6 offset-lg-2 col-lg-8 col-md-12 col-sm-12">
                        <h1 style="font-size: 55px;">Connecting readers with knowledge, <br><strong>one book at a time.</strong></h1>
                        <p>               </p>
                        <a href="#features" class="main-button-slider">Library Management System</a>
                    </div>
                </div>
            </div>
        </div>
        <!-- ***** Header Text End ***** -->
    </div>
    <!-- ***** Welcome Area End ***** -->

    <!-- ***** Features Small Start ***** -->
    <section class="section home-feature">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="row">
                        <!-- ***** Features Small Item Start ***** -->
                        <div class="col-lg-4 col-md-6 col-sm-6 col-12" data-scroll-reveal="enter bottom move 50px over 0.6s after 0.2s">
                            <div class="features-small-item">
                                <div class="icon">
                                    <i><img src="assets/images/featured-item-01.png" alt=""></i>
                                </div>
                                <h5 class="features-title">Catalog Management</h5>
                                <p>Enables library staff to efficiently organize, update, and categorize the library's collection of materials, including books, periodicals, and multimedia items, ensuring accurate records and easy retrieval for patrons</p>
                            </div>
                        </div>
                        <!-- ***** Features Small Item End ***** -->

                        <!-- ***** Features Small Item Start ***** -->
                        <div class="col-lg-4 col-md-6 col-sm-6 col-12" data-scroll-reveal="enter bottom move 50px over 0.6s after 0.4s">
                            <div class="features-small-item">
                                <div class="icon">
                                    <i><img src="assets/images/featured-item-01.png" alt=""></i>
                                </div>
                                <h5 class="features-title">User Management and Circulation</h5>
                                <p>Library administrators can seamlessly manage patron accounts, handling registration, borrowing privileges, and transaction history, while streamlining circulation processes such as checkouts, renewals, and returns, enhancing the overall user experience.</p>
                            </div>
                        </div>
                        <!-- ***** Features Small Item End ***** -->

                        <!-- ***** Features Small Item Start ***** -->
                        <div class="col-lg-4 col-md-6 col-sm-6 col-12" data-scroll-reveal="enter bottom move 50px over 0.6s after 0.6s">
                            <div class="features-small-item">
                                <div class="icon">
                                    <i><img src="assets/images/featured-item-01.png" alt=""></i>
                                </div>
                                <h5 class="features-title">Search and Discovery</h5>
                                <p>Patrons can easily locate desired materials through an intuitive search interface, accessing detailed item information, availability status, and related resources, while enjoying features like advanced search options, filtering, and the ability to place holds or requests.</p>
                            </div>
                        </div>
                        <!-- ***** Features Small Item End ***** -->
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ***** Features Small End ***** -->
    
    <?php include 'includes/scripts.php'; ?>
</body>
</html>

