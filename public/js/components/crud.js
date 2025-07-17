class CrudHandler {
    constructor(baseUrl, alert) {
        this.baseUrl = baseUrl;
        this.alert = alert;
        this.csrfToken = document
            .querySelector('meta[name="csrf-token"]')
            .getAttribute("content");
    }

    async create(data) {
        return this.request("POST", this.baseUrl, data);
    }

    async update(id, data) {
        data.append("_method", "PUT");
        return this.request("POST", `${this.baseUrl}/${id}`, data);
    }

    async delete(id) {
        return this.request("DELETE", `${this.baseUrl}/${id}`);
    }

    async request(method, url, data = null) {
        const options = {
            method: method === "DELETE" ? "DELETE" : "POST",
            headers: {
                "X-CSRF-TOKEN": this.csrfToken,
                Accept: "application/json",
            },
        };

        if (data) {
            options.body = data;
        }

        try {
            const response = await fetch(url, options);
            return await response.json();
        } catch (error) {
            console.error("Error:", error);
            this.alert.show("Terjadi kesalahan", "error");
            throw error;
        }
    }

    handleFormSubmit(form, id, successCallback, errorCallback) {
        const formData = new FormData(form);
        const isEdit = id && id.value;

        const promise = isEdit
            ? this.update(id.value, formData)
            : this.create(formData);

        promise
            .then((data) => {
                if (data.success) {
                    const message = isEdit
                        ? "Data berhasil diupdate"
                        : "Data berhasil ditambahkan";
                    this.alert.show(message, "success");
                    if (successCallback) successCallback(data);
                } else {
                    if (errorCallback) errorCallback(data);
                }
            })
            .catch((error) => {
                this.alert.show(
                    "Terjadi kesalahan saat menyimpan data",
                    "error"
                );
            });
    }

    handleDelete(id, successCallback) {
        this.delete(id)
            .then((data) => {
                if (data.success) {
                    this.alert.show("Data berhasil dihapus", "success");
                    if (successCallback) successCallback(data);
                } else {
                    this.alert.show("Gagal menghapus data", "error");
                }
            })
            .catch((error) => {
                this.alert.show("Terjadi kesalahan", "error");
            });
    }
}
