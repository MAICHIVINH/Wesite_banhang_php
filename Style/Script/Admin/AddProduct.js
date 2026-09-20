document
  .getElementById("mainImageInput")
  .addEventListener("change", function (e) {
    const preview = document.getElementById("mainImagePreview");
    preview.innerHTML = "";

    const file = e.target.files[0];
    if (file) {
      const container = document.createElement("div");
      container.classList.add("preview-item");

      const img = document.createElement("img");
      img.src = URL.createObjectURL(file);

      const name = document.createElement("p");
      name.textContent = file.name;

      const removeBtn = document.createElement("button");
      removeBtn.classList.add("remove-btn");
      removeBtn.textContent = "×";

      removeBtn.addEventListener("click", function (e) {
        e.stopPropagation();
        container.remove();
        document.getElementById("mainImageInput").value = "";
      });

      container.appendChild(img);
      container.appendChild(removeBtn);
      container.appendChild(name);
      preview.appendChild(container);
    }
  });

document
  .getElementById("extraImagesInput")
  .addEventListener("change", function (e) {
    const preview = document.getElementById("extraImagesPreview");
    preview.innerHTML = "";

    Array.from(e.target.files).forEach((file, index) => {
      const container = document.createElement("div");
      container.classList.add("preview-item");

      const img = document.createElement("img");
      img.src = URL.createObjectURL(file);

      const name = document.createElement("p");
      name.textContent = file.name;

      const removeBtn = document.createElement("button");
      removeBtn.classList.add("remove-btn");
      removeBtn.textContent = "×";

      removeBtn.addEventListener("click", function (e) {
        e.stopPropagation();
        container.remove();
        resetExtraImagesInput();
      });

      container.appendChild(img);
      container.appendChild(removeBtn);
      container.appendChild(name);
      preview.appendChild(container);
    });
  });

// Reset lại input ảnh phụ sau khi xoá ảnh
function resetExtraImagesInput() {
  const preview = document.getElementById("extraImagesPreview");
  const files = preview.querySelectorAll("img");
  if (files.length === 0) {
    document.getElementById("extraImagesInput").value = "";
  }
}

function attachImagePreview(selector) {
  document.querySelector(selector).addEventListener("click", function (e) {
    if (e.target.tagName.toLowerCase() === "img") {
      const lightbox = document.getElementById("lightbox");
      const lightboxImg = document.getElementById("lightbox-img");
      lightboxImg.src = e.target.src;
      lightbox.style.display = "flex";
    }
  });
}

attachImagePreview("#mainImagePreview");
attachImagePreview("#extraImagesPreview");

document.getElementById("lightbox").addEventListener("click", function () {
  this.style.display = "none";
});
