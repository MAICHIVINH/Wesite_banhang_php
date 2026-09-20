 document.addEventListener('DOMContentLoaded', () => {
    const editModal = document.getElementById('editCategoryModal');
    editModal.addEventListener('show.bs.modal', event => {
      const button = event.relatedTarget;
      document.getElementById('editCategoryId').value = button.getAttribute('data-id');
      document.getElementById('editCategoryName').value = button.getAttribute('data-name');
      document.getElementById('editCategoryIcon').value = button.getAttribute('data-icon');
      document.getElementById('editCategoryStatus').value = button.getAttribute('data-status');
    });

    const deleteModal = document.getElementById('deleteCategoryModal');
    deleteModal.addEventListener('show.bs.modal', event => {
      const button = event.relatedTarget;
      document.getElementById('deleteCategoryId').value = button.getAttribute('data-id');
      document.getElementById('deleteCategoryName').innerText = button.getAttribute('data-name');
    });

    document.querySelectorAll('.modal').forEach(modalEl => {
      modalEl.addEventListener('hidden.bs.modal', () => {
        document.querySelectorAll('.modal-backdrop').forEach(el => el.remove());
      });
    });
  });