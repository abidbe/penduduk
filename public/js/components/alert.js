class AlertComponent {
    constructor() {
        this.container = document.getElementById("alertContainer");
        this.box = document.getElementById("alertBox");
        this.message = document.getElementById("alertMessage");
    }

    show(message, type = "success", duration = 3000) {
        this.message.textContent = message;
        this.box.className = `alert alert-${type}`;
        this.container.style.display = "block";

        setTimeout(() => {
            this.container.style.display = "none";
        }, duration);
    }

    hide() {
        this.container.style.display = "none";
    }
}
