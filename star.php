<?php
// Set session security enhancements before starting the session
ini_set('session.use_only_cookies', 1);
ini_set('session.use_trans_sid', 0);
ini_set('session.cookie_httponly', 1); // Prevent JavaScript access to session cookie
ini_set('session.cookie_secure', 1); // Ensure cookies are sent over HTTPS

session_start(); // Now start the session

session_regenerate_id(true); // Regenerate session ID to prevent session fixation attacks

$login_successful = false;
$error_message = "";

// Check if we have the session set from a previous login
if (isset($_SESSION['username'])) {
    header("Location: star.php"); // Redirect to star2.php with absolute URL
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize input
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);

    // Example check against hardcoded credentials (use hashed passwords in production)
    // Password should be hashed and stored in a secure manner.
    $hashed_password = password_hash('admin1234', PASSWORD_DEFAULT); // Example hash

    if ($username == 'CEO' && password_verify($password, $hashed_password)) {
        $login_successful = true;
        $_SESSION['username'] = $username; // Save the username in the session
        header("Location: star.php"); // Redirect to star2.php
        exit();
    } else {
        $error_message = "Invalid username or password!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>We Are Stars - Home</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 20px;
            background-color: #333;
            color: white;
        }
        .logo {
            font-size: 24px;
            font-weight: bold;
        }
        nav ul {
            list-style: none;
            display: flex;
            margin: 0;
            padding: 0;
        }
        nav ul li {
            margin: 0 15px;
        }
        nav ul li a {
            color: white;
            text-decoration: none;
        }
        .search-bar input {
            padding: 5px;
        }
        main {
            padding: 20px;
        }
        .hero {
            text-align: center;
            padding: 50px;
            background: linear-gradient(to right, #10a89cff, #6b2875ff);
            color: white;
        }
        .hero h1 {
            font-size: 48px;
        }
        .hero button {
            padding: 10px 20px;
            font-size: 18px;
            color: white;
            background-color: #333;
            border: none;
            cursor: pointer;
        }
        .about, .subscriptions, .featured-talents, .latest-news, .how-it-works, .testimonials, .social-media, .contact {
            padding: 20px 0;
            text-align: center;
        }
        .plan, .talent, .article {
            display: inline-block;
            width: 30%;
            margin: 1%;
            vertical-align: top;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            padding: 10px;
            box-sizing: border-box;
        }
        .plan h3, .talent p, .article h3, .article p {
            margin: 10px 0;
        }
        .plan p {
            font-size: 18px;
            font-weight: bold;
        }
        .contact form input, .contact form textarea {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            box-sizing: border-box;
        }
        .contact form button {
            padding: 10px 20px;
            background-color: #333;
            color: white;
            border: none;
            cursor: pointer;
        }
        footer {
            padding: 10px 20px;
            background-color: #333;
            color: white;
            text-align: center;
        }
        .social-media-icons a {
            color: white;
            margin: 0 10px;
            text-decoration: none;
        }

        /* Responsive Styles */
        @media (max-width: 768px) {
            header {
                flex-direction: column;
                align-items: flex-start;
            }
            nav ul {
                flex-direction: column;
                align-items: flex-start;
            }
            nav ul li {
                margin: 5px 0;
            }
            .search-bar {
                width: 100%;
                margin-top: 10px;
            }
            .hero h1 {
                font-size: 36px;
            }
            .plan, .talent, .article {
                width: 100%;
                margin: 10px 0;
            }
        }

        @media (max-width: 480px) {
            .hero h1 {
                font-size: 28px;
            }
            .hero button {
                font-size: 16px;
                padding: 8px 16px;
            }
        }
    </style>
</head>
<body>
    <header>
        <div class="logo">We Are Stars</div>
        <nav>
            <ul>
                <li><a href="star.php">Home</a></li>
                <li><a href="about.php">About Us</a></li>
                <li><a href="services.php">Services</a></li>
                <li><a href="blog.php">Blog</a></li>
                <li><a href="contact.php">Contact Us</a></li>
                <li><a href="register.php">Login/Register</a></li>
            </ul>
        </nav>
        <div class="search-bar">
            <input type="text" placeholder="Search...">
        </div>
    </header>
    <main>
        <section class="hero">
            <h1>Discover and Connect with the Best Talent</h1>
            <button>Join Now</button>
        </section>
        <section class="about">
            <h2>About Us</h2>
            <p>We Are Stars is a platform dedicated to connecting top talent with casting professionals.</p>
        </section>
        <section class="subscriptions">
            <h2>Subscription Plans</h2>
            <div class="plan">
                <h3>Six Months</h3>
                <p>$550 plus GST</p>
            </div>
            <div class="plan">
                <h3>One Year</h3>
                <p>$800 plus GST</p>
            </div>
            <div class="plan">
                <h3>Lifetime</h3>
                <p>$3500 plus GST</p>
            </div>
        </section>
        <section class="featured-talents">
            <h2>Featured Talents</h2>
            <div class="talent">
                <img src="talent1.jpg" alt="Talent 1" style="width:100%;">
                <p>Talent 1 - Actor</p>
            </div>
            <div class="talent">
                <img src="talent2.jpg" alt="Talent 2" style="width:100%;">
                <p>Talent 2 - Influencer</p>
            </div>
        </section>
        <section class="latest-news">
            <h2>Latest News and Blog</h2>
            <article class="article">
                <h3>Blog Post 1</h3>
                <p>At We Are Stars, we pride ourselves on discovering and nurturing hidden talents. In this post, we share inspiring success stories of our members who have achieved their dreams through our platform. From aspiring actors landing their first major roles to influencers gaining massive followings, these stories highlight the power of persistence and the right opportunities. Read on to get inspired and see how We Are Stars can help you shine in the spotlight!</p>
                <a href="blog-post1.html">Read more</a>
            </article>
            <article class="article">
                <h3>Blog Post 2</h3>
                <p>As the entertainment and talent management industries evolve, staying ahead of the latest trends is crucial. In this post, we explore the key trends shaping the future of talent management in 2024. From the rise of virtual auditions and AI-driven talent scouting to the growing importance of personal branding and social media presence, discover what you need to know to stay competitive in this dynamic field. Join us as we delve into the innovations that are set to transform how talent is discovered and managed.</p>
                <a href="blog-post2.html">Read more</a>
            </article>
        </section>
        <section class="how-it-works">
            <h2>How It Works</h2>
            <p>Step-by-step guide on joining and benefiting from our platform.</p>
        </section>
        <section class="testimonials">
            <h2>Testimonials</h2>
            <blockquote>
                <p>"We Are Stars helped me land my dream role!" - Talent 1</p>
            </blockquote>
        </section>
        <section class="social-media">
            <h2>Follow Us</h2>
            <a href="#">Facebook</a>
            <a href="#">Twitter</a>
            <a href="#">Instagram</a>
        </section>
        <section class="contact">
            <h2>Contact Us</h2>
            <form>
                <input type="text" name="name" placeholder="Your Name">
                <input type="email" name="email" placeholder="Your Email">
                <textarea name="message" placeholder="Your Message"></textarea>
                <button type="submit">Send</button>
            </form>
        </section>
    </main>
    <footer>
        <p>&copy; 2024 We Are Stars. All rights reserved.</p>
        <div class="social-media-icons">
            <a href="#">Facebook</a>
            <a href="#">Twitter</a>
            <a href="#">Instagram</a>
        </div>
    </footer>
</body>
</html>
