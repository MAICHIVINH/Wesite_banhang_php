document.addEventListener("DOMContentLoaded", function () {
  // Khi chọn quyền thì chọn tất cả chức năng thuộc quyền đó
  document.querySelectorAll(".role-checkbox").forEach(function (roleCheckbox) {
    roleCheckbox.addEventListener("change", function () {
      const roleId = this.dataset.roleId;
      const isChecked = this.checked;

      document
        .querySelectorAll('.menu-checkbox[data-role-id="' + roleId + '"]')
        .forEach(function (menuCheckbox) {
          menuCheckbox.checked = isChecked;
        });
    });
  });

  // Nếu bỏ check từng chức năng thì bỏ check quyền nếu tất cả bị bỏ
  document.querySelectorAll(".menu-checkbox").forEach(function (menuCheckbox) {
    menuCheckbox.addEventListener("change", function () {
      const roleId = this.dataset.roleId;
      const relatedMenus = document.querySelectorAll(
        '.menu-checkbox[data-role-id="' + roleId + '"]'
      );
      const allChecked = Array.from(relatedMenus).every((cb) => cb.checked);
      const roleCheckbox = document.querySelector(
        '.role-checkbox[data-role-id="' + roleId + '"]'
      );
      if (roleCheckbox) {
        roleCheckbox.checked = allChecked;
      }
    });
  });

  const editModal = document.getElementById("editEmployeeModal");

  editModal.addEventListener("show.bs.modal", function (event) {
    const button = event.relatedTarget;

    document.getElementById("edit_employee_id").value = button.dataset.id;
    document.getElementById("edit_name").value = button.dataset.name;
    document.getElementById("edit_email").value = button.dataset.email;
    document.getElementById("edit_phone").value = button.dataset.phone;
    document.getElementById("edit_position").value = button.dataset.position;
    document.getElementById("edit_address").value = button.dataset.address;
    document.getElementById("edit_branch_id").value = button.dataset.branch;

    // Lấy role và menu đã có
    const selectedRoles = JSON.parse(button.dataset.roles || "[]");
    const selectedMenus = JSON.parse(button.dataset.menus || "[]");

    // Reset tất cả checkbox
    document
      .querySelectorAll(".role-checkbox-edit, .menu-checkbox-edit")
      .forEach((cb) => (cb.checked = false));

    // Tick các checkbox quyền
    selectedRoles.forEach((rid) => {
      const cb = document.querySelector(
        '.role-checkbox-edit[value="' + rid + '"]'
      );
      if (cb) cb.checked = true;
    });

    // Tick các checkbox menu
    selectedMenus.forEach((mid) => {
      const cb = document.querySelector(
        '.menu-checkbox-edit[value="' + mid + '"]'
      );
      if (cb) cb.checked = true;
    });
  });

  // Tự động check menu theo role
  document.querySelectorAll(".role-checkbox-edit").forEach((roleCb) => {
    roleCb.addEventListener("change", function () {
      const roleId = this.dataset.roleId;
      const isChecked = this.checked;
      document
        .querySelectorAll('.menu-checkbox-edit[data-role-id="' + roleId + '"]')
        .forEach((cb) => {
          cb.checked = isChecked;
        });
    });
  });

  document.querySelectorAll(".menu-checkbox-edit").forEach((menuCb) => {
    menuCb.addEventListener("change", function () {
      const roleId = this.dataset.roleId;
      const allMenus = document.querySelectorAll(
        '.menu-checkbox-edit[data-role-id="' + roleId + '"]'
      );
      const allChecked = Array.from(allMenus).every((cb) => cb.checked);
      const roleCb = document.querySelector(
        '.role-checkbox-edit[data-role-id="' + roleId + '"]'
      );
      if (roleCb) roleCb.checked = allChecked;
    });
  });
  //Xử lý form xóa
  const deleteModal = document.getElementById("deleteEmployeeModal");
  deleteModal.addEventListener("show.bs.modal", function (event) {
    const button = event.relatedTarget;
    const id = button.getAttribute("data-id");
    const name = button.getAttribute("data-name");

    document.getElementById("deleteEmployeeId").value = id;
    document.getElementById("deleteEmployeeName").innerText = name;
  });
});
