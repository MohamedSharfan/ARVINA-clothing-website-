<?php


session_start();


if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: admin_login.php');
    exit;
}

require_once '../php/db_connect.php';

$conn = getDBConnection();


if (isset($_GET['action']) && isset($_GET['id'])) {
    $messageId = intval($_GET['id']);
    $action = $_GET['action'];
    
    if ($action === 'mark_read') {
        $stmt = $conn->prepare("UPDATE contact_messages SET status = 'read' WHERE message_id = ?");
        $stmt->bind_param("i", $messageId);
        $stmt->execute();
        $stmt->close();
        header('Location: admin_messages.php?updated=1');
        exit;
    } elseif ($action === 'mark_replied') {
        $stmt = $conn->prepare("UPDATE contact_messages SET status = 'replied' WHERE message_id = ?");
        $stmt->bind_param("i", $messageId);
        $stmt->execute();
        $stmt->close();
        header('Location: admin_messages.php?updated=1');
        exit;
    } elseif ($action === 'delete') {
        $stmt = $conn->prepare("DELETE FROM contact_messages WHERE message_id = ?");
        $stmt->bind_param("i", $messageId);
        $stmt->execute();
        $stmt->close();
        header('Location: admin_messages.php?deleted=1');
        exit;
    }
}


$statusFilter = isset($_GET['status']) ? $_GET['status'] : 'all';


$query = "SELECT * FROM contact_messages";
if ($statusFilter !== 'all') {
    $query .= " WHERE status = '" . $conn->real_escape_string($statusFilter) . "'";
}
$query .= " ORDER BY created_at DESC";

$result = $conn->query($query);


$newCount = $conn->query("SELECT COUNT(*) as count FROM contact_messages WHERE status = 'new'")->fetch_assoc()['count'];
$readCount = $conn->query("SELECT COUNT(*) as count FROM contact_messages WHERE status = 'read'")->fetch_assoc()['count'];
$repliedCount = $conn->query("SELECT COUNT(*) as count FROM contact_messages WHERE status = 'replied'")->fetch_assoc()['count'];
$totalCount = $conn->query("SELECT COUNT(*) as count FROM contact_messages")->fetch_assoc()['count'];

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="../css/admin.css">
    <title>Contact Messages - Admin Panel</title>
    <style>
        .filter-tabs {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }
        
        .filter-tab {
            padding: 10px 20px;
            background: #f0f0f0;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            color: #333;
            font-size: 14px;
            transition: all 0.3s;
        }
        
        .filter-tab:hover {
            background: #e0e0e0;
        }
        
        .filter-tab.active {
            background: #3498db;
            color: white;
        }
        
        .filter-tab .badge {
            background: rgba(255, 255, 255, 0.3);
            padding: 2px 8px;
            border-radius: 10px;
            margin-left: 5px;
            font-size: 12px;
        }
        
        .messages-table {
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .messages-table table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .messages-table th {
            background: #2c3e50;
            color: white;
            padding: 15px;
            text-align: left;
            font-weight: 600;
        }
        
        .messages-table td {
            padding: 15px;
            border-bottom: 1px solid #eee;
        }
        
        .messages-table tr:hover {
            background: #f9f9f9;
        }
        
        .status-badge {
            display: inline-block;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }
        
        .status-new {
            background: #e74c3c;
            color: white;
        }
        
        .status-read {
            background: #f39c12;
            color: white;
        }
        
        .status-replied {
            background: #27ae60;
            color: white;
        }
        
        .message-actions {
            display: flex;
            gap: 5px;
        }
        
        .action-icon {
            padding: 8px 12px;
            border-radius: 5px;
            text-decoration: none;
            font-size: 14px;
            transition: all 0.3s;
            cursor: pointer;
            border: none;
            background: none;
        }
        
        .action-icon:hover {
            transform: translateY(-2px);
        }
        
        .action-view {
            color: #3498db;
        }
        
        .action-view:hover {
            background: #ecf0f1;
        }
        
        .action-check {
            color: #27ae60;
        }
        
        .action-check:hover {
            background: #d5f4e6;
        }
        
        .action-delete {
            color: #e74c3c;
        }
        
        .action-delete:hover {
            background: #fadbd8;
        }
        
        .no-messages {
            text-align: center;
            padding: 40px;
            color: #999;
        }
        
        .message-preview {
            max-width: 300px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        
        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        
        .alert-danger {
            background: #f8d7da;
            color: #721c24;
            border-color: #f5c6cb;
        }
    </style>
</head>
<body class="admin-page">
    <div class="admin-container">
        <aside class="sidebar">
            <div class="sidebar-header">
                <h2>ARVINA</h2>
                <p>Admin Panel</p>
            </div>
            <nav class="sidebar-nav">
                <a href="admin_dashboard.php" class="nav-item">
                    <i class="fa-solid fa-gauge"></i> Dashboard
                </a>
                <a href="admin_products.php" class="nav-item">
                    <i class="fa-solid fa-shirt"></i> Products
                </a>
                <a href="admin_orders.php" class="nav-item">
                    <i class="fa-solid fa-shopping-bag"></i> Orders
                </a>
                <a href="admin_messages.php" class="nav-item active">
                    <i class="fa-solid fa-envelope"></i> Messages
                    <?php if ($newCount > 0): ?>
                        <span style="background: #e74c3c; color: white; padding: 2px 8px; border-radius: 10px; margin-left: 5px; font-size: 11px;"><?php echo $newCount; ?></span>
                    <?php endif; ?>
                </a>
                <a href="admin_logout.php" class="nav-item logout">
                    <i class="fa-solid fa-right-from-bracket"></i> Logout
                </a>
            </nav>
        </aside>
        
        <main class="main-content">
            <header class="admin-header">
                <h1><i class="fa-solid fa-envelope"></i> Contact Messages</h1>
                <div class="admin-user">
                    <i class="fa-solid fa-user-circle"></i>
                    <span>Welcome, <?php echo htmlspecialchars($_SESSION['admin_username']); ?></span>
                </div>
            </header>
            
            <?php if (isset($_GET['updated'])): ?>
                <div class="alert">Message status updated successfully!</div>
            <?php endif; ?>
            
            <?php if (isset($_GET['deleted'])): ?>
                <div class="alert alert-danger">Message deleted successfully!</div>
            <?php endif; ?>
            
            <div class="filter-tabs">
                <a href="admin_messages.php?status=all" class="filter-tab <?php echo $statusFilter === 'all' ? 'active' : ''; ?>">
                    All Messages <span class="badge"><?php echo $totalCount; ?></span>
                </a>
                <a href="admin_messages.php?status=new" class="filter-tab <?php echo $statusFilter === 'new' ? 'active' : ''; ?>">
                    New <span class="badge"><?php echo $newCount; ?></span>
                </a>
                <a href="admin_messages.php?status=read" class="filter-tab <?php echo $statusFilter === 'read' ? 'active' : ''; ?>">
                    Read <span class="badge"><?php echo $readCount; ?></span>
                </a>
                <a href="admin_messages.php?status=replied" class="filter-tab <?php echo $statusFilter === 'replied' ? 'active' : ''; ?>">
                    Replied <span class="badge"><?php echo $repliedCount; ?></span>
                </a>
            </div>
            
            <div class="messages-table">
                <?php if ($result->num_rows > 0): ?>
                    <table>
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Subject</th>
                                <th>Message</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while($message = $result->fetch_assoc()): ?>
                                <tr>
                                    <td><?php echo date('M d, Y H:i', strtotime($message['created_at'])); ?></td>
                                    <td><strong><?php echo htmlspecialchars($message['name']); ?></strong></td>
                                    <td><?php echo htmlspecialchars($message['email']); ?></td>
                                    <td><?php echo htmlspecialchars($message['phone'] ?? 'N/A'); ?></td>
                                    <td><?php echo htmlspecialchars($message['subject']); ?></td>
                                    <td>
                                        <div class="message-preview" title="<?php echo htmlspecialchars($message['message']); ?>">
                                            <?php echo htmlspecialchars($message['message']); ?>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="status-badge status-<?php echo $message['status']; ?>">
                                            <?php echo ucfirst($message['status']); ?>
                                        </span>
                                    </td>
                                    <td>
                                        <div class="message-actions">
                                            <a href="admin_message_view.php?id=<?php echo $message['message_id']; ?>" 
                                               class="action-icon action-view" 
                                               title="View Full Message">
                                                <i class="fa-solid fa-eye"></i>
                                            </a>
                                            <?php if ($message['status'] !== 'replied'): ?>
                                                <a href="admin_messages.php?action=mark_replied&id=<?php echo $message['message_id']; ?>" 
                                                   class="action-icon action-check" 
                                                   title="Mark as Replied"
                                                   onclick="return confirm('Mark this message as replied?')">
                                                    <i class="fa-solid fa-check"></i>
                                                </a>
                                            <?php endif; ?>
                                            <a href="admin_messages.php?action=delete&id=<?php echo $message['message_id']; ?>" 
                                               class="action-icon action-delete" 
                                               title="Delete Message"
                                               onclick="return confirm('Are you sure you want to delete this message?')">
                                                <i class="fa-solid fa-trash"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <div class="no-messages">
                        <i class="fa-solid fa-inbox" style="font-size: 48px; color: #ddd; margin-bottom: 10px;"></i>
                        <p>No messages found</p>
                    </div>
                <?php endif; ?>
            </div>
        </main>
    </div>
</body>
</html>
<?php
closeDBConnection($conn);
?>
