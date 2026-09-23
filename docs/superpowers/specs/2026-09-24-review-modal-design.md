# Design Spec: Modern & Interactive Review Modal for CheckOrder.php

## 1. Overview
Redesign the review modal (`<!-- Modal đánh giá -->`) in `modules/Users/page/CheckOrder.php` into a modern, interactive, user-friendly component with star hover micro-animations, emotion labels/emojis, quick suggestion tags, character counter, and stylish button components.

## 2. Component Structure (HTML)
- **Modal Container**: `#reviewModal` with `modal-dialog-centered` and `modal-md`.
- **Header**: Gradient header banner with icon badge (`bi-star-fill`), title "Đánh giá sản phẩm", and clean close button.
- **Body**:
  - Hidden inputs: `order_id` (`#review_order_id`) and `rating` (`#rating`).
  - **Star Rating Section**:
    - 5 Star buttons (`data-value="1..5"`) with large size (`2rem`) and smooth transition.
    - Rating feedback label (`#rating-text`) & Emoji display (`#rating-emoji`):
      - 1 Star: 😞 *Rất không hài lòng*
      - 2 Stars: 🙁 *Không hài lòng*
      - 3 Stars: 😐 *Bình thường*
      - 4 Stars: 🙂 *Hài lòng*
      - 5 Stars: 😍 *Tuyệt vời!*
  - **Quick Tags Section**:
    - Chip buttons: `🚚 Giao hàng nhanh`, `🎁 Đóng gói cẩn thận`, `⭐ Sản phẩm chất lượng`, `💬 Tư vấn nhiệt tình`, `💰 Giá hợp lý`.
    - Clicking a tag inserts/appends tag text directly into comment textarea.
  - **Comment Textarea**:
    - Modern styled textarea (`#comment`) with custom border and shadow focus.
    - Live character counter (`0/500 ký tự`).
- **Footer**:
  - Cancel button (`btn-light rounded-3`).
  - Submit button (`btn-primary rounded-3` with `bi-send-fill` icon and hover lift effect).

## 3. Styling & Micro-Interactions (CSS)
- Custom CSS classes added to `CheckOrder.php` or `CheckOrder.css`:
  - Hover scaling on star buttons (`transform: scale(1.25)`).
  - Selected state glowing star color (`#ffb800`).
  - Tag pill style with smooth hover color change (`background: #e0e7ff`, `color: #4338ca`).
  - Focus glow for input controls (`box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.15)`).

## 4. JavaScript Logic
- **Star Hover & Click**:
  - `mouseenter`: Preview filled stars up to hovered value + preview rating label.
  - `mouseleave`: Revert to currently selected star value.
  - `click`: Permanently set rating value, lock selected stars, update text & emoji.
- **Quick Tag Click**:
  - Toggle active state for tag.
  - Append/remove tag text from textarea and trigger character count update.
- **Character Counter**:
  - Update `#char-count` on `input` event on `#comment` textarea.
- **Form Submission Check**:
  - Prevent submit if rating is missing and display user-friendly prompt.

## 5. Verification Plan
- Test clicking 1 to 5 stars and check label & emoji updates.
- Test hover behavior on stars.
- Test quick tag toggles and text insertion.
- Test textarea character counter limit.
- Test submitting review with valid rating & comment.
