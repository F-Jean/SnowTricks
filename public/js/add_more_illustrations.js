function previewFile(item) {
    var preview = item.querySelector('img');
    var file = item.querySelector('input[type=file]').files[0];
    var reader = new FileReader();
    console.log(preview, file);
    reader.addEventListener("load", function () {
        preview.src = reader.result;
    }, 
    false);

    if (file) {
        reader.readAsDataURL(file);
    }
}

/* ADD & DELETE BUTTONS */
const newItem = (e) => {
    // pick up the collections "#illustrations & #videos"
    const collectionHolder = document.querySelector(e.currentTarget.dataset.collection);
    // create a div class media in JS
    const item = document.createElement("div");
    item.classList.add("media");
    // replace the prototype /__name__/ by our index
    item.innerHTML = collectionHolder
        .dataset
        .prototype
        .replace(
            /__name__/g, 
            collectionHolder.dataset.index
        );
    // remove the whole div when clicking the remove btn
    item.querySelector(".btn-remove").addEventListener("click", () => item.remove());
    collectionHolder.appendChild(item);
    item.querySelector("input").addEventListener("change", function() {previewFile(item)});
    // increase index
    collectionHolder.dataset.index++;
    previewFile(item);
};

document
    .querySelectorAll('.btn-new')
    .forEach(btn => btn.addEventListener("click", newItem));

    document
    .querySelectorAll('.btn-remove')
    .forEach(btn => btn.addEventListener("click", (e) => e.currentTarget.closest('.media').remove()));