<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user-id'])) {
    $_SESSION['redirect_after_login'] = 'addBlogs.php';
    header("Location: signin.php");
    exit;
}

$title = $content = $category_id = $image_url = "";
$titleErr = $contentErr = $categoryErr = "";
$success_message = "";
$error_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["title"])) {
        $titleErr = "Title is required";
    } else {
        $title = test_input($_POST["title"]);
    }
    
    if (empty($_POST["content"])) {
        $contentErr = "Content is required";
    } else {
        $content = test_input($_POST["content"]);
    }
    
    if (empty($_POST["category_id"])) {
        $categoryErr = "Category is required";
    } else {
        $category_id = test_input($_POST["category_id"]);
    }
    
    $target_dir = "uploads/";
    $image_url = "";
    
    if(isset($_FILES["blog_image"]) && $_FILES["blog_image"]["name"] != "") {
        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        
        $target_file = $target_dir . basename($_FILES["blog_image"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        
        $check = getimagesize($_FILES["blog_image"]["tmp_name"]);
        if($check !== false) {
            $image_url = $target_dir . uniqid() . "." . $imageFileType;
            
            if (move_uploaded_file($_FILES["blog_image"]["tmp_name"], $image_url)) {
            } else {
                $error_message = "Sorry, there was an error uploading your file.";
            }
        } else {
            $error_message = "File is not an image.";
        }
    }
    
    if (empty($titleErr) && empty($contentErr) && empty($categoryErr) && empty($error_message)) {
        $author_id = $_SESSION['user-id'];
        $author_id = isset($_SESSION['user-id']) ? $_SESSION['user-id'] : 1;
        
        $sql = "INSERT INTO articles (title, content, image_url, category_id, author_id, created_at) 
                VALUES (?, ?, ?, ?, ?, NOW())";
        
        $stmt = $connection->prepare($sql);
        $stmt->bind_param("sssii", $title, $content, $image_url, $category_id, $author_id);
        
        if ($stmt->execute()) {
            $success_message = "Blog post created successfully!";
            $title = $content = $category_id = "";
        } else {
            $error_message = "Error: " . $connection->error;
        }
        
        $stmt->close();
    }
}

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

$categories = array();
$sql = "SELECT category_id, category_name FROM categories";
$result = $connection->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $categories[] = $row;
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Blog Post</title>
    <style>
        /* Black and White Theme */
        :root {
            --primary-color: #000000;
            --secondary-color: #333333;
            --accent-color: #666666;
            --background-color: #ffffff;
            --text-color: #000000;
            --error-color: #ff0000;
            --success-color: #008000;
            --border-color: #cccccc;
        }
        
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: var(--text-color);
            background-color: var(--background-color);
            margin: 0;
            padding: 0;
        }
        
        .header {
            background-color: var(--primary-color);
            color: var(--background-color);
            padding: 1rem 0;
            text-align: center;
        }
        
        .container {
            max-width: 900px;
            margin: 0 auto;
            padding: 20px;
        }
        
        .page-title {
            border-bottom: 2px solid var(--primary-color);
            padding-bottom: 10px;
            margin-bottom: 30px;
            color: var(--primary-color);
        }
        
        .blog-form {
            background-color: #f9f9f9;
            padding: 30px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: var(--secondary-color);
        }
        
        input[type="text"],
        select,
        textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid var(--border-color);
            border-radius: 4px;
            font-size: 16px;
        }
        
        textarea {
            min-height: 250px;
            resize: vertical;
        }
        
        .error {
            color: var(--error-color);
            font-size: 14px;
            display: block;
            margin-top: 5px;
        }
        
        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 4px;
        }
        
        .alert-success {
            color: var(--success-color);
            background-color: #f0fff0;
            border: 1px solid var(--success-color);
        }
        
        .alert-danger {
            color: var(--error-color);
            background-color: #fff0f0;
            border: 1px solid var(--error-color);
        }
        
        .form-actions {
            margin-top: 30px;
            display: flex;
            gap: 10px;
        }
        
        .btn {
            padding: 12px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            font-weight: bold;
            transition: background-color 0.3s;
        }
        
        .btn-primary {
            background-color: var(--primary-color);
            color: var(--background-color);
        }
        
        .btn-primary:hover {
            background-color: var(--secondary-color);
        }
        
        .btn-secondary {
            background-color: var(--accent-color);
            color: var(--background-color);
        }
        
        .btn-secondary:hover {
            background-color: #999999;
        }
        
        .footer {
            background-color: var(--primary-color);
            color: var(--background-color);
            text-align: center;
            padding: 1rem 0;
            margin-top: 30px;
        }
        
        small {
            font-size: 12px;
            color: var(--accent-color);
        }
        
        /* Image preview styles */
        .image-preview {
            max-width: 300px;
            margin-top: 10px;
            display: none;
        }
        
        .image-preview img {
            max-width: 100%;
            border: 1px solid var(--border-color);
        }
    </style>
</head>
<body>
  <?php include 'navbar.php' ?>
    
    <div class="container">
        <h1 class="page-title">Create New Blog Post</h1>
        
        <?php if (!empty($success_message)): ?>
            <div class="alert alert-success">
                <?php echo $success_message; ?>
            </div>
        <?php endif; ?>
        
        <?php if (!empty($error_message)): ?>
            <div class="alert alert-danger">
                <?php echo $error_message; ?>
            </div>
        <?php endif; ?>
        
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" enctype="multipart/form-data" class="blog-form">
            <div class="form-group">
                <label for="title">Title*</label>
                <input type="text" id="title" name="title" value="<?php echo $title; ?>" required>
                <span class="error"><?php echo $titleErr; ?></span>
            </div>
            
            <div class="form-group">
                <label for="category_id">Category*</label>
                <select id="category_id" name="category_id" required>
                    <option value="" disabled selected>Select a category</option>
                    <option value="1">Mental Health</option>
                    <option value="2">Food Habits</option>
                    <option value="3">Gym and Fitness</option>
                    <option value="4">Sleeping Habits</option>
                    <option value="5">Longevity</option>
                    <option value="6">Sexual Health</option>
                    <option value="7">Parenting</option>
                    <option value="8">Spiritual Health</option>
                    <option value="9">Disease Management</option>
                </select>
            </div>
            
            <div class="form-group">
                <label for="blog_image">Cover Image</label>
                <input type="file" id="blog_image" name="blog_image" accept="image/*" onchange="previewImage(this)">
                <small>Recommended size: 1200 x 630 pixels</small>
                <div id="imagePreview" class="image-preview">
                    <img id="preview" src="#">
                </div>
            </div>
            
            <div class="form-group">
                <label for="content">Content*</label>
                <textarea id="content" name="content" rows="10" required><?php echo $content; ?></textarea>
                <span class="error"><?php echo $contentErr; ?></span>
            </div>
            
            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Publish Blog</button>
            </div>
        </form>
    </div>
    
    <?php include 'footer.php' ?>
    
    <script>    
    function previewImage(input) {
        var preview = document.getElementById('preview');
        var previewDiv = document.getElementById('imagePreview');
        
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            
            reader.onload = function(e) {
                preview.src = e.target.result;
                previewDiv.style.display = 'block';
            }
            
            reader.readAsDataURL(input.files[0]);
        } else {
            preview.src = '';
            previewDiv.style.display = 'none';
        }
    }
    </script>
</body>
</html>