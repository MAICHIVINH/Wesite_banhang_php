const editModal = document.getElementById("editMenuModal");
editModal.addEventListener("show.bs.modal", function (event) {
  const button = event.relatedTarget;
  const id = button.getAttribute("data-id");
  const name = button.getAttribute("data-name");
  const url = button.getAttribute("data-url");

  document.getElementById("editMenuId").value = id;
  document.getElementById("editMenuName").value = name;
  document.getElementById("editMenuUrl").value = url;
});
