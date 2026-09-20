
  function previewAvatar(input) {
    const preview = document.getElementById('avatarPreview');
    const file = input.files[0];

    if (file && file.type.startsWith('image/')) {
      const reader = new FileReader();
      reader.onload = function (e) {
        preview.src = e.target.result;
      };
      reader.readAsDataURL(file);
    } else {
      preview.src = "Style/Images/mtp.jpg"; // fallback nếu không hợp lệ
    }
  }
