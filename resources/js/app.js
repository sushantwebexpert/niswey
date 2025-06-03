import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

document.addEventListener("DOMContentLoaded", () => {
    const form = document.getElementById("xml-import-form");
    const progressWrapper = document.getElementById("progress-wrapper");
    const progressBar = document.getElementById("progress-bar");
    const progressText = document.getElementById("progress-text");

    if (form) {
        form.addEventListener("submit", function (e) {
            e.preventDefault();

            const formData = new FormData(form);
            const xhr = new XMLHttpRequest();

            xhr.open("POST", form.action, true);
            xhr.setRequestHeader('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));

            xhr.upload.addEventListener("loadstart", () => {
                progressWrapper.classList.remove("hidden");
                progressBar.style.width = "0%";
                progressText.innerText = "0%";
            });

            xhr.upload.addEventListener("progress", (e) => {
                if (e.lengthComputable) {
                    const percent = Math.round((e.loaded / e.total) * 100);
                    progressBar.style.width = percent + "%";
                    progressText.innerText = percent + "%";
                }
            });

            xhr.onload = function () {
                progressWrapper.classList.add("hidden");

                if (xhr.status === 200) {
                    const result = JSON.parse(xhr.responseText);

                    // Show success toast
                    window.dispatchEvent(new CustomEvent("toast", {
                        detail: { type: 'success', message: `Successfully imported ${result.imported} contacts.` }
                    }));

                    // Wait for toast to show, then redirect
                    setTimeout(() => {
                        window.location.href = "/contacts"; // Change route if different
                    }, 1000); // Wait 2 seconds before redirect
                } else {
                    // Show error toast
                    window.dispatchEvent(new CustomEvent("toast", {
                        detail: { type: 'error', message: "Import failed. Try again." }
                    }));
                }
            };


            xhr.onerror = function () {
                progressWrapper.classList.add("hidden");
                window.dispatchEvent(new CustomEvent("toast", {
                    detail: { type: 'error', message: "An error occurred during upload." }
                }));
            };


            xhr.send(formData);
        });
    }
});