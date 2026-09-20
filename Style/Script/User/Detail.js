
// Ảnh sản phẩm
const mainImage = document.getElementById('mainImage');
const modalImage = document.getElementById('modalImage');
const thumbnails = document.querySelectorAll('.thumb-img');

const imageList = [mainImage.src, ...Array.from(thumbnails).map(t => t.src)];
let currentIndex = 0;

function swapImage(thumb) {
    const tempSrc = mainImage.src;
    mainImage.src = thumb.src;
    thumb.src = tempSrc;
    

    imageList[0] = mainImage.src;
    for (let i = 0; i < thumbnails.length; i++) {
        imageList[i + 1] = thumbnails[i].src;
    }
}



mainImage.addEventListener('click', function () {
    updateImage(0);
    const modal = new bootstrap.Modal(document.getElementById('imageModal'));
    modal.show();
});

function nextImage() {
    currentIndex = (currentIndex + 1) % imageList.length;
    updateImage(currentIndex);
}

function prevImage() {
    currentIndex = (currentIndex - 1 + imageList.length) % imageList.length;
    updateImage(currentIndex);
}

function updateImage(index) {
    currentIndex = index;
    modalImage.src = imageList[index];
}