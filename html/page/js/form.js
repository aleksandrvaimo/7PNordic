/**
 * Copyright © ...
 */

(function($) {
    $.customerFormValidation = function(currentForm) {
        let customForm = currentForm,
            formInput = 'input',
            invalidClass = 'is-invalid',
            formGroupClass = '.form-group',
            errorMessageClass = 'text-danger',
            errorMessage = 'input value must be at least 3 characters in length',
            dateErrorMessage = 'Date Of Birth is incorrect';

        let addErrorMessage = (element, msg) => {
            if (!element.closest(formGroupClass).find('span').length) {
                element.closest(formGroupClass).append(
                    $('<span />').addClass(errorMessageClass).html(msg)
                );
            }
        }

        let cleanInput = (element) => {
            if (element.hasClass(invalidClass)) {
                element.removeClass(invalidClass);
            }

            if (element.closest(formGroupClass).find('span').length) {
                element.closest(formGroupClass).find('span').remove();
            }
        }

        let isDateCorrect = (element) => {
            return new Date(element.val()) < new Date();
        }

        let addError = (element, errorMessage) => {
            if (!element.hasClass(invalidClass)) {
                element.attr('class', element.attr('class') + ' ' + invalidClass);
            }

            addErrorMessage(element, errorMessage);
        }

        let crud = customForm.find('.crud').val();
        customForm.find(formInput).each(function() {
            if ($(this).attr('type') == 'hidden' || crud == 'update' && $(this).hasClass('password')) {
                return false;
            }

            if ($(this).hasClass('dob') && !isDateCorrect($(this))) {
                addError($(this), dateErrorMessage);

                return false;
            }

            if ($(this).val().length < 3) {
                addError($(this), errorMessage);
            } else {
                cleanInput($(this));
            }
        });
    }
})(jQuery);
