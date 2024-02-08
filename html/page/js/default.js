/**
 * Copyright © ...
 */

(function($) {
    $.workWithCustomer = function() {
        let createCustomerForm = $('form.create-customer'),
            updateCustomerForm = 'form.update-customer',
            updateFormBtn = $('.crud-update'),
            deleteFormBtn = $('.crud-delete'),
            disabled = false;

        /**
         * Create Action
         */
        createCustomerForm.on('submit', function(event) {
            event.preventDefault();
            if (disabled) {
                return;
            }
            let params = $.fn.getParams($(this));
            if (params) {
                $.fn.request(params);
            }
        });

        /**
         * Update Action
         */
        updateFormBtn.on('click', function(event) {
            event.preventDefault();
            if (disabled) {
                return;
            }
            let cForm = $(this).closest(updateCustomerForm);
            cForm.find('.crud').val('update');

            let params = $.fn.getParams(cForm);
            if (params) {
                $.fn.request(params);
            }
        });

        /**
         * Delete Action
         */
        deleteFormBtn.on('click', function(event) {
            event.preventDefault();
            if (disabled) {
                return;
            }
            let form = $(this).closest(updateCustomerForm),
                params = 'username=' + form.find('.username').val() + '&id=' + form.find('.customer').val() + '&crud=delete';

            $.fn.request(params);
        });

        $.fn.getParams = function(currentForm) {
            new $.customerFormValidation(currentForm);

            if (currentForm.find('.text-danger').length) {
                return;
            }

            let params = currentForm.serialize();

            return params;
        };

        $.fn.request = function(params) {
            disabled = true;

            $.ajax({
                url: createCustomerForm.attr('action'),
                method: 'POST',
                data: params,
                dataType: 'JSON',
                beforeSend: function() {
                    $('.loader').show().css('display', 'flex');
                },
                complete: function(){
                    $('.loader').hide();
                },
                success: function (response) {
                    disabled = false;
                    if ('msg' in response) {
                        if ('status' in response) {
                            if (response.status == 'success') {
                                window.location.href = '/';
                            }
                            this.message(response);
                        }
                    }
                },
                message: function(data) {
                    if (!$('.alert').length) {
                        $('<div />').addClass('alert').insertBefore($('.container'));
                    }

                    let removeClass = data.status == 'success' ? 'alert-danger' : 'alert-success';
                    let addClass = data.status == 'success' ? 'alert-success' : 'alert-danger';

                    $('.alert').removeClass(removeClass).addClass(addClass).html(data.msg);
                },
                error: function (xhr) {
                    disabled = false;
                    console.log('Error occurred: ' + xhr.status + ' ' + xhr.statusText);
                }
           });
        }
    }
})(jQuery);
