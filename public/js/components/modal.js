class ModalComponent {
    constructor(modalId) {
        this.modal = document.getElementById(modalId);
        this.isOpen = false;
    }

    open() {
        this.modal.classList.add("modal-open");
        this.isOpen = true;
    }

    close() {
        this.modal.classList.remove("modal-open");
        this.isOpen = false;
    }

    toggle() {
        if (this.isOpen) {
            this.close();
        } else {
            this.open();
        }
    }
}
