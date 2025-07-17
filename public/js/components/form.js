class FormHandler {
    constructor(formId, modal, crud) {
        this.form = document.getElementById(formId);
        this.modal = modal;
        this.crud = crud;
        this.errors = {};
        this.init();
    }

    init() {
        this.form.addEventListener("submit", (e) => {
            e.preventDefault();
            this.submit();
        });
    }

    submit() {
        this.clearErrors();
        const idField = this.form.querySelector(
            'input[type="hidden"][name="id"]'
        );

        this.crud.handleFormSubmit(
            this.form,
            idField,
            (data) => {
                this.modal.close();
                setTimeout(() => location.reload(), 1000);
            },
            (data) => {
                this.showErrors(data.errors);
            }
        );
    }

    showErrors(errors) {
        this.errors = errors;
        for (const [field, messages] of Object.entries(errors)) {
            const errorElement = document.getElementById(`${field}Error`);
            if (errorElement) {
                errorElement.textContent = messages[0];
                errorElement.classList.remove("hidden");
            }
        }
    }

    clearErrors() {
        const errorElements = this.form.querySelectorAll('[id$="Error"]');
        errorElements.forEach((element) => {
            element.textContent = "";
            element.classList.add("hidden");
        });
    }

    reset() {
        this.form.reset();
        this.clearErrors();
    }

    populate(data) {
        for (const [key, value] of Object.entries(data)) {
            const field = this.form.querySelector(`[name="${key}"]`);
            if (field) {
                field.value = value;
            }
        }
    }
}
