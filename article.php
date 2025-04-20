<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include 'db.php';

$user_logged_in = isset($_SESSION['user-id']) && !empty($_SESSION['user-id']);
$current_user_id = $user_logged_in ? $_SESSION['user-id'] : 0;

$article_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if (!$article_id) {
    header('Location: blogs.php');
    exit;
}

if (isset($_POST['action']) && $_POST['action'] == 'like') {
    header('Content-Type: application/json');

    if (!$user_logged_in) {
        echo json_encode(['status' => 'error', 'message' => 'Please log in to like articles']);
        exit;
    }

    $check_sql = "SELECT * FROM article_likes WHERE article_id = ? AND user_id = ?";
    $check_stmt = $connection->prepare($check_sql);
    $check_stmt->bind_param("ii", $article_id, $current_user_id);
    $check_stmt->execute();
    $check_result = $check_stmt->get_result();

    if ($check_result->num_rows > 0) {
        $delete_sql = "DELETE FROM article_likes WHERE article_id = ? AND user_id = ?";
        $delete_stmt = $connection->prepare($delete_sql);
        $delete_stmt->bind_param("ii", $article_id, $current_user_id);

        if ($delete_stmt->execute()) {
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
        $insert_sql = "INSERT INTO article_likes (article_id, user_id) VALUES (?, ?)";
        $insert_stmt = $connection->prepare($insert_sql);
        $insert_stmt->bind_param("ii", $article_id, $current_user_id);

        if ($insert_stmt->execute()) {
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

if (isset($_POST['add_comment']) && $user_logged_in) {
    $comment_content = trim($_POST['comment_content']);

    if (!empty($comment_content)) {
        $insert_comment = "INSERT INTO comments (article_id, user_id, comment_text) VALUES (?, ?, ?)";
        $comment_stmt = $connection->prepare($insert_comment);
        $comment_stmt->bind_param("iis", $article_id, $current_user_id, $comment_content);

        if ($comment_stmt->execute()) {
            header("Location: article.php?id=$article_id");
            exit;
        }
    }
}

include 'navbar.php';

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
    header('Location: blogs.php');
    exit;
}

$article = $result->fetch_assoc();

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
    if (strlen($related['excerpt']) >= 150) {
        $related['excerpt'] .= '...';
    }
    $relatedArticles[] = $related;
}

function format_date($date_string)
{
    if (empty($date_string)) return 'Date unavailable';

    try {
        $date = new DateTime($date_string);
        return $date->format('F j, Y');
    } catch (Exception $e) {
        $timestamp = strtotime($date_string);
        if ($timestamp === false) {
            return 'Invalid date';
        }
        return date('F j, Y', $timestamp);
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($article['title']); ?> - Wellness Blog</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }

        body {
            background-color: #111;
            color: #fff;
            line-height: 1.6;
        }

        .container {
            max-width: 1000px;
            margin: 0 auto;
            padding: 40px 20px;
        }

        body.article-page .nav-list li a {
            color: #fff;
            text-decoration: none;
        }

        body.article-page .nav-list li a:hover {
            color: #1f2937;
            text-decoration: none;
        }

        body.article-page .logo-link .logo-text {
            color: #fff;
        }

        body.article-page .navbar {
            background-color: transparent;
            border-bottom: none;
        }

        body.article-page .navbar-divider {
            background-color: rgba(255, 255, 255, 0.2);
        }

        .article {
            background-color: #222;
            border-radius: 12px;
            overflow: hidden;
            margin-bottom: 40px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.5);
        }

        .article-header {
            position: relative;
            height: 450px;
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
            background: linear-gradient(to top, rgba(0, 0, 0, 0.9), transparent);
            padding: 40px 30px 30px;
        }

        .article-title {
            color: #fff;
            font-size: 32px;
            font-weight: bold;
            line-height: 1.3;
            margin-bottom: 15px;
            text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.8);
        }

        .article-meta {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 20px;
            font-size: 14px;
            color: #ccc;
        }

        .article-category {
            background-color: rgba(255, 255, 255, 0.1);
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: #fff;
        }

        .article-author {
            display: flex;
            align-items: center;
        }

        .article-author img {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            margin-right: 10px;
            border: 2px solid rgba(255, 255, 255, 0.3);
        }

        .article-content {
            padding: 40px;
            font-size: 17px;
            color: #e0e0e0;
        }

        .article-content p {
            margin-bottom: 25px;
        }

        .article-content h2 {
            margin-top: 40px;
            margin-bottom: 20px;
            font-size: 24px;
            color: #fff;
        }

        .article-content h3 {
            margin-top: 35px;
            margin-bottom: 15px;
            font-size: 20px;
            color: #fff;
        }

        .article-content ul,
        .article-content ol {
            margin-bottom: 25px;
            margin-left: 30px;
        }

        .article-content li {
            margin-bottom: 12px;
        }

        .article-interactions {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            padding: 20px 40px;
        }

        .like-container {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .like-button {
            background: none;
            border: none;
            font-size: 26px;
            cursor: pointer;
            transition: transform 0.3s ease, filter 0.3s ease;
        }

        .like-button:hover {
            transform: scale(1.2);
            filter: brightness(1.2);
        }

        .like-count {
            font-size: 16px;
            font-weight: 600;
            color: #ddd;
        }

        .share-container {
            display: flex;
            gap: 15px;
        }

        .share-button {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            background-color: rgba(255, 255, 255, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .share-button:hover {
            background-color: rgba(255, 255, 255, 0.2);
        }

        .comments-section {
            margin-top: 60px;
        }

        .section-title {
            font-size: 24px;
            margin-bottom: 30px;
            font-weight: bold;
            color: #fff;
            position: relative;
            padding-bottom: 12px;
        }

        .section-title:after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 60px;
            height: 3px;
            background-color: rgba(255, 255, 255, 0.3);
        }

        .comment-form {
            margin-bottom: 40px;
        }

        .comment-textarea {
            width: 100%;
            padding: 15px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 8px;
            font-size: 15px;
            margin-bottom: 12px;
            min-height: 120px;
            resize: vertical;
            background-color: rgba(255, 255, 255, 0.05);
            color: #fff;
        }

        .comment-textarea:focus {
            outline: none;
            border-color: rgba(255, 255, 255, 0.5);
            background-color: rgba(255, 255, 255, 0.1);
        }

        .comment-button {
            background-color: rgba(255, 255, 255, 0.1);
            color: white;
            border: 1px solid rgba(255, 255, 255, 0.3);
            padding: 12px 24px;
            border-radius: 6px;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .comment-button:hover {
            background-color: rgba(255, 255, 255, 0.2);
            border-color: rgba(255, 255, 255, 0.5);
        }

        .comment {
            background-color: rgba(255, 255, 255, 0.05);
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 18px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
        }

        .comment-header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 12px;
        }

        .comment-author {
            font-weight: bold;
            color: #fff;
        }

        .comment-date {
            color: #999;
            font-size: 12px;
        }

        .comment-content {
            color: #ddd;
            font-size: 15px;
        }

        .related-articles {
            margin-top: 70px;
        }

        .related-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 25px;
        }

        .related-card {
            background-color: #222;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .related-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.4);
        }

        .related-image {
            height: 180px;
            overflow: hidden;
        }

        .related-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .related-card:hover .related-image img {
            transform: scale(1.1);
        }

        .related-content {
            padding: 20px;
        }

        .related-title {
            font-weight: bold;
            font-size: 17px;
            margin-bottom: 12px;
            color: #fff;
            line-height: 1.4;
        }

        .related-date {
            font-size: 12px;
            color: #999;
            margin-bottom: 12px;
        }

        .related-excerpt {
            font-size: 14px;
            color: #bbb;
            margin-bottom: 18px;
            line-height: 1.5;
        }

        .read-more {
            display: inline-flex;
            align-items: center;
            font-size: 13px;
            font-weight: bold;
            color: #ccc;
            text-decoration: none;
            transition: color 0.3s;
        }

        .read-more:hover {
            color: #fff;
        }

        .login-message {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            padding: 20px;
            background-color: rgba(25, 25, 25, 0.95);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 8px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.5);
            z-index: 100;
            max-width: 320px;
            text-align: center;
            color: #fff;
        }

        .login-message.show {
            display: block;
            animation: fadeIn 0.3s;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translate(-50%, -60%);
            }

            to {
                opacity: 1;
                transform: translate(-50%, -50%);
            }
        }

        .login-message button {
            margin-top: 15px;
            padding: 8px 20px;
            background-color: rgba(255, 255, 255, 0.1);
            color: #fff;
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 5px;
            cursor: pointer;
            transition: all 0.3s;
        }

        .login-message button:hover {
            background-color: rgba(255, 255, 255, 0.2);
        }

        .status-message {
            position: fixed;
            bottom: 30px;
            right: 30px;
            padding: 12px 20px;
            background-color: rgba(0, 0, 0, 0.8);
            color: white;
            border-radius: 6px;
            font-size: 14px;
            z-index: 100;
            display: none;
            animation: fadeInUp 0.3s;
            border: 1px solid rgba(255, 255, 255, 0.2);
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
        @media (max-width: 900px) {
            .article-title {
                font-size: 28px;
            }

            .article-header {
                height: 350px;
            }

            .article-content {
                padding: 30px;
            }
        }

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

            .container {
                padding: 20px;
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
                gap: 20px;
                padding: 20px;
            }

            .share-container {
                align-self: flex-end;
            }

            .article-content {
                padding: 20px;
                font-size: 16px;
            }

            .article-title {
                font-size: 22px;
            }
        }
    </style>
</head>

<body class="article-page">
    <div class="container">
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

        <section class="comments-section">
            <h2 class="section-title">Comments (<?php echo count($comments); ?>)</h2>

            <?php if ($user_logged_in): ?>
                <form class="comment-form" method="post" action="article.php?id=<?php echo $article_id; ?>">
                    <textarea name="comment_content" class="comment-textarea" placeholder="Add your comment..."></textarea>
                    <button type="submit" name="add_comment" class="comment-button">Post Comment</button>
                </form>
            <?php else: ?>
                <p style="margin-bottom: 20px; color: #aaa;">Please <a href="signin.php" style="color: #fff; text-decoration: underline;">log in</a> to post a comment.</p>
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
                <p style="color: #aaa; font-style: italic;">No comments yet. Be the first to share your thoughts!</p>
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

    <div class="login-message" id="loginMessage">
        <p>Please log in to like articles</p>
        <button onclick="closeLoginMessage()">OK</button>
    </div>

    <div class="status-message" id="statusMessage"></div>

    <script>
        const userLoggedIn = <?php echo $user_logged_in ? 'true' : 'false'; ?>;

        function showStatus(message, duration = 2500) {
            const statusEl = document.getElementById('statusMessage');
            statusEl.textContent = message;
            statusEl.style.display = 'block';

            setTimeout(() => {
                statusEl.style.display = 'none';
            }, duration);
        }

        const likeButton = document.getElementById('likeButton');
        const likeCount = document.getElementById('likeCount');

        if (likeButton) {
            likeButton.addEventListener('click', function() {
                if (!userLoggedIn) {
                    document.getElementById('loginMessage').classList.add('show');
                    return;
                }

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

        function closeLoginMessage() {
            document.getElementById('loginMessage').classList.remove('show');
        }
    </script>
</body>

</html>

<?php
include 'footer.php';
?>