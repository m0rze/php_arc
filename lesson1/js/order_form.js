$(document).ready(function () {


    $(".order_cat_select").change(function () {
        let ajaxUrl = $("#ajax-url").val();
        $(".master_select").html("");
        $(".date_picker").val("");
        $(".time_select").html("");
        $.ajax({
            url: ajaxUrl,
            type: 'POST',
            cache: false,
            data: {'action': 'postajax', 'getmasters': 'yes', 'catid': this.value},
            dataType: 'html',
            success: function (data) {
                data = JSON.parse(data);
                if (data) {
                    if (data.result == true) {
                        $(".master_select").html(data.masters_select);
                    }
                }
            }
        });
    });

    $(".master_select").change(function () {
        $(".date_picker").val("");
        $(".time_select").html("");
    });

    $(".date_picker").change(function () {
        let ajaxUrl = $("#ajax-url").val();
        //alert($(".master_option:selected").val());
        $.ajax({
            url: ajaxUrl,
            type: 'POST',
            cache: false,
            data: {
                'action': 'postajax',
                'getmastertime': 'yes',
                'date': $(".date_picker").val(),
                'masterid': $(".master_option:selected").val()
            },
            dataType: 'html',
            success: function (data) {
                data = JSON.parse(data);
                if (data) {
                    $(".time_select").html(data.time);
                }
            }
        });
    });

    $(".submit_order").click(function () {
        $(".errors").html("");
        if (!$(".order_form_input_phone").val() || !$(".order_form_input").val() || !$(".cat-selection:selected").val() || !$(".master_option:selected").val() || !$(".date_picker").val() || !$(".time_option:selected").val()) {
            $(".errors").html("Заполните все поля формы");
            return false;
        }
        let ajaxUrl = $("#ajax-url").val();
        $.ajax({
            url: ajaxUrl,
            type: 'POST',
            cache: false,
            data: {
                'action': 'postajax',
                'sendorder': 'yes',
                'fullname': $(".order_form_input").val(),
                'phone': $(".order_form_input_phone").val(),
                'email': $(".order_form_input_email").val(),
                'catid': $(".cat-selection:selected").val(),
                'masterid': $(".master_option:selected").val(),
                'date_when': $(".date_picker").val(),
                'time_when': $(".time_option:selected").val()
            },
            dataType: 'html',
            success: function (data) {
                data = JSON.parse(data);

                if (data) {
                    if (data.error == 1) {
                        $(".errors").html("Неверный формат даты или времени");
                    }
                    if (data.error == 2) {
                        $(".errors").html("Заказ не сохранен, попробуйте еще раз");
                    }

                    if(data.result){
                        $(".form_heading").html("");
                        $(".order_form").html(data.result);
                    }
                }
            }
        });
    });
});