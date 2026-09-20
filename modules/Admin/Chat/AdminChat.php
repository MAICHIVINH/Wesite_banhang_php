<?php
if (!isset($chatController) || !isset($userController)) return;

$userId = $_GET['chat_user_id'] ?? $_POST['userId'] ?? $userId ?? null;

// Endpoint AJAX lấy tin nhắn của user chọn
if (isset($_GET['ajax_get_admin_chat']) && $userId) {
    header('Content-Type: application/json');
    $messages = $chatController->getChatHistory($userId);
    echo json_encode($messages);
    exit;
}

// Endpoint AJAX gửi tin nhắn từ Admin tới user
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ajax_send_admin_chat']) && $userId) {
    header('Content-Type: application/json');
    $msg = trim($_POST['message'] ?? '');
    if ($msg !== '') {
        $chatController->sendMessage($userId, ['sender_id' => 1, 'sender_role' => 'admin'], $msg);
        echo json_encode(['success' => true, 'time' => date('H:i d/m/Y')]);
    } else {
        echo json_encode(['success' => false]);
    }
    exit;
}

// Fallback PHP POST nếu không bật JS
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['message'], $_POST['userId']) && !isset($_POST['ajax_send_admin_chat'])) {
    $msg = trim($_POST['message']);
    $toUser = (int)$_POST['userId'];
    if ($msg !== '') {
        $chatController->sendMessage($toUser, ['sender_id' => 1, 'sender_role' => 'admin'], $msg);
        echo "<script>window.location.href = '?chat_user_id=$toUser';</script>";
    }
}

$messages = $userId ? $chatController->getChatHistory($userId) : [];
$clientInfo = $userId ? $userController->getById($userId) : null;
$clientName = $clientInfo['FullName'] ?? "Không có tên";
?>

<!-- Form tin nhắn khi đã chọn người dùng -->

<?php if ($userId) { ?>
    <div id="chat-form" class="chat-box-admin">
        <div class="p-2 bg-success text-white d-flex justify-content-between align-items-center" style="border-radius: 8px 8px 0 0;">
            <p class="m-0">Chat với khách hàng <?= htmlspecialchars($clientName) ?></p>
            <a href="Admin.php" class="text-white"><i class="bi bi-x-lg"></i></a>
        </div>

        <div id="chat-content-admin" class="p-2 overflow-auto flex-grow-1" style="background: #f8f9fa;">
            <?php foreach ($messages as $msg) { ?>
                <?php if ($msg->from === 'user') { ?>
                    <div class="d-flex align-items-start mb-2" style="margin-right: 100px;">
                        <img src="https://tse4.mm.bing.net/th?id=OIP.kQyrx9VbuWXWxCVxoreXOgHaHN&pid=Api&P=0&h=220"
                            class="rounded-circle me-2" style="width: 30px; height: 30px;">
                        <div>
                            <strong><?= htmlspecialchars($clientName) ?></strong>
                            <div class="p-2 bg-light border rounded"><?= htmlspecialchars($msg->message) ?></div>
                            <div class="small text-muted"><?= htmlspecialchars($msg->time ?? '') ?></div>
                        </div>
                    </div>
                <?php } else { ?>
                    <div class="d-flex justify-content-end mb-2" style="margin-left: 100px;">
                        <div>
                            <div class="p-2 bg-success text-white rounded"><?= htmlspecialchars($msg->message) ?></div>
                            <div class="small text-muted text-end"><?= htmlspecialchars($msg->time ?? '') ?></div>
                        </div>
                    </div>
                <?php } ?>
            <?php } ?>
        </div>

        <form id="admin-chat-input-form" method="POST" class="p-2 border-top d-flex align-items-center">
            <input type="hidden" id="admin-chat-user-id" name="userId" value="<?= $userId ?>">
            <input type="text" id="admin-chat-input" name="message" class="form-control me-2" style="border: none; box-shadow: none; outline: none;" placeholder="Nhập tin nhắn..." required autocomplete="off">
            <button type="submit" class="btn">
                <i class="bi bi-send-fill text-success fs-4"></i>
            </button>
        </form>
    </div>
<?php } ?>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const chatContent = document.getElementById('chat-content-admin');
        const adminForm = document.getElementById('admin-chat-input-form');
        const adminInput = document.getElementById('admin-chat-input');
        const targetUserId = "<?= $userId ?>";

        function scrollChatToBottom() {
            if (chatContent) {
                chatContent.scrollTop = chatContent.scrollHeight;
            }
        }

        scrollChatToBottom();

        if (adminForm && targetUserId) {
            // 1. Gửi tin nhắn bằng AJAX (Không bị reload trang Admin.php)
            adminForm.addEventListener('submit', function(e) {
                e.preventDefault();
                const msgText = adminInput.value.trim();
                if (!msgText) return;

                const formData = new FormData();
                formData.append('ajax_send_admin_chat', '1');
                formData.append('userId', targetUserId);
                formData.append('message', msgText);

                fetch('Admin.php', {
                    method: 'POST',
                    body: formData
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        adminInput.value = '';
                        fetchAdminMessages();
                    }
                })
                .catch(err => console.error('Send admin error:', err));
            });

            // 2. Tự động lấy tin nhắn mới (Polling 2s)
            function fetchAdminMessages() {
                fetch('Admin.php?ajax_get_admin_chat=1&chat_user_id=' + targetUserId)
                .then(res => res.json())
                .then(messages => {
                    if (!Array.isArray(messages)) return;
                    const clientName = "<?= addslashes(htmlspecialchars($clientName)) ?>";
                    let html = '';
                    messages.forEach(msg => {
                        if (msg.from === 'user') {
                            html += `
                                <div class="d-flex align-items-start mb-2" style="margin-right: 100px;">
                                    <img src="https://tse4.mm.bing.net/th?id=OIP.kQyrx9VbuWXWxCVxoreXOgHaHN&pid=Api&P=0&h=220"
                                        class="rounded-circle me-2" style="width: 30px; height: 30px;">
                                    <div>
                                        <strong>${clientName}</strong>
                                        <div class="p-2 bg-light border rounded">${escapeHtml(msg.message)}</div>
                                        <div class="small text-muted">${msg.time || ''}</div>
                                    </div>
                                </div>
                            `;
                        } else {
                            html += `
                                <div class="d-flex justify-content-end mb-2" style="margin-left: 100px;">
                                    <div>
                                        <div class="p-2 bg-success text-white rounded">${escapeHtml(msg.message)}</div>
                                        <div class="small text-muted text-end">${msg.time || ''}</div>
                                    </div>
                                </div>
                            `;
                        }
                    });
                    chatContent.innerHTML = html;
                    scrollChatToBottom();
                })
                .catch(err => console.error('Fetch admin chat error:', err));
            }

            function escapeHtml(text) {
                const div = document.createElement('div');
                div.textContent = text;
                return div.innerHTML;
            }

            // Polling 2s/lần
            setInterval(fetchAdminMessages, 2000);
        }
    });
</script>