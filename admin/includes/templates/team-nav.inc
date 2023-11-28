
<!-- navbar css file link  -->
<link rel="stylesheet" href="<?php echo "../" . $css; ?>navbar.css">

</head>
<body>
    <div class="dash-container">
        <nav class="sidebar">
            <ion-icon name="close-outline" class="close-icon"></ion-icon>
            <div class="logo">
                sy-koora
            </div>
            <div class="list">
                <ul>
                    <li class="list-item">
                        <a href="manage-team.php">
                            <ion-icon class="icons" name="football-outline"></ion-icon>
                            <span>manage team</span>
                        </a>
                    </li>
                    <li class="list-item">
                        <a href="manage-users.php">
                            <ion-icon class="icons" name="people-outline"></ion-icon>
                            <span>manage users</span>
                        </a>
                    </li>
                    <li class="list-item">
                        <a href="manage-leagues.php">
                            <ion-icon class="icons" name="stats-chart-outline"></ion-icon>
                            <span>joined leagues</span>
                        </a>
                    </li>
                    <li class="list-item">
                        <a href="manage-posts.php">
                            <ion-icon class="icons" name="pricetags-outline"></ion-icon>
                            <span>manage posts</span>
                        </a>
                    </li>
                    <li class="list-item">
                        <a href="../logout.php">
                            <ion-icon class="icons" name="log-out-outline"></ion-icon>
                            <span>logout</span>
                        </a>
                    </li>
                </ul>
            </div>
        </nav>