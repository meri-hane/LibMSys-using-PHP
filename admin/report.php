<?php
include('includes/connect.php');

$sqlBooksCount = "SELECT COUNT(*) AS total_books FROM books";
$sqlMembersCount = "SELECT COUNT(*) AS total_members FROM members";
$sqlCheckoutsCount = "SELECT COUNT(*) AS total_checkouts FROM checkouts";

$resultBooks = mysqli_query($conn, $sqlBooksCount);
$resultMembers = mysqli_query($conn, $sqlMembersCount);
$resultCheckouts = mysqli_query($conn, $sqlCheckoutsCount);

$countBooks = mysqli_fetch_assoc($resultBooks)['total_books'];
$countMembers = mysqli_fetch_assoc($resultMembers)['total_members'];
$countCheckouts = mysqli_fetch_assoc($resultCheckouts)['total_checkouts'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Home</title>
  <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="assets/css/font-awesome.css">
  <link rel="stylesheet" href="assets/css/templatemo-softy-pinko.css">
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/simple-datatables/style.css" rel="stylesheet">
  <link href="assets/css/style.css" rel="stylesheet">
  <style>
    .logo img {
      max-width: 100%;
      height: auto;
      max-height: 50px;
      margin-top: -10px;
      margin-bottom: -10px;
    }
  </style>
</head>
<body>
  <header class="header-area header-sticky">
    <div class="container">
      <div class="row">
        <div class="col-12">
          <nav class="main-nav">
            <a href="#" class="logo">
              <img src="assets/images/new_logo.png" />
            </a>
            <ul class="nav">
              <li class="nav-item">
                <a class="nav-link" href="index.php">Home</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="report.php">Report</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="book.php">Books</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="members.php">Members</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="checkout.php">Checkout</a>
              </li>
            </ul>
            <a class='menu-trigger'>
              <span>Menu</span>
            </a>
          </nav>
        </div>
      </div>
    </div>
  </header>

  <main id="main" class="main">
    <section class="section dashboard">
      <div class="row">
        <div class="col-lg-8">
          <div class="row">
            <div class="col-md-4">
              <div class="card info-card sales-card">
                <div class="card-body">
                  <h5 class="card-title">Books <span>| Total</span></h5>
                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-book"></i>
                    </div>
                    <div class="ps-3">
                      <h6><?php echo $countBooks; ?></h6>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-4">
              <div class="card info-card revenue-card">
                <div class="card-body">
                  <h5 class="card-title">Members <span>| Total</span></h5>
                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-person"></i>
                    </div>
                    <div class="ps-3">
                      <h6><?php echo $countMembers; ?></h6>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-4">
              <div class="card info-card customers-card">
                <div class="card-body">
                  <h5 class="card-title">Checkouts <span>| Total</span></h5>
                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-journal-check"></i>
                    </div>
                    <div class="ps-3">
                      <h6><?php echo $countCheckouts; ?></h6>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-12">
              <div class="card">
                <div class="filter">
                  <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                  <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                    <li class="dropdown-header text-start">
                      <h6>Filter</h6>
                    </li>
                    <li><a class="dropdown-item" href="#">Today</a></li>
                    <li><a class="dropdown-item" href="#">This Month</a></li>
                    <li><a class="dropdown-item" href="#">This Year</a></li>
                  </ul>
                </div>
                <div class="card-body">
                  <h5 class="card-title">Reports <span>/ Today</span></h5>
                  <div id="reportsChart"></div>
                  <script>
                    document.addEventListener("DOMContentLoaded", () => {
                      new ApexCharts(document.querySelector("#reportsChart"), {
                        series: [{
                          name: 'Books',
                          data: [<?php echo $countBooks; ?>],
                        }, {
                          name: 'Members',
                          data: [<?php echo $countMembers; ?>]
                        }, {
                          name: 'Checkouts',
                          data: [<?php echo $countCheckouts; ?>]
                        }],
                        chart: {
                          height: 350,
                          type: 'line',
                          toolbar: {
                            show: false
                          },
                        },
                        markers: {
                          size:  4
                        },
                        colors: ['#4154f1', '#2eca6a', '#ff771d'],
                        fill: {
                          type: "gradient",
                          gradient: {
                            shadeIntensity: 1,
                            opacityFrom: 0.3,
                            opacityTo: 0.4,
                            stops: [0, 90, 100]
                          }
                        },
                        dataLabels: {
                          enabled: false
                        },
                        stroke: {
                          curve: 'smooth',
                          width: 2
                        },
                        xaxis: {
                          categories: ['Books', 'Members', 'Checkouts']
                        },
                        tooltip: {
                          x: {
                            format: 'dd/MM/yy HH:mm'
                          },
                        }
                      }).render();
                    });
                  </script>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="col-lg-4">
        <div class="card border-primary">
    <div class="card-body">
        <div class="d-flex align-items-center mb-3">

            <div>
                <h5 class="card-title mb-0">📢 DON'T KNOW WHAT TO READ?</h5>
            </div>
        </div>

        <hr class="mb-3">

        <div class="top-books mb-4">
            <h6 style="font-family: 'Poppins', sans-serif;">📘 Categories:</h6>
            <ul class="list-unstyled mb-0">
                <li style="font-family: 'Nunito', sans-serif;"><strong>🌟 Top Book:</strong> The Great Gatsby</li>
                <li style="font-family: 'Nunito', sans-serif;"><strong>😢 Books that will make you cry:</strong> Design and Analysis of Algorithm</li>
                <li style="font-family: 'Nunito', sans-serif;"><strong>📺 Anime:</strong> Naruto: The Seventh Hokage and the Scarlet Spring</li>
                <li style="font-family: 'Nunito', sans-serif;"><strong>💼 Self Help:</strong> The 7 Habits of Highly Effective People</li>
            </ul>
        </div>

        <hr class="mb-4">

        <div class="top-books-year mb-4">
            <h6 style="font-family: 'Poppins', sans-serif;">🏆 Top 3 Books of the Year:</h6>
            <ol class="list-unstyled mb-0">
                <li style="font-family: 'Nunito', sans-serif;"><strong>1️⃣ </strong> Untamed by Glennon Doyle</li>
                <li style="font-family: 'Nunito', sans-serif;"><strong>2️⃣ </strong> The Vanishing Half by Brit Bennett</li>
                <li style="font-family: 'Nunito', sans-serif;"><strong>3️⃣ </strong> Where the Crawdads Sing by Delia Owens</li>
            </ol>
        </div>

        <hr class="mt-4">

        <div class="text-center">
            <p class="mb-2"><i class="bi bi-lightbulb-fill text-warning me-2"></i> Did you know?</p>
            <p class="mb-0" style="font-family: 'Poppins', sans-serif;">Reading for just 30 minutes a day can improve your focus and concentration.</p>
        </div>

        <hr class="mt-4">

        <div class="mind-blowing-trivia mt-4">
            <h6 style="font-family: 'Poppins', sans-serif;">💡 Mind-Blowing Trivia:</h6>
            <ul class="list-unstyled mb-0">
                <li style="font-family: 'Nunito', sans-serif;"><strong>🚀 Did you know?</strong> The longest novel ever written is "In Search of Lost Time" by Marcel Proust, with over 4,000 pages!</li>
                <li style="font-family: 'Nunito', sans-serif;"><strong>🎉 Fun Fact:</strong> Reading can reduce stress levels by up to 68%.</li>
                <li style="font-family: 'Nunito', sans-serif;"><strong>💡 Did you know?</strong> Reading can increase empathy and improve relationships with others.</li>
                <li style="font-family: 'Nunito', sans-serif;"><strong>🧠 Fun Fact:</strong> Regular reading can slow down cognitive decline and keep your brain sharp as you age.</li>
            </ul>
        </div>
    </div>
</div>

      
    </div>
  </div>
</div>

      </div>
    </section>
  </main>

  <script src="assets/js/jquery-2.1.0.min.js"></script>
  <script src="assets/js/popper.js"></script>
  <script src="assets/js/bootstrap.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/chart.js/chart.umd.js"></script>
  <script src="assets/vendor/echarts/echarts.min.js"></script>
  <script src="assets/vendor/quill/quill.js"></script>
  <script src="assets/vendor/simple-datatables/simple-datatables.js"></script>
  <script src="assets/vendor/tinymce/tinymce.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>
  <script src="assets/js/main.js"></script>
</body>
</html>
