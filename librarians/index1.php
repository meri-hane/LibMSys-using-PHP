<?php
// Start session
session_start();

// Check if librarian is not logged in, redirect to login page
if (!isset($_SESSION['librarian_id'])) {
  header('Location: login.php');
  exit();
}

include('includes/connect.php');


// Fetch the counts from the database
$sqlBooksCount = "SELECT COUNT(*) AS total_books FROM books";
$sqlMembersCount = "SELECT COUNT(*) AS total_members FROM members";
$sqlLibrariansCount = "SELECT COUNT(*) AS total_librarians FROM librarians";
$sqlCheckoutsCount = "SELECT COUNT(*) AS total_checkouts FROM checkouts";

$resultBooks = mysqli_query($conn, $sqlBooksCount);
$resultMembers = mysqli_query($conn, $sqlMembersCount);
$resultLibrarians = mysqli_query($conn, $sqlLibrariansCount);
$resultCheckouts = mysqli_query($conn, $sqlCheckoutsCount);

$countBooks = mysqli_fetch_assoc($resultBooks)['total_books'];
$countMembers = mysqli_fetch_assoc($resultMembers)['total_members'];
$countLibrarians = mysqli_fetch_assoc($resultLibrarians)['total_librarians'];
$countCheckouts = mysqli_fetch_assoc($resultCheckouts)['total_checkouts'];

// Fetch monthly count of borrowed books
$sqlBorrowedBooks = "SELECT DATE_FORMAT(borrow_date, '%Y-%m') AS month, COUNT(*) AS total_borrowed
                    FROM checkouts
                    WHERE borrow_date IS NOT NULL
                    GROUP BY DATE_FORMAT(borrow_date, '%Y-%m')";
$resultBorrowedBooks = mysqli_query($conn, $sqlBorrowedBooks);

// Fetch monthly count of returned books
$sqlReturnedBooks = "SELECT DATE_FORMAT(return_date, '%Y-%m') AS month, COUNT(*) AS total_returned
                    FROM checkouts
                    WHERE return_date IS NOT NULL
                    GROUP BY DATE_FORMAT(return_date, '%Y-%m')";
$resultReturnedBooks = mysqli_query($conn, $sqlReturnedBooks);

// Initialize arrays to hold monthly data
$dataBorrowedBooks = [];
$dataReturnedBooks = [];

// Get current month and year
$currentMonth = date('n');
$currentYear = date('Y');

// Initialize arrays to hold monthly data
$months = [];
$totalBorrowedBooks = [];
$totalReturnedBooks = [];

// Loop through all months of the year
for ($i = 1; $i <= 12; $i++) {
    // Get month abbreviation
    $monthLabel = date('F', mktime(0, 0, 0, $i, 1));
    // Initialize counts to zero for each month
    $totalBorrowedBooks[$monthLabel] = 0;
    $totalReturnedBooks[$monthLabel] = 0;
    // Store month abbreviation
    $months[] = $monthLabel;
}

// Fetch and populate data for borrowed books
while ($row = mysqli_fetch_assoc($resultBorrowedBooks)) {
    $dataBorrowedBooks[$row['month']] = $row['total_borrowed'];
}

// Fetch and populate data for returned books
while ($row = mysqli_fetch_assoc($resultReturnedBooks)) {
    $dataReturnedBooks[$row['month']] = $row['total_returned'];
}

// Merge fetched data with initialized arrays
foreach ($dataBorrowedBooks as $month => $count) {
    $monthLabel = date('F', strtotime($month . '-01'));
    if (isset($totalBorrowedBooks[$monthLabel])) {
        $totalBorrowedBooks[$monthLabel] = $count;
    }
}

foreach ($dataReturnedBooks as $month => $count) {
    $monthLabel = date('F', strtotime($month . '-01'));
    if (isset($totalReturnedBooks[$monthLabel])) {
        $totalReturnedBooks[$monthLabel] = $count;
    }
}

// Prepare data for JavaScript
$months = array_values($months);
$totalBorrowedBooks = array_values($totalBorrowedBooks);
$totalReturnedBooks = array_values($totalReturnedBooks);

// Query to fetch data from members table
$sqlMembershipCount = "SELECT membership_type, COUNT(*) AS total_members FROM members GROUP BY membership_type";
$resultMembershipCount = mysqli_query($conn, $sqlMembershipCount);

// Initialize an empty array to store membership data
$membershipData = array();

// Fetch and store membership data
while ($row = mysqli_fetch_assoc($resultMembershipCount)) {
    $membershipData[$row['membership_type']] = $row['total_members'];
}
?>
<?php include 'includes/header.php'; ?>
<body>
<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">

  <ul class="sidebar-nav" id="sidebar-nav">

    <li class="nav-item">
      <a class="nav-link" href="index1.php">
        <i class="bi bi-grid"></i>
        <span>Dashboard</span>
      </a>
    </li><!-- End Dashboard Nav -->

   <li class="nav-item">
      <a class="nav-link collapsed" href="transaction.php">
        <i class="bi bi-menu-button-wide"></i><span>Transaction</span>
      </a>
    </li><!-- End Components Nav -->

    <li class="nav-item">
      <a class="nav-link collapsed" href="book1.php">
        <i class="bi bi-journal-text"></i><span>Books</span>
      </a>
    </li><!-- End Forms Nav -->

    <li class="nav-item">
      <a class="nav-link collapsed" href="member1.php">
        <i class="bi bi-layout-text-window-reverse"></i><span>Members</span>
      </a>
    </li><!-- End Tables Nav -->

  </ul>

</aside><!-- End Sidebar-->


<main id="main" class="main">

  <div class="pagetitle">
    <h1>Dashboard</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="index1.php">Home</a></li>
        <li class="breadcrumb-item active">Dashboard</li>
      </ol>
    </nav>
  </div><!-- End Page Title -->

  <section class="section dashboard">
    <div class="row">

      <!-- Left side columns -->
      <div class="col-lg-12">
        <div class="row">

         <!-- Books Card -->
  <div class="col-lg-4 col-md-4">
    <div class="card info-card sales-card">
      <div class="card-body">
        <h5 class="card-title">Books <span>| Total</span></h5>
        <div class="d-flex align-items-center">
        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center" style="background-color: rgba(209, 160, 255, 0.3);">
        <i class="bi bi-book" style="color: #9775fa;"></i>
          </div>
          <div class="ps-3">
            <h6><?php echo $countBooks; ?></h6>
          </div>
        </div>
      </div>
    </div>
  </div><!-- End Books Card -->

  <!-- Members Card -->
  <div class="col-lg-4 col-md-4">
    <div class="card info-card sales-card">
      <div class="card-body">
        <h5 class="card-title">Members <span>| Total</span></h5>
        <div class="d-flex align-items-center">
        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center" style="background-color: rgba(255, 204, 204, 0.4);">
        <i class="bi bi-person" style="color: #ff6699;"></i>
          </div>
          <div class="ps-3">
            <h6><?php echo $countMembers; ?></h6>
          </div>
        </div>
      </div>
    </div>
  </div><!-- End Members Card -->

  <!-- Checkouts Card -->
  <div class="col-lg-4 col-md-4">
    <div class="card info-card customers-card">
      <div class="card-body">
        <h5 class="card-title">Checkout <span>| Total</span></h5>
        <div class="d-flex align-items-center">
        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center" style="background-color: rgba(209, 160, 255, 0.3);">
        <i class="bi bi-book" style="color: #9775fa;"></i>
          </div>
          <div class="ps-3">
            <h6><?php echo $countCheckouts; ?></h6>
          </div>
        </div>
      </div>
    </div>
  </div><!-- End Checkouts Card -->

          <!-- Reports -->
          <div class="col-12">
            <div class="row">
              <!-- Monthly Transaction Report -->
              <div class="col-lg-6">
                <div class="card">
                  <div class="card-body">
                    <h5 class="card-title">Monthly Transaction Report</h5>
                    <div id="monthlyTransactionChart"></div>
                    <script>
                      document.addEventListener("DOMContentLoaded", function() {
                        new ApexCharts(document.querySelector("#monthlyTransactionChart"), {
                          series: [{
                            name: 'Borrowed',
                            data: <?php echo json_encode($totalBorrowedBooks); ?>
                          }, {
                            name: 'Returned',
                            data: <?php echo json_encode($totalReturnedBooks); ?>
                          }],
                          chart: {
                            type: 'bar',
                            height: 350,
                            toolbar: {
                              show: false
                            }
                          },
                          plotOptions: {
                            bar: {
                              horizontal: false,
                              columnWidth: '50%',
                              endingShape: 'rounded'
                            }
                          },
                          dataLabels: {
                            enabled: false
                          },
                          xaxis: {
                            categories: <?php echo json_encode($months); ?>
                          },
                          yaxis: {
                            min: 0,
                            max: 12,
                            tickAmount: 4,
                            labels: {
                              formatter: function(val) {
                                return val === 0 ? '0' : val;
                              }
                            }
                          },
                          colors: ['#ff69b4', '#dac0f1'],
                          tooltip: {
                            x: {
                              formatter: function(val) {
                                return 'Month: ' + val;
                              }
                            }
                          }
                        }).render();
                      });
                    </script>
                  </div>
                </div>
              </div>

              <div class="col-lg-6">
                <div class="card">
                  <div class="card-body">
                    <h5 class="card-title">Membership Type Report</h5>
                    <div id="donutChart" style="min-height: 365px;" class="echart"></div>
                    <script>
                      document.addEventListener("DOMContentLoaded", () => {
                        echarts.init(document.querySelector("#donutChart")).setOption({
                          tooltip: {
                            trigger: 'item'
                          },
                          legend: {
                            top: '5%',
                            left: 'center'
                          },
                          series: [{
                            name: 'Access From',
                            type: 'pie',
                            radius: ['40%', '70%'],
                            avoidLabelOverlap: false,
                            label: {
                              show: false,
                              position: 'center'
                            },
                            emphasis: {
                              label: {
                                show: true,
                                fontSize: '18',
                                fontWeight: 'bold'
                              }
                            },
                            labelLine: {
                              show: false
                            },
                            data: <?php echo json_encode(array_map(function($type, $count) {
                              return ['value' => $count, 'name' => $type];
                            }, array_keys($membershipData), array_values($membershipData))); ?>
                          }]
                        });
                      });
                    </script>
                  </div>
                </div>
              </div>
            </div>
          </div><!-- End Reports -->
        </div>
      </div><!-- End Left side columns -->
    </div>
  </section>
</main><!-- End #main -->

<?php include 'includes/footer.php'; ?>

<a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>


  <!-- Vendor JS Files -->
  <script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/chart.js/chart.umd.js"></script>
  <script src="assets/vendor/echarts/echarts.min.js"></script>
  <script src="assets/vendor/quill/quill.js"></script>
  <script src="assets/vendor/simple-datatables/simple-datatables.js"></script>
  <script src="assets/vendor/tinymce/tinymce.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>
</body>
</html>
