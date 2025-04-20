<?php
session_start();
include 'db.php';

if (isset($_GET['message']) && $_GET['message'] == 'deleted') {
  $delete_message = "Post deleted successfully";
}

$current_user_id = $_SESSION['user-id'];

$sql = "SELECT a.article_id, a.title, c.category_name, a.created_at 
        FROM articles a 
        LEFT JOIN categories c ON a.category_id = c.category_id 
        WHERE a.author_id = $current_user_id
        ORDER BY a.created_at DESC";
$result = $connection->query($sql);

$total_posts = ($result) ? $result->num_rows : 0;

if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
  $article_id = $connection->real_escape_string($_GET['delete']);

  $check_ownership = "SELECT article_id FROM articles WHERE article_id = $article_id AND author_id = $current_user_id";
  $ownership_result = $connection->query($check_ownership);

  if ($ownership_result && $ownership_result->num_rows > 0) {
    $delete_sql = "DELETE FROM articles WHERE article_id = $article_id AND author_id = $current_user_id";

    if ($connection->query($delete_sql) === TRUE) {
      $delete_message = "Post deleted successfully";
      header("Location: dashboard.php?message=deleted");
      exit;
    } else {
      $delete_message = "Error deleting post: " . $connection->error;
    }
  } else {
    $delete_message = "Error: You don't have permission to delete this post or it doesn't exist.";
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= isset($_SESSION['username']) ? htmlspecialchars($_SESSION['username']) : 'User'; ?> Dashboard</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    :root {
      --black: #ffffff;
      --darker-gray: #cccccc;
      --dark-gray: #aaaaaa;
      --medium-gray: #777777;
      --light-gray: #333333;
      --lighter-gray: #0d0d0d;
      --white: #000000;
      --border-radius: 8px;
      --box-shadow: 0 4px 20px rgba(255, 255, 255, 0.08);
      --transition: all 0.2s ease;
    }

    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
      background-color: var(--lighter-gray);
      color: var(--darker-gray);
      line-height: 1.6;
    }

    .container {
      max-width: 1200px;
      margin: 0 auto;
      padding: 2rem;
    }

    .dashboard-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 2rem;
    }

    .dashboard-title {
      display: flex;
      align-items: center;
      gap: 1rem;
    }

    .dashboard-title h1 {
      font-size: 2rem;
      font-weight: 800;
      color: var(--black);
      margin: 0;
    }

    .dashboard-title-icon {
      width: 24px;
      height: 24px;
      background-color: var(--black);
      color: var(--white);
      border-radius: var(--border-radius);
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 1.5rem;
    }

    .dashboard-user {
      display: flex;
      align-items: center;
      gap: 1rem;
    }

    .user-avatar-profile{
      min-width: 42px;
      width: 42px;
      min-height: 42px;
      height: 42px;
      background-color: var(--black);
      color: var(--white);
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 1.2rem;
      box-shadow: var(--box-shadow);
      flex-shrink: 0;
      overflow: hidden;
      aspect-ratio: 1/1;
    }

    .user-info {
      text-align: right;
    }

    .user-name {
      font-weight: 600;
      margin-bottom: 0.2rem;
    }

    .logout-btn {
      color: var(--dark-gray);
      text-decoration: none;
      font-size: 0.85rem;
      transition: var(--transition);
      white-space: nowrap;
    }

    .logout-btn i {
      margin-right: 4px;
    }

    .logout-btn:hover {
      color: var(--black);
    }

    .dashboard-container {
      display: grid;
      grid-template-columns: 250px 1fr;
      gap: 2rem;
    }

    .sidebar {
      background-color: var(--white);
      border-radius: var(--border-radius);
      padding: 1.5rem;
      box-shadow: var(--box-shadow);
      height: fit-content;
    }

    .button {
      display: flex;
      align-items: center;
      gap: 10px;
      background-color: var(--black);
      color: var(--white);
      border: none;
      border-radius: var(--border-radius);
      padding: 14px 18px;
      font-size: 16px;
      font-weight: 500;
      cursor: pointer;
      margin-bottom: 14px;
      width: 100%;
      text-decoration: none;
      transition: var(--transition);
    }

    .button:hover {
      background-color: var(--darker-gray);
    }

    .sidebar-item {
      display: flex;
      align-items: center;
      gap: 12px;
      padding: 12px 16px;
      border-radius: var(--border-radius);
      cursor: pointer;
      font-weight: 500;
      text-decoration: none;
      color: var(--dark-gray);
      transition: var(--transition);
    }

    .sidebar-item.active {
      background-color: var(--lighter-gray);
      color: var(--black);
      font-weight: 600;
    }

    .sidebar-item:hover:not(.active) {
      background-color: var(--lighter-gray);
    }

    .sidebar-icon {
      width: 20px;
      text-align: center;
    }

    .content {
      background-color: var(--white);
      border-radius: var(--border-radius);
      padding: 2rem;
      box-shadow: var(--box-shadow);
    }

    .content-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 1.5rem;
      padding-bottom: 1rem;
      border-bottom: 1px solid var(--light-gray);
    }

    .content-title {
      font-size: 1.5rem;
      font-weight: 700;
      color: var(--black);
    }

    .post-count {
      background-color: var(--lighter-gray);
      color: var(--dark-gray);
      font-size: 0.9rem;
      padding: 0.3rem 0.8rem;
      border-radius: 30px;
      font-weight: 600;
    }

    .alert {
      padding: 1rem 1.2rem;
      margin-bottom: 1.5rem;
      border-radius: var(--border-radius);
      font-weight: 500;
      display: flex;
      align-items: center;
      gap: 0.8rem;
    }

    .alert-success {
      background-color: var(--lighter-gray);
      color: var(--darker-gray);
      border-left: 4px solid var(--black);
    }

    .alert-error {
      background-color: var(--lighter-gray);
      color: var(--darker-gray);
      border-left: 4px solid var(--dark-gray);
    }

    .posts-table-container {
      overflow-x: auto;
    }

    .posts-table {
      width: 100%;
      border-collapse: separate;
      border-spacing: 0;
    }

    .posts-table th {
      text-align: left;
      padding: 1rem 1.2rem;
      background-color: var(--black);
      font-weight: 500;
      font-size: 0.9rem;
      text-transform: uppercase;
      letter-spacing: 0.5px;
      color: var(--white);
    }

    .posts-table th:first-child {
      border-top-left-radius: var(--border-radius);
    }

    .posts-table th:last-child {
      border-top-right-radius: var(--border-radius);
    }

    .posts-table td {
      padding: 1rem 1.2rem;
      border-bottom: 1px solid var(--lighter-gray);
      vertical-align: middle;
    }

    .posts-table tr:last-child td {
      border-bottom: none;
    }

    .posts-table tr:hover {
      background-color: var(--lighter-gray);
    }

    .post-title {
      font-weight: 600;
      color: var(--black);
    }

    .category-badge {
      display: inline-block;
      background-color: var(--lighter-gray);
      color: var(--darker-gray);
      padding: 0.3rem 0.8rem;
      font-size: 0.8rem;
      border-radius: 30px;
      font-weight: 600;
    }

    .edit-btn,
    .delete-btn {
      font-weight: 500;
      text-decoration: none;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      gap: 0.5rem;
      padding: 0.5rem 1rem;
      border-radius: var(--border-radius);
      transition: var(--transition);
    }

    .edit-btn {
      background-color: var(--lighter-gray);
      color: var(--darker-gray);
    }

    .delete-btn {
      background-color: var(--black);
      color: var(--white);
    }

    .edit-btn:hover {
      background-color: var(--light-gray);
    }

    .delete-btn:hover {
      background-color: var(--darker-gray);
    }

    .action-buttons {
      display: flex;
      gap: 0.5rem;
    }

    .no-posts {
      padding: 3rem 1rem;
      text-align: center;
      color: var(--medium-gray);
    }

    .no-posts-icon {
      font-size: 3rem;
      color: var(--light-gray);
      margin-bottom: 1rem;
    }

    .no-posts-message {
      font-size: 1.1rem;
      font-weight: 500;
      margin-bottom: 0.5rem;
      color: var(--darker-gray);
    }

    .no-posts-sub {
      font-size: 0.9rem;
      margin-bottom: 1.5rem;
    }

    .no-posts-btn {
      display: inline-flex;
      align-items: center;
      gap: 0.5rem;
      background-color: var(--black);
      color: var(--white);
      text-decoration: none;
      padding: 0.7rem 1.2rem;
      border-radius: var(--border-radius);
      font-weight: 500;
      transition: var(--transition);
    }

    .no-posts-btn:hover {
      background-color: var(--darker-gray);
    }

    .date-info {
      color: var(--medium-gray);
      font-size: 0.85rem;
    }

    @media (max-width: 992px) {
      .dashboard-container {
        grid-template-columns: 1fr;
      }

      .sidebar {
        display: flex;
        gap: 1rem;
        margin-bottom: 2rem;
      }

      .button,
      .sidebar-item {
        margin-bottom: 0;
        flex: 1;
      }
    }

    @media (max-width: 768px) {
      .container {
        padding: 1rem;
      }

      .dashboard-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 1rem;
      }

      .dashboard-user {
        width: 100%;
        justify-content: flex-end;
      }

      .content {
        padding: 1.5rem;
      }

      .sidebar {
        flex-direction: column;
      }
    }
  </style>
</head>

<body>
  <?php include 'navbar.php'; ?>

  <div class="container">
    <div class="dashboard-header">
      <div class="dashboard-title">
        <div class="dashboard-title-icon">
          <i class="fas fa-pen-to-square"></i>
        </div>
        <h1>Blog Dashboard</h1>
      </div>

      <div class="dashboard-user">
        <?php if (isset($_SESSION['username'])): ?>
          <div class="user-info">
            <div class="user-name"><?php echo htmlspecialchars($_SESSION['username']); ?></div>
            <a href="logout.php" class="logout-btn">
              <i class="fas fa-sign-out-alt"></i>Logout
            </a>
          </div>
          <div class="user-avatar-profile">
            <?php echo strtoupper(substr($_SESSION['username'], 0, 1)); ?>
          </div>
        <?php endif; ?>
      </div>
    </div>

    <div class="dashboard-container">
      <div class="sidebar">
        <a href="addBlogs.php" class="button">
          <i class="fas fa-plus"></i>
          Create New Blog
        </a>

        <a href="dashboard.php" class="sidebar-item active">
          <span class="sidebar-icon">
            <i class="fas fa-list-ul"></i>
          </span>
          My Blogs
        </a>
      </div>

      <div class="content">
        <div class="content-header">
          <h2 class="content-title">My Blogs</h2>
          <div class="post-count"><?php echo $total_posts; ?> posts</div>
        </div>

        <?php
        if (isset($_GET['message'])) {
          if ($_GET['message'] == 'created') {
            echo '<div class="alert alert-success">Blog post created successfully!</div>';
          } elseif ($_GET['message'] == 'updated') {
            echo '<div class="alert alert-success">Blog post updated successfully!</div>';
          }
        }
        ?>

        <?php if (isset($delete_message)): ?>
          <div class="alert <?php echo strpos($delete_message, 'Error') !== false ? 'alert-error' : 'alert-success'; ?>">
            <i class="fas fa-<?php echo strpos($delete_message, 'Error') !== false ? 'exclamation-circle' : 'check-circle'; ?>"></i>
            <?php echo $delete_message; ?>
          </div>
        <?php endif; ?>

        <?php if ($result && $result->num_rows > 0): ?>
          <div class="posts-table-container">
            <table class="posts-table">
              <thead>
                <tr>
                  <th width="40%">Title</th>
                  <th width="20%">Category</th>
                  <th width="20%">Date</th>
                  <th width="20%">Actions</th>
                </tr>
              </thead>
              <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                  <tr>
                    <td>
                      <div class="post-title"><?php echo htmlspecialchars($row['title']); ?></div>
                    </td>
                    <td>
                      <span class="category-badge">
                        <?php echo htmlspecialchars($row['category_name'] ?? 'Uncategorized'); ?>
                      </span>
                    </td>
                    <td>
                      <div class="date-info">
                        <?php echo date('M d, Y', strtotime($row['created_at'])); ?>
                      </div>
                    </td>
                    <td>
                      <div class="action-buttons">
                        <a href="edit-article.php?id=<?php echo $row['article_id']; ?>" class="edit-btn">
                          <i class="fas fa-edit"></i> Edit
                        </a>
                        <a href="dashboard.php?delete=<?php echo $row['article_id']; ?>" class="delete-btn" onclick="return confirm('Are you sure you want to delete this post?')">
                          <i class="fas fa-trash"></i>
                        </a>
                      </div>
                    </td>
                  </tr>
                <?php endwhile; ?>
              </tbody>
            </table>
          </div>
        <?php else: ?>
          <div class="no-posts">
            <div class="no-posts-icon">
              <i class="fas fa-pen-fancy"></i>
            </div>
            <div class="no-posts-message">You haven't created any posts yet</div>
            <div class="no-posts-sub">Share your thoughts and ideas with the world</div>
            <a href="addBlogs.php" class="no-posts-btn">
              <i class="fas fa-plus"></i> Create Your First Post
            </a>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </div>

  <?php include 'footer.php'; ?>
</body>

</html>