document.addEventListener("DOMContentLoaded", function() {
    let hiddenData = document.getElementById("hiddenData").value;
    let button = document.getElementById("p.b.forum");
    let infoContainer = document.getElementById("infoContainer");
    let infoBox;

    button.addEventListener("click", function() {
        if (!infoBox) {
            infoBox = document.createElement("div");
            infoBox.className = "info-box";
            //infoBox.textContent = "This is information window";
            infoBox.textContent = hiddenData;
            infoContainer.appendChild(infoBox);
        }

        infoBox.style.display = (infoBox.style.display === "none" || infoBox.style.display === "") ? "block" : "none";
    });
});