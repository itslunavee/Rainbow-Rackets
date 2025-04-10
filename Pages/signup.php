<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rainbow Rackets - Register</title>
    <link rel="stylesheet" href="../Styles/fonts.css">
    <link rel="stylesheet" href="../Styles/main.css">
</head>

<header class="header">
        <nav class="nav-container">
            <a href="home.php" class="logo">Rainbow Rackets</a>
            <button class="hamburger">☰</button>
            <ul class="nav-menu">
                <li><a href="home.php" class="nav-link">Home</a></li>
                <li><a href="events.php" class="nav-link">Events</a></li>
                <li><a href="signup.php" class="nav-link">Join</a></li>
                <li><a href="about.php" class="nav-link">About</a></li>
            </ul>
        </nav>
</header>

<body>
<section class="signup-form">
    <h2>Join Our Community</h2>
    <form action="../Server/auth/register.php" method="POST">
        <div class="form-group">
            <label>Full Name</label>
            <input type="text" name="name" required>
        </div>
        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" required>
        </div>
        <div class="form-group">
            <label>Password</label>
            <input type="password" name="password" required>
        </div>
        <div class="form-group">
            <label>Tell us about yourself (optional)</label>
            <textarea name="message"></textarea>
        </div>
        <button type="submit" class="button">Sign Up</button>
    </form>
</section>
</body>