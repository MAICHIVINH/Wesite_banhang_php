<div class="bg-white shadow-sm p-3 h-100 rounded border"
    style="position: sticky; top: 70px; z-index: 1029; min-width: 320px; background-color: #fff;">

    <h5 class="fw-bold mb-3 text-danger">
        <i class="bi bi-filter-circle me-2"></i> Lọc theo giá
    </h5>

    <form method="get" id="filterForm">
        <input type="hidden" name="subpage" value="modules/Users/Layout/Main.php">
        <?php if (!empty($id_category)) { ?>
            <input type="hidden" name="category" value="<?= htmlspecialchars($id_category) ?>">
        <?php } ?>
        <?php if (!empty($id_supplier)) { ?>
            <input type="hidden" name="supplier" value="<?= htmlspecialchars($id_supplier) ?>">
        <?php } ?>
        <?php if (!empty($keyword)) { ?>
            <input type="hidden" name="search" value="<?= htmlspecialchars($keyword) ?>">
        <?php } ?>
        <div class="form-check mb-2">
            <input class="form-check-input" type="checkbox" name="price[]" value="1"
                id="price1" <?= in_array(1, $_GET['price'] ?? []) ? 'checked' : '' ?>>
            <label class="form-check-label" for="price1">Dưới 5 triệu</label>
        </div>
        <div class="form-check mb-2">
            <input class="form-check-input" type="checkbox" name="price[]" value="2"
                id="price2" <?= in_array(2, $_GET['price'] ?? []) ? 'checked' : '' ?>>
            <label class="form-check-label" for="price2">Từ 5 - 10 triệu</label>
        </div>
        <div class="form-check mb-2">
            <input class="form-check-input" type="checkbox" name="price[]" value="3"
                id="price3" <?= in_array(3, $_GET['price'] ?? []) ? 'checked' : '' ?>>
            <label class="form-check-label" for="price3">Từ 10 - 20 triệu</label>
        </div>
        <div class="form-check mb-3">
            <input class="form-check-input" type="checkbox" name="price[]" value="4"
                id="price4" <?= in_array(4, $_GET['price'] ?? []) ? 'checked' : '' ?>>
            <label class="form-check-label" for="price4">Trên 20 triệu</label>
        </div>

        <!-- <h5 class="fw-bold mb-3 text-danger mt-4">
            <i class="bi bi-award me-2"></i> Thương hiệu
        </h5>

        <div class="form-check mb-2">
            <input class="form-check-input" type="checkbox" name="brand[]" value="acer" id="brand1">
            <label class="form-check-label" for="brand1">Acer</label>
        </div>
        <div class="form-check mb-2">
            <input class="form-check-input" type="checkbox" name="brand[]" value="asus" id="brand2">
            <label class="form-check-label" for="brand2">ASUS</label>
        </div>
        <div class="form-check mb-3">
            <input class="form-check-input" type="checkbox" name="brand[]" value="apple" id="brand3">
            <label class="form-check-label" for="brand3">Apple</label>
        </div> -->

        <button type="submit" class="btn btn-danger w-100 mt-3">
            <i class="bi bi-filter-circle"></i> Áp dụng
        </button>
    </form>
</div>