/* ADD & DELETE BUTTONS */
const newItem = (e) => {
    const collectionHolder = document.querySelector(e.currentTarget.dataset.collection);

    const item = document.createElement("div");
    item.classList.add("media");
    item.innerHTML = collectionHolder
        .dataset
        .prototype
        .replace(
            /__name__/g, 
            collectionHolder.dataset.index
        );
    item.querySelector(".btn-remove").addEventListener("click", () => item.remove());

    collectionHolder.appendChild(item);

    collectionHolder.dataset.index++;
};

document
    .querySelectorAll('.btn-remove')
    .forEach(btn => btn.addEventListener("click", (e) => e.currentTarget.closest(".media").remove()));

document
    .querySelectorAll('.btn-new')
    .forEach(btn => btn.addEventListener("click", newItem));

/* SHOW IMAGE ON SELECT */

document
    .querySelector("input").onchange = function() {previewFile()};

function previewFile() {
    var preview = document.querySelector('img');
    var file = document.querySelector('input[type=file]').files[0];
    var reader = new FileReader();

    reader.addEventListener("load", function () {
        preview.src = reader.result;
    }, 
    false);

    if (file) {
        reader.readAsDataURL(file);
    }
}