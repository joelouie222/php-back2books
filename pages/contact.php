<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Back2Books</title>

    <!-- GOOGLE FONT -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DotGothic16&display=swap" rel="stylesheet">

    <!-- FONT AWESOME -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- OUR CSS -->
    <link rel="stylesheet" href="/style.css">
    <!-- <link rel="stylesheet" href="/logo-style.css"> -->
    <link rel="icon" type="image/x-icon" href="/images/favicon/favicon-16x16.png">
</head>

<body id="home">
    <?php 
        include('../layout.php');
    ?>

    <div class="container">
        <div class="contact-us window" style="padding: 2rem;">

            <div style="text-align: center; margin-bottom: 2.5rem;">
                <h1>Contact Us</h1>
                <p style="font-size: 1.1rem; color: #555; max-width: 600px; margin: 0 auto;">We'd love to hear from you. Whether you have a question, feedback, or a business inquiry, feel free to reach out.</p>
            </div>

            <div style="display: flex; flex-wrap: wrap; gap: 2rem;">

                <div style="flex: 2; min-width: 300px;">
                    <h2>Send Us a Message</h2>
                    <form id="contactForm" action="#" method="POST">
                        <div style="margin-bottom: 1rem;">
                            <label for="name" style="display: block; margin-bottom: 0.5rem;">Your Name:</label>
                            <input type="text" id="name" name="name" required style="width: 100%; padding: 0.75rem; border: 1px solid #ccc; border-radius: 4px; font-family: inherit;">
                        </div>
                        <div style="margin-bottom: 1rem;">
                            <label for="email" style="display: block; margin-bottom: 0.5rem;">Your Email:</label>
                            <input type="email" id="email" name="email" required style="width: 100%; padding: 0.75rem; border: 1px solid #ccc; border-radius: 4px; font-family: inherit;">
                        </div>
                        <div style="margin-bottom: 1rem;">
                            <label for="subject" style="display: block; margin-bottom: 0.5rem;">Subject:</label>
                            <input type="text" id="subject" name="subject" required style="width: 100%; padding: 0.75rem; border: 1px solid #ccc; border-radius: 4px; font-family: inherit;">
                        </div>
                        <div style="margin-bottom: 1rem;">
                            <label for="message" style="display: block; margin-bottom: 0.5rem;">Message:</label>
                            <textarea id="message" name="message" rows="6" required style="width: 100%; padding: 0.75rem; border: 1px solid #ccc; border-radius: 4px; font-family: inherit;"></textarea>
                        </div>
                        <button type="submit" style="padding: 0.75rem 1.5rem; background-color: #333; color: white; border: none; cursor: pointer;">Submit</button>
                    </form>
                </div>

                <div style="flex: 1; min-width: 280px;">
                    <div style="margin-bottom: 2rem; padding-left: 1.5rem; border-left: 3px solid #f0f0f0;">
                        <h3 style="margin-top: 0; margin-bottom: 1rem;">Customer Support</h3>
                        <p style="margin: 0.5rem 0; display: flex; align-items: center;"><i class="fa fa-envelope" style="margin-right: 10px; font-size: 1.2rem; color: #333; width: 14px;"></i> <a href="mailto:support@back2books.com">support@back2books.com</a></p>
                        <p style="margin: 0.5rem 0; display: flex; align-items: center;"><i class="fa fa-phone" style="margin-right: 10px; font-size: 1.2rem; color: #333; width: 14px;"></i> (210) 123-4567</p>
                    </div>

                    <div style="margin-bottom: 2rem; padding-left: 1.5rem; border-left: 3px solid #f0f0f0;">
                        <h3 style="margin-top: 0; margin-bottom: 1rem;">Business Inquiries</h3>
                        <p style="margin: 0.5rem 0; display: flex; align-items: center;"><i class="fa fa-envelope" style="margin-right: 10px; font-size: 1.2rem; color: #333; width: 14px;"></i> <a href="mailto:business@back2books.com">business@back2books.com</a></p>
                    </div>

                    <div style="margin-bottom: 2rem; padding-left: 1.5rem; border-left: 3px solid #f0f0f0;">
                        <h3 style="margin-top: 0; margin-bottom: 1rem;">Support Hours</h3>
                        <p style="margin: 0.5rem 0; display: flex; align-items: center;"><i class="fa fa-clock-o" style="margin-right: 10px; font-size: 1.2rem; color: #333; width: 14px;"></i> Monday - Friday</p>
                        <p style="padding-left: 24px;">9:00 AM - 5:00 PM (CST)</p>
                    </div>

                    <div style="margin-bottom: 2rem; padding-left: 1.5rem; border-left: 3px solid #f0f0f0;">
                        <h3 style="margin-top: 0; margin-bottom: 1rem;">Project Repository</h3>
                        <p style="margin: 0.5rem 0;">This website is a student project. You can view the source code on our GitHub.</p>
                        <a href="https://github.com/joelouie222/php-back2books" target="_blank" style="display: inline-block; margin-top: 1rem; padding: 0.75rem 1.5rem; background-color: #24292e; color: white; text-decoration: none; border-radius: 5px;">
                            <i class="fa fa-github" style="margin-right: 8px; color: white;"></i> View on GitHub
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
    // Find the form element by its ID
    const contactForm = document.getElementById('contactForm');

    // Add an event listener that waits for the 'submit' action
    contactForm.addEventListener('submit', function(event) {
        // Prevent the form from actually submitting to a new page
        event.preventDefault();

        // Show a pop-up alert message
        alert('Thank you for your message! Since this is a student project, this form is for demonstration purposes only.');
        
        // Optional: Clear the form fields after submission
        contactForm.reset();
    });
    </script>
    <script src="js/scripts.js"></script>
</body>



</html>