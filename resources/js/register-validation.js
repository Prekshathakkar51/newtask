import axios from 'axios';

document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('registerForm');

    if (!form) return;

    form.addEventListener('submit', async function (e) {
        e.preventDefault();

        document
            .querySelectorAll('.error-message')
            .forEach(el => el.textContent = '');

        try {
            const formData = new FormData(form);

            const response = await axios.post(
                form.action,
                formData
            );

            // console.log('SUCCESS RESPONSE:', response.data);

            Alpine.store('toast').success(response.data.message);



            setTimeout(() => {
                window.location.href =
                    response.data.redirect;
            }, 1200);

        } catch (error) {

            if (error.response?.status === 422) {

                const errors = error.response.data.errors;

                Object.keys(errors).forEach(field => {

                    const errorElement =
                        document.querySelector(
                            `[data-error="${field}"]`
                        );

                    if (errorElement) {
                        errorElement.textContent =
                            errors[field][0];
                    }
                });

                Alpine.store('toast').error(
                    'Please fix the validation errors.'
                );

                return;
            }

            Alpine.store('toast').error(
                'Something went wrong.'
            );
        }
    });
});