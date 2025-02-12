document.addEventListener("DOMContentLoaded", function () {
    const mode = sessionStorage.getItem("mode") || "light-mode";
    document.body.classList.add(mode);

    const toggleModeButton = document.getElementById("toggle-mode");
    toggleModeButton.addEventListener("click", () => {
        const currentMode = document.body.classList.contains("dark-mode")
            ? "dark-mode"
            : "light-mode";
        const newMode =
            currentMode === "dark-mode" ? "light-mode" : "dark-mode";

        sessionStorage.setItem("mode", newMode);
        document.body.classList.toggle("dark-mode");
        document.body.classList.toggle("light-mode");
    });
});
