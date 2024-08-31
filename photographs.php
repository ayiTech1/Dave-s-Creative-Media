
<?php include 'nav.php' ?>

  <!-- gallery section -->

  <div class="gallery_section layout_padding2">
    <div class="container-fluid">
        <div class="heading_container heading_center">
            <h2>ALL PHOTOGRAPHS</h2>
        </div>
        <div class="row">
            <?php
            include 'fetch_photographs.php';

            // Loop through all fetched designs and generate HTML
            foreach ($images as $image) {
                echo '<div class="col-sm-4 col-md-3 px-0">';
                echo '<div class="img-box">';
                echo '<img src="' . htmlspecialchars($image) . '" alt="Photograph">';
                echo '<a href="' . htmlspecialchars($image) . '" data-toggle="lightbox" data-gallery="gallery">';
                echo '<i class="fa fa-picture-o" aria-hidden="true"></i>';
                echo '</a>';
                echo '</div>';
                echo '</div>';
            }
            ?>
        </div>
    </div>
</div>

  <!-- end gallery section -->


  <?php include 'footer.php' ?>