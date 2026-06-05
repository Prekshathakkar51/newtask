window.taskForm = function () {
    return {
        errors: {},

        validateForm() {
            this.errors = {};

            // Title
            const title = this.$el
                .querySelector('[name="title"]')
                ?.value
                .trim();

            if (!title) {
                this.errors.title = 'Task title is required.';
            } else if (title.length > 255) {
                this.errors.title =
                    'Task title cannot exceed 255 characters.';
            }

            // Description
            const description = this.$el
                .querySelector('[name="description"]')
                ?.value
                .trim();

            if (!description) {
                this.errors.description =
                    'Task description is required.';
            }

            // Assigned User
            const assignedUserId = this.$el
                .querySelector('[name="assigned_user_id"]')
                ?.value;

            if (!assignedUserId) {
                this.errors.assigned_user_id =
                    'Please select a user.';
            }

            // Priority
            const priority = this.$el
                .querySelector('[name="priority"]')
                ?.value;

            if (!priority) {
                this.errors.priority =
                    'Please select a priority.';
            }

            // Status
            const status = this.$el
                .querySelector('[name="status"]')
                ?.value;

            if (!status) {
                this.errors.status =
                    'Please select a status.';
            }

            // Due Date
            const dueDate = this.$el
                .querySelector('[name="due_date"]')
                ?.value;

            if (!dueDate) {
                this.errors.due_date =
                    'Please select a due date.';
            } else {
                const selectedDate = new Date(dueDate);
                const today = new Date();

                today.setHours(0, 0, 0, 0);

                if (selectedDate < today) {
                    this.errors.due_date =
                        'Due date cannot be in the past.';
                }
            }

            // Attachment
            const fileInput =
                this.$el.querySelector(
                    '[name="attachment"]'
                );

            const file = fileInput?.files[0];

            if (file) {
                const allowedExtensions = [
                    'pdf',
                    'doc',
                    'docx',
                    'jpg',
                    'jpeg',
                    'png',
                    'webp',
                    'zip',
                ];

                const extension = file.name
                    .split('.')
                    .pop()
                    .toLowerCase();

                if (
                    !allowedExtensions.includes(
                        extension
                    )
                ) {
                    this.errors.attachment =
                        'Invalid file type.';
                }

                const maxSize =
                    5 * 1024 * 1024;

                if (file.size > maxSize) {
                    this.errors.attachment =
                        'File size must not exceed 5 MB.';
                }
            }

            return (
                Object.keys(this.errors)
                    .length === 0
            );
        },


        async submitForm() {

            this.errors = {};

            if (!this.validateForm()) {
                return;
            }

            const formData = new FormData(this.$el);

            // adding this so it works for both create and edit forms
            const method = this.$el.getAttribute('method')?.toLowerCase() || 'post';
            const url = this.$el.action;

            if (method === 'put') {
                formData.append('_method', 'PUT');
            }

            try {

                const response = await axios.post(
                    url, formData
                );

                Alpine.store('toast').success(response.data.message);

                setTimeout(() => {
                    window.location.href = response.data.redirect;
                }, 1200);

            }
            catch (error) {

                if (
                    error.response &&
                    error.response.status === 422
                ) {

                    const serverErrors =
                        error.response.data.errors;

                    Object.keys(serverErrors)
                        .forEach(field => {

                            this.errors[field] =
                                serverErrors[field][0];
                        });
                }
                else {
                    console.error(error);
                }


            }
        }
    };
};