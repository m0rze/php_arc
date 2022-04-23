$(document).ready(function () {
    $(".add-cat-button").click(function () {
        let ajaxUrl = $("#ajax-url").val();
        // alert(ajaxUrl);
        $.ajax({
            url: ajaxUrl,
            type: 'POST',
            cache: false,
            data: {'action': 'postajax', 'addnewcat': 'yes', 'catname': $(".cat-name-input").val()},
            dataType: 'html',
            success: function (data) {
                data = JSON.parse(data);
                if (data) {
                    if (data.result == true) {
                        $(".add-result").html("<h4 style='color: darkgreen'>Категория успешно добавлена</h4>");
                        $(".cats-list-ul").append("<li class='cat-list-item'><span class='dashicons dashicons-trash delete-cat'></span>\n" + "<span class='span-cat-name'>" + $(".cat-name-input").val() + "</span></li>");
                        $(".cat-name-input").val("");
                    } else {
                        $(".add-result").html("<h4 style='color: red'>Категория не добавлена</h4>");
                    }
                }
            }
        });

    });

    $(".delete-cat").click(function () {
        let ajaxUrl = $("#ajax-url").val();
        $("ul").find("[data-li-catid='" + $(this).attr("data-catid") + "']").remove();
        $.ajax({
            url: ajaxUrl,
            type: 'POST',
            cache: false,
            data: {'action': 'postajax', 'deletecat': 'yes', 'catid': $(this).attr("data-catid")},
            dataType: 'html',
            success: function (data) {

            }
        });
    });


    $(".add-master-button").click(function () {
        let ajaxUrl = $("#ajax-url").val();
        $.ajax({
            url: ajaxUrl,
            type: 'POST',
            cache: false,
            data: {'action': 'postajax', 'addnewmaster': 'yes', 'mastername' : $(".master-name-input").val(), 'catid': $(".cat-selection:selected").val()},
            dataType: 'html',
            success: function (data) {
                data = JSON.parse(data);
                if (data) {
                    if (data.result == true) {
                        $(".add-result").html("<h4 style='color: darkgreen'>Мастер успешно добавлен</h4>");
                        $(".cats-list-ul").append("<li class='cat-list-item'><span class='dashicons dashicons-trash delete-cat'></span>\n" + "<span class='span-cat-name'>" + $(".master-name-input").val() + "</span></li>");
                        $(".master-name-input").val("");
                    } else {
                        $(".add-result").html("<h4 style='color: red'>Мастер не добавлен</h4>");
                    }
                }
            }
        });

    });

    $(".delete-master").click(function () {
        let ajaxUrl = $("#ajax-url").val();
        $("ul").find("[data-li-masterid='" + $(this).attr("data-masterid") + "']").remove();
        $.ajax({
            url: ajaxUrl,
            type: 'POST',
            cache: false,
            data: {'action': 'postajax', 'deletemaster': 'yes', 'masterid': $(this).attr("data-masterid")},
            dataType: 'html',
            success: function (data) {

            }
        });
    });

    $(".delete-order").click(function () {
        let ajaxUrl = $("#ajax-url").val();
        $(this).closest("tr").remove();
        $.ajax({
            url: ajaxUrl,
            type: 'POST',
            cache: false,
            data: {'action': 'postajax', 'deleteorder': 'yes', 'orderid': $(this).attr("data-orderid")},
            dataType: 'html',
            success: function (data) {
            }
        });
    });
});