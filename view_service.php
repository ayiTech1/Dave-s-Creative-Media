<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Services</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- <style>
        .service_section {
            padding: 50px 0;
        }
        .box {
            /* border: 1px solid #ccc; */
            padding: 2px;
            margin-bottom: 20px;
        }
        .box img {
            max-width: 100%;
            height: auto;
        }
    </style> -->
</head>
<body>
    <section class="service_section layout_padding">
        <div class="container">
            <div class="heading_container heading_center">
                <h2>Services</h2>
            </div>
            <div class="row">
                <?php include 'fetch_services.php'; ?> 
                <?php foreach ($services as $service): ?>
                    <div class="col-md-6 col-lg-4 mx-auto">
                        <div class="box">
                            <div class="img-box">
                                <img src="<?php echo htmlspecialchars($service['image']); ?>" alt="<?php echo htmlspecialchars($service['title']); ?>">
                            </div>
                            <div class="detail-box">
                                <h5><?php echo htmlspecialchars($service['title']); ?></h5>
                                <p class="service-description"><?php echo truncateText($service['description'], 20); ?></p>
                                <a href="#" class="read-more" data-full-description="<?php echo htmlspecialchars($service['description']); ?>">Read More</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.read-more').click(function(e) {
                e.preventDefault();
                var $this = $(this);
                var fullDescription = $this.data('full-description');
                var currentText = $this.prev('.service-description').text();

                if (currentText.trim().endsWith('...')) {
                    $this.prev('.service-description').text(fullDescription);
                    $this.text('Read Less');
                } else {
                    $this.prev('.service-description').text(truncateText(fullDescription, 20));
                    $this.text('Read More');
                }
            });
        });

        function truncateText(text, limit) {
            var words = text.split(' ');
            if (words.length > limit) {
                return words.slice(0, limit).join(' ') + ' ...';
            } else {
                return text;
            }
        }
    </script>
</body>
</html>
