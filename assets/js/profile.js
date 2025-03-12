document.addEventListener("DOMContentLoaded", function() {
    let button = document.getElementById("p.b.forum");
    let infoContainer = document.getElementById("infoContainer");
    let infoBox;

    let hiddenInput = document.getElementById("hiddenData");
    let data = hiddenInput.value;

    button.addEventListener("click", function() {
        if (!infoBox) {
            infoBox = document.createElement("div");
            infoBox.className = "info-box";
            //infoBox.textContent = "This is information window";
            //infoBox.textContent = hiddenInput;
            infoBox.innerHTML = data;
            infoContainer.appendChild(infoBox);
        }

        infoBox.style.display = (infoBox.style.display === "none" || infoBox.style.display === "") ? "grid" : "none";
    });
});