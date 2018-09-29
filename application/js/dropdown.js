$(function () {
    init_drop_down();
});

function init_drop_down() {
    var search_type = $("input#search_type").val();
    var limit_selected_count;
    if (search_type == 2)
        limit_selected_count = $("input#limit_selected_count").val();
    else
        limit_selected_count = 0;
    // var selected_count = $("div.result_box_content").length;
    // if (selected_count > 0)
    //     $(".custom_dropdown_block").removeAttr("hidden");

    // -------- when click header, show dropdown box ---------
    // $("div.result_box").click(function (e) {
    //     var dropdown_showmark = $("span#mark");
    //
    //     $("div#group_form").attr("hidden", "hidden");
    //     $("span#mark").attr("class", "fa fa-caret-down");
    // });

    //---------- when lost focus dropdown, hide dropdowm box -------------------------
    // $(document).mouseup(function (e) {
    //     var dropdowm_box = $("div.dropdown_box");
    //
    //     if (!dropdowm_box.is(e.target) // if the target of the click isn't the container...
    //         && dropdowm_box.has(e.target).length === 0) // ... nor a descendant of the container
    //     {
    //         var top_div = $(".result_box");
    //         var dropdown_showmark = $("span#mark");
    //         if (!top_div.is(e.target) && !dropdown_showmark.is(e.target)) {
    //             $("div#group_form").attr("hidden", "hidden");
    //             $("span#mark").attr("class", "fa fa-caret-down");
    //         }
    //     }
    // });

    //------- display and hidden form ----------
    $("div.result_mark").click(function () {
        //alert($("div#group_form").attr("hidden"));
        if ($("div#group_form").attr("hidden") === "hidden") {

            if ($("div#group_form").attr("hidden") === "hidden") {
                $("div#group_form").removeAttr("hidden");
                $("span#mark").attr("class", "fa fa-caret-up");

                var main_category_names = $("span.main_category_name");
                var sub_category_li = $("div.sub_category ul li");

                //------- remove hidden attribut of every main category --------------
                main_category_names.each(function () {
                    var identifier = $(this).attr("id");

                    if ($("li." + identifier).attr("hidden") === "hidden")
                        $("li." + identifier).removeAttr("hidden");
                    if ($("div." + identifier).attr("hidden") === "hidden")
                        $("div." + identifier).removeAttr("hidden");
                    $("span#mark_" + identifier).attr("class", "main_category_mark fa fa-caret-up");


                });


                //------- remove hidden attribut of every sub category -----------------
                sub_category_li.each(function () {
                    var identifier = $(this).attr("sub_category_id");
                    var main_category__id = $("input#" + identifier).attr("main_category_id");
                    if ($("li." + main_category__id).attr("hidden") === "hidden")
                        $("li." + main_category__id).removeAttr("hidden");
                    if ($("div." + main_category__id).attr("hidden") === "hidden")
                        $("div." + main_category__id).removeAttr("hidden");
                    if ($("li." + identifier).attr("hidden") === "hidden")
                        $("li." + identifier).removeAttr("hidden");
                    $("span#mark_" + main_category__id).attr("class", "main_category_mark fa fa-caret-up");

                });


                $("#search_box").val("");
                $("#search_box").keyup();
            }

            $("div#group_form").removeAttr("hidden");
            $("span#mark").attr("class", "fa fa-caret-up");
        }
        else {

            $("div#group_form").attr("hidden", "hidden");
            $("span#mark").attr("class", "fa fa-caret-down");
        }
    });

    //-------- click submit button -----------
    $("#result_submit").click(function () {
        $("#group_form").submit();
    });


    //-------- check main category checkbox -------
    $(".main_category").change(function () {
        var main_category_id = $(this).attr("id");


        if ($(this).is(":checked")) {
            if (search_type == 0) {
                if ($("div." + main_category_id).attr("hidden") === "hidden")
                    $("div." + main_category_id).removeAttr("hidden");
                $(this).parent().children("label").children("span.main_category_mark").attr("class", "main_category_mark fa fa-caret-up");
                $("ul." + main_category_id + " li").each(function () {
                    if ($(this).children("div").children('input').is(":checked") == false) {
                        $(this).children("div").children('input').prop('checked', true);
                        $(this).children("div").children("input").change();
                    }
                });
            } else if (search_type == 1) {

            } else if (search_type == 2) {

                var selected_count = $("div.result_box_content").length;
                var adding_count = 0;
                $("ul." + main_category_id + " li").each(function () {
                    if ($(this).children("div").children("input").is(":checked") == false)
                        adding_count++;
                });

                if (selected_count + adding_count < parseInt(limit_selected_count) + 1) {
                    if ($("div." + main_category_id).attr("hidden") === "hidden")
                        $("div." + main_category_id).removeAttr("hidden");
                    $(this).parent().children("label").children("span.main_category_mark").attr("class", "main_category_mark fa fa-caret-up");
                    $("ul." + main_category_id + " li").each(function () {
                        if ($(this).children("div").children('input').is(":checked") == false) {
                            $(this).children("div").children('input').prop('checked', true);
                            $(this).children("div").children("input").change();
                        }
                    });
                } else {

                    alert("Exceeds max categories allowed: " + limit_selected_count + ".");
                    $(this).prop("checked", false);
                }
            }

        } else {
            $('ul.' + main_category_id + " li").each(function () {
                if ($(this).children("div").children('input').is(":checked") == true) {
                    $(this).children("div").children("input").prop('checked', false);
                    $(this).children("div").children("input").change();
                }
            });
        }
    });

    //--------- click main category_label -----------
    $(".main_category_label").click(function () {
        var main_category_id = $(this).attr("main_category_id");
        var dest_div = $("div." + main_category_id);
        if (dest_div.attr("hidden") == "hidden") {
            dest_div.removeAttr("hidden");
            $(this).children("span.main_category_mark").attr("class", "main_category_mark fa fa-caret-up");
        } else {
            dest_div.attr("hidden", "hidden");
            $(this).children("span.main_category_mark").attr("class", "main_category_mark fa fa-caret-down");
        }
    });

    //------- when click sub_category check box--------
    $(".sub_item").change(function () {
        //------ display result in result box --------
        var sub_category_id = $(this).attr("id");
        var main_category_id = $(this).attr("main_category_id");
        var sub_category_name = $("label." + sub_category_id).html();
        var main_category_name = $("span#" + main_category_id).html();
        if ($(this).is(":checked")) {
            if (search_type == 0) {
                var add = '<div class="' + sub_category_id + ' result_box_content"><span style="color: black">' +
                    main_category_name +
                    '</span><span style="color: white">' +
                    sub_category_name +
                    '<input type="hidden" name="' + sub_category_id + '" value="' + sub_category_id + '">' +
                    '</span><span class="remove_category fa fa-times" sub_category_id=' + sub_category_id + '></span></div>';
                var original = $("div.result_box_area").html();
                $("div.result_box_area").html(original + add);
                $(".remove_category").click(function () {
                    var sub_category_id = $(this).attr("sub_category_id");
                    $("div." + sub_category_id).remove();
                    $("input#" + sub_category_id).prop("checked", false);
                    $("input#" + sub_category_id).change();
                });
            } else if (search_type == 1) {
                //------ init sub category checkbox(unchecked) ------
                $("div.sub_category ul li").each(function () {
                    var sub_category_id1 = $(this).attr("sub_category_id")
                    if ($("input#" + sub_category_id1).is(":checked"))
                        $("input#" + sub_category_id1).prop("checked", false);
                });

                //------ only one set checked ----------------
                $(this).prop("checked", true);

                //------ show search result box --------------
                var add = '<div class="' + sub_category_id + ' result_box_content"><span style="color: black">' +
                    main_category_name +
                    '</span><span style="color: white">' +
                    sub_category_name +
                    '<input type="hidden" name="' + sub_category_id + '" value="' + sub_category_id + '">' +
                    '</span><span class="remove_category fa fa-times" sub_category_id=' + sub_category_id + '></span></div>';

                $("div.result_box_area").html(add);
                $(".remove_category").click(function () {
                    var sub_category_id = $(this).attr("sub_category_id");
                    $("div." + sub_category_id).remove();
                    $("input#" + sub_category_id).prop("checked", false);
                    $("input#" + sub_category_id).change();
                });


            } else if (search_type == 2) {

                var selected_count = $("div.result_box_content").length;
                if (selected_count < limit_selected_count) {
                    var add = '<div class="' + sub_category_id + ' result_box_content"><span style="color: black">' +
                        main_category_name +
                        '</span><span style="color: white">' +
                        sub_category_name +
                        '<input type="hidden" name="' + sub_category_id + '" value="' + sub_category_id + '">' +
                        '</span><span class="remove_category fa fa-times" sub_category_id=' + sub_category_id + '></span></div>';
                    var original = $("div.result_box_area").html();
                    $("div.result_box_area").html(original + add);
                    $(".remove_category").click(function () {
                        var sub_category_id = $(this).attr("sub_category_id");
                        $("div." + sub_category_id).remove();
                        $("input#" + sub_category_id).prop("checked", false);
                        $("input#" + sub_category_id).change();
                    });
                } else {
                    alert("Exceeds max categories allowed:  " + limit_selected_count + ".");
                    $(this).prop("checked", false);
                }
            }

        } else {
            $("div." + sub_category_id).remove();
        }

        //-------- set check state of main category --------
        $check_state = true;
        var main_category_id = $(this).attr("main_category_id");
        $("ul." + main_category_id + " li").each(function () {
            if ($(this).children("div").children("input").is(":checked") == false) {
                $check_state = false;
            }
        });

        if ($check_state) {
            $("input." + main_category_id).prop('checked', true);
        } else {
            $("input." + main_category_id).prop('checked', false);
        }

        if ($("div.result_box_content").length == 0) {
            $(".result_box").attr("hidden", "hidden");
            $("span#mark").attr("class", "fa fa-caret-down");
        } else {
            $(".result_box").removeAttr("hidden");
        }
    });

    //--------- when onload page, remove checked mark in sub cateogry ----------
    /*  $("input.sub_item").each(function () {
     $(this).prop("checked", false);
     }); */

    //--------- when onload page, remove checked mark in main cateogry ----------
    /* $("input.main_category").each(function () {
     $(this).prop("checked", false);
     }); */

    //--------- when input serachbox, display search result in dropdowm box-----------

    $("#search_box").on('keyup', function (event, el) {
        var search_key = $(this).val().toLowerCase();
        if (search_type != 1) {
            var main_category_names = $("span.main_category_name");
            //------- search main category --------------
            main_category_names.each(function () {
                var identifier = $(this).attr("id");
                var main_category_name_lower = $(this).html().toLowerCase();

                if (main_category_name_lower.indexOf(search_key) < 0) {
                    var show_main_category = false;
                    //------- search sub category -----------------
                    $("ul." + identifier + " li").each(function () {

                        var sub_identifier = $(this).attr("sub_category_id");
                        var sub_category_name_lower = $("label." + sub_identifier).html().toLowerCase();
                        //alert(sub_category_name_lower.indexOf(search_key));
                        if (sub_category_name_lower.indexOf(search_key) < 0) {
                            $("li." + sub_identifier).attr("hidden", "hidden");

                        } else {
                            //alert($("li." + sub_identifier).attr("hidden"));
                            show_main_category = true;
                            if ($("li." + sub_identifier).attr("hidden") === "hidden")
                                $("li." + sub_identifier).removeAttr("hidden");
                            $("span#mark_" + identifier).attr("class", "main_category_mark fa fa-caret-up");
                        }

                    });

                    if (show_main_category) {
                        if ($("li." + identifier).attr("hidden") === "hidden")
                            $("li." + identifier).removeAttr("hidden");
                        if ($("div." + identifier).attr("hidden") === "hidden")
                            $("div." + identifier).removeAttr("hidden");
                    }
                    else {
                        $("li." + identifier).attr("hidden", "hidden");
                        $("div." + identifier).attr("hidden", "hidden");
                    }

                }
                else {
                    if ($("li." + identifier).attr("hidden") === "hidden")
                        $("li." + identifier).removeAttr("hidden");
                    if ($("div." + identifier).attr("hidden") === "hidden")
                        $("div." + identifier).removeAttr("hidden");
                    $("span#mark_" + identifier).attr("class", "main_category_mark fa fa-caret-up");

                    //---- show of sub category items in main category --------

                    $("ul." + identifier + " li").each(function () {
                        if ($(this).attr("hidden") === "hidden")
                            $(this).removeAttr("hidden");
                    });

                }

            });
        } else {
            $("div.sub_category ul li").each(function () {
                var sub_category_id1 = $(this).attr("sub_category_id");
                var sub_category_name_lower = $("label." + sub_category_id1).html().toLowerCase();

                if (sub_category_name_lower.indexOf(search_key) < 0) {
                    $("li." + sub_category_id1).attr("hidden", "hidden");

                } else {
                    if ($("li." + sub_category_id1).attr("hidden") === "hidden")
                        $("li." + sub_category_id1).removeAttr("hidden");
                }
            });
        }
    });

    //------- when input enter key in search box ----
    $("#search_box").keypress(function (e) {
        if (e.which == 13 && $(this).val() != "") {
            if (search_type == 1) {

                $("div.result_box_area").html("");

                $("div.sub_category ul li").each(function () {
                    if ($(this).attr("hidden") != "hidden") {
                        var selected_sub_category_id = $(this).attr("sub_category_id");
                        //if ($("input#" + selected_sub_category_id).is(":checked") == false) {
                        $("input#" + selected_sub_category_id).prop("checked", true);
                        $("input#" + selected_sub_category_id).change();
                        //}
                        //else {
                        //    return true;
                        //}
                        $("div#group_form").attr("hidden", "hidden");
                        $("span#mark").attr("class", "fa fa-caret-down");
                        $("#search_box").blur();
                        $("#search_box").val("");
                        return false;
                    }
                });

            }
            else {
                $("div.sub_category ul li").each(function () {
                    if ($(this).attr("hidden") != "hidden") {
                        var selected_sub_category_id = $(this).attr("sub_category_id");
                        if ($("input#" + selected_sub_category_id).is(":checked") == false) {
                            $("input#" + selected_sub_category_id).prop("checked", true);
                            $("input#" + selected_sub_category_id).change();
                        } else {
                            return true;
                        }
                        $("div#group_form").attr("hidden", "hidden");
                        $("span#mark").attr("class", "fa fa-caret-down");
                        $("#search_box").blur();
                        $("#search_box").val("");
                        return false;
                    }
                });
            }
        }
    });

    $('.sub_item').each(function () {
        if ($(this).prop('checked') == true) {
            $(this).change();
        }
    });
    $("#search_box").keyup();
}