<div class="bg-white shadow-sm p-3 rounded-3 border mb-3">
    <div class="d-flex justify-content-between align-items-center">
        <h5 class="fw-bold mb-0 text-danger fs-6">
            <i class="bi bi-funnel-fill me-2"></i> Lọc theo giá
        </h5>
        <button class="btn btn-sm btn-outline-danger d-lg-none" type="button" data-bs-toggle="collapse" data-bs-target="#mobileFilterCollapse" aria-expanded="false" aria-controls="mobileFilterCollapse">
            <i class="bi bi-sliders me-1"></i> Bộ lọc
        </button>
    </div>

    <div class="collapse d-lg-block mt-3 mt-lg-2" id="mobileFilterCollapse">
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
                <label class="form-check-label small fw-semibold text-secondary" for="price1">Dưới 5 triệu</label>
            </div>
            <div class="form-check mb-2">
                <input class="form-check-input" type="checkbox" name="price[]" value="2"
                    id="price2" <?= in_array(2, $_GET['price'] ?? []) ? 'checked' : '' ?>>
                <label class="form-check-label small fw-semibold text-secondary" for="price2">Từ 5 - 10 triệu</label>
            </div>
            <div class="form-check mb-2">
                <input class="form-check-input" type="checkbox" name="price[]" value="3"
                    id="price3" <?= in_array(3, $_GET['price'] ?? []) ? 'checked' : '' ?>>
                <label class="form-check-label small fw-semibold text-secondary" for="price3">Từ 10 - 20 triệu</label>
            </div>
            <div class="form-check mb-3">
                <input class="form-check-input" type="checkbox" name="price[]" value="4"
                    id="price4" <?= in_array(4, $_GET['price'] ?? []) ? 'checked' : '' ?>>
                <label class="form-check-label small fw-semibold text-secondary" for="price4">Trên 20 triệu</label>
            </div>

            <button type="submit" class="btn btn-danger w-100 mt-2 py-2 fw-bold text-white shadow-sm">
                <i class="bi bi-filter-circle me-1"></i> Áp dụng bộ lọc
            </button>
        </form>
    </div>
</div>