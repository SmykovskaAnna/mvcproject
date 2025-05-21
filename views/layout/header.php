<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Personal Task Manager Pro</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            padding-top: 80px;
            background-color: #f5f7fa;
        }

        .navbar {
            background-color:rgb(170, 170, 170) !important;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        .navbar-brand {
            font-weight: 600;
            color:rgb(0, 0, 0) !important;
        }

        .nav-link {
            color: #333 !important;
            font-weight: 500;
            margin-left: 10px;
            transition: color 0.3s ease;
        }

        .nav-link:hover {
            color:rgb(253, 197, 13) !important;
            text-shadow: 0 0 2px rgba(164, 159, 16, 0.5);
        }

        .container {
            max-width: 1000px;
        }

        .card {
            border-radius: 12px;
            border: none;
            background: linear-gradient(to right, #ffffff, #f7faff);
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
            transition: transform 0.2s ease;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .list-group-item.active {
            background-color:rgb(123, 40, 230);
            border-color:rgb(212, 169, 13);
            color: #fff;
        }

        .progress {
            height: 6px;
            border-radius: 4px;
            background-color: #e9ecef;
        }

        .btn {
            border-radius: 10px;
            font-weight: 500;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg fixed-top">
    <div class="container">
       <a class="navbar-brand" href="index.php?action=profile">Profile</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav">
                <?php if (isset($_SESSION['user_id'])): ?>
                    <li class="nav-item"><a class="nav-link" href="index.php?action=tasks">Tasks</a></li>
                    <li class="nav-item"><a class="nav-link" href="index.php?action=category_list">Categories</a></li>
                    <li class="nav-item"><a class="nav-link" href="index.php?action=report">Report</a></li>
                    <li class="nav-item"><a class="nav-link" href="index.php?action=logout">Logout</a></li>
                <?php else: ?>
                    <li class="nav-item"><a class="nav-link" href="index.php?action=login">Login</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

<div class="container py-4">