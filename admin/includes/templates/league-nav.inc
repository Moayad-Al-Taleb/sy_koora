
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
                        <a href="manage-league.php">
                            <ion-icon class="icons" name="stats-chart-outline"></ion-icon>
                            <span>manage league</span>
                        </a>
                    </li>
                    <li class="list-item">
                        <a href="league-posts.php">
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