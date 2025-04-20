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

    if (isset($_FILES["blog_image"]) && $_FILES["blog_image"]["name"] != "") {
        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true);
        }

        $target_file = $target_dir . basename($_FILES["blog_image"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        $check = getimagesize($_FILES["blog_image"]["tmp_name"]);
        if ($check !== false) {
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

function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

$categories = array();
$sql = "SELECT category_id, category_name FROM categories";
$result = $connection->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
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
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background-color: #111;
            color: #fff;
            margin: 0;
            padding: 0;
            line-height: 1.6;
        }

        body.add-blogs-page .nav-list li a {
            color: #fff;
            text-decoration: none;
        }

        body.add-blogs-page .nav-list li a:hover {
            color: #1f2937;
            text-decoration: none;
        }

        body.add-blogs-page .logo-link .logo-text {
            color: #fff;
        }

        body.add-blogs-page .navbar {
            background-color: transparent;
            border-bottom: none;
        }

        body.add-blogs-page .navbar-divider {
            background-color: rgba(255, 255, 255, 0.2);
        }

        .container {
            max-width: 900px;
            margin: 0 auto;
            padding: 20px;
        }

        .page-title {
            text-align: center;
            font-size: 2.5rem;
            margin-bottom: 1rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
            padding-bottom: 15px;
        }

        .page-subtitle {
            text-align: center;
            font-size: 1rem;
            margin-bottom: 2rem;
            color: #ccc;
        }

        .blog-form {
            background-color: rgba(30, 30, 30, 0.8);
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.5);
        }

        .form-group {
            margin-bottom: 25px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #fff;
        }

        input[type="text"],
        select,
        textarea {
            width: 100%;
            padding: 12px;
            background-color: #1a1a1a;
            border: 1px solid #333;
            border-radius: 5px;
            font-size: 16px;
            color: #fff;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }

        input[type="text"]:focus,
        select:focus,
        textarea:focus {
            border-color: #666;
            outline: none;
            box-shadow: 0 0 0 2px rgba(255, 255, 255, 0.1);
        }

        input[type="file"] {
            padding: 10px 0;
        }

        textarea {
            min-height: 250px;
            resize: vertical;
        }

        .error {
            color: #ff5555;
            font-size: 14px;
            display: block;
            margin-top: 5px;
        }

        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
        }

        .alert-success {
            color: #4eff9f;
            background-color: rgba(78, 255, 159, 0.1);
            border: 1px solid rgba(78, 255, 159, 0.3);
        }

        .alert-danger {
            color: #ff5555;
            background-color: rgba(255, 85, 85, 0.1);
            border: 1px solid rgba(255, 85, 85, 0.3);
        }

        .form-actions {
            margin-top: 30px;
            display: flex;
            justify-content: center;
            gap: 15px;
        }

        .btn {
            padding: 12px 25px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            font-weight: bold;
            transition: all 0.3s ease;
        }

        .btn-primary {
            background-color: #1a1a1a;
            color: #fff;
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        .btn-primary:hover {
            background-color: #333;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
        }

        small {
            font-size: 12px;
            color: #999;
        }

        .image-preview {
            max-width: 300px;
            margin: 15px auto;
            display: none;
        }

        .image-preview img {
            max-width: 100%;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
        }

        /* Custom file input */
        .file-input-container {
            position: relative;
            margin-bottom: 10px;
        }

        .file-input-label {
            display: inline-block;
            padding: 12px 20px;
            background-color: #1a1a1a;
            color: #fff;
            border: 1px solid #333;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: all 0.3s ease;
        }

        .file-input-label:hover {
            background-color: #333;
        }

        .file-name {
            margin-left: 10px;
            font-size: 14px;
            color: #ccc;
        }
    </style>
</head>

<body class="add-blogs-page">
    <?php include 'navbar.php' ?>

    <div class="container">
        <h1 class="page-title">Create New Blog Post</h1>
        <p class="page-subtitle">Share your wellness knowledge and experiences with our community</p>

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
                <label for="title">Blog Title*</label>
                <input type="text" id="title" name="title" value="<?php echo $title; ?>" placeholder="Enter an engaging title for your blog post" required>
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
                <span class="error"><?php echo $categoryErr; ?></span>
            </div>

            <div class="form-group">
                <label for="blog_image">Cover Image</label>
                <div class="file-input-container">
                    <label class="file-input-label">
                        Choose File
                        <input type="file" id="blog_image" name="blog_image" accept="image/*" onchange="previewImage(this)" style="display: none;">
                    </label>
                    <span class="file-name" id="fileName">No file chosen</span>
                </div>
                <small>Recommended size: 1200 x 630 pixels</small>
                <div id="imagePreview" class="image-preview">
                    <img id="preview" src="#">
                </div>
            </div>

            <div class="form-group">
                <label for="content">Content*</label>
                <textarea id="content" name="content" rows="10" placeholder="Write your blog content here..." required><?php echo $content; ?></textarea>
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
            var fileName = document.getElementById('fileName');

            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    preview.src = e.target.result;
                    previewDiv.style.display = 'block';
                    fileName.textContent = input.files[0].name;
                }

                reader.readAsDataURL(input.files[0]);
            } else {
                preview.src = '';
                previewDiv.style.display = 'none';
                fileName.textContent = 'No file chosen';
            }
        }
    </script>
</body>

</html>