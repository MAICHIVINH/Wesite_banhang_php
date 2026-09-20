<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['remove_customer_report'])) {
    $userId = $_POST['remove_report_id'] ?? null;

    if ($userId) {
        $result = $userReportController->delete($userId);

        if ($result['success']) {
            $_SESSION['success'] = $result['message'];
        } else {
            $_SESSION['error'] = $result['message'];
        }

        echo "<script>window.location.href = 'Admin.php?page=modules/Admin/Customers/Customer.php';</script>";
        exit;
    }
}


?>




<div class="modal fade" id="deleteCustomerReportModal" tabindex="-1" aria-labelledby="deleteCustomerReportModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form method="POST">
                <input type="hidden" name="remove_report_id" id="removeReportCustomerId">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="deleteCustomerReportModalLabel"><i class="fas fa-exclamation-triangle"></i> Gỡ báo cáo khách hàng</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
                </div>
                <div class="modal-body">
                    Bạn có chắc chắn muốn <strong>gỡ báo cáo</strong> cho khách hàng <span id="removeReportCustomerName" class="fw-bold text-danger"></span> không?
                </div>
                <div class="modal-footer">
                    <button type="submit" name="remove_customer_report" class="btn btn-danger">Gỡ báo cáo</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const deleteReportButtons = document.querySelectorAll(".btn-delete-customer");

        deleteReportButtons.forEach(button => {
            button.addEventListener("click", function() {
                const id = this.getAttribute("data-id");
                const name = this.getAttribute("data-name");

                document.getElementById("removeReportCustomerId").value = id;
                document.getElementById("removeReportCustomerName").textContent = name;
            });
        });
    });
</script>