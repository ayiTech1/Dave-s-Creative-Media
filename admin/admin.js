// Load items on page load
$(document).ready(function() {
    loadItems('photographs');
    loadItems('galleries');
    loadItems('videos');
    
    // Add new photograph
    $('#addPhotoForm').submit(function(e) {
        e.preventDefault();
        addItem('photographs', $('#photoTitle').val(), $('#photoUrl').val());
    });

    // Add new gallery
    $('#addGalleryForm').submit(function(e) {
        e.preventDefault();
        addItem('galleries', $('#galleryTitle').val(), $('#galleryUrl').val());
    });

    // Add new video
    $('#addVideoForm').submit(function(e) {
        e.preventDefault();
        addItem('videos', $('#videoTitle').val(), $('#videoUrl').val());
    });
});

function loadItems(type) {
    $.ajax({
        url: 'fetch_items.php',
        type: 'GET',
        data: { type: type },
        success: function(data) {
            $('#' + type + 'Items').html(data);
        },
        error: function(xhr, status, error) {
            alert('Error fetching ' + type + ' items.');
        }
    });
}

function addItem(type, title, url) {
    $.ajax({
        url: 'add_item.php',
        type: 'POST',
        data: { type: type, title: title, url: url },
        success: function() {
            loadItems(type);
        },
        error: function(xhr, status, error) {
            alert('Error adding item to ' + type + '.');
        }
    });
}

function editItem(type, id, title, url) {
    $.ajax({
        url: 'edit_item.php',
        type: 'POST',
        data: { type: type, id: id, title: title, url: url },
        success: function() {
            loadItems(type);
        },
        error: function(xhr, status, error) {
            alert('Error editing item in ' + type + '.');
        }
    });
}

function deleteItem(type, id) {
    $.ajax({
        url: 'delete_item.php',
        type: 'POST',
        data: { type: type, id: id },
        success: function() {
            loadItems(type);
        },
        error: function(xhr, status, error) {
            alert('Error deleting item from ' + type + '.');
        }
    });
}
