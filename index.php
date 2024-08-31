<?php include 'nav.php' ?>
  <!-- about section -->

  <section class="about_section layout_padding ">
    <div class="container">
        <div class="row">
            <?php include 'fetch_about.php' ?>
            <div class="col-md-6">
                <div class="img-box">
                    <img src="<?php echo $image_url; ?>" alt="">
                </div>
            </div>
            <div class="col-md-6">
                <div class="detail-box">
                    <div class="heading_container">
                        <h2>
                            <?php echo $title; ?>
                        </h2>
                    </div>
                    <p>
                        <?php echo $description; ?>
                    </p>
                    <a href="">
                        Read More
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

  <!-- end about section -->

  <!-- Designs section -->
  <div class="gallery_section layout_padding2">
    <div class="container-fluid">
        <div class="heading_container heading_center">
            <h2>DESIGNS</h2>
        </div>
        <div class="row">
            <?php
            include 'fetch_design.php';

            // Loop through the fetched designs and generate HTML for the first 8 images
            $counter = 0;
            foreach ($images as $image) {
                if ($counter < 8) {
                    echo '<div class="col-sm-4 col-md-3 px-0">';
                    echo '<div class="img-box">';
                    echo '<img src="' . htmlspecialchars($image) . '" alt="Design">';
                    echo '<a href="' . htmlspecialchars($image) . '" data-toggle="lightbox" data-gallery="gallery">';
                    echo '<i class="fa fa-picture-o" aria-hidden="true"></i>';
                    echo '</a>';
                    echo '</div>';
                    echo '</div>';
                }
                $counter++;
            }
            ?>
        </div>
        <div class="btn-box">
            <a href="design.php">View All</a>
        </div>
    </div>
</div>

  <!-- end Designs section -->

<!-- Photography section -->
<div class="gallery_section layout_padding2">
    <div class="container-fluid">
        <div class="heading_container heading_center">
            <h2>PHOTOGRAPHS</h2>
        </div>
        <div class="row">
            <?php
            // Include the PHP script that fetches photographs
            include 'fetch_photographs.php';
            $counter = 0;

            // Loop through the fetched photographs and generate HTML
            foreach ($photos as $photo) {
                if ($counter < 8) {
                echo '<div class="col-sm-4 col-md-3 px-0">';
                echo '<div class="img-box">';
                echo '<img src="' . htmlspecialchars($photo) . '" alt="Photograph">';
                echo '<a href="' . htmlspecialchars($photo) . '" data-toggle="lightbox" data-gallery="gallery">';
                echo '<i class="fa fa-picture-o" aria-hidden="true"></i>';
                echo '</a>';
                echo '</div>';
                echo '</div>';

                $counter++;
                }
            }
            ?>
        </div>
        <div class="btn-box">
            <a href="photographs.php">View All</a>
        </div>
    </div>
</div>

<!-- end photography section -->

<!-- Video section -->

<div class="gallery_section layout_padding2">
    <div class="container-fluid">
        <div class="heading_container heading_center">
            <h2>VIDEOS</h2>
        </div>
        <div class="row">
            <?php
            // Include the PHP script that fetches videos
            include 'fetch_videos.php';
            $counter = 0;

            // Loop through the fetched videos and generate HTML
            foreach ($videos as $video) {
                if ($counter < 8) {
                echo '<div class="col-sm-4 col-md-3 px-0">';
                echo '<div class="img-box">';
                echo '<img src="' . htmlspecialchars($video['thumbnail_url']) . '" alt="Video">';
                echo '<a href="' . htmlspecialchars($video['video_url']) . '" data-toggle="lightbox" data-gallery="gallery">';
                echo '<i class="fa fa-video-camera" aria-hidden="true"></i>';
                echo '</a>';
                echo '</div>';
                echo '</div>';

            }
            $counter++;
            }
            ?>
        </div>
        <div class="btn-box">
            <a href="videos.php">View All</a>
        </div>
    </div>
</div>
<!-- end Video section -->


  <!-- service section -->
  <?php include 'view_service.php' ?>


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
<!-- end conta
  
  <!-- end service section -->


  <!-- contact section
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
</section> -->



  <!-- end contact section -->

  <!-- info section -->
 <?php include 'footer.php' ?>