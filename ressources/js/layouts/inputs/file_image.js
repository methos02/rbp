export function previewImage(e, input) {
    const reader = new FileReader();

    reader.onload = () => {
        [...document.querySelectorAll(`img[data-preview=${input.dataset.preview}]`)].forEach(image => {
            image.src = reader.result;
            image.dispatchEvent(new Event('change', {bubbles:true}));
        });
    }

    reader.readAsDataURL(e.target.files[0]);
}
