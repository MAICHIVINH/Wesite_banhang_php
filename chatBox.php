<?php
require 'vendor/autoload.php';

use GuzzleHttp\Client;
// use Parsedown;

$isChatOpenAi = $_SESSION['chat_open_ai'] ?? false;

if (isset($_GET['closeChatAi'])) {
    unset($_SESSION['chat_open_ai']);
    exit;
}

if (isset($_GET['newChatAi'])) {
    $_SESSION['chat_history'] = [];
    $_SESSION['chat_open_ai'] = true;
    header('Content-Type: application/json');
    echo json_encode(['status' => 'success']);
    exit;
}





if (!isset($_SESSION['chat_history'])) {
    $_SESSION['chat_history'] = [];
}


require_once __DIR__ . '/controllers/GeminiService.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ai_message'])) {
    $message = trim($_POST['ai_message']);

    if (mb_strlen($message) > 500) {
        swal_alert('error', 'Lỗi gửi tin nhắn', 'Bạn không được gửi quá 500 ký tự', "index.php");
    } else {
        $geminiService = new GeminiService();
        $aiChatResponse = $geminiService->ask($message);

        $timestamp = date('H:i d/m/Y');
        $_SESSION['chat_history'][] = [
            'user_message' => $message,
            'ai_response' => $aiChatResponse,
            'timestamp' => $timestamp
        ];
        $_SESSION['chat_open_ai'] = true;
        echo '<meta http-equiv="refresh" content="0">';
    }
} else {
    $aiChatResponse = '';
}
?>


<div id="ai-chat-form" class="chat-box <?= $isChatOpenAi ? '' : 'hidden' ?>">
    <div class="p-2 bg-primary text-white d-flex justify-content-between align-items-center"
        style="border-radius: 8px 8px 0 0;">
        <!-- Bên trái: Avatar + Tiêu đề -->
        <div class="d-flex align-items-center">
            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQO42z2p6t2s8Sv8gkV_R1aMeIyfmIQR_ss7w&s"
                alt="AI Avatar" class="rounded-circle me-2" style="width: 36px; height: 36px; object-fit: cover;">
            <p class="m-0 fw-bold">Hỗ trợ AI</p>
        </div>

        <!-- Bên phải: Nút Chat mới + Nút đóng -->
        <div class="d-flex align-items-center gap-2">
            <button type="button" id="ai-chat-new" class="btn btn-sm btn-light text-primary d-flex align-items-center gap-1" style="font-size: 12px; padding: 2px 8px; border-radius: 12px;" title="Tạo cuộc trò chuyện mới">
                <i class="bi bi-plus-lg"></i> Chat mới
            </button>
            <i id="ai-chat-close" class="bi bi-x-lg" style="cursor: pointer;" title="Đóng"></i>
        </div>
    </div>
    <div id="ai-chat-content" class="p-2"
        style="background: #f8f9fa; min-height: 399px; max-height: 399px; overflow-y: auto;">
        <?php if (empty($_SESSION['chat_history'])): ?>
            <div class="text-center text-muted" style="margin-top: 150px;">
                <i class="bi bi-chat-dots fs-1"></i>
                <p class="mt-2">Chưa có tin nhắn</p>
            </div>
        <?php else: ?>

            <?php foreach ($_SESSION['chat_history'] as $i => $chat) {
                $isLast = $i === array_key_last($_SESSION['chat_history']);
                ?>
                <div class="d-flex justify-content-end mb-2 flex-column align-items-end">
                    <div class="p-2 bg-primary text-white border rounded" style="max-width: 80%; word-break: break-word; text-align: left;">
                        <?= htmlspecialchars($chat['user_message']) ?>
                    </div>
                    <div class="small text-muted mt-1"><?= $chat['timestamp'] ?></div>
                </div>

                <div class="d-flex align-items-start mb-2 flex-column">
                    <div class="d-flex" style="max-width: 80%;">
                        <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQO42z2p6t2s8Sv8gkV_R1aMeIyfmIQR_ss7w&s"
                            class="rounded-circle me-2" style="width: 30px; height: 30px;">
                        <div class="p-2 bg-light border rounded ai-response-text <?= $isLast ? 'new' : '' ?>">
                            <?php
                            $Parsedown = new Parsedown();
                            $htmlFormatted = $Parsedown->text($chat['ai_response']);
                            echo $htmlFormatted ?>
                        </div>
                    </div>
                    <div class="small text-muted mt-1" style="margin-left: 40px;"><?= $chat['timestamp'] ?></div>
                </div>
            <?php } ?>
        <?php endif; ?>

    </div>
    <form method="POST" class="border-top d-flex align-items-center">
        <input type="text" class="form-control me-2" style="border: none; box-shadow: none; outline: none;"
            name="ai_message" placeholder="Nhập tin nhắn..." required>
        <button type="submit" class="btn"><i class="bi bi-send-fill text-green fs-4"></i>
        </button>
    </form>
</div>


<script>
    document.addEventListener("DOMContentLoaded", function () {
        const closeBtn = document.getElementById("ai-chat-close");
        if (closeBtn) {
            closeBtn.addEventListener("click", () => {
                fetch("?closeChatAi=1").then(() => {
                    document.getElementById("ai-chat-form").classList.add("hidden");
                });
            });
        }

        const newChatBtn = document.getElementById("ai-chat-new");
        if (newChatBtn) {
            newChatBtn.addEventListener("click", () => {
                fetch("?newChatAi=1").then(() => {
                    const content = document.getElementById("ai-chat-content");
                    if (content) {
                        content.innerHTML = `
                            <div class="text-center text-muted" style="margin-top: 150px;">
                                <i class="bi bi-chat-dots fs-1"></i>
                                <p class="mt-2">Chưa có tin nhắn</p>
                            </div>
                        `;
                    }
                });
            });
        }


        const content = document.getElementById("ai-chat-content");
        if (content) {
            content.scrollTop = content.scrollHeight;
        }
    });
</script>