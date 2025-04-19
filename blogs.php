<?php
session_start();
include 'db.php';

date_default_timezone_set('Asia/Kolkata');

$category = isset($_GET['category']) ? intval($_GET['category']) : null;
$sort = isset($_GET['sort']) ? $_GET['sort'] : null;

$count_sql = "SELECT COUNT(*) as total FROM articles a WHERE 1=1";
if ($category) {
    $count_sql .= " AND a.category_id = $category";
}
$count_result = $connection->query($count_sql);
$total_articles = $count_result->fetch_assoc()['total'];
$total_pages = ceil($total_articles / $articles_per_page);

$sql = "SELECT 
    a.article_id, 
    a.title, 
    a.created_at, 
    a.updated_at, 
    a.image_url, 
    a.author_id,
    a.category_id,
    c.category_name, 
    u.username, 
    COUNT(DISTINCT com.comment_id) AS comment_count,
    COUNT(DISTINCT al.like_id) AS likes_count
FROM 
    articles a
LEFT JOIN 
    categories c ON a.category_id = c.category_id
LEFT JOIN 
    users u ON a.author_id = u.user_id
LEFT JOIN 
    comments com ON com.article_id = a.article_id
LEFT JOIN 
    article_likes al ON al.article_id = a.article_id
WHERE 
    1=1";

if ($category) {
    $sql .= " AND a.category_id = $category";
}

$sql .= " GROUP BY 
    a.article_id, a.title, a.created_at, a.image_url, a.author_id, a.category_id, c.category_name, u.username";

if ($sort === 'popular') {
    $sql .= " ORDER BY likes_count DESC";
} else {
    $sql .= " ORDER BY a.created_at DESC";
}

$articles_per_page = 10;
$current_page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$offset = ($current_page - 1) * $articles_per_page;

$sql .= " LIMIT $offset, $articles_per_page";

$result = $connection->query($sql);
if (!$result) {
    echo "Error: " . $connection->error;
}

function time_elapsed_string($datetime)
{
    $now = new DateTime;
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);

    if ($diff->y > 0) {
        return $diff->y . ' year' . ($diff->y > 1 ? 's' : '') . ' ago';
    } elseif ($diff->m > 0) {
        return $diff->m . ' month' . ($diff->m > 1 ? 's' : '') . ' ago';
    } elseif ($diff->d > 0) {
        if ($diff->d == 1) {
            return 'Yesterday';
        } else {
            return $diff->d . ' days ago';
        }
    } elseif ($diff->h > 0) {
        return $diff->h . ' hour' . ($diff->h > 1 ? 's' : '') . ' ago';
    } elseif ($diff->i > 0) {
        return $diff->i . ' minute' . ($diff->i > 1 ? 's' : '') . ' ago';
    } else {
        return 'Just now';
    }
}

function format_date($date_string)
{
    if (empty($date_string)) return 'Date unavailable';

    try {
        $date = new DateTime($date_string);
        return $date->format('F j, Y');
    } catch (Exception $e) {
        return 'Invalid date';
    }
}

function check_if_liked($article_id, $user_id)
{
    global $connection;
    $stmt = $connection->prepare("SELECT * FROM article_likes WHERE article_id = ? AND user_id = ?");
    $stmt->bind_param("ii", $article_id, $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->num_rows > 0;
}

function build_pagination_url($page)
{
    $url = '?page=' . $page;

    foreach ($_GET as $key => $value) {
        if ($key !== 'page') {
            $url .= '&' . urlencode($key) . '=' . urlencode($value);
        }
    }

    return $url;
}

function getCategoryName($category_id)
{
    global $connection;
    $stmt = $connection->prepare("SELECT category_name FROM categories WHERE category_id = ?");
    $stmt->bind_param("i", $category_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($row = $result->fetch_assoc()) {
        return $row['category_name'];
    }
    return 'Unknown Category';
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $category ? getCategoryName($category) . " Blogs" : "Blog Posts"; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
        }

        body {
            background-color: #ffffff;
            color: #000000;
            line-height: 1.5;
            margin: 0;
            padding: 0;
        }

        .main-content {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }

        .blog-list {
            margin-top: 20px;
        }

        .blog-card {
            display: flex;
            padding: 15px 10px;
            border-bottom: 1px solid #e0e0e0;
            position: relative;
            transition: background-color 0.2s ease;
        }

        .blog-card:hover {
            background-color: #f5f5f5;
        }

        .blog-content {
            flex: 1;
        }

        .blog-title {
            font-size: 16px;
            font-weight: 500;
            margin-bottom: 6px;
            color: #000;
        }

        .blog-title a {
            color: inherit;
            text-decoration: none;
        }

        .blog-title a:hover {
            color: #444;
            text-decoration: underline;
        }

        .blog-meta {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 8px;
            font-size: 12px;
            color: #555;
        }

        .tag {
            padding: 3px 8px;
            border-radius: 4px;
            font-size: 11px;
            font-weight: 500;
            color: #fff;
            background-color: #000;
            border: 1px solid #000;
        }

        .product {
            background-color: #1a1a1a;
        }

        .case-study {
            background-color: #2a2a2a;
        }

        .opinion {
            background-color: #3a3a3a;
        }

        .ui-theory {
            background-color: #4a4a4a;
        }

        .author {
            display: flex;
            align-items: center;
        }

        .author img {
            width: 16px;
            height: 16px;
            border-radius: 50%;
            margin-right: 5px;
            filter: grayscale(100%);
        }

        .comments {
            display: flex;
            align-items: center;
        }

        .comments svg {
            width: 14px;
            height: 14px;
            margin-right: 4px;
        }

        .filter-bar {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 1px solid #ccc;
        }

        .filter-options a {
            margin-right: 15px;
            color: #555;
            text-decoration: none;
            font-size: 14px;
            transition: color 0.2s ease;
        }

        .filter-options a.active {
            color: #000;
            font-weight: 500;
            position: relative;
        }

        .filter-options a.active::after {
            content: '';
            position: absolute;
            bottom: -3px;
            left: 0;
            width: 100%;
            height: 2px;
            background-color: #000;
        }

        .filter-options a:hover {
            color: #000;
        }

        .edit-link {
            font-size: 12px;
            color: #555;
            text-decoration: none;
            position: absolute;
            right: 10px;
            top: 15px;
            transition: color 0.2s ease;
        }

        .edit-link:hover {
            color: #000;
            text-decoration: underline;
        }

        .time::after {
            content: "•";
            margin-left: 5px;
            margin-right: 5px;
            color: #888;
        }

        .like-button {
            display: flex;
            align-items: center;
            gap: 4px;
            cursor: pointer;
            transition: color 0.2s ease;
        }

        .like-button:hover {
            color: #ff4757;
        }

        .like-button:hover .like-icon {
            stroke: #ff4757;
        }

        .like-icon {
            width: 14px;
            height: 14px;
            transition: stroke 0.2s ease, fill 0.2s ease;
        }

        .like-button .like-icon[fill="currentColor"] {
            fill: #ff4757;
            stroke: #ff4757;
        }

        .page-info {
            text-align: center;
            margin-top: 10px;
            font-size: 14px;
            color: #666;
        }

        .category-indicator {
            background-color: #f8f9fa;
            border-radius: 4px;
            padding: 8px 15px;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .category-name {
            font-weight: 500;
        }

        .clear-filter {
            color: #555;
            text-decoration: none;
            font-size: 13px;
            transition: color 0.2s ease;
        }

        .clear-filter:hover {
            color: #000;
            text-decoration: underline;
        }


        .pagination {
            display: flex;
            justify-content: center;
            margin-top: 30px;
            gap: 5px;
        }

        .pagination-item {
            padding: 8px 12px;
            border: 1px solid #e0e0e0;
            border-radius: 4px;
            text-decoration: none;
            color: #555;
            transition: all 0.2s ease;
        }

        .pagination-item:hover {
            background-color: #f5f5f5;
        }

        .pagination-item.active {
            background-color: #000;
            color: #fff;
            border-color: #000;
        }

        .pagination-item.disabled {
            opacity: 0.5;
            pointer-events: none;
        }
    </style>
</head>

<body>
    <?php include 'navbar.php'; ?>

    <div class="main-content">
        <h2 class="text-center mb-4">Explore our Blogs</h2>

        <?php if ($category): ?>
            <div class="category-indicator">
                <div class="category-name">Showing: <?php echo htmlspecialchars(getCategoryName($category)); ?></div>
                <a href="blogs.php<?php echo $sort ? '?sort=' . $sort : ''; ?>" class="clear-filter">Clear filter</a>
            </div>
        <?php endif; ?>

        <div class="filter-bar">
            <div class="filter-options">
                <a href="?sort=latest<?php echo $category ? '&category=' . $category : ''; ?>" class="<?php echo (!$sort || $sort === 'latest') ? 'active' : ''; ?>">Latest</a>
                <a href="?sort=popular<?php echo $category ? '&category=' . $category : ''; ?>" class="<?php echo ($sort === 'popular') ? 'active' : ''; ?>">Popular</a>
            </div>
        </div>

        <div class="blog-list">
            <?php
            if ($result && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $time_ago = time_elapsed_string($row["created_at"]);

                    $category_class = "";
                    $category_name = $row["category_name"];

                    if (stripos($category_name, "product") !== false) {
                        $category_class = "product";
                    } else if (stripos($category_name, "case study") !== false) {
                        $category_class = "case-study";
                    } else if (stripos($category_name, "opinion") !== false) {
                        $category_class = "opinion";
                    } else if (stripos($category_name, "ui theory") !== false) {
                        $category_class = "ui-theory";
                    }
            ?>
                    <article class="blog-card">
                        <div class="blog-content">
                            <h2 class="blog-title">
                                <a href="article.php?id=<?php echo $row["article_id"]; ?>"><?php echo htmlspecialchars($row["title"]); ?></a>
                            </h2>
                            <div class="blog-meta">
                                <a href="blogs.php?category=<?php echo $row["category_id"]; ?>" class="tag <?php echo $category_class; ?>"><?php echo htmlspecialchars($row["category_name"]); ?></a>
                                <span class="author">
                                    <img src="https://ui-avatars.com/api/?name=<?php echo urlencode($row["username"]); ?>&size=32&background=random" alt="<?php echo htmlspecialchars($row["username"]); ?>">
                                    <?php echo htmlspecialchars($row["username"]); ?>
                                </span>
                                <span class="time"><?php echo $time_ago; ?></span>
                                <?php
                                echo "Published: " . format_date($row['created_at']);
                                if (isset($row['updated_at']) && $row['updated_at'] != $row['created_at']) {
                                    echo " (Updated: " . format_date($row['updated_at']) . ")";
                                }
                                ?>
                                <span class="like-button" data-article-id="<?php echo $row["article_id"]; ?>">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="<?php echo (isset($_SESSION['user_id']) && check_if_liked($row["article_id"], $_SESSION['user_id'])) ? 'currentColor' : 'none'; ?>" stroke="currentColor" stroke-width="2" class="like-icon">
                                        <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
                                    </svg>
                                    <span class="like-count"><?php echo $row["likes_count"]; ?></span>
                                </span>
                                <span class="comments">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
                                    </svg>
                                    <?php echo $row["comment_count"]; ?>
                                </span>

                                <?php if (isset($_SESSION['user-id']) && $_SESSION['user-id'] == $row["author_id"]): ?>
                                    <a href="edit-article.php?id=<?php echo $row["article_id"]; ?>" class="edit-link">Edit</a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </article>
            <?php
                }
            } else {
                echo '<div class="alert alert-info mt-3">No articles found matching these criteria</div>';
            }
            ?>
        </div>

        <?php if ($total_pages > 1): ?>
            <div class="page-info">
                Showing page <?php echo $current_page; ?> of <?php echo $total_pages; ?>
            </div>
            <div class="pagination">
                <?php if ($current_page > 1): ?>
                    <a href="<?php echo build_pagination_url(1); ?>" class="pagination-item">&laquo; First</a>
                    <a href="<?php echo build_pagination_url($current_page - 1); ?>" class="pagination-item">&lsaquo; Prev</a>
                <?php else: ?>
                    <span class="pagination-item disabled">&laquo; First</span>
                    <span class="pagination-item disabled">&lsaquo; Prev</span>
                <?php endif; ?>

                <?php
                $start_page = max(1, $current_page - 2);
                $end_page = min($total_pages, $current_page + 2);

                for ($i = $start_page; $i <= $end_page; $i++): ?>
                    <a href="<?php echo build_pagination_url($i); ?>" class="pagination-item <?php echo ($i == $current_page) ? 'active' : ''; ?>"><?php echo $i; ?></a>
                <?php endfor; ?>

                <?php if ($current_page < $total_pages): ?>
                    <a href="<?php echo build_pagination_url($current_page + 1); ?>" class="pagination-item">Next &rsaquo;</a>
                    <a href="<?php echo build_pagination_url($total_pages); ?>" class="pagination-item">Last &raquo;</a>
                <?php else: ?>
                    <span class="pagination-item disabled">Next &rsaquo;</span>
                    <span class="pagination-item disabled">Last &raquo;</span>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>

    <?php include 'footer.php'; ?>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const likeButtons = document.querySelectorAll('.like-button');

            likeButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const articleId = this.getAttribute('data-article-id');
                    const likeIcon = this.querySelector('.like-icon');
                    const likeCount = this.querySelector('.like-count');

                    const formData = new FormData();
                    formData.append('article_id', articleId);

                    fetch('like_article.php', {
                            method: 'POST',
                            body: formData
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.status === 'success') {
                                likeCount.textContent = data.likes_count;

                                if (data.action === 'liked') {
                                    likeIcon.setAttribute('fill', 'currentColor');
                                } else {
                                    likeIcon.setAttribute('fill', 'none');
                                }
                            } else {
                                if (data.message === 'You must be logged in to like articles') {
                                    alert('Please log in to like articles');
                                    window.location.href = 'signin.php';
                                } else {
                                    alert(data.message);
                                }
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                        });
                });
            });
        });
    </script>
</body>

</html>