<?php
    session_start();
    $conn = mysqli_connect('localhost', 'root', '', 'studentdatabase');

    // Check if user is logged in as admin
    if (!isset($_SESSION['adminlogin'])) {
        echo '<script>
                    alert("Please login as admin to view results");
                    location = "AdminLogin.php";
                </script>';
        exit();
    }

    $positions = ['GS', 'LR', 'Sports Secretary', 'Cultural Activity', 'Other Activity'];
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Security-Policy" content="default-src 'self' https:; style-src 'self' 'unsafe-inline' https:; script-src 'self' 'unsafe-inline' https:;">
    <title>Election Results</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <style>
        .navbar {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 999;
        }

        .nav-item a {
            font-family: sans-serif;
            color: mediumblue;
        }

        .nav-item a:hover {
            background: red;
            color: white;
            border-radius: 7px;
        }

        .result-card {
            box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.7);
            margin-bottom: 20px;
        }

        body {
            padding-top: 60px;
        }

        .chart-container {
            width: 100%;
            height: 400px;
            margin: 20px 0;
        }

        .position-title {
            background-color: #f8f9fa;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Election Results</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="AdminDashboard.php">Dashboard</a>
                    </li>
                    <!-- <li class="nav-item">
                        <a class="nav-link" href="adminlogout.php">Logout</a>
                    </li> -->
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <h2 class="text-center mb-4">Election Results</h2>

        <?php foreach ($positions as $position) {
            // Get candidates for this position
            $query = "SELECT ac.* FROM addcandidate ac 
                      INNER JOIN candidate_positions cp ON ac.id = cp.candidate_id 
                      WHERE cp.position = '$position' ORDER BY ac.votes DESC";
            $result = mysqli_query($conn, $query);
            $candidates = mysqli_fetch_all($result, MYSQLI_ASSOC);

            if (!empty($candidates)) {
                $max_votes = $candidates[0]['votes'];
        ?>
                <div class="card result-card">
                    <div class="card-header">
                        <h3 class="position-title text-center"><?php echo $position; ?></h3>
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Candidate Name</th>
                                    <!-- <th>Description</th> -->
                                    <th>Votes</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($candidates as $candidate) {
                                    $is_winner = $candidate['votes'] == $max_votes && $max_votes > 0;
                                ?>
                                    <tr class="<?php echo $is_winner ? 'winner' : ''; ?>">
                                        <td><?php echo $candidate['cname']; ?></td>
                                        <!-- <td><?php echo $candidate['description']; ?></td> -->
                                        <td><?php echo $candidate['votes']; ?></td>
                                        <td>
                                            <?php if ($is_winner) { ?>
                                                <span class="badge bg-success">Winner</span>
                                            <?php } else { ?>
                                                <span class="badge bg-secondary">Runner-up</span>
                                            <?php } ?>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
        <?php
            }
        } ?>
    </div>

</body>

</html>