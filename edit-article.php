<?php
session_start();
include 'db.php';

// Check if user is logged in
if (!isset($_SESSION['user-id'])) {
    header("Location: signin.php");
    exit;
}

$article_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$user_id = $_SESSION['user-id'];

// Verify this article belongs to the current user
$checkSql = "SELECT * FROM articles WHERE article_id = ? AND author_id = ?";
$checkStmt = $connection->prepare($checkSql);
$checkStmt->bind_param("ii", $article_id, $user_id);
$checkStmt->execute();
$result = $checkStmt->get_result();

if ($result->num_rows === 0) {
    header("Location: blogs.php");
    exit;
}

$article = $result->fetch_assoc();

// Handle form submission for updating the article
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);
    $category_id = intval($_POST['category_id']);
    
    if (!empty($title) && !empty($content)) {
        $updateSql = "UPDATE articles SET title = ?, content = ?, category_id = ? WHERE article_id = ?";
        $updateStmt = $connection->prepare($updateSql);
        $updateStmt->bind_param("ssii", $title, $content, $category_id, $article_id);
        
        if ($updateStmt->execute()) {
            header("Location: article.php?id=$article_id");
            exit;
        } else {
            $error = "Failed to update article: " . $connection->error;
        }
    } else {
        $error = "Title and content are required";
    }
}

$categories = [];
$categorySql = "SELECT category_id, category_name FROM categories";
$categoryResult = $connection->query($categorySql);
while ($row = $categoryResult->fetch_assoc()) {
    $categories[] = $row;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Article</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #ffffff;
            --primary-hover: rgba(255, 255, 255, 0.8);
            --secondary-color: rgba(255, 255, 255, 0.1);
            --text-color: #fff;
            --text-muted: #ccc;
            --light-text: #aaa;
            --border-color: #333;
            --danger-color: #dc3545;
            --success-color: #28a745;
            --input-bg: #222;
            --input-focus: #333;
            --shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }
        
        body.edit-article-page {
            background-color: #111;
            color: var(--text-color);
            line-height: 1.6;
        }
        
        /* Navigation styling for this page */
        body.edit-article-page .nav-list li a {
            color: #fff;
            text-decoration: none;
        }

        body.edit-article-page .nav-list li a:hover {
            color: #1f2937;
            text-decoration: none;
        }

        body.edit-article-page .logo-link .logo-text {
            color: #fff;
        }

        body.edit-article-page .navbar {
            background-color: transparent;
            border-bottom: none;
        }

        body.edit-article-page .navbar-divider {
            background-color: rgba(255, 255, 255, 0.2);
        }
        
        .container {
            max-width: 900px;
            margin: 2rem auto;
            padding: 2rem;
            background-color: rgba(30, 30, 30, 0.7);
            border-radius: 10px;
            box-shadow: var(--shadow);
        }
        
        h1 {
            color: var(--primary-color);
            margin-bottom: 1.5rem;
            padding-bottom: 0.5rem;
            border-bottom: 2px solid var(--secondary-color);
            font-weight: 600;
        }
        
        .error {
            background-color: rgba(220, 53, 69, 0.2);
            color: var(--danger-color);
            padding: 1rem;
            border-radius: 4px;
            margin-bottom: 1.5rem;
            border-left: 4px solid var(--danger-color);
        }
        
        .form-group {
            margin-bottom: 1.5rem;
        }
        
        label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
            color: var(--text-muted);
        }
        
        input[type="text"],
        select,
        textarea {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid var(--border-color);
            border-radius: 4px;
            background-color: var(--input-bg);
            font-size: 1rem;
            transition: all 0.3s ease;
            color: var(--text-color);
        }
        
        input[type="text"]:focus,
        select:focus,
        textarea:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(255, 255, 255, 0.1);
            background-color: var(--input-focus);
        }
        
        textarea {
            min-height: 250px;
            resize: vertical;
        }
        
        .form-actions {
            display: flex;
            gap: 1rem;
            margin-top: 2rem;
        }
        
        .btn {
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 4px;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }
        
        .btn-primary {
            background-color: var(--primary-color);
            color: #111;
        }
        
        .btn-primary:hover {
            background-color: var(--primary-hover);
        }
        
        .btn-secondary {
            background-color: var(--secondary-color);
            color: var(--text-color);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        .btn-secondary:hover {
            background-color: rgba(255, 255, 255, 0.15);
        }
        
        .btn i {
            margin-right: 0.5rem;
        }
        
        /* Custom select styling */
        .select-wrapper {
            position: relative;
        }
        
        .select-wrapper::after {
            content: "\f078";
            font-family: "Font Awesome 6 Free";
            font-weight: 900;
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--light-text);
            pointer-events: none;
        }
        
        select {
            appearance: none;
            padding-right: 2.5rem;
        }
        
        #wordCount {
            text-align: right;
            color: var(--light-text);
            margin-top: 5px;
        }
        
        /* Responsive design */
        @media (max-width: 768px) {
            .container {
                padding: 1.5rem;
                margin: 1rem;
            }
            
            .form-actions {
                flex-direction: column;
            }
            
            .btn {
                width: 100%;
            }
        }

        /* Toast notification */
        .toast {
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 1rem 1.5rem;
            border-radius: 4px;
            color: white;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.5);
            display: flex;
            align-items: center;
            z-index: 1000;
            transform: translateY(-100px);
            opacity: 0;
            transition: all 0.5s ease;
        }
        
        .toast.show {
            transform: translateY(0);
            opacity: 1;
        }
        
        .toast-success {
            background-color: var(--success-color);
        }
        
        .toast-error {
            background-color: var(--danger-color);
        }
        
        .toast i {
            margin-right: 10px;
        }
    </style>
</head>
<body class="edit-article-page">
    <?php include 'navbar.php'; ?>
    
    <div class="container">
        <h1><i class="fas fa-edit"></i> Edit Article</h1>
        
        <?php if (isset($error)): ?>
            <div class="error">
                <i class="fas fa-exclamation-circle"></i> <?php echo $error; ?>
            </div>
        <?php endif; ?>
        
        <form method="post" action="edit-article.php?id=<?php echo $article_id; ?>" id="editArticleForm">
            <div class="form-group">
                <label for="title"><i class="fas fa-heading"></i> Title</label>
                <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($article['title']); ?>" 
                       required placeholder="Enter article title">
            </div>
            
            <div class="form-group">
                <label for="category_id"><i class="fas fa-folder"></i> Category</label>
                <div class="select-wrapper">
                    <select id="category_id" name="category_id">
                        <?php foreach ($categories as $category): ?>
                            <option value="<?php echo $category['category_id']; ?>" 
                                <?php echo ($category['category_id'] == $article['category_id']) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($category['category_name']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            
            <div class="form-group">
                <label for="content"><i class="fas fa-paragraph"></i> Content</label>
                <textarea id="content" name="content" rows="10" required 
                          placeholder="Write your article content here..."><?php echo htmlspecialchars($article['content']); ?></textarea>
                <div id="wordCount">0 words</div>
            </div>
            
            <div class="form-actions">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Update Article
                </button>
                <a href="article.php?id=<?php echo $article_id; ?>" class="btn btn-secondary">
                    <i class="fas fa-times"></i> Cancel
                </a>
            </div>
        </form>
    </div>
    
    <?php include 'footer.php'; ?>
    
    <script>
        const contentArea = document.getElementById('content');
        const wordCount = document.getElementById('wordCount');
        
        function updateWordCount() {
            const text = contentArea.value.trim();
            const words = text ? text.split(/\s+/).length : 0;
            wordCount.textContent = words + (words === 1 ? ' word' : ' words');
        }
        
        contentArea.addEventListener('input', updateWordCount);
        updateWordCount();        
    </script>
</body>
</html>