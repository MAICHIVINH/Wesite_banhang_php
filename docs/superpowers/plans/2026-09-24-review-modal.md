# Modern & Interactive Review Modal Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Redesign the review modal (`<!-- Modal đánh giá -->`) in `CheckOrder.php` into an interactive, modern modal with star micro-animations, emotion labels/emojis, quick tags, character counter, and stylish button components.

**Architecture:** Update HTML structure in `modules/Users/page/CheckOrder.php`, add scoped modern CSS styles, and enhance JavaScript interactivity for rating preview, quick tags, character counter, and form validation.

**Tech Stack:** PHP, HTML5, Bootstrap 5, Bootstrap Icons, Vanilla JavaScript, Vanilla CSS.

## Global Constraints
- Target File: `c:\xampp\htdocs\DevPHP_V2\modules\Users\page\CheckOrder.php`
- Preserve existing form submission parameters (`name="order_id"`, `name="rating"`, `name="comment"`, `name="btnReview"`).
- Maintain compatibility with Bootstrap 5 modal API (`bootstrap.Modal`).

---

### Task 1: Update HTML Structure and Scoped CSS Styles for Review Modal

**Files:**
- Modify: `c:\xampp\htdocs\DevPHP_V2\modules\Users\page\CheckOrder.php:101-112` (CSS styles)
- Modify: `c:\xampp\htdocs\DevPHP_V2\modules\Users\page\CheckOrder.php:372-411` (Modal HTML)

**Interfaces:**
- Consumes: Existing form structure and POST action for `btnReview`.
- Produces: Enhanced HTML elements `#reviewModal`, `#rating-text`, `#rating-emoji`, `#char-count`, `.quick-tag`.

- [ ] **Step 1: Add scoped CSS for review modal in `CheckOrder.php`**

Add CSS rules for star rating animations, hover states, quick tags, gradient header, and character counter within `<style>` tag:

```css
    /* Modern Review Modal Styling */
    #reviewModal .modal-content {
        border: none;
        border-radius: 1rem;
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.1);
        overflow: hidden;
    }

    #reviewModal .modal-header-gradient {
        background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
        color: #ffffff;
        padding: 1.25rem 1.5rem;
    }

    #reviewModal .star-rating-custom .star {
        font-size: 2rem;
        color: #cbd5e1;
        cursor: pointer;
        transition: transform 0.2s ease, color 0.2s ease;
    }

    #reviewModal .star-rating-custom .star:hover,
    #reviewModal .star-rating-custom .star.active,
    #reviewModal .star-rating-custom .star.hovered {
        color: #f59e0b;
    }

    #reviewModal .star-rating-custom .star:hover {
        transform: scale(1.25);
    }

    .quick-tag-chip {
        display: inline-block;
        border: 1px solid #e2e8f0;
        background-color: #f8fafc;
        color: #475569;
        border-radius: 50rem;
        padding: 6px 14px;
        font-size: 0.85rem;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.2s ease;
        user-select: none;
        margin: 3px 2px;
    }

    .quick-tag-chip:hover,
    .quick-tag-chip.selected {
        background-color: #e0e7ff;
        border-color: #6366f1;
        color: #4338ca;
        transform: translateY(-1px);
    }

    #reviewModal .form-control:focus {
        border-color: #6366f1;
        box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.15);
    }

    #reviewModal .btn-submit-review {
        background: linear-gradient(135deg, #4f46e5 0%, #6366f1 100%);
        border: none;
        color: #ffffff;
        transition: all 0.2s ease;
    }

    #reviewModal .btn-submit-review:hover {
        background: linear-gradient(135deg, #4338ca 0%, #4f46e5 100%);
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(79, 70, 229, 0.3);
    }
```

- [ ] **Step 2: Update `<!-- Modal đánh giá -->` HTML markup in `CheckOrder.php`**

Replace lines 372-411 with modern card modal markup:

```html
<!-- Modal đánh giá -->
<div class="modal fade" id="reviewModal" tabindex="-1" aria-labelledby="reviewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form method="post" novalidate id="reviewForm" class="w-100">
            <div class="modal-content">
                <div class="modal-header modal-header-gradient border-0 align-items-center">
                    <div class="d-flex align-items-center gap-2">
                        <span class="badge bg-white text-primary rounded-circle p-2 d-flex align-items-center justify-content-center" style="width: 38px; height: 38px;">
                            <i class="bi bi-star-fill text-warning fs-5"></i>
                        </span>
                        <div>
                            <h5 class="modal-title fw-bold text-white mb-0" id="reviewModalLabel">Đánh giá sản phẩm</h5>
                            <small class="text-white-50">Ý kiến của bạn giúp chúng tôi cải thiện chất lượng dịch vụ</small>
                        </div>
                    </div>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Đóng"></button>
                </div>
                <div class="modal-body p-4 bg-white">
                    <input type="hidden" name="order_id" id="review_order_id">

                    <!-- Star Rating Section -->
                    <div class="text-center mb-4 p-3 bg-light rounded-3 border border-light-subtle">
                        <label class="form-label d-block text-secondary fw-semibold mb-2">Bạn đánh giá trải nghiệm mua hàng như thế nào?</label>
                        <div class="star-rating-custom d-flex justify-content-center gap-2 mb-2">
                            <i class="bi bi-star star" data-value="1"></i>
                            <i class="bi bi-star star" data-value="2"></i>
                            <i class="bi bi-star star" data-value="3"></i>
                            <i class="bi bi-star star" data-value="4"></i>
                            <i class="bi bi-star star" data-value="5"></i>
                        </div>
                        <div class="d-flex align-items-center justify-content-center gap-2">
                            <span id="rating-emoji" class="fs-4">🌟</span>
                            <span id="rating-text" class="fw-bold text-primary">Vui lòng chọn số sao</span>
                        </div>
                        <input type="hidden" name="rating" id="rating" required>
                    </div>

                    <!-- Quick Suggestion Tags -->
                    <div class="mb-3">
                        <label class="form-label text-secondary fw-semibold mb-2 fs-7">Gợi ý đánh giá nhanh:</label>
                        <div class="d-flex flex-wrap gap-1" id="quickTagsContainer">
                            <span class="quick-tag-chip" data-tag="Giao hàng nhanh 🚚">Giao hàng nhanh 🚚</span>
                            <span class="quick-tag-chip" data-tag="Đóng gói cẩn thận 🎁">Đóng gói cẩn thận 🎁</span>
                            <span class="quick-tag-chip" data-tag="Sản phẩm chất lượng ⭐">Sản phẩm chất lượng ⭐</span>
                            <span class="quick-tag-chip" data-tag="Tư vấn nhiệt tình 💬">Tư vấn nhiệt tình 💬</span>
                            <span class="quick-tag-chip" data-tag="Giá cả hợp lý 💰">Giá cả hợp lý 💰</span>
                        </div>
                    </div>

                    <!-- Comment Textarea -->
                    <div class="mb-2">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <label for="comment" class="form-label text-secondary fw-semibold mb-0">Nhận xét chi tiết:</label>
                            <small class="text-muted"><span id="char-count">0</span>/500 ký tự</small>
                        </div>
                        <textarea class="form-control rounded-3 p-3" id="comment" name="comment" rows="4" maxlength="500" placeholder="Hãy chia sẻ trải nghiệm về sản phẩm, đóng gói và thái độ giao hàng..." required></textarea>
                    </div>
                </div>
                <div class="modal-footer bg-light border-0 px-4 py-3">
                    <button type="button" class="btn btn-light border px-4 py-2 rounded-3 text-secondary fw-semibold" data-bs-dismiss="modal">Hủy</button>
                    <button type="submit" class="btn btn-submit-review px-4 py-2 rounded-3 fw-semibold shadow-sm" name="btnReview" id="btnSubmitReview">
                        <i class="bi bi-send-fill me-2"></i>Gửi đánh giá
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
```

---

### Task 2: Implement JavaScript Logic for Star Hover, Quick Tags, Counter & Validation

**Files:**
- Modify: `c:\xampp\htdocs\DevPHP_V2\modules\Users\page\CheckOrder.php:413-465` (JavaScript block)

**Interfaces:**
- Handles DOM events for `.star`, `.quick-tag-chip`, `#comment`, and `#reviewForm`.

- [ ] **Step 1: Replace star rating and modal script logic in `CheckOrder.php`**

Update JavaScript block to handle:
1. Dynamic emoji and text update based on star selection (1: 😞 Rất không hài lòng, 2: 🙁 Không hài lòng, 3: 😐 Bình thường, 4: 🙂 Hài lòng, 5: 😍 Tuyệt vời!).
2. Hover preview effect on stars.
3. Quick tag chip click to toggle text in comment box.
4. Character count indicator for textarea.
5. Form validation to ensure rating star is selected before submit.

```javascript
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const cancelButtons = document.querySelectorAll(".cancel-btn");
        const cancelInput = document.getElementById("cancel_order_id");
        const reviewButtons = document.querySelectorAll(".open-review-modal");
        const orderIdInput = document.getElementById("review_order_id");
        const stars = document.querySelectorAll("#reviewModal .star");
        const ratingInput = document.getElementById("rating");
        const ratingText = document.getElementById("rating-text");
        const ratingEmoji = document.getElementById("rating-emoji");
        const commentTextarea = document.getElementById("comment");
        const charCount = document.getElementById("char-count");
        const quickTags = document.querySelectorAll(".quick-tag-chip");
        const reviewForm = document.getElementById("reviewForm");

        const ratingLabels = {
            1: { text: "Rất không hài lòng", emoji: "😞", color: "text-danger" },
            2: { text: "Không hài lòng", emoji: "🙁", color: "text-warning" },
            3: { text: "Bình thường", emoji: "😐", color: "text-info" },
            4: { text: "Hài lòng", emoji: "🙂", color: "text-primary" },
            5: { text: "Tuyệt vời!", emoji: "😍", color: "text-success" }
        };

        cancelButtons.forEach(button => {
            button.addEventListener("click", function() {
                const orderId = this.getAttribute("data-order-id");
                if (cancelInput) cancelInput.value = orderId;
            });
        });

        reviewButtons.forEach(button => {
            button.addEventListener("click", function() {
                const orderId = this.getAttribute("data-order-id");
                if (orderIdInput) orderIdInput.value = orderId;
                
                // Reset form state when modal opens
                ratingInput.value = "";
                if (commentTextarea) commentTextarea.value = "";
                if (charCount) charCount.textContent = "0";
                if (ratingText) {
                    ratingText.textContent = "Vui lòng chọn số sao";
                    ratingText.className = "fw-bold text-secondary";
                }
                if (ratingEmoji) ratingEmoji.textContent = "🌟";
                
                stars.forEach(s => {
                    s.classList.remove("active", "hovered");
                    s.classList.replace("bi-star-fill", "bi-star");
                });

                quickTags.forEach(tag => tag.classList.remove("selected"));
            });
        });

        function updateStarDisplay(value, isHover = false) {
            stars.forEach((s, i) => {
                const starVal = i + 1;
                if (starVal <= value) {
                    if (isHover) {
                        s.classList.add("hovered");
                    } else {
                        s.classList.add("active");
                    }
                    s.classList.replace("bi-star", "bi-star-fill");
                } else {
                    s.classList.remove("active", "hovered");
                    s.classList.replace("bi-star-fill", "bi-star");
                }
            });

            if (value in ratingLabels) {
                ratingText.textContent = ratingLabels[value].text;
                ratingText.className = `fw-bold ${ratingLabels[value].color}`;
                ratingEmoji.textContent = ratingLabels[value].emoji;
            }
        }

        stars.forEach(star => {
            star.addEventListener("mouseenter", function() {
                const val = parseInt(this.getAttribute("data-value"));
                updateStarDisplay(val, true);
            });

            star.addEventListener("mouseleave", function() {
                const currentVal = parseInt(ratingInput.value) || 0;
                if (currentVal > 0) {
                    updateStarDisplay(currentVal, false);
                } else {
                    stars.forEach(s => {
                        s.classList.remove("active", "hovered");
                        s.classList.replace("bi-star-fill", "bi-star");
                    });
                    ratingText.textContent = "Vui lòng chọn số sao";
                    ratingText.className = "fw-bold text-secondary";
                    ratingEmoji.textContent = "🌟";
                }
            });

            star.addEventListener("click", function() {
                const val = parseInt(this.getAttribute("data-value"));
                ratingInput.value = val;
                updateStarDisplay(val, false);
            });
        });

        // Quick Tag Chip Toggle Logic
        quickTags.forEach(chip => {
            chip.addEventListener("click", function() {
                const tagText = this.getAttribute("data-tag");
                this.classList.toggle("selected");
                
                let currentVal = commentTextarea.value.trim();
                if (this.classList.contains("selected")) {
                    if (currentVal.length > 0) {
                        commentTextarea.value = currentVal + ". " + tagText;
                    } else {
                        commentTextarea.value = tagText;
                    }
                } else {
                    // Remove tag text if unselected
                    commentTextarea.value = currentVal.replace(tagText, "").replace(/\.\s*\./g, ".").trim();
                }

                // Update character counter
                commentTextarea.dispatchEvent(new Event("input"));
            });
        });

        // Character counter logic
        if (commentTextarea && charCount) {
            commentTextarea.addEventListener("input", function() {
                charCount.textContent = this.value.length;
            });
        }

        // Form submit validation
        if (reviewForm) {
            reviewForm.addEventListener("submit", function(e) {
                if (!ratingInput.value || ratingInput.value === "") {
                    e.preventDefault();
                    Swal.fire({
                        icon: 'warning',
                        title: 'Chưa chọn số sao',
                        text: 'Vui lòng chọn đánh giá từ 1 đến 5 sao trước khi gửi!',
                        confirmColor: '#4f46e5'
                    });
                    return false;
                }
            });
        }

        // Cancel order reason change handler
        const reasonSelect = document.getElementById('reasonSelect');
        if (reasonSelect) {
            reasonSelect.addEventListener('change', function() {
                if (this.value === 'Khác') {
                    const orderId = document.getElementById('cancel_order_id').value;
                    const cancelModalInstance = bootstrap.Modal.getInstance(document.getElementById('cancelModal'));
                    if (cancelModalInstance) cancelModalInstance.hide();

                    document.getElementById('custom_order_id').value = orderId;
                    const customModal = new bootstrap.Modal(document.getElementById('customReasonModal'));
                    customModal.show();
                }
            });
        }
    });
</script>
```

---

### Task 3: Verification

- Verify code syntax in `CheckOrder.php`.
- Check that form handles rating POST submission cleanly.
