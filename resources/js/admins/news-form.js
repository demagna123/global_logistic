// public/js/admin/news-form.js

document.addEventListener("DOMContentLoaded", function () {
    const imageUploadArea = document.getElementById("imageUploadArea");
    const fileInput = document.getElementById("images");
    const previewContainer = document.getElementById("imagePreviewContainer");
    const maxImages = 3;

    let existingImageCount = document.querySelectorAll(".existing-image-item").length || 0;
    let imageCount = existingImageCount;
    let newImageCount = 0;
    let selectedFiles = []; // ✅ Stocker les fichiers sélectionnés

    if (imageUploadArea) {
        imageUploadArea.addEventListener("click", function () {
            fileInput.click();
        });
    }

    if (fileInput) {
        fileInput.addEventListener("change", function (event) {
            const files = event.target.files;
            const remainingSlots = maxImages - imageCount;

            if (files.length > remainingSlots) {
                alert(`Vous ne pouvez ajouter que ${remainingSlots} image(s) supplémentaire(s).`);
                this.value = "";
                return;
            }

            // ✅ Ajouter les nouveaux fichiers à la liste
            for (let i = 0; i < files.length; i++) {
                selectedFiles.push(files[i]);
            }

            // ✅ Recréer le FileList avec tous les fichiers
            const dataTransfer = new DataTransfer();
            selectedFiles.forEach(file => dataTransfer.items.add(file));
            fileInput.files = dataTransfer.files;

            // Afficher les aperçus
            for (let i = 0; i < files.length; i++) {
                const file = files[i];

                if (!file.type.startsWith("image/")) {
                    alert(`Le fichier "${file.name}" n'est pas une image.`);
                    continue;
                }

                if (file.size > 2 * 1024 * 1024) {
                    alert(`L'image "${file.name}" dépasse la taille limite de 2MB.`);
                    continue;
                }

                if (imageCount >= maxImages) break;

                const reader = new FileReader();
                const idx = newImageCount;

                reader.onload = function (e) {
                    const previewItem = document.createElement("div");
                    previewItem.className = "image-preview-item";
                    previewItem.setAttribute("data-index", idx);

                    previewItem.innerHTML = `
                        <img src="${e.target.result}" alt="Aperçu">
                        <span class="order-badge">${imageCount + 1}</span>
                        <button type="button" class="remove-image" onclick="removeNewImage(${idx})">✕</button>
                        <div class="image-info">
                            <input 
                                type="text" 
                                name="captions[${idx}]" 
                                placeholder="Légende de l'image (optionnel)"
                                maxlength="255"
                            >
                        </div>
                    `;

                    previewContainer.appendChild(previewItem);
                    imageCount++;
                    newImageCount++;
                };
                reader.readAsDataURL(file);
            }

            // ✅ Réinitialiser l'input pour permettre de rajouter des fichiers
            // Mais garder les fichiers déjà sélectionnés
            updateUploadArea();
        });
    }

    // ✅ Fonction pour supprimer une image
    window.removeNewImage = function (index) {
        const items = previewContainer.querySelectorAll(".image-preview-item");
        let found = false;

        items.forEach((item) => {
            if (parseInt(item.getAttribute("data-index")) === index) {
                item.remove();
                found = true;
                imageCount--;
                
                // ✅ Supprimer le fichier de la liste
                const idx = parseInt(item.getAttribute("data-index"));
                if (selectedFiles[idx]) {
                    selectedFiles.splice(idx, 1);
                }
                
                // ✅ Mettre à jour le FileInput
                const dataTransfer = new DataTransfer();
                selectedFiles.forEach(file => dataTransfer.items.add(file));
                fileInput.files = dataTransfer.files;
            }
        });

        reindexNewImages();
        updateUploadArea();
    };

    function reindexNewImages() {
        const items = previewContainer.querySelectorAll(".image-preview-item");
        items.forEach((item, newIndex) => {
            item.setAttribute("data-index", newIndex);

            const badge = item.querySelector(".order-badge");
            if (badge) {
                badge.textContent = newIndex + 1;
            }

            const captionInput = item.querySelector(".image-info input");
            if (captionInput) {
                captionInput.name = `captions[${newIndex}]`;
            }

            const removeBtn = item.querySelector(".remove-image");
            if (removeBtn) {
                removeBtn.setAttribute("onclick", `removeNewImage(${newIndex})`);
            }
        });
    }

    function updateUploadArea() {
        if (!imageUploadArea) return;

        const remaining = maxImages - imageCount;
        const hint = imageUploadArea.querySelector(".hint");

        if (imageCount >= maxImages) {
            imageUploadArea.classList.add("disabled");
            if (hint) {
                hint.textContent = `⚠️ Maximum ${maxImages} images atteint`;
            }
            if (fileInput) {
                fileInput.disabled = true;
            }
        } else {
            imageUploadArea.classList.remove("disabled");
            if (hint) {
                hint.textContent = `Formats acceptés : JPG, PNG, GIF (max 2MB) - ${remaining} image(s) restante(s)`;
            }
            if (fileInput) {
                fileInput.disabled = false;
            }
        }
    }

    updateUploadArea();
});