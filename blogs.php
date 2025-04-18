<?php
include 'navbar.php'
?>

<?php
include 'db.php'; // Include database connection

// Get filter parameters
$category = isset($_GET['category']) ? intval($_GET['category']) : null;
$sort = isset($_GET['sort']) ? $_GET['sort'] : null;

// Build the SQL query based on filters
$sql = "SELECT a.article_id, a.title, a.created_at, a.image_url, 
       c.category_name, u.username, 
       (SELECT COUNT(*) FROM comments WHERE article_id = a.article_id) AS comment_count,
       (SELECT COUNT(*) FROM article_likes WHERE article_id = a.article_id) AS likes_count
       FROM articles a
       LEFT JOIN categories c ON a.category_id = c.category_id
       LEFT JOIN users u ON a.author_id = u.user_id
       WHERE 1=1";

// Add category filter if specified
if ($category) {
    $sql .= " AND a.category_id = $category";
}

// Determine sort order
if ($sort === 'popular') {
    $sql .= " ORDER BY likes_count DESC";
} else {
    $sql .= " ORDER BY a.created_at DESC";
}

$sql .= " LIMIT 10";

$result = $connection->query($sql);

// Helper function to calculate time ago
function time_elapsed_string($datetime) {
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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog Posts</title>
    <style>
        /* Reset and common styles */
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
            padding: 20px;
        }
        
        .container {
            max-width: 800px;
            margin: 0 auto;
        }
        
        /* Blog list styling */
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
        
        /* Vote count styling */
        .vote-count {
            color: #333;
            font-weight: bold;
            font-size: 18px;
            width: 30px;
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-right: 15px;
        }
        
        .vote-arrow {
            font-size: 12px;
            color: #000;
        }
        
        /* Content styling */
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
        
        /* Tag styles - now in black and white */
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
        
        /* Author and meta info */
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
        
        /* Filter bar */
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
        
        /* Edit button */
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
        
        /* Fix for the time display */
        .time::after {
            content: "•";
            margin-left: 5px;
            margin-right: 5px;
            color: #888;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="filter-bar">
            <div class="filter-options">
                <a href="?sort=latest" class="<?php echo (!$sort || $sort === 'latest') ? 'active' : ''; ?>">Latest</a>
                <a href="?sort=popular" class="<?php echo ($sort === 'popular') ? 'active' : ''; ?>">Popular</a>
                <?php if ($category): ?>
                    <a href="blogs.php">Clear Filters</a>
                <?php endif; ?>
            </div>
        </div>
        
        <div class="blog-list">
            <?php 
            // Check if there are results
            if ($result && $result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    // Calculate time ago
                    $time_ago = time_elapsed_string($row["created_at"]);
                    
                    // Determine category class
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
                            <span class="tag <?php echo $category_class; ?>"><?php echo htmlspecialchars($row["category_name"]); ?></span>
                            <span class="author">
                                <img src="https://ui-avatars.com/api/?name=<?php echo urlencode($row["username"]); ?>&size=32&background=random" alt="<?php echo htmlspecialchars($row["username"]); ?>">
                                <?php echo htmlspecialchars($row["username"]); ?>
                            </span>
                            <span class="time"><?php echo $time_ago; ?></span>
                            <span class="comments">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
                                </svg>
                                <?php echo $row["comment_count"]; ?> Comments
                            </span>
                            <?php if (isset($_SESSION['user_id']) && $_SESSION['user_id'] == $row["author_id"]): ?>
                                <a href="edit-article.php?id=<?php echo $row["article_id"]; ?>" class="edit-link">Edit</a>
                            <?php endif; ?>
                        </div>
                    </div>
                </article>
            <?php
                }
            } else {
                echo "<p>No articles found matching these criteria</p>";
            }
            ?>
        </div>
    </div>
</body>
</html>

<?php
include 'footer.php';
?>