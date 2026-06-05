document.addEventListener("DOMContentLoaded", () => {
    const form = document.getElementById("loginForm");

    if (!form) return;

    form.addEventListener("submit", async (e) => {
        e.preventDefault();

        document
            .querySelectorAll(".error-message")
            .forEach((el) => (el.textContent = ""));

        try {
            const response = await axios.post(
                form.action,
                new FormData(form)
            );

            Alpine.store("toast").success(
                response.data.message
            );

            setTimeout(() => {
                window.location.href =
                    response.data.redirect;
            }, 1200);

        } catch (error) {

            if (error.response?.status === 422) {

                const data = error.response.data;

                if (data.errors) {

                    Object.entries(data.errors).forEach(
                        ([field, messages]) => {

                            const errorElement =
                                document.querySelector(
                                    `[data-error="${field}"]`
                                );

                            if (errorElement) {
                                errorElement.textContent =
                                    messages[0];
                            }
                        }
                    );

                } else {

                    Alpine.store("toast").error(
                        data.message
                    );
                }
            }
        }
    });
});