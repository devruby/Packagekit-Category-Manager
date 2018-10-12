/**
 * Created by Kanak on 2/8/16.
 */

'use strict';
//  Author: ThemeREX.com
//  forms-wizard.html scripts
//

(function($) {

    $(document).ready(function() {

        "use strict";


        // Form Wizard
        var form = $("#custom-form-wizard");
        // form.validate({
        //     errorPlacement: function errorPlacement(error, element) {
        //         element.after(error);
        //     },
        //     rules: {
        //         confirm: {
        //             equalTo : "#password"
        //         }
        //     }
        // });
        var url = window.location.href;
        var url_split = url.split('/');
        var enable = true, enableFinishButton = true;
        if (typeof url_split[3] !== 'undefined' && url_split[3] == 'add-employee') {
            var enable = false, enableFinishButton = false;

        }
        form.children(".wizard").steps({
            headerTag: ".wizard-section-title",
            bodyTag: ".wizard-section",
            enableAllSteps: enable,
            enableCancelButton: true,
            showFinishButtonAlways: enableFinishButton,
            labels: {
                previous: '<i class="fa fa-chevron-circle-left" aria-hidden="true"> Back</i>',
                next: '<i class="fa fa-chevron-circle-right" aria-hidden="true"> Next</i>',
                cancel: '<i class="fa fa-times" aria-hidden="true"> Cancel</i>',
                finish: '<i class="fa fa-floppy-o" aria-hidden="true"> Save</i>',
            },
            onInit: function (event, currentIndex) {
                console.log(currentIndex);
                $('a[href="#cancel"]').css('background-color','#f5393d !important');
                $('a[href="#finish"]').css('background-color','#c3d62d');
                // $('a[href="#next"]').css('background-color','#5b4c44');
            },
            onStepChanging: function(event, currentIndex, newIndex) {

                form.validate().settings.ignore = ":disabled,:hidden";
                return form.valid();
            },
            onFinishing: function(event, currentIndex) {
                form.validate().settings.ignore = ":disabled";
                return form.valid();
            },
            onCanceled: function(event, currentIndex) {
                window.location.assign("employee-manager");
            },
            onFinished: function(event, currentIndex) {
                event.preventDefault();
                var name = $('#name').val();
                var code = $('#code').val();
                var phone_number = $('#phone_number').val();
                var email = $('#email').val();
                var email_personal = $('#email_personal').val();
                var date_of_birth = $('#date_of_birth').val();
                var identify_id = $('#identify_id').val();
                var gender = $('#gender:checked').val();
                var get_married = $('#get_married:checked').val();
                var role_id = $('#role_id').val();
                var permanent_address = $('#permanent_address').val();
                var current_address = $('#current_address').val();
                var emergency_name = $('#emergency_name').val();
                var emergency_number = $('#emergency_number').val();
                var emergency_address = $('#emergency_address').val();
                var graduate_from = $('#graduate_from').val();
                var jobs_major = $('#jobs_major').val();
                var strong_points = $('#strong_points').val();
                var weak_points = $('#weak_points').val();
                var hobby = $('#hobby').val();
                var language_skills = $('#language_skills').val();
                var family_description = $('#family_description').val();
                var team_id = $('#team_id').val();
                var salary = $('#salary').val();
                var leave_days = $('#leave_days').val();
                var bank_name = $('#bank_name').val();
                var contract_code = $('#contract_code').val();
                var bank_account_number = $('#bank_account_number').val();
                var status = $('#status:checked').val();
                var document_submit = $('#document_submit:checked').val();
                var token = $('#token').val();
                var id_emp = $('#id_emp').val();

                // contract history
                var type = [];
                var date_to = [];
                var leader_review = [];
                var date_from = [];
                var contract_code = [];
                $('input[name="date_from"]').each(function(){
                    var kq = $(this).val();
                    date_from.push(kq);
                });
                $('input[name="date_to"]').each(function(){
                    var kq = $(this).val();
                    date_to.push(kq);
                });
                $('input[name="contract_code"]').each(function(){
                    var kq = $(this).val();
                    contract_code.push(kq);
                });

                $('select[name="type"]').each(function(){
                    var kq = $(this).val();
                    type.push(kq);
                });
                $('textarea[name="leader_review"]').each(function(){
                    var kq = $(this).val();
                    leader_review.push(kq);
                });

                var photo = document.getElementById('photo_upload');
                var formData = new FormData();

                if(photo.value != '') {
                    formData.append('photo', photo.files[0], photo.value);
                }
                formData.append('name', name);
                formData.append('code', code);
                formData.append('date_of_birth', date_of_birth);
                formData.append('email_personal', email_personal);
                formData.append('email', email);
                formData.append('phone_number', phone_number);                
                formData.append('identify_id', identify_id);
                formData.append('gender', gender);
                formData.append('get_married', get_married);
                formData.append('role_id', role_id);
                formData.append('permanent_address', permanent_address);
                formData.append('current_address', current_address);
                formData.append('emergency_name', emergency_name);
                formData.append('emergency_number', emergency_number);
                formData.append('emergency_address', emergency_address);
                formData.append('graduate_from', graduate_from);
                formData.append('jobs_major', jobs_major);
                formData.append('strong_points', strong_points);
                formData.append('weak_points', weak_points);
                formData.append('hobby', hobby);
                formData.append('language_skills', language_skills);
                formData.append('family_description', family_description);
                formData.append('bank_account_number', bank_account_number);
                formData.append('team_id', team_id);
                formData.append('salary', salary);
                formData.append('leave_days', leave_days);
                formData.append('bank_name', bank_name);
                formData.append('status', status);
                formData.append('document_submit', document_submit);
                // contract history
                formData.append('type', type);
                formData.append('date_from', date_from);
                formData.append('date_to', date_to);
                formData.append('leader_review', leader_review);

                formData.append('_token', token);
                formData.append('contract_code', contract_code);
                formData.append('id_emp', id_emp);

                console.log(formData);
                var url = $('#url').val();
                $.ajax({
                        type: 'POST',
                        url: '/'+ url,
                        data: formData,
                        contentType: false,
                        processData: false,
                        success: function (data) {
                            // console.log(data); die();
                            var parsed = JSON.parse(data);
                            if(parsed.status == 1){
                                $('.modal-footer button').hide();
                                $('.modal-footer a').show();
                            } else{
                                $('.modal-footer button').show();
                                $('.modal-footer a').hide();
                            }
                            $('#modal-header').attr('class', 'modal-header '+parsed.class);
                            $('.modal-title').html(parsed.title);
                            $('.modal-body').html(parsed.message);
                            $('#notification-modal').modal('show');
                        }
                });

            }
        });

        // Init Wizard
        var formWizard = $('.wizard');
        var formSteps = formWizard.find('.steps');

        $('.wizard-options .holder-style').on('click', function(e) {
            e.preventDefault();

            var stepStyle = $(this).data('steps-style');

            var stepRight = $('.holder-style[data-steps-style="steps-right"]');
            var stepLeft = $('.holder-style[data-steps-style="steps-left"]');
            var stepJustified = $('.holder-style[data-steps-style="steps-justified"]');

            if (stepStyle === "steps-left") {
                stepRight.removeClass('holder-active');
                stepJustified.removeClass('holder-active');
                formWizard.removeClass('steps-right steps-justified');
            }
            if (stepStyle === "steps-right") {
                stepLeft.removeClass('holder-active');
                stepJustified.removeClass('holder-active');
                formWizard.removeClass('steps-left steps-justified');
            }
            if (stepStyle === "steps-justified") {
                stepLeft.removeClass('holder-active');
                stepRight.removeClass('holder-active');
                formWizard.removeClass('steps-left steps-right');
            }

            if ($(this).hasClass('holder-active')) {
                formWizard.removeClass(stepStyle);
            } else {
                formWizard.addClass(stepStyle);
            }

            $(this).toggleClass('holder-active');
        });

        $(document).on('click', '.focus-email', function(){
            $('#notification-modal').modal('hide');
            $('ul[role="tablist"] li.first a').click();
            $('input[name="email"]').focus().css('border-color','red');
        });
    });

})(jQuery);
