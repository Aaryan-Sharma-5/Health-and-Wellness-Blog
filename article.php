<?php
include 'navbar.php';
include 'db.php'; // Include database connection

// Make sure session is started if not already
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Check if user is logged in
$user_logged_in = isset($_SESSION['user_id']) && !empty($_SESSION['user_id']);
$current_user_id = $user_logged_in ? $_SESSION['user_id'] : 0;

// Get article ID from URL
$article_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if (!$article_id) {
    // Redirect to blogs page if no ID provided
    header('Location: blogs.php');
    exit;
}

// Fetch the article with author and category details
$articleQuery = "SELECT a.article_id, a.title, a.content, a.image_url, a.created_at, 
                       c.category_name, c.category_id, u.username as author_name, u.user_id as author_id,
                       (SELECT COUNT(*) FROM article_likes WHERE article_id = a.article_id) AS likes_count,
                       (SELECT COUNT(*) FROM article_likes WHERE article_id = a.article_id AND user_id = ?) AS user_liked
                FROM articles a
                LEFT JOIN categories c ON a.category_id = c.category_id
                LEFT JOIN users u ON a.author_id = u.user_id
                WHERE a.article_id = ?";

$stmt = $connection->prepare($articleQuery);
$stmt->bind_param("ii", $current_user_id, $article_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    // Article not found, redirect to blogs page
    header('Location: blogs.php');
    exit;
}

$article = $result->fetch_assoc();

// Fetch comments for this article
$commentsQuery = "SELECT c.comment_id, c.comment_text as content, c.created_at, u.username, u.user_id
                 FROM comments c
                 LEFT JOIN users u ON c.user_id = u.user_id
                 WHERE c.article_id = ?
                 ORDER BY c.created_at DESC";

$commentStmt = $connection->prepare($commentsQuery);
$commentStmt->bind_param("i", $article_id);
$commentStmt->execute();
$commentsResult = $commentStmt->get_result();

$comments = [];
while ($comment = $commentsResult->fetch_assoc()) {
    $comments[] = $comment;
}

// Fetch related articles (same category, excluding current)
$relatedQuery = "SELECT a.article_id, a.title, LEFT(a.content, 150) as excerpt, a.image_url, 
                       a.created_at, c.category_name
                FROM articles a
                LEFT JOIN categories c ON a.category_id = c.category_id
                WHERE a.category_id = ? AND a.article_id != ?
                ORDER BY a.created_at DESC
                LIMIT 3";

$relatedStmt = $connection->prepare($relatedQuery);
$relatedStmt->bind_param("ii", $article['category_id'], $article_id);
$relatedStmt->execute();
$relatedResult = $relatedStmt->get_result();

$relatedArticles = [];
while ($related = $relatedResult->fetch_assoc()) {
    // Add ellipsis to excerpt if it's truncated
    if (strlen($related['excerpt']) >= 150) {
        $related['excerpt'] .= '...';
    }
    $relatedArticles[] = $related;
}

// Handle like/unlike via AJAX
if (isset($_POST['action']) && $_POST['action'] == 'like') {
    header('Content-Type: application/json');
    
    if (!$user_logged_in) {
        echo json_encode(['status' => 'error', 'message' => 'Please log in to like articles']);
        exit;
    }
    
    // Check if user already liked this article
    $check_sql = "SELECT * FROM article_likes WHERE article_id = ? AND user_id = ?";
    $check_stmt = $connection->prepare($check_sql);
    $check_stmt->bind_param("ii", $article_id, $current_user_id);
    $check_stmt->execute();
    $check_result = $check_stmt->get_result();
    
    if ($check_result->num_rows > 0) {
        // User already liked this article, so remove the like
        $delete_sql = "DELETE FROM article_likes WHERE article_id = ? AND user_id = ?";
        $delete_stmt = $connection->prepare($delete_sql);
        $delete_stmt->bind_param("ii", $article_id, $current_user_id);
        
        if ($delete_stmt->execute()) {
            // Get updated like count
            $count_sql = "SELECT COUNT(*) AS likes_count FROM article_likes WHERE article_id = ?";
            $count_stmt = $connection->prepare($count_sql);
            $count_stmt->bind_param("i", $article_id);
            $count_stmt->execute();
            $count_result = $count_stmt->get_result();
            $likes_count = $count_result->fetch_assoc()['likes_count'];
            
            echo json_encode(['status' => 'success', 'liked' => false, 'count' => $likes_count]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to unlike article']);
        }
    } else {
        // User hasn't liked this article yet, so add a like
        $insert_sql = "INSERT INTO article_likes (article_id, user_id) VALUES (?, ?)";
        $insert_stmt = $connection->prepare($insert_sql);
        $insert_stmt->bind_param("ii", $article_id, $current_user_id);
        
        if ($insert_stmt->execute()) {
            // Get updated like count
            $count_sql = "SELECT COUNT(*) AS likes_count FROM article_likes WHERE article_id = ?";
            $count_stmt = $connection->prepare($count_sql);
            $count_stmt->bind_param("i", $article_id);
            $count_stmt->execute();
            $count_result = $count_stmt->get_result();
            $likes_count = $count_result->fetch_assoc()['likes_count'];
            
            echo json_encode(['status' => 'success', 'liked' => true, 'count' => $likes_count]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to like article']);
        }
    }
    
    exit;
}

// Handle adding comments
if (isset($_POST['add_comment']) && $user_logged_in) {
    $comment_content = trim($_POST['comment_content']);
    
    if (!empty($comment_content)) {
        $insert_comment = "INSERT INTO comments (article_id, user_id, content) VALUES (?, ?, ?)";
        $comment_stmt = $connection->prepare($insert_comment);
        $comment_stmt->bind_param("iis", $article_id, $current_user_id, $comment_content);
        
        if ($comment_stmt->execute()) {
            // Refresh the page to show the new comment
            header("Location: article.php?id=$article_id");
            exit;
        }
    }
}

// Helper function to format date
function format_date($date_string) {
    $date = new DateTime($date_string);
    return $date->format('F j, Y');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($article['title']); ?> - Wellness Blog</title>
    <style>
        /* Reset and base styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }
        
        body {
            background-color: #f5f5f5;
            color: #333;
            line-height: 1.6;
        }
        
        .container {
            max-width: 900px;
            margin: 0 auto;
            padding: 20px;
        }
        
        /* Article styling */
        .article {
            background-color: #fff;
            border-radius: 5px;
            overflow: hidden;
            margin-bottom: 40px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        
        .article-header {
            position: relative;
            height: 400px;
        }
        
        .article-header img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        .article-title-box {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            background-color: rgba(255, 255, 255, 0.9);
            padding: 20px;
        }
        
        .article-title {
            color: #222;
            font-size: 28px;
            font-weight: bold;
            line-height: 1.3;
            margin-bottom: 10px;
        }
        
        .article-meta {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 15px;
            font-size: 14px;
            color: #777;
        }
        
        .article-category {
            background-color: #f0f0f0;
            padding: 3px 10px;
            border-radius: 15px;
            font-size: 12px;
            font-weight: bold;
        }
        
        .article-author {
            display: flex;
            align-items: center;
        }
        
        .article-author img {
            width: 24px;
            height: 24px;
            border-radius: 50%;
            margin-right: 8px;
        }
        
        .article-content {
            padding: 30px;
            font-size: 16px;
        }
        
        .article-content p {
            margin-bottom: 20px;
        }
        
        .article-content h2 {
            margin-top: 30px;
            margin-bottom: 15px;
            font-size: 22px;
        }
        
        .article-content h3 {
            margin-top: 25px;
            margin-bottom: 10px;
            font-size: 18px;
        }
        
        .article-content ul, .article-content ol {
            margin-bottom: 20px;
            margin-left: 20px;
        }
        
        .article-content li {
            margin-bottom: 8px;
        }
        
        /* Like button and interactions */
        .article-interactions {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-top: 1px solid #eee;
            padding: 15px 30px;
        }
        
        .like-container {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .like-button {
            background: none;
            border: none;
            font-size: 24px;
            cursor: pointer;
            transition: transform 0.2s;
        }
        
        .like-button:hover {
            transform: scale(1.2);
        }
        
        .like-button.active {
            color: #e74c3c;
        }
        
        .like-count {
            font-size: 16px;
            font-weight: bold;
        }
        
        .share-container {
            display: flex;
            gap: 15px;
        }
        
        .share-button {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background-color: #f5f5f5;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: background-color 0.2s;
        }
        
        .share-button:hover {
            background-color: #e0e0e0;
        }
        
        /* Comments section */
        .comments-section {
            margin-top: 40px;
        }
        
        .section-title {
            font-size: 22px;
            margin-bottom: 20px;
            font-weight: bold;
        }
        
        .comment-form {
            margin-bottom: 30px;
        }
        
        .comment-textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
            margin-bottom: 10px;
            min-height: 100px;
            resize: vertical;
        }
        
        .comment-button {
            background-color: #333;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            font-size: 14px;
            cursor: pointer;
            transition: background-color 0.2s;
        }
        
        .comment-button:hover {
            background-color: #555;
        }
        
        .comment {
            background-color: #fff;
            border-radius: 5px;
            padding: 15px;
            margin-bottom: 15px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }
        
        .comment-header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
        }
        
        .comment-author {
            font-weight: bold;
        }
        
        .comment-date {
            color: #777;
            font-size: 12px;
        }
        
        .comment-content {
            color: #333;
            font-size: 14px;
        }
        
        /* Related articles */
        .related-articles {
            margin-top: 50px;
        }
        
        .related-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
        }
        
        .related-card {
            background-color: #fff;
            border-radius: 5px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }
        
        .related-card:hover {
            transform: translateY(-5px);
        }
        
        .related-image {
            height: 180px;
            overflow: hidden;
        }
        
        .related-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        .related-content {
            padding: 15px;
        }
        
        .related-title {
            font-weight: bold;
            font-size: 16px;
            margin-bottom: 8px;
            color: #333;
        }
        
        .related-date {
            font-size: 12px;
            color: #777;
            margin-bottom: 10px;
        }
        
        .related-excerpt {
            font-size: 14px;
            color: #555;
            margin-bottom: 15px;
        }
        
        .read-more {
            display: flex;
            align-items: center;
            font-size: 12px;
            font-weight: bold;
            color: #555;
            text-decoration: none;
        }
        
        .read-more:hover {
            color: #000;
        }
        
        /* Login message */
        .login-message {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            padding: 15px;
            background-color: #f0f0f0;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.15);
            z-index: 100;
            max-width: 300px;
            text-align: center;
        }
        
        .login-message.show {
            display: block;
            animation: fadeIn 0.3s;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        
        .login-message button {
            margin-top: 10px;
            padding: 5px 10px;
            background-color: #000;
            color: #fff;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }
        
        .login-message button:hover {
            background-color: #333;
        }
        
        /* Status message */
        .status-message {
            position: fixed;
            bottom: 20px;
            right: 20px;
            padding: 10px 15px;
            background-color: rgba(0, 0, 0, 0.8);
            color: white;
            border-radius: 4px;
            font-size: 14px;
            z-index: 100;
            display: none;
            animation: fadeInUp 0.3s;
        }
        
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        /* Responsive design */
        @media (max-width: 768px) {
            .related-grid {
                grid-template-columns: repeat(2, 1fr);
            }
            
            .article-title {
                font-size: 24px;
            }
            
            .article-header {
                height: 300px;
            }
        }
        
        @media (max-width: 576px) {
            .related-grid {
                grid-template-columns: 1fr;
            }
            
            .article-header {
                height: 250px;
            }
            
            .article-interactions {
                flex-direction: column;
                align-items: flex-start;
                gap: 15px;
            }
            
            .share-container {
                align-self: flex-end;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Main Article -->
        <article class="article">
            <div class="article-header">
                <img src="<?php echo htmlspecialchars($article['image_url'] ?? 'images/default-header.jpg'); ?>" alt="<?php echo htmlspecialchars($article['title']); ?>">
                <div class="article-title-box">
                    <h1 class="article-title"><?php echo htmlspecialchars($article['title']); ?></h1>
                    <div class="article-meta">
                        <span class="article-category"><?php echo htmlspecialchars($article['category_name']); ?></span>
                        <span class="article-date"><?php echo format_date($article['created_at']); ?></span>
                        <div class="article-author">
                            <img src="https://ui-avatars.com/api/?name=<?php echo urlencode($article['author_name']); ?>&size=64&background=random" alt="<?php echo htmlspecialchars($article['author_name']); ?>">
                            <span><?php echo htmlspecialchars($article['author_name']); ?></span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="article-content">
                <?php echo $article['content']; ?>
            </div>

            <div class="article-interactions">
                <div class="like-container">
                    <button class="like-button <?php echo $article['user_liked'] ? 'active' : ''; ?>" id="likeButton">
                        <?php echo $article['user_liked'] ? '❤️' : '🤍'; ?>
                    </button>
                    <span class="like-count" id="likeCount"><?php echo $article['likes_count']; ?> Likes</span>
                </div>
            </div>
        </article>

        <!-- Comments Section -->
        <section class="comments-section">
            <h2 class="section-title">Comments (<?php echo count($comments); ?>)</h2>
            
            <?php if ($user_logged_in): ?>
                <form class="comment-form" method="post" action="article.php?id=<?php echo $article_id; ?>">
                    <textarea name="comment_content" class="comment-textarea" placeholder="Add your comment..."></textarea>
                    <button type="submit" name="add_comment" class="comment-button">Post Comment</button>
                </form>
            <?php else: ?>
                <p style="margin-bottom: 20px;">Please <a href="login.php">log in</a> to post a comment.</p>
            <?php endif; ?>
            
            <?php if (!empty($comments)): ?>
                <?php foreach ($comments as $comment): ?>
                    <div class="comment">
                        <div class="comment-header">
                            <span class="comment-author"><?php echo htmlspecialchars($comment['username']); ?></span>
                            <span class="comment-date"><?php echo format_date($comment['created_at']); ?></span>
                        </div>
                        <div class="comment-content">
                            <?php echo htmlspecialchars($comment['content']); ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No comments yet. Be the first to share your thoughts!</p>
            <?php endif; ?>
        </section>

        <!-- Related Articles -->
        <?php if (!empty($relatedArticles)): ?>
            <section class="related-articles">
                <h2 class="section-title">Related Articles</h2>
                <div class="related-grid">
                    <?php foreach ($relatedArticles as $related): ?>
                        <div class="related-card">
                            <div class="related-image">
                                <img src="<?php echo htmlspecialchars($related['image_url'] ?? 'images/default-blog.jpg'); ?>" alt="<?php echo htmlspecialchars($related['title']); ?>">
                            </div>
                            <div class="related-content">
                                <h3 class="related-title"><?php echo htmlspecialchars($related['title']); ?></h3>
                                <p class="related-date"><?php echo format_date($related['created_at']); ?></p>
                                <p class="related-excerpt"><?php echo htmlspecialchars($related['excerpt']); ?></p>
                                <a href="article.php?id=<?php echo $related['article_id']; ?>" class="read-more">
                                    Know more →
                                </a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </section>
        <?php endif; ?>
    </div>
    
    <!-- Login message popup -->
    <div class="login-message" id="loginMessage">
        <p>Please log in to like articles</p>
        <button onclick="closeLoginMessage()">OK</button>
    </div>
    
    <!-- Status message -->
    <div class="status-message" id="statusMessage"></div>
    
    <script>
        // Store login status client-side
        const userLoggedIn = <?php echo $user_logged_in ? 'true' : 'false'; ?>;
        
        // Function to show status message
        function showStatus(message, duration = 2000) {
            const statusEl = document.getElementById('statusMessage');
            statusEl.textContent = message;
            statusEl.style.display = 'block';
            
            setTimeout(() => {
                statusEl.style.display = 'none';
            }, duration);
        }
        
        // Handle like button click
        const likeButton = document.getElementById('likeButton');
        const likeCount = document.getElementById('likeCount');
        
        if (likeButton) {
            likeButton.addEventListener('click', function() {
                if (!userLoggedIn) {
                    // Show login message if not logged in
                    document.getElementById('loginMessage').classList.add('show');
                    return;
                }
                
                // Send AJAX request to like/unlike
                fetch('article.php?id=<?php echo $article_id; ?>', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: 'action=like'
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        // Update UI
                        likeCount.textContent = data.count + ' Likes';
                        
                        if (data.liked) {
                            likeButton.classList.add('active');
                            likeButton.textContent = '❤️';
                            showStatus('Article liked!');
                        } else {
                            likeButton.classList.remove('active');
                            likeButton.textContent = '🤍';
                            showStatus('Like removed');
                        }
                    } else if (data.status === 'error' && data.message.includes('log in')) {
                        // Server reports user is not logged in
                        document.getElementById('loginMessage').classList.add('show');
                    } else {
                        console.error('Error:', data.message);
                        showStatus('Error: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showStatus('Network error. Please try again.');
                });
            });
        }
        
        // Function to close the login message
        function closeLoginMessage() {
            document.getElementById('loginMessage').classList.remove('show');
        }
        
    </script>
</body>
</html>

<?php
include 'footer.php';
$connection->close();
?>