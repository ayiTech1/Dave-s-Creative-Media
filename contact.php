<?php include 'nav.php' ?>

<?php 
// Check if success message is set
if (isset($_SESSION['success_message'])) {
    // Display success message
    echo '<div class="container">';
    echo '<div class="row">';
    echo '<div class="col-md-7 col-lg-6">';
    echo '<div class="form_container">';
    echo '<p class="success-message">' . $_SESSION['success_message'] . '</p>';
    echo '</div>';
    echo '</div>';
    echo '</div>';
    echo '</div>';
    
    // Unset the session variable after displaying the message
    unset($_SESSION['success_message']);
}
?>

<!-- contact section -->
<section class="contact_section">
    <div class="container">
        <div class="row">
            <div class="col-md-7 col-lg-6">
                <div class="form_container">
                    <div class="heading_container">
                        <h2>Contact Us</h2>
                    </div>
                    <form action="submit_message.php" method="POST">
                        <div>
                            <input type="text" name="name" placeholder="Your Name" required />
                        </div>
                        <div>
                            <input type="text" name="phone" placeholder="Phone Number" required />
                        </div>
                        <div>
                            <input type="email" name="email" placeholder="Email" required />
                        </div>
                        <div>
                            <textarea name="message" class="message-box" placeholder="Message" required></textarea>
                        </div>
                        <div class="btn_box">
                            <button type="submit">SEND</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- end contact section -->

<?php include 'footer.php' ?>
