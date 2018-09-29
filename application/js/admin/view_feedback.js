/**
 * Created by geymur-vs on 18.08.17.
 */
var view_feedback;

(new (function ViewFeedback() {

    var _this = view_feedback = this;

    var siteUrl;

    this.init = function (adminUrl) {

        siteUrl = adminUrl;

        $("#find-feedback-btn").click(function (e) {

            e.preventDefault();

            pagination.loadPage(0, jQuery('.feedbacks-table'), true, 1, '.feedbacks-table');

        });

        $("#reset-find-feedback-btn").click(function (e) {

            e.preventDefault();

            $('#feedback_type_id').val(null);

            $('#export-as-excel-btn').attr('href', $('#export-as-excel-btn').attr('href').split('?')[0]);

            pagination.loadPage(0, jQuery('.feedbacks-table'), true, 1, '.feedbacks-table');

        });

        // $("#export-as-excel-btn").click(function (e) {
        //
        //     e.preventDefault();
        //
        //     m.post(
        //         siteUrl + '/feedback/exportFeedbackToExcel',
        //         {
        //             feedback_type_id: jQuery('#feedback_type_id').val()
        //         }
        //     );
        //
        // });

        pagination.init(
            siteUrl + '/feedback/viewFeedbacks',
            function () {
                return {
                    feedback_type_id: jQuery('#feedback_type_id').val()
                }
            },
            function () {
            },
            function () {
            },
            '.feedbacks-table'
        );

        $('#feedback_type_id').change(function(){
            if ($('#feedback_type_id').val() != "") {
                $('#export-as-excel-btn').attr('href', $('#export-as-excel-btn').attr('href').split('?')[0]+'?feedback_type_id='+$('#feedback_type_id').val());
            }
            else {
                $('#export-as-excel-btn').attr('href', $('#export-as-excel-btn').attr('href').split('?')[0]);
            }
        });
    };

})());
