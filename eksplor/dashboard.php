<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: #2c2c2c;
            color: white;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .dashboard {
            background: #383838;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 0 15px rgba(0,0,0,0.4);
            text-align: center;
        }

        h1 {
            color: #ffffff;
        }

        a.logout-btn {
            margin-top: 20px;
            display: inline-block;
            padding: 10px 20px;
            background-color: #00adb5;;
            color: white;
            border-radius: 6px;
            text-decoration: none;
            transition: background 0.3s ease;
        }

        a.logout-btn:hover {
            background-color: #00adb5;;
        }
    </style>
</head>
<body>
    <div class="dashboard">
        <h1>Selamat Datang, <?php echo $_SESSION['username']; ?>!</h1>
        <a class="logout-btn" href="logout.php">Logout</a>
    </div>
</body>
</html>
