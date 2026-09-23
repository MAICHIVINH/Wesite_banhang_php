<?php
require_once __DIR__ . '/../models/AiKnowledgeBase.php';
require_once __DIR__ . '/../models/AiLog.php';

class AiTrainingController
{
    private $knowledgeModel;
    private $logModel;

    public function __construct()
    {
        $this->knowledgeModel = new AiKnowledgeBase();
        $this->logModel = new AiLog();
    }

    public function handlePostRequest()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return;
        }

        $action = $_POST['action'] ?? '';

        if ($action === 'add_knowledge') {
            $keywords = trim($_POST['keywords'] ?? '');
            $category = trim($_POST['intent_category'] ?? 'Chung');
            $question = trim($_POST['question_pattern'] ?? '');
            $answer = trim($_POST['answer_template'] ?? '');
            $priority = (int)($_POST['priority'] ?? 10);

            if (!empty($keywords) && !empty($answer)) {
                $sql = "INSERT INTO ai_knowledge_base (keywords, intent_category, question_pattern, answer_template, priority, status, isDeleted) VALUES (:keywords, :intent_category, :question_pattern, :answer_template, :priority, 1, 0)";
                $stmt = $this->knowledgeModel->getPdo()->prepare($sql);
                $stmt->execute([
                    'keywords' => $keywords,
                    'intent_category' => $category,
                    'question_pattern' => $question,
                    'answer_template' => $answer,
                    'priority' => $priority
                ]);

                // Nếu huấn luyện từ 1 log ID có sẵn
                $logId = (int)($_POST['log_id'] ?? 0);
                if ($logId > 0) {
                    $upSql = "UPDATE ai_chat_logs SET is_resolved = 1 WHERE id = :id";
                    $upStmt = $this->logModel->getPdo()->prepare($upSql);
                    $upStmt->execute(['id' => $logId]);
                }

                $_SESSION['flash_message'] = "Thêm tri thức AI thành công!";
            } else {
                $_SESSION['flash_error'] = "Vui lòng nhập từ khóa và câu trả lời!";
            }
            header("Location: Admin.php?page=modules/Admin/AiTraining/index.php");
            exit;
        }

        if ($action === 'update_knowledge') {
            $id = (int)($_POST['id'] ?? 0);
            $keywords = trim($_POST['keywords'] ?? '');
            $category = trim($_POST['intent_category'] ?? 'Chung');
            $question = trim($_POST['question_pattern'] ?? '');
            $answer = trim($_POST['answer_template'] ?? '');
            $priority = (int)($_POST['priority'] ?? 10);
            $status = (int)($_POST['status'] ?? 1);

            if ($id > 0 && !empty($keywords) && !empty($answer)) {
                $sql = "UPDATE ai_knowledge_base SET keywords = :keywords, intent_category = :intent_category, question_pattern = :question_pattern, answer_template = :answer_template, priority = :priority, status = :status WHERE id = :id";
                $stmt = $this->knowledgeModel->getPdo()->prepare($sql);
                $stmt->execute([
                    'keywords' => $keywords,
                    'intent_category' => $category,
                    'question_pattern' => $question,
                    'answer_template' => $answer,
                    'priority' => $priority,
                    'status' => $status,
                    'id' => $id
                ]);
                $_SESSION['flash_message'] = "Cập nhật tri thức AI thành công!";
            }
            header("Location: Admin.php?page=modules/Admin/AiTraining/index.php");
            exit;
        }

        if ($action === 'delete_knowledge') {
            $id = (int)($_POST['id'] ?? 0);
            if ($id > 0) {
                $sql = "UPDATE ai_knowledge_base SET isDeleted = 1 WHERE id = :id";
                $stmt = $this->knowledgeModel->getPdo()->prepare($sql);
                $stmt->execute(['id' => $id]);
                $_SESSION['flash_message'] = "Đã xóa tri thức AI!";
            }
            header("Location: Admin.php?page=modules/Admin/AiTraining/index.php");
            exit;
        }
    }

    public function getKnowledgeList()
    {
        return $this->knowledgeModel->getAllActive();
    }

    public function getUnresolvedLogs()
    {
        return $this->logModel->getUnresolvedQueries(50);
    }
}
