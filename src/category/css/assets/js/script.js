$.ajaxSetup({
  headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
  }
});

$(document).ready(function () {

  var count = $('#count_project').val();
  $(document).on('click', '.btn-add-contract', function () {
    var html = `<div class="panel panel-default">
                        <div class="remove-contract"><i class="fa fa-times-circle" aria-hidden="true"></i></div>
                        <div class="panel-body">
                            <div class="col-md-6">
                                <div class="form-group">
                                <label>
                                <h6 class="mb5 mt10">Loại hợp đồng
                                </h6></label>
                                <label class="field select">
                                <select name="type" class="type" id="type">
                                    <option value="" selected="selected">Tất cả</option>
                                    <option value="tt">Thực tập</option>
                                    <option value="hv">Học việc</option>
                                    <option value="tv">Thử việc</option>
                                    <option value="1n">Chính thức 12 tháng</option>
                                    <option value="3n">Chính thức 36 tháng</option>
                                </select><i class="arrow double"></i></label></div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label><h6 class="mb5 mt10">Mã hợp đồng</h6></label>
                                    <input type="text" name="contract_code" id="contract_code" class="form-control" value="" >
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                <label>
                                    <h6 class="mb5 mt10">Từ ngày </h6></label>
                                    <label class="field prepend-icon">
                                        <input type="text" name="date_from" id="" class="form-control date1 date_from" value="" required="required">
                                        <label for="input002" class="field-icon">
                                            <i class="fa fa-calendar"></i>
                                        </label>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>
                                        <h6 class="mb5 mt10">Đến ngày </h6>
                                    </label>
                                    <label class="field prepend-icon">
                                    <input type="text" name="date_to" id="" class="form-control date1 date_to" value="" required="required">
                                    <label for="input002" class="field-icon">
                                        <i class="fa fa-calendar"></i>
                                    </label></label>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label><h6 class="mb5 mt10">Đánh giá</h6></label>
                                    <textarea name="leader_review" id="leader_review" class="form-control" rows="5"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>`;
    $('div#row-first').append(html);

    $(".date1").datepicker({
      prevText: '<i class="fa fa-chevron-left"></i>',
      nextText: '<i class="fa fa-chevron-right"></i>',
      showButtonPanel: false,
      dateFormat: "dd-mm-yy",
      changeMonth: true,
      changeYear: true,
      yearRange: '1970:2020',
      beforeShow: function (input, inst) {
        var newclass = 'allcp-form';
        var themeClass = $(this).parents('.allcp-form').attr('class');
        var smartpikr = inst.dpDiv.parent();
        if (!smartpikr.hasClass(themeClass)) {
          inst.dpDiv.wrap('<div class="' + themeClass + '"></div>');
        }
      }
    });
  });


  //appends html on click button add task report
  $(document).on('click', '.btn-add-report', function () {
    var id = $(this).attr('id');
    var option = '';
    var max = 0;
    $.get("/get-add-report/" + id, function (data) {
      if (data == '') {
        option = '<option value="0">Tất cả</option>';

      } else {
        option = '<option value="0">Tất cả</option>';
        $.each(data, function (index) {

          option += `
            <option value="` + data[index].id + `"> ` + data[index].task_name + `</option>
            `;
        });
      }
      $('.row[stt-id]').each(function (index, el) {
        // alert(index);
        var stt = $(this).attr('stt-id');
        if (stt > max) {
          max = stt;
        }
      });

      max++;
      console.log(option);
      var html = `
            <div class="row" stt-id="` + max + `">
                <div class="panel panel-default panel-primary">
                    <div class="remove-report">
                        <i class="fa fa-times-circle" aria-hidden="true"></i>
                    </div>
                    <div class="panel-body">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label><h6 class="mb5 mt10">Task dự án <i class="required" aria-required="true">*</i></h6></label>
                                    <select name="task_project[]" class="task-projects">
                                        ` + option + `
                                    </select>
                                    <label for="input002" class="error error-none">Không được để trống</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label><h6 class="mb5 mt10">Tên công việc <i class="required" aria-required="true">*</i></h6></label>
                                <label class="field prepend-icon">
                                    <input type="text" name="task_name[]" id="name" class="form-control" value="">
                                    <label for="input002" class="error error-none">Không được để trống</label>
                                    <label for="input002" class="field-icon">
                                        <i class="fa fa-tasks"></i>
                                    </label>
                                </label>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label><h6 class="mb5 mt10">Link công việc </h6></label>
                                <label class="field prepend-icon">
                                    <input type="text" name="link_task[]" id="name" class="form-control" value="">
                                    <label for="input002" class="error error-none">Không được để trống</label>
                                    <label for="input002" class="field-icon">
                                        <i class="fa fa-link"></i>
                                    </label>
                                </label>
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-group">
                                <label><h6 class="mb5 mt10">ETA (h) <i class="required" aria-required="true">*</i></h6></label>
                                <label class="field prepend-icon">
                                    <input type="number" name="working_hours_plan[]" id="working_hours_plan" class="form-control" value="" step="0.25">
                                    <label for="input002" class="error error-none">Không được để trống</label>
                                    <label for="input002" class="field-icon">
                                        <i class="fa fa-clock-o"></i>
                                    </label>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        `;
      $(html).insertAfter('.form-add-report .form-header');
      $('.task-projects').select2({
        placeholder: "Tất cả ",
        width: 'resolve'
      });
    });


  });

  //Remove contract item
  $(document).on('click', '.remove-contract', function () {
    var stt = $('#row-first .panel-default').length;
    // if(stt > 1){
    $(this).parent().remove();
    // } else{
    // 	alert('Không thể xóa!');
    // 	return false;
    // }
  });


  //Remove report item
  $(document).on('click', '.form-add-report .remove-report', function () {
    var stt = $('.form-add-report .row').length;
    if (stt > 2) {
      $(this).closest('.row').remove();
    } else {
      alert('Không thể xóa!');
      return false;
    }
  });

  // $('select[name="user_id"]').select2();

  $('[data-toggle="tooltip"]').tooltip();
  // leader confirm report
  $(document).on('click', 'a.rating', function () {
    var id = $(this).data('id');
    $('#confirmModal input[name="report_id"]').val(id);
  });

  //Timepicker leave
  $('#timepicker-from, #timepicker-to').bootstrapMaterialDatePicker({
    date: false,
    shortTime: false,
    format: 'HH:mm',
  });

  $('#time-from, #time-to').bootstrapMaterialDatePicker({
    date: false,
    shortTime: false,
    format: 'HH:mm',
  });
  //Change date working report
  $(document).on('change', '#report_date', function () {
    var date = $(this).val();
    var url = '/get-report-day';
    $.ajax({
      type: 'GET',
      url: url,
      data: {
        report_date: date
      },
      success: function (res) {
        console.log(res);
        if (res.status == 1) {
          var html = '';
          res.data.forEach(function (e) {
            if (e.working_hours_result == 0) {
              working_hours_result = e.working_hours_plan;
            } else {
              working_hours_result = e.working_hours_result;
            }
            var option = '';
            for (var i = 10; i >= 0; i--) {
              if (e.task_status == i * 10) {
                var selected = 'selected="selected"';
              } else {
                var selected = '';
              }
              option += '<option value="' + i * 10 + '" ' + selected + '>' + i * 10 + ' </option>';
            }

            if (e.name) {
              project_name = e.name;
            } else {
              project_name = 'Đang cập nhật';
            }

            var check_link_task = e.link_task;
            var link_task = "";
            if (check_link_task) {
              link_task = '<a target="_blank" href="' + e.link_task + '"><i class="fa fa-link" aria-hidden="true"></i></a>';
            } else {
              link_task = '';
            }
            html += `<tr>
                                    <input type="hidden" name="report_id[]" value="` + e.id + `">
                                    <input type="hidden" name="project_id[]" value="` + e.project_id + `">
                                    <td class="text-center">` + project_name + `</td>
                                    <td class="text-center">` + e.task_name + `</td>
                                    <td class="text-center">` + e.small_task_name + `</td>
                                    <td class="text-center">` + link_task + `</td>
                                    <td class="text-center">` + e.working_hours_plan + `</td>
                                    <td class="text-center">
                                        <label class="field prepend-icon spent">
                                            <input type="number" name="working_hours_result[]" id="nump_` + e.id + `" class="form-control" step="0.25" value="` + working_hours_result + `" required="required">
                                        </label>
                                    </td>
                                    <td class="text-center">
                                        <label class="field select">
                                            <select name="task_status[]" aria-invalid="false" class="valid">
                                                <option value="">Tất cả</option>`
              + option +
              `</select>
                                            <i class="arrow double"></i>
                                        </label>
                                    </td>
                                    <td>
                                      <input id="" data-toggle="toggle" type="checkbox" class="checkbox_cancel" data-id="` + e.id + `" >
                                      <input type="hidden" id="checkbox_` + e.id + `" name="cancel[]" value="2">
                                    </td>
                                    <td class="text-center">
                                        <textarea name="notes[]" id="notes" class="form-control" rows="2">` + e.notes + `</textarea>
                                    </td>
                                </tr>`;
          });
          $('.report-inner-html').html(html);
          $(function () {
            $('.checkbox_cancel').bootstrapToggle();
          })
          $('.checkbox_cancel').change(function () {

            var id = $(this).data('id');
            if ($('.checkbox_cancel').is(':checked')) {
              $('#checkbox_' + id).val('4');
              $("input[type='number']#nump_" + id).prop('readonly', true).val('0');

            } else {
              $('#checkbox_' + id).val('2');
              $("input[type='number']#nump_" + id).prop('readonly', false).val('0');
            }
            // console.log(id);

          });
        } else {
          html = '<tr><td colspan="9">Không có dữ liệu hiển thị...</td></tr>';
          $('.report-inner-html').html(html);
        }
      }
    });
  });

  //Remove report item
  $(document).on('click', '.form-add-task-project .remove-report', function () {
    // $(this).closest('.row').remove();
    var stt = $('.form-add-task-project .row').length;
    if (stt > 2) {
      $(this).closest('.row').remove();
    } else {
      alert('Không thể xóa!');
      return false;
    }
  });
  $(document).on('click', '#form-custom button.btn-add-task-project', function () {
    var id = $(this).data('id');
    // console.log(id);
    $.get("/get-member/" + id, function (data) {
      console.log(data);
      html = '';
      if (data == '') {
        $(".add_emp_id").html('');

      } else {

        // console.log(data);

        // html = '<option value="0">Chọn</option>';
        $.each(data, function (index) {
          html += `
                <option value="` + data[index].id + `">` + data[index].name + `</option>
                `;
          $(".add_emp_id").html(html);
        });

      }
    });
    var option = $('select[name="task_project[emp_id][`+max+`][]"]').html();
    var max = 0;
    $('.form-add-task-project > .row').each(function () {
      var stt = $(this).data('stt');
      if (stt > max) {
        max = stt;
      }
    });
    max++;
    var html = `<div class="row" data-stt="` + max + `">
                        <div class="panel panel-default panel-primary">
                            <div class="remove-report">
                                <i class="fa fa-times-circle" aria-hidden="true"></i>
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label">
                                              <h6 class="mb5 mt10">Tên task <span class="required">*</span>  </h6>
                                            </label>
                                            <label class="field prepend-icon">
                                                <input type="text" name="task_project[task_name][` + count + `]" class="form-control task-name" value="" required="required">
                                                <input type="hidden" name="task_project[edit_id][]" value="" />
                                                <label for="input002" class="error error-none">Không được để trống</label>
                                                <label for="input002" class="field-icon">
                                                    <i class="fa fa-tasks"></i>
                                                </label>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label">
                                              <h6 class="mb5 mt10">Link task  </h6>
                                            </label>
                                            <label class="field prepend-icon">
                                                <input type="text" name="task_project[link_task][]" id="name" class="form-control" value="">
                                                <label for="input002" class="error error-none">Không được để trống</label>
                                                <label for="input002" class="field-icon">
                                                    <i class="fa fa-link" aria-hidden="true"></i>
                                                </label>
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label">
                                              <h6 class="mb5 mt10">Từ ngày </h6>
                                            </label>
                                            <label class="field prepend-icon">
                                                <input type="text" name="task_project[task_date_from][]" id="" class="form-control datepickerhai" value="">
                                                <label for="input002" class="field-icon">
                                                    <i class="fa fa-calendar"></i>
                                                </label>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label">
                                              <h6 class="mb5 mt10">Đến ngày   </h6>
                                            </label>
                                            <label class="field prepend-icon">
                                                <input type="text" name="task_project[task_date_to][]" id="" class="form-control datepickerhai" value="" >
                                                <label for="input002" class="field-icon">
                                                    <i class="fa fa-calendar"></i>
                                                </label>
                                            </label>
                                        </div>
                                    </div>



                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label">
                                              <h6 class="mb5 mt10">ETA (h) </h6>
                                            </label>
                                            <label class="field prepend-icon">
                                                <input type="number" name="task_project[working_hours_plan][]" id="working_hours_plan" class="form-control" value="{{ (isset($task_project->working_hours_plan) && $task_project->working_hours_plan) ? $task_project->working_hours_plan : NULL}}" step="0.25" >
                                                <label for="input002" class="error error-none">Không được để trống</label>
                                                <label for="input002" class="field-icon">
                                                    <i class="fa fa-clock-o"></i>
                                                </label>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>`;
    $('.form-add-task-project').prepend(html);

    $('#edit-form input[name^="task_project[task_name]"]').rules("add", {
      required: true,
      messages: {
        required: "Không được bỏ trống"
      }
    });

    $('.form-add-task-project .datepickerhai').each(function () {
      if (!$(this).val()) {
        $(this).datepicker({
          prevText: '<i class="fa fa-chevron-left"></i>',
          nextText: '<i class="fa fa-chevron-right"></i>',
          showButtonPanel: false,
          dateFormat: "dd-mm-yy",
        }).datepicker("setDate", new Date());
      }
    })

    $(".add-emp-to-task-project").select2({
      'placeholder': 'Tất cả',
      'width': '100%'
    });
    $(".datepicker1").datepicker({
      prevText: '<i class="fa fa-chevron-left"></i>',
      nextText: '<i class="fa fa-chevron-right"></i>',
      showButtonPanel: false,
      dateFormat: "dd-mm-yy",
      beforeShow: function (input, inst) {
        var newclass = 'allcp-form';
        var themeClass = $(this).parents('.allcp-form').attr('class');
        var smartpikr = inst.dpDiv.parent();
        if (!smartpikr.hasClass(themeClass)) {
          inst.dpDiv.wrap('<div class="' + themeClass + '"></div>');
        }
      }
    });
    $(".datepickerhai").datepicker({
      prevText: '<i class="fa fa-chevron-left"></i>',
      nextText: '<i class="fa fa-chevron-right"></i>',
      showButtonPanel: false,
      dateFormat: "dd-mm-yy",
      // beforeShow: function(input, inst) {
      //     var newclass = 'allcp-form';
      //     var themeClass = $(this).parents('.allcp-form').attr('class');
      //     var smartpikr = inst.dpDiv.parent();
      //     if (!smartpikr.hasClass(themeClass)) {
      //         inst.dpDiv.wrap('<div class="' + themeClass + '"></div>');
      //     }
      // }
    });
    count++;
  });
  //Validate form add project
  var form = $('.form-validate-hai');
  $('.nav-tabs a').click(function () {
    var link_to = $(this).attr('href');
    // link_to = link_to.replace('#','');

    form.valid();
    if (form.valid()) {
      $('.nav-tabs li').removeClass('active');
      $(this).parent().addClass('active');
      $('.tab-content > div').removeClass('in active');
      $('.tab-content ' + link_to).addClass('in active');
    }

  });

  var module_selectBox = "Chọn";

  $(".add-emp-to-task-project").select2({
    'placeholder': module_selectBox,
    'width': '100%'
  });


  $(".js-example-basic-multiple").select2({
    'placeholder': module_selectBox,
  });

  $(".js-example-basic-multiple-mot").select2({
    'placeholder': module_selectBox,
  });

  $(".js-example-basic-multiple-mot.cskh-type").select2({
    'placeholder': module_selectBox
  });

  $(".js-example-basic-multiple.vip").select2({
    'placeholder': module_selectBox
  });

  $(".search").select2();

  $("#program_id").change(function () {
    var id = $(this).val();
    // alert(id);
    if (id) {
      $.get("list-program-teacher/" + id, function (data) {
        console.log(data.name);
        $("#showteacher").val(data.name);
      });
    } else {
      $("#showteacher").val('');
    }
  });

  $(".btn-select").click(function (event) {
    var student = $("#student_id").val();
    var program = $("#program_id").val();
    // alert(student);
    // alert(program);
    if (student == null && program == "") {

      $('.select-error').html('Không được để trống').removeClass('hidden').css({
        'color': 'red',
        'font-size': '12px',
      });
      $('.select-error-hai').html('Không được để trống').removeClass('hidden').css({
        'color': 'red',
        'font-size': '12px',
      });

      // return  false;
      event.preventDefault();
    } else if (student != null && program == "") {
      $('.select-error').addClass('hidden');
      $('.select-error-hai').html('Không được để trống').removeClass('hidden').css({
        'color': 'red',
        'font-size': '12px',
      });
      // return  false;
      event.preventDefault();
    } else if (student == null && program != "") {
      $('.select-error').html('Không được để trống').removeClass('hidden').css({
        'color': 'red',
        'font-size': '12px',
      });
      $('.select-error-hai').addClass('hidden');
      // return  false;
      event.preventDefault();
    }

  });

  $("#student_id").change(function () {
    var student = $("#student_id").val();
    if (student == null) {
      $('.select-error').html('Không được để trống').removeClass('hidden').css({
        'color': 'red',
        'font-size': '12px',
      });
    } else {
      $('.select-error').addClass('hidden');
    }
  });

  $("#program_id").change(function () {
    var program = $("#program_id").val();
    if (program == "") {
      $('.select-error-hai').html('Không được để trống').removeClass('hidden').css({
        'color': 'red',
        'font-size': '12px',
      });
    } else {
      $('.select-error-hai').addClass('hidden');
    }
  });


  $(".btn-select-hai").click(function (event) {
    // alert('msg');
    $emp = $("#emp_id").val();
    // alert($emp == null);
    if ($emp == null) {
      $('.duuocchon').html('Không được để trống').removeClass('hidden').css({
        'color': 'red',
        'font-size': '12px',
      });
    }

  });

  $("#emp_id").change(function () {
    $emp = $("#emp_id").val();
    // alert($emp == null);
    if ($emp == null) {
      $('.duuocchon').html('Không được để trống').removeClass('hidden').css({
        'color': 'red',
        'font-size': '12px',
      });
    } else {
      $('.duuocchon').addClass('hidden')
    }
  });

  $("table:not(.table-my-report)").tablesorter({
    dateFormat: "ddmmyyyy",
    headers: {
      '.thaotac': {
        sorter: false,
      },
      '.date': {
        sorter: "shortDate",
      }
    }
  });

  $('.approvedChange').click(function () {
    var id = $(this).data('id');
    // alert(id);
    $.get("get-approved-report/" + id, function (data) {
      console.log(data.id);
      $('#button_' + data.id).removeClass('btn-primary').addClass('btn-success');
      $('#button_' + data.id + ' i').html('Đã phê duyệt');
      $('#menu_' + data.id).addClass('hidden');

      // alert( "Load was performed." );
    });
  });

  // $('.approveOT').click(function () {
  //     var id = $(this).data('id');
  //     var status = $(this).data('status');
  //     var menu = '';
  //     $.get( "get-approved-overtime/" + id + "/" + status, function( data ) {
  //         console.log(data.id);
  //         console.log(data.status);
  //         if (data.status == 1){
  //             menu = '<li>\n' +
  //                 '<a href="javascript:void(0)" class="making-payment-ot" data-id="'+data.id+'">Quyết toán</a>\n' +
  //                 '</li>\n';
  //             $('#ot_'+ data.id).attr('id', 'making-payment-'+ data.id);
  //             $('#making-payment-'+ data.id).removeClass('btn-info ').addClass('btn-success').html('Chấp nhận <span class="caret ml5"></span>');
  //             $('#menu_'+ data.id).html(menu).parent( ".open" ).removeClass('open');
  //         }else if (data.status == 2){
  //             $('#ot_'+ data.id).removeClass('btn-info').addClass('btn-danger').html('<i class="fa fa-times"> Từ chối </i>');
  //             // $('#button_'+ data.id);
  //             $('#menu_'+ data.id).addClass('hidden');
  //         }
  //
  //
  //         // alert( "Load was performed." );
  //     });
  // });

  // $('.making-payment-ot').click(function () {
  //
  // });

  $(".approveOT").on("click", function () {
    var id = $(this).data('id');
    var status = $(this).data('status');
    var html = '';
    $.get("get-approved-overtime/" + id + "/" + status, function (data) {
      console.log(data.id);
      console.log(data.status);
      if (data.status == 2) {
        $('#ot_' + data.id).removeClass('btn-info').addClass('btn-success').html('<i class="fa fa-check"> Chấp nhận </i>');
        $('#menu_' + data.id).addClass('hidden');
      } else if (data.status == 3) {
        $('#ot_' + data.id).removeClass('btn-info').addClass('btn-danger').html('<i class="fa fa-times"> Từ chối </i>');
        // $('#button_'+ data.id);
        $('#menu_' + data.id).addClass('hidden');
      }
    });
  });

  //delegate là bắt sự kiên những thằng sinh ra từ html của ajax để bắt sự kiện click tiếp cho nó
  $(".making-payment-ot").on("click", function () {

    var id = $(this).data('id');
    // var status = $(this).data('status');
    $.get("get-making-payment-ot/" + id, function (data) {
      console.log(data);
      if (data) {
        $('#making-payment-' + data).removeClass('btn-success').addClass('btn-warning').html('<i class="fa fa-check-square-o" aria-hidden="true">Quyết toán</i>');
        $('#menu_' + data).addClass('hidden');
      } else {
        console.log('không có id');
      }
      // alert( "Load was performed." );
    });
  });


  $('.evaluation').click(function () {
    var id = $(this).data('id');
    // alert(id);
    $("#evaluate_" + id).modal('show');
  });

  $('.view-report').click(function () {
    var id = $(this).data('id');
    // alert(id);
    $("#report_" + id).modal('show');
  });

  $('.checkbox_cancel').change(function () {

    var id = $(this).data('id');
    if ($('.checkbox_cancel').is(':checked')) {
      $('#checkbox_' + id).val('4');
      $("input[type='number']#nump_" + id).prop('readonly', true).val('0');

    } else {
      $('#checkbox_' + id).val('2');
      $("input[type='number']#nump_" + id).prop('readonly', false).val('0');
    }
    // console.log(id);

  });

  $('.get-task-project').change(function () {
    var id = $(this).val();
    // console.log(id);
    $(".btn-add-report").attr('id', id);
    $.get("/get-task-project/" + id, function (data) {
      // console.log(data);
      html = '';
      if (data == '') {
        $(".task-projects").html('<option value="0">Tất cả</option>');

      } else {
        // console.log(data);

        html = '<option value="0">Tất cả</option>';
        $.each(data, function (index) {

          html += `
            <option value="` + data[index].id + `"> ` + data[index].task_name + `</option>
            `;
          $(".task-projects").html(html);

        });
      }
    });
  });

  $('.project_edit').change(function (event) {
    var id = $(this).val();
    $.get("/get-project_edit/" + id, function (data) {
      html = '';
      if (data == '') {
        $(".task-projects-hai").html('<option value="">Tất cả</option>');

      } else {

        // console.log(data);

        html = '<option value="">Tất cả</option>';
        $.each(data, function (index) {
          html += `
            <option value="` + data[index].id + `">` + data[index].task_name + `</option>
            `;
          $(".task-projects-hai").html(html);
        });

      }
    });
  });

  $(document).on('change', '.task-projects', function (event) {
    var id = $(this).val();
    var stt = $(this).closest('.row').attr('stt-id');

    $.get("/get-linktask-project/" + id + "/" + stt, function (data) {
      $('.row[stt-id="' + data.stt + '"]').find('input[name="link_task[]"]').val(data.link_task);
    });
  });

  $(document).on('change', '.task-projects-hai', function (event) {
    var id = $(this).val();

    $.get("/get-linktask-project-edit/" + id, function (data) {
      // console.log(data);
      if (data == '') {
        $('input[name="link_task"]').val('');
      } else {
        $('input[name="link_task"]').val(data.link_task);
      }
    });
  });

  $(".list-project").click(function (event) {
    var id = $(this).data('id');
    // alert(id);
    $("#em_" + id).modal('show');
  });

  $(".list-task-project").click(function (event) {
    var id = $(this).data('id');
    // alert(id);
    $("#task_project_" + id).modal('show');
  });

  $(".btn-nhap-ba").click(function (event) {
    var id = [];
    id = $('.row').attr('stt-id');
    console.log(id);
  });

  var datefrom = $('#date_from');
  var dateto = $('#date_to');

  var dayfrom = $('#day_date_from');
  var dayto = $('#day_date_to');

  var phases_dayfrom = $('#phases_date_from');
  var phase_dayto = $('#phases_date_to');

  var task_dayfrom = $('#task_date_from');
  var task_dayto = $('#task_date_to');

  $('chon-ngay').change(function (event) {
    var start = moment("17-01-2018 5:40", "DD-MM-YYYY HH:mm"); //todays date
    var end = moment("30-01-2018 12:15", "DD-MM-YYYY HH:mm"); // another date
    if (end.isAfter(start)) {
      var duration = moment.duration(end.diff(start));
      var days = duration.asDays();
      var a = (days - parseInt(days)) * 24;
      console.log(a);
      $('#working_hours_plan').val(days);

    }
  });


  function getdatehai() {
    if (dateto.val() && datefrom.val()) {
      var start = moment(datefrom.val(), "DD-MM-YYYY HH:mm");
      var end = moment(dateto.val(), "DD-MM-YYYY HH:mm"); // another date
      if (start.isAfter(end)) {
        $("#error_modal").modal();
        $('#working_hours_plan').val('');
        datefrom.val('');
        dateto.val('');
        $('.btn.btn-primary').prop('disabled', true);
      } else {
        var duration = moment.duration(end.diff(start));
        var days = duration.asDays() + 1;
        var a = days * 8;
        $('#working_hours_plan').val(a);
        $('.btn.btn-primary').prop('disabled', false);
      }
    }
  }

  function getdateba() {
    if (dayto.val() && dayfrom.val()) {
      var start = moment(dayfrom.val(), "DD-MM-YYYY HH:mm");
      var end = moment(dayto.val(), "DD-MM-YYYY HH:mm"); // another date
      if (start.isAfter(end)) {
        $("#error_modal").modal();
        $('#working_hours_plan').val('');
        dayfrom.val('');
        dayto.val('');
        // $('.btn.btn-primary').prop('disabled', true);
      } else {
        var duration = moment.duration(end.diff(start));

        var days = duration.asDays() + 1;
        $('#working_hours_plan').val(days);
        // $('.btn.btn-primary').prop('disabled', false);
      }
    }
  }

  function getdatebon() {
    if (phase_dayto.val() && phases_dayfrom.val()) {
      var start = moment(phases_dayfrom.val(), "DD-MM-YYYY HH:mm");
      var end = moment(phase_dayto.val(), "DD-MM-YYYY HH:mm"); // another date
      if (start.isAfter(end)) {
        $("#error_modal").modal();
        $('#add-phases .suatext').val('');
        phases_dayfrom.val('');
        phase_dayto.val('');
        // $('.btn.btn-primary').prop('disabled', true);
      } else {
        var duration = moment.duration(end.diff(start));

        var days = duration.asDays() + 1;
        $('#add-phases .suatext').val(days);
        // $('.btn.btn-primary').prop('disabled', false);
      }
    }
  }

  function getdatenam() {
    if (task_dayto.val() && task_dayfrom.val()) {
      var start = moment(task_dayfrom.val(), "DD-MM-YYYY HH:mm");
      var end = moment(task_dayto.val(), "DD-MM-YYYY HH:mm"); // another date
      if (start.isAfter(end)) {
        $("#error_modal").modal();
        $('.modal-lg-task .suatext').val('');
        task_dayfrom.val('');
        task_dayto.val('');
        // $('.btn.btn-primary').prop('disabled', true);
      } else {
        var duration = moment.duration(end.diff(start));

        var days = duration.asDays() + 1;
        $('.modal-lg-task .suatext').val(days);
        // $('.btn.btn-primary').prop('disabled', false);
      }
    }
  }

  datefrom.on('change', function () {
    getdatehai();
  });

  dateto.on('change', function () {
    getdatehai();
  });

  dayfrom.on('change', function () {
    getdateba();
  });

  dayto.on('change', function () {
    getdateba();
  });

  phases_dayfrom.on('change', function () {
    getdatebon();
  });

  phase_dayto.on('change', function () {
    getdatebon();
  });

  task_dayfrom.on('change', function () {
    getdatenam();
  });

  task_dayto.on('change', function () {
    getdatenam();
  });

  function getdateemployee(from, to) {
    var start = moment($(from).val(), "DD-MM-YYYY");
    var end = moment($(to).val(), "DD-MM-YYYY"); // another date
    if (start.isAfter(end)) {
      return false;
    }
    return true;
  }

  $('body').on('change', '.date_from, .date_to', function () {
    var check = true;
    $('.date_from').each(function (i, from) {
      var to = $(from).closest('.panel-body').find('.date_to');
      if ($(from).val() && $(to).val()) {
        if (!getdateemployee(from, to)) {
          $("#error_modal").modal();
          $(from).val('');
          $(to).val('');
          check = false;

        }
      }
    });
  });

  $('.task-projects').select2({
    placeholder: "Tất cả",
    width: 'resolve'
  });

  $(document).ready(function () {
    $('#manager_id').select2({
      placeholder: "Tất cả",
      width: 'resolve'
    });
  });

  $('.task-projects-hai').select2({
    placeholder: "Tất cả",
    width: 'resolve'
  });
  $('.select-ngay').on('change', function () {
    var id = $(this).val();
    if (!id) {
      id = 0;
    }
    $.get("/select-date/" + id, function (data) {
      if (data) {
        $("#date_to").val(data.date_to);
        $("#date_from").val(data.date_from);
      } else {
        console.log("không tồn tại dữ liệu");
      }
    });
  });


  $("#date1").datepicker({
    prevText: '<i class="fa fa-chevron-left"></i>',
    nextText: '<i class="fa fa-chevron-right"></i>',
    showButtonPanel: false,
    dateFormat: 'dd-mm-yy',
    beforeShow: function (input, inst) {
      var newclass = 'allcp-form';
      var themeClass = $(this).parents('.allcp-form').attr('class');
      var smartpikr = inst.dpDiv.parent();
      if (!smartpikr.hasClass(themeClass)) {
        inst.dpDiv.wrap('<div class="' + themeClass + '"></div>');
      }
    }
  });

  $("#date4").datepicker({
    prevText: '<i class="fa fa-chevron-left"></i>',
    nextText: '<i class="fa fa-chevron-right"></i>',
    showButtonPanel: false,
    dateFormat: 'dd-mm-yy',
    beforeShow: function (input, inst) {
      var newclass = 'allcp-form';
      var themeClass = $(this).parents('.allcp-form').attr('class');
      var smartpikr = inst.dpDiv.parent();
      if (!smartpikr.hasClass(themeClass)) {
        inst.dpDiv.wrap('<div class="' + themeClass + '"></div>');
      }
    }
  });

  var dateot = $('#date-ot');
  var timefromot = $('#time-from');
  var timetoot = $('#time-to');

  function getdateot() {
    if (dateot.val() && timefromot.val() && timetoot.val()) {
      var start = moment(dateot.val() + ' ' + timefromot.val(), "DD-MM-YYYY HH:mm");
      var end = moment(dateot.val() + ' ' + timetoot.val(), "DD-MM-YYYY HH:mm"); // another date
      var duration = moment.duration(end.diff(start));
      var days = duration.asDays();
      var hour = (days - parseInt(days)) * 24;
      var time = hour + parseInt(days) * 8;
      console.log(time.toFixed(2));

      if (parseInt(time) > 0) {
        $('#total_days').val(parseInt(time) + ' giờ ' + Math.round((time - parseInt(time)) * 60) + ' phút');
        $('#total_days_hai').val(time);
        $('.btn.btn-primary').prop('disabled', false);
      } else if (parseInt(time) == 0) {
        $('#total_days').val(Math.round((time - parseInt(time)) * 60) + ' phút');
        $('#total_days_hai').val(time);
        $('.btn.btn-primary').prop('disabled', false);
      } else {
        $("#error_modal_time").modal();
        $('#total_days').val('');
        $('#total_days_hai').val('');
        $(timefromot).val('08:30');
        $(timetoot).val('18:00');
        $('.btn.btn-primary').prop('disabled', true);
      }
    }

  }


  // date4.on('change', function () {
  //     getdateot();
  // });

  timetoot.on('change', function () {
    getdateot();
  });

  dateot.on('change', function () {
    getdateot();
  });

  timefromot.on('change', function () {
    getdateot();
  });

  $('#select-all').click(function (event) {
    if (this.checked) {
      $(':checkbox').prop('checked', true);
    } else {
      $(':checkbox').prop('checked', false);
    }
  });

  $("#inspection").click(function () {
    var arr = [];
    var id = "";
    $("input[name='checkked']").each(function () {
      id = $(this).data('id');

      if ($(this).is(':checked')) {
        if ($(this).prop("disabled") == false) {
          arr.push(id)
        }
      }
    });
    $.ajax({
      url: '/get-inspection-all',
      type: 'POST',
      data: {
        id: arr,
      }
    }).done(function (data) {
      jQuery.each(data, function (index, item) {
        $("#select-all").prop('checked', false);
        $("#checkbox_" + item).addClass('hidden');
        $('#button_' + item).removeClass('btn-primary').addClass('btn-success');
        $('#button_' + item + ' i').html('Đã phê duyệt');
        $('#menu_' + item).addClass('hidden');
      });
      $('#hidden-all').addClass('hidden');
      $('#alert-success').removeClass('hidden').html('Phê duyệt báo cáo công việc thành công');
    });

  });

  $("#del-report").click(function () {
    var arr = [];
    var id = "";
    $("input[name='check_del']").each(function () {
      id = $(this).data('id');

      if ($(this).is(':checked')) {
        arr.push(id);
      }
    });
    if (confirm("Bạn có chắc chắn muốn xóa tất cả?")) {
      $.ajax({
        url: '/get-checkdel-report',
        type: 'POST',
        data: {
          id: arr,
        }
      }).done(function (data) {
        jQuery.each(data, function (index, item) {
          $("#select-all").prop('checked', false);
          $("#row_" + item).addClass('hidden');
        });
        $('#hidden-all-hai').addClass('hidden');
        $('#alert-success').removeClass('hidden').html('Xóa báo cáo công việc thành công');
      });
    }
    return false;


  });


  $("#del-emp").click(function () {
    var arr = [];
    var id = "";
    $("input[name='check_del']").each(function () {
      id = $(this).data('id');

      if ($(this).is(':checked')) {
        arr.push(id);
      }

    });
    if (confirm("Bạn có chắc chắn muốn xóa tất cả?")) {
      $.ajax({
        url: '/get-checkdel-emp',
        type: 'POST',
        data: {
          id: arr,
        }
      }).done(function (data) {
        jQuery.each(data, function (index, item) {
          $("#select-all").prop('checked', false);
          $("#row_" + item).addClass('hidden');
        });
        $('#hidden-all-hai').addClass('hidden');
        $('#alert-success').removeClass('hidden').html('Xóa báo cáo công việc thành công');
      });
    }
    return false;

  });

  $("#del-projects").click(function () {
    var arr = [];
    var id = "";
    $("input[name='check_del']").each(function () {
      id = $(this).data('id');

      if ($(this).is(':checked')) {
        arr.push(id);
      }

    });
    if (confirm("Bạn có chắc chắn muốn xóa tất cả?")) {
      $.ajax({
        url: '/get-checkdel-project',
        type: 'POST',
        data: {
          id: arr,
        }
      }).done(function (data) {
        jQuery.each(data, function (index, item) {
          $("#select-all").prop('checked', false);
          $("#row_" + item).addClass('hidden');
        });
        $('#hidden-all-hai').addClass('hidden');
        $('#alert-success').removeClass('hidden').html('Xóa báo cáo công việc thành công');
      });
    }
    return false;

  });

  $("#del-leave").click(function () {
    var arr = [];
    var id = "";
    $("input[name='check_del']").each(function () {
      id = $(this).data('id');

      if ($(this).is(':checked')) {
        arr.push(id);
      }

    });
    console.log(arr);
    if (confirm("Bạn có chắc chắn muốn xóa tất cả?")) {
      $.ajax({
        url: '/get-checkdel-leave',
        type: 'POST',
        data: {
          id: arr,
        }
      }).done(function (data) {
        jQuery.each(data, function (index, item) {
          $("#select-all").prop('checked', false);
          $("#row_" + item).addClass('hidden');
        });
        $('#hidden-all-hai').addClass('hidden');
        $('#alert-success').removeClass('hidden').html('Xóa báo cáo công việc thành công');
      });
    }
    return false;

  });


  $('input[name=\'checkked\']').click(function () {
    var len = $("input[name='checkked']:checked").length;
    if (len === 0) {
      $('#hidden-all').addClass('hidden');
    } else {
      $('#hidden-all').removeClass('hidden');
    }
  });

  $('input[name=\'check_del\']').click(function () {
    var len = $("input[name='check_del']:checked").length;
    if (len === 0) {
      $('#hidden-all-hai').addClass('hidden');
    } else {
      $('#hidden-all-hai').removeClass('hidden');
    }
  });

  $('#select-all').click(function () {
    var len = $("input[name='checkked']:checked").length;
    var len_hai = $("input[name='check_del']:checked").length;
    if (len == 0) {
      $('#hidden-all').addClass('hidden');
    } else {
      $('#hidden-all').removeClass('hidden');
    }

    if (len_hai === 0) {
      $('#hidden-all-hai').addClass('hidden');
    } else {
      $('#hidden-all-hai').removeClass('hidden');
    }
  });

  $('.cancelapproveClick').click(function () {
    var leaveId = $(this).data('id');
    var type = $(this).data('status');
    $('#od_status').val(type);
    $('#status-message').empty();
    $('#remark-text').val('');
    $('#ot_id').val(leaveId);
    $('#remarkModalhai').modal('show');

  });

  $('#proceed-button-hai').click(function () {
    $('#loader').removeClass('hidden');
    console.log('please wait processing...');
    var remarks   = $('#remark-text').val();
    console.log('remarks ' + remarks);
    var leave_id  = $('#ot_id').val();
    var token     = $('#token').val();

    var message     = 'Từ chối đơn nghỉ phép';
    var divClass    = 'alert-danger';
    var url         = '/disapprove-ovetime';
    var buttonText  = 'Từ chối';
    var buttonClass = 'btn-danger';
    var buttonIcon  = 'fa-times';

    $.post(url, {'id': leave_id, 'remarks': remarks}, function (data) {
      $('#loader').addClass('hidden');
      console.log();
      var statusmessage = $('#status-message');
      statusmessage.append("<div class='alert " + divClass + "'>" + message + "</div>");
      statusmessage.removeClass('hidden');
      var remarks_div   = $('#remark-' + data.id);
      remarks_div.html(data.reason);
      var leavebutton   = $('#button-' + data.id);
      leavebutton.empty();
      $('#ot_' + data.id).addClass('btn-danger').removeClass('btn-info').html('<i class="fa fa-times"> Từ chối </i>');
      $('#menu_' + data.id).addClass('hidden');
      leavebutton.append("<button type='button' class='btn " + buttonClass + " br2 btn-xs fs12' aria-expanded='false'><i class='fa " + buttonIcon + "'>" + buttonText + "</i> </button>");
      setTimeout(function () {
        $('#remarkModalhai').modal('hide');
      }, 1000);
    });
  });

  $('.proceed-button-ba').click(function () {
    var report_id = $(this).attr('id');
    var remarks = $('#leader_confirm_' + report_id).val();
    var porn_id = $('input[name=point]:checked').val();
    $('.loader-hinhanh').removeClass('hidden');
    console.log('please wait processing...');
    console.log('remarks ' + remarks);
    console.log(report_id);
    console.log(porn_id);
    var message     = 'Đánh giá công việc thành công';
    var divClass    = 'alert-success';
    var url         = '/get-approved-reports';
    var buttonText  = 'Xem đánh giá';
    var buttonClass = 'btn-success';
    var buttonIcon  = 'fa-times';

    $.post(url, {'id': report_id, 'remarks': remarks, 'porn_id': porn_id}, function (data) {
      if (data) {
        $('.loader-hinhanh').addClass('hidden');
        var statusmessage = $('.status-message');
        statusmessage.html("<div class='alert " + divClass + "'>" + message + "</div>");
        statusmessage.removeClass('hidden');
        var remarks_div = $('#remark-' + data.id);
        remarks_div.html(data.leader_confirm);
        var leavebutton = $('#button_' + data.id);
        leavebutton.empty();
        $('#menu_' + data.id).addClass('hidden');
        leavebutton.removeClass('btn-purple').addClass('btn-warning').attr({
          'data-toggle': "modal",
          'data-target': "#evaluate_" + data.id,
        }).html('<i class="fa fa-external-link"> Xem Đánh giá </i>');
        setTimeout(function () {
          $('#evaluate_' + data.id).modal('hide');
          $('.proceed-' + data.id).addClass('hidden');
          $('.check' + data.id).addClass('hidden');
          $('#pornt-check_' + data.id).html('<p>' + porn_id + '</p>');
          $('#leader_confirm_' + data.id).addClass('hidden');
          $('#textarea_' + data.id).html(remarks);
          statusmessage.addClass('hidden');
        }, 1000);
      }
    });
  });

  $("#tab2 #btn-edit").on('click', function () {
    setTimeout(function () {
      $("#tab2 #btn-edit").fadeOut();
      $("#tab2 .panel1").fadeOut();
    }, 300);
    setTimeout(function () {
      $("#tab2 .panel2").fadeIn();
      $("#tab2 .btn-show").fadeIn();
    }, 700);
  });

  $('.search-members').on('keyup', function () {
    var text        = $(this).val();
    var id_leader   = $("#id_leader").val();
    var id_coders   = $("#id_coder").val();
    var id_projects = $("#id_project").val();
    var data        = {};
    data.text       = text;
    data.leader_id  = id_leader;
    data.project_id = id_projects;
    var parent      = $(this).closest('.dropdown');
    var type        = parent.find('ul.user-add').data('type');

    data.type       = type;
    data.coder_id   = id_coders;
    var url         = '/ajax/seach-members';

    $.post(url, data)
      .done(function (data) {
        if (data) {
          parent.find('ul.user-add').html(data);
        }
      });
  });

  $('.search-members-phases').on('keyup', function () {
    var text        = $(this).val();
    var id          = $(this).data('id');
    var project_id  = $(this).data('project');
    var id_coders   = $('#coder_phases_' + id).val();
    var id_phases   = $("#id_phases").val();

    var data        = {};
    data.text       = text;
    data.project_id = project_id;
    data.phases_id  = id_phases;
    var parent      = $(this).closest('.dropdown');
    data.coder_id   = id_coders;
    var url         = '/ajax/seach-phases-members';

    $.post(url, data)
      .done(function (data) {
        if (data) {
          parent.find('ul.user-add-phases').html(data);
        }
      });
  });


  $('*').delegate('.user-add li', 'click', function () {
    // var data = {};
    var id        = $(this).find('.add-user-click').data('id');
    var pro_id    = $(this).find('.add-user-click').data('type');
    var code_id   = $('#id_coder').val();
    var arr_code  = code_id.split(',');

    if (jQuery.inArray(id.toString(), arr_code) == -1) {
      $('#id_coder').val(code_id + ',' + id);
      $(this).find('.add-user-click').append('<span class="glyphicon glyphicon-ok pull-right"></span>');
      var url = '/ajax/add-coder/';
      $.get(url + id, function (data) {
        if (data) {
          $('.panel2 .add-coder').append(data);
        }
      });

    } else {
      $('#id_coder').val(code_id.toString().replace(',' + id, ''));
      $(this).find(".add-user-click .glyphicon.glyphicon-ok.pull-right").remove();
      $('#add_user_' + id).remove();
    }

  });

  $('*').delegate('.user-add-phases li', 'click', function () {
    // var data = {};
    var id        = $(this).find('.add-phases-click').data('id');
    var phases_id = $(this).find('.add-phases-click').data('type');
    var code_id   = $('#coder_phases_' + phases_id).val();
    var arr_code  = code_id.split(',');
    var parent    = $(this).closest('#add_phases_' + phases_id);

    if (jQuery.inArray(id.toString(), arr_code) == -1) {

      $('#coder_phases_' + phases_id).val(code_id + ',' + id);
      $(this).find('.add-phases-click').append('<span class="glyphicon glyphicon-ok pull-right"></span>');

      var url = '/ajax/add-phases-coder/';

      $.get(url + id, function (data) {
        if (data) {
          parent.find('.list-performer').append(data);
        }
      });

    } else {
      $('#coder_phases_' + phases_id).val(code_id.toString().replace(',' + id, ''));
      $(this).find(".add-phases-click .glyphicon.glyphicon-ok.pull-right").remove();
      parent.find('#performer_' + id).remove();
    }

  });

  $('body').delegate(' .click-add-phases', 'click', function () {
    var btn   = $(this);
    var id    = $(this).data('id');
    var data  = {};
    $("#loadings").fadeIn();
    if (id) {

      var parent    = $(this).closest('#add_phases_' + id);

      var name                    = parent.find('input[name="name"]').val();
      var text                    = parent.find('textarea[name="description"]').val();
      var coder_id                = parent.find('input[name="performer_id"]').val();
      var time                    = parent.find('input[name="time"]').val();
      var time_today              = parent.find('input[name="time_today"]').val();
      var eta                     = parent.find('input[name="eta"]').val();
      var arr_time                = time.split(' - ');
      var date_from               = arr_time[0];
      var date_to                 = arr_time[1];

      if (coder_id && name) {
        parent.find('.name-error').html('');
        parent.find('.performer-error').html('');


        data.id                    = id;
        data.description           = text;
        data.performer_id          = coder_id;
        data.date_from             = date_from;
        data.eta                   = eta;
        data.date_to               = date_to;
        data.name                  = name;

        var url = '/ajax/save-edit-phase';
        $.post(url, data)
          .done(function (data) {
            if (data) {
              $('.add_phases_' + id).fadeOut('slow');

              setTimeout(function() {
                $('.add_phases_' + id).fadeIn('slow').html(data.name);
                  $("#loadings").fadeOut();
              }, 700);
              // parent.find('input[name="working_hours_result"]').val(data.html_edit_phases);
              btn.fadeOut('slow');
              parent.collapse('hide');

            }

          });
      }else {
        if (name) {
          parent.find('.name-error').html('');
          parent.find('.performer-error').html('Không được để trống');
        }else if(coder_id){
          parent.find('.name-error').html('Không được để trống');
          parent.find('.performer-error').html('');

        }else{
          parent.find('.name-error').html('Không được để trống');
          parent.find('.performer-error').html('Không được để trống');
        }
      }

    }
  });

  $('*').delegate(' .user-add-new-phases li', 'click', function () {
    // var data = {};
    var id = $(this).find('.add-user-phases-click').data('id');
    var code_id = $('#add_new_phases').val();
    var arr_code = '';
    if (code_id) {
      arr_code = code_id.split(',');
    }

    // console.log(jQuery.inArray( id.toString(),  arr_code));
    // var arr_code = code_id.split(',');
    var parent = $(this).closest('#add-phases');
    if (jQuery.inArray(id.toString(), arr_code) == -1) {
      console.log('KHONG TON TAI ');
      $('#add_new_phases').val(code_id + ',' + id);
      $(this).find('.add-user-phases-click').append('<span class="glyphicon glyphicon-ok pull-right"></span>');
      var url = '/ajax/add-phases-coder/';
      $.get(url + id, function (data) {
        if (data) {
          parent.find('.list-performer').append(data);
        }
      });

    } else {
      $('#add_new_phases').val(code_id.toString().replace(',' + id, ''));
      $(this).find(".add-user-phases-click .glyphicon.glyphicon-ok.pull-right").remove();
      parent.find('#performer_' + id).remove();
    }

  });


  // $('.click-add-plus').click(function () {
  //   var id = $(this).data('id');
  //   var check_in = $(this).closest('.phases').closest('.panel.panel-default').find('#phases_' + id);
  //   var check_prolan_in = '';
  //   if (check_in.hasClass('in')) {
  //     $(this).closest('.phases').find('.css-plus').addClass('hidden');
  //   } else {
  //     $('.css-plus').addClass('hidden');
  //     $(this).closest('.phases').closest('.panel.panel-default').find('.in').removeClass('in');
  //     $(this).closest('.phases').find('.css-plus').removeClass('hidden');
  //   }

  // });

  // $('body').delegate(' .click-add-plus-parent', 'click', function () {
  //   var id = $(this).data('id');
  //   var phases_id = $(this).data('phases');
  //   var check_in = $(this).closest('.project_plan').closest('.panel.panel-default').find('#pro_plan_' + id);
  //   var check_prolan_in = '';
  //   if (check_in.hasClass('in')) {
  //     $(this).closest('.project_plan').find('.css-plus').addClass('hidden');
  //   } else {
  //     $(this).closest('#accordion_phases_' + phases_id).find('.css-plus').addClass('hidden');
  //     $(this).closest('.project_plan').find('.css-plus').removeClass('hidden');
  //   }

  // });





  $('.change-project-style').on('change', function () {
    var id = $(this).val();
    var url = '/ajax/taxonomy-type/' + id;
    $.get(url, function (data) {
      if (data) {
        $('.change-project-type').html(data);
      }
    });
  });



  function getButtonEditTask(parent) {
    parent.find('.btn.btn-primary.btn-add-phases').fadeIn( "slow" );
  }

  $('body').on('focus', '.css-modal-form input[name="name"]', function(event) {
   var parent = $(this).closest('.css-modal-form');
    getButtonEditTask(parent);
  });

  $('body').on('focus', '.css-modal-form textarea[name="description"]', function(event) {
   var parent = $(this).closest('.css-modal-form');
    getButtonEditTask(parent);
  });

  $('body').on('change', '.css-modal-form input[name="working_hours_plan"]', function(event) {
   var parent = $(this).closest('.css-modal-form');
    getButtonEditTask(parent);
  });


  $('body').on('change', '.css-modal-form input[name="performer_id"]', function(event) {
    parent = $(this).closest('.css-modal-form');
    getButtonEditTask(parent);
  });

  $('body').on('focus', '.css-modal-form input[name="time"]', function(event) {
    parent = $(this).closest('.css-modal-form');
    getButtonEditTask(parent);
  });

  $('body').on('focus', '.css-modal-form select[name="status_point"]', function(event) {
    parent = $(this).closest('.css-modal-form');
    getButtonEditTask(parent);
  });


  $('.click-add-task').click(function(event) {
    $("#loadings").fadeIn();
    var btn                 = $(this);
    var id                  = $(this).data('id');
    var parent              = $(this).closest('.edit-task');
    var name                = parent.find('input[name="name"]').val();
    var text                = parent.find('textarea[name="description"]').val();
    var eta                 = parent.find('input[name="eta"]').val();
    var status_point        = parent.find('select[name="status_point"]').val();
    var time                = parent.find('input[name="time"]').val();
    var arr_time            = time.split(' - ');
    var coder_id            = parent.find('input[name="performer_id"]').val();
    var date_from           = arr_time[0];
    var date_to             = arr_time[1];
    var data                = {};

    if (name && coder_id) {
      parent.find('.name-error').html('');
      parent.find('.performer-error').html('');

      data.id           = id;
      data.name         = name;
      data.description  = text;
      data.date_from    = date_from;
      data.status_point = status_point;
      data.date_to      = date_to;
      data.eta          = eta;
      data.performer_id = coder_id;

      var url = '/ajax/save-edit-task';

      $.post(url, data, function(data) {
          btn.fadeOut('slow');
          parent.closest('.modal-lg-task').find('.popup-task-name').fadeOut('slow');
          setTimeout(function() {
            parent.closest('.modal-lg-task').find('.popup-task-name').fadeIn('slow').html(name);
              $("#loadings").fadeOut();
          }, 700);
      });
    }else{
      if (name) {
        parent.find('.name-error').html('');
        parent.find('.performer-error').html('Không được để trống');
      }else if(coder_id){
        parent.find('.name-error').html('Không được để trống');
        parent.find('.performer-error').html('');

      }else{
        parent.find('.name-error').html('Không được để trống');
        parent.find('.performer-error').html('Không được để trống');
      }
        $("#loadings").fadeOut();
    }


  });



  $('.changes-button-add').keyup(function(event) {
    $check_str = $(this).val();
    var parent = $(this).closest('.add-comment');
    if($check_str){
      parent.find('.click-add-comment-childrent').prop('disabled', false).removeClass('btn-default').addClass('btn-success');
    }else{
      parent.find('.click-add-comment-childrent').prop('disabled', true).removeClass('btn-success').addClass('btn-default');
    }
  });

  $('body').delegate('.click-show-edit-comment', 'click',function(){
    var id      = $(this).data('id');
    var parent  = $(this).closest('#list-comment-' + id);

    var text    = parent.find('.get-comment').find('.comment-content').html();

    parent.find('.edit-comment').find('textarea[name="content"]').val(text);
    parent.find('.get-comment').hide();
    parent.find('.edit-comment').fadeIn('slow');
  });

  $('body').delegate('.click-add-comment-childrent', 'click',function(){
    var id      = $(this).data('id');
    var parent  = $(this).closest('.add-comment');
    var user_id = parent.find('input[name="user_id"]').val();
    var content = parent.find('textarea[name="content"]').val();

    var data      = {};
    data.id       = id;
    data.user_id  = user_id;
    data.content  = content;
    var url = '/ajax/add-new-comment-childrent';
    $.post(url, data, function(data) {
      if(data){
        parent.closest('.module-comment').find('#get-comment-'+ id).find('.show-list-comments').prepend(data);
        parent.closest('.module-comment').find('#get-comment-'+ id).find('.list-comments').fadeIn('slow');
        parent.find('.changes-button-add').val('');
        parent.find('.click-add-comment-childrent').prop('disabled', true).removeClass('btn-success').addClass('btn-default');
      }
    });
  });

  $('body').delegate('.changes-button-edit', 'keyup',function(){
    $check_str = $(this).val();
    var parent = $(this).closest('.edit-comment');
    if($check_str){
      parent.find('.click-edit-comment-childrent').prop('disabled', false).removeClass('btn-default').addClass('btn-success');
    }else{
      parent.find('.click-edit-comment-childrent').prop('disabled', true).removeClass('btn-success').addClass('btn-default');
    }
  });

  $('body').delegate('.click-delete-comment', 'click',function(){
    var r = confirm("Bạn có muốn xóa bình luận ?");
    if(r == true){
      var id = $(this).data('id');
      var parent = $(this).closest('#list-comment-' + id);
      if(id){
        var url = '/ajax/delete-comment/' + id;
        $.get(url, function(data) {
          parent.fadeOut(300, function(){ parent.remove();});
        });
      }
    }

  });


  // $('.form-popup').validate({

  //   rules: {
  //     name        : "required",

  //   },

  //   messages : {
  //     name        : "Không được để trống ",
  //     // // address     : "Không được để trống ",
  //     // teaching    : "Không được để trống ",
  //     // level       : "Không được để trống ",
  //   }
  // });

  $('body').delegate('.click-edit-comment-childrent', 'click',function(){
    var id = $(this).data('id');
    if(id){
      var data      = {};
      var parent    = $(this).closest('#list-comment-' + id);
      var content    = parent.find('textarea[name="content"]').val();
      data.id       = id;
      data.content  = content;
      var url = '/ajax/edit-comment-childrent';

      $.post(url , data, function(data) {
        console.log(data);
        if (data) {
          parent.find('.edit-comment').hide();
          parent.find('.get-comment').find('.comment-name').html(data.name);
          parent.find('.get-comment').find('.comment-content').html(data.content);
          parent.find('.get-comment').find('.comment-time').html(data.updated_at);
          parent.find('.get-comment').fadeIn('slow');
        }

      });
    }
  });

  $('body').delegate('.size-icont-time', 'click',function(){
    var id = $(this).data('id');

    if (id) {
      var parent = $(this).closest('#list-comment-' + id);
      parent.find('.edit-comment').hide();
      parent.find('.get-comment').fadeIn('slow');
    }
  });

  $('body').delegate('.comment-attachment', 'change',function(){

    var form      = $(this).closest('form.attachment_image')[0];
    var formData  = new FormData(form);
    var parent    = $(this).closest('.modal-lg').find('.attachment');
    var url       = '/ajax/comment-attachment';

    $.ajax({
      url: url,
      data: formData,
      contentType: 'multipart/form-data',
      async: false,
      cache: false,
      contentType: false,
      processData: false,
      type: 'POST',
      success: function(data){
          parent.find('.list-image').prepend(data.html);
          parent.find('.bo-attachment').fadeOut('slow');
          parent.find('.attach-form').html(data.html_new);

      }
    });
  });


  function gettime( date_from, date_to) {
    if (date_from && date_to) {
      var start = moment(date_from, "DD/MM/YYYY");
      var end = moment(date_to, "DD/MM/YYYY"); // another date
      var duration = moment.duration(end.diff(start));
      var days = duration.asDays() + 1;

      return days;
    }
  }


  // $( 'bo' ).on( 'click', '.dateRangePicker', function (event) {
  $('.date-range-all').daterangepicker({
        // opens: 'left',
        locale: {
          format: 'DD/MM/YYYY'
        },
        autoApply: true,

    }).on('apply.daterangepicker', function() {

      var days = '';

      var parent = $(this).closest('.css-modal-form');
      console.log(parent);
      var time = $(this).val();
      var arr_time = time.split(' - ');
      var date_from = arr_time[0];
      var date_to = arr_time[1];
      var days = gettime(date_from, date_to);
      // parent.find('input[name="working_hours_result"]').val(days);

    });

    $('body').on('change', '.click-proccess', function() {
      var parent = $(this).closest('.css-modal-detail');
      var point = $(this).val(),
          id = parent.find('.btn[data-id]').data('id'),
          type = parent.hasClass('is-phase') ? 1 : 0;
      $.ajax({
        url: '/ajax/update-color',
        type: 'POST',
        data: {
          point: point,
          id: id,
          type: type,
        },
        success: function(data) {
          switch(data.color) {
              case 1:
                  parent.find('.progress-bar').css('background-color', '#f5393d !important');
                  break;
              case 2:
                  parent.find('.progress-bar').css('background-color', '#EAC52D !important');
                  break;
              case 0:
                  parent.find('.progress-bar').css('background-color', '#58c249 !important');
                  break;
          }
          parent.find('.progress-bar').css('width', point +'%').css('min-width', point +'%');
        }
      });
    });

    $('body').on('click', '.edit-detail-phases', function() {
    var btn                   = $(this);
    var parent                = $(this).closest('.css-modal-form');
    var name                  = parent.find('input[name="name"]').val();
    var text                  = parent.find('textarea[name="description"]').val();
    var coder_id              = parent.find('input[name="performer_id"]').val();
    var eta                   = parent.find('input[name="eta"]').val();
    var id                    = $(this).data('id');
    var status_point          = parent.find('select[name="status_point"]').val();
    $("#loadings").fadeIn();
    var time      = parent.find('input[name="time"]').val();
    var arr_time  = time.split(' - ');
    var date_from = arr_time[0];
    var date_to   = arr_time[1];


    var data  = {};

    if(name && coder_id){
      parent.find('.name-error').html('');
      parent.find('.performer-error').html('');

      data.status_point         = status_point;
      data.id                   = id;
      data.description          = text;
      data.name                 = name;
      data.performer_id         = coder_id;
      data.eta                  = eta;
      data.date_from            = date_from;
      data.date_to              = date_to;
      url                       = '/ajax/edit-detail-phases';

      $.post(url, data)
        .done(function (data) {

           parent.closest('.modal-lg-phases').find('.name_phases').fadeOut('slow');
           // parent.find('input[name="working_hours_result"]').val(data);
          setTimeout(function(){
            parent.closest('.modal-lg-phases').find('.name_phases').fadeIn('slow').html(name);
            $("#loadings").fadeOut();
          }, 700);

          if(data.check_progress == true){
              parent.find('.change_proccess').find('.box-progress').html(data.html);
          }else{
              parent.find('.change_proccess').find('.box-progress').html(data.html);
          }

          btn.fadeOut('slow');
          console.log('thanh cong');
        });
    }else{
      if (name) {
        parent.find('.name-error').html('');
        parent.find('.performer-error').html('Không được để trống');
      }else if(coder_id){
        parent.find('.name-error').html('Không được để trống');
        parent.find('.performer-error').html('');

      }else{
        parent.find('.name-error').html('Không được để trống');
        parent.find('.performer-error').html('Không được để trống');
      }
    }

    });

    // edit parent
    $('body').on('click', '.add-edit-parent', function() {
      var btn                 = $(this);
      var parent              = $(this).closest('.css-modal-form');
      var name                = parent.find('input[name="name"]').val();
      var text                = parent.find('textarea[name="description"]').val();
      var coder_id            = parent.find('input[name="performer_id"]').val();
      var eta                 = parent.find('input[name="eta"]').val();
      $("#loadings").fadeIn();
      var id        = $(this).data('id');
      var time      = parent.find('input[name="time"]').val();
      var arr_time  = time.split(' - ');
      var date_from = arr_time[0];
      var date_to   = arr_time[1];
      var data      = {};

      if (name && coder_id) {

        parent.find('.name-error').html('');
        parent.find('.performer-error').html('');

          data.description          = text;
          data.name                 = name;
          data.performer_id         = coder_id;
          data.date_from            = date_from;
          data.date_to              = date_to;
          data.eta                  = eta;
          data.id                   = id;
          url                       = '/ajax/add-edit-parent';

        $.post(url, data)
          .done(function (data) {
          parent.closest('#add_phases_' + id).collapse('hide');
          if(name) {
            parent.closest('.list_parent').find('.add_parent_' + id).fadeOut('slow');
            setTimeout(function() {
              parent.closest('.list_parent').find('.add_parent_' + id).fadeIn('slow').html(name);
              $("#loadings").fadeOut();
            }, 700);
            if(data){
                // parent.closest('.modal-body').find('#edit_detail_phases_' + data.id).find('input[name="working_hours_result"]').val(data.real_phases);
                // parent.closest('.modal-body').find('#edit_detail_phases_' + data.id).find('input[name="time_today"]').val(data.count_real);
                parent.closest('.modal-body').find('#edit_detail_phases_' + data.id).find('input[name="eta"]').val(data.count_eta);
                // parent.find('input[name="working_hours_result"]').val(data.real_phases_edit);
            }
            btn.fadeOut('slow');
          }
        });
      }else {

        if (name) {
          parent.find('.name-error').html('');
          parent.find('.performer-error').html('Không được để trống');
        }else if(coder_id){
          parent.find('.name-error').html('Không được để trống');
          parent.find('.performer-error').html('');

        }else{
          parent.find('.name-error').html('Không được để trống');
          parent.find('.performer-error').html('Không được để trống');
        }

      }


      });

    // edit task
    $('body').on('click', '.add-edit-task', function() {
      $("#loadings").fadeIn();
      var btn = $(this);
      var parent    = $(this).closest('.css-modal-form');
      var name      = parent.find('input[name="name"]').val();
      var text      = parent.find('textarea[name="description"]').val();
      var coder_id  = parent.find('input[name="performer_id"]').val();
      var eta       = parent.find('input[name="eta"]').val();
      var id        = $(this).data('id');

      var time = parent.find('input[name="time"]').val();
      var arr_time = time.split(' - ');
      var date_from = arr_time[0];
      var date_to = arr_time[1];
      var data = {};

      if (name && coder_id) {
        parent.find('.name-error').html('');
        parent.find('.performer-error').html('');

          data.description  = text;
          data.name         = name;
          data.performer_id = coder_id;
          data.date_from    = date_from;
          data.date_to      = date_to;
          data.eta          = eta;
          data.id           = id;
          url               = '/ajax/add-edit-task';

        $.post(url, data)
          .done(function (data) {
            parent.closest('#add_parent_' + id).collapse('hide');
            if(name) {
              parent.closest('.list_task').find('.add_task_' + id).fadeOut('slow');
              setTimeout(function() {
                parent.closest('.list_task').find('.add_task_' + id).fadeIn('slow').html(name);
              }, 700);

              parent.closest('.modal-body').find('#edit_detail_parent_' + data.id).find('input[name="eta"]').val(data.real_time);
              // parent.find('input[name="working_hours_result"]').val(data.real_time_edit);

              btn.fadeOut('slow');
            }
            $("#loadings").fadeOut();
          });
      }else{
        if (name) {
          parent.find('.name-error').html('');
          parent.find('.performer-error').html('Không được để trống');
        }else if(coder_id){
          parent.find('.name-error').html('Không được để trống');
          parent.find('.performer-error').html('');

        }else{
          parent.find('.name-error').html('Không được để trống');
          parent.find('.performer-error').html('Không được để trống');
        }
      }

    });

    $('.btn.btn-primary.btn-add-phases').on('click', function() {
        var parent = $(this).closest('.modal-dialog');
        var check  = parent.find('.box-list').find('div.in').hasClass('in');
        if(check == true){
            parent.find('.box-list').find('div.in').collapse("hide");
        }
    });

  // end document.ready

});



function getAddMember(list_id, name) {
  var url = '/ajax/add-member-ajax';
  var data = {};
  data.list_id = list_id;
  data.name = name;
  var html = '';
  $.ajax({
    url: url,
    async: false,
    method: "POST",
    data: data,
    success: function (res) {
      html = res;
    }
  });

  return html;
}


//edit parent
$('body').on('click', '.edit-parent', function () {
  var  id = $(this).data('parent-id');
  var url = '/edit-ajax-parent/' + $(this).data('parent-id');
  $.ajax({
      url:url,
      type: 'GET',
      success: function(res) {
        console.log(res);
          $('.performer_parent').empty();
          $.each(res.data.list_performer, function(i, e) {
              $('.performer_parent').append('<img src="/uploads/employees/'+e.image+'" />');
          });
          $('.parent_edit_name').val(res.data.name);
          $('.date_from_edit_parent').val(res.data.date_from);
          $('.date_to_edit_parent').val(res.data.date_to);
          $('.description_parent_edit').val(res.data.note);
      }
  });
});

//show data parent
$('body').on('click','.edit-detail-parent', function(){
  var btn = $(this);
  $("#loadings").fadeIn();
  var id = $(this).data('id');
  var parent        = $(this).closest('#edit_detail_parent_' + id);
  var name          = parent.find('input[name="name"]').val();
  var text          = parent.find('textarea[name="description"]').val();
  var coder_id      = parent.find('input[name="performer_id"]').val();
  var time          = parent.find('input[name="time"]').val();
  var status_point  = parent.find('select[name="status_point"]').val();
  var eta           = parent.find('input[name="eta"]').val();

  var arr_time  = time.split(' - ');
  var date_from = arr_time[0];
  var date_to   = arr_time[1];

  var data = {};

  if (name && coder_id) {
    parent.find('.name-error').html('');
    parent.find('.performer-error').html('');

      data.description  = text;
      data.name         = name;
      data.status_point = status_point;
      data.eta          = eta;
      data.performer_id = coder_id;
      data.date_from    = date_from;
      data.date_to      = date_to;
      data.id           = id;
      url               = '/ajax/edit-detail-parent';

    $.post(url, data)
      .done(function (data) {
        btn.fadeOut('slow');
        // parent.find('input[name="eta"]').val(data);
        parent.closest('.modal-lg-phases').find('.name_parent').fadeOut('slow');

        setTimeout(function() {
          parent.closest('.modal-lg-phases').find('.name_parent').fadeIn('slow').html(name);
        }, 700);

        if(data.check_progress == true){
            parent.find('.change_proccess').find('.box-progress').html(data.html);
        }else{
            parent.find('.change_proccess').find('.box-progress').html(data.html);
        }

        $("#loadings").fadeOut();

    });
  }else{
    if (name) {
      parent.find('.name-error').html('');
      parent.find('.performer-error').html('Không được để trống');
    }else if(coder_id){
      parent.find('.name-error').html('Không được để trống');
      parent.find('.performer-error').html('');

    }else{
      parent.find('.name-error').html('Không được để trống');
      parent.find('.performer-error').html('Không được để trống');
    }
  }

});

// remove attachment
$('body').on('click', '.delete_image', function() {
  /* Act on the event */

   var alert = confirm('Bạn muốn gỡ tập tin đính kèm?');

  if(alert) {

    var id          = $(this).data('id');
    var parent      = $(this).closest('#image_' + id);
    var parent_list = parent.closest('.attachment');

    url = '/ajax/delete-attachment/' + id;
    $.get( url , function( data ) {
      if(data){

        parent.closest('.box-image').fadeOut('slow');

        setTimeout(function() {
          parent.closest('.box-image').remove();
          var check_list = parent_list.find('.box-image').length;

          if(check_list == 0 ){

          parent_list.find('.attachment_image').fadeOut('slow');
          parent_list.find('.attach-form').html(data);

          // setTimeout(function() {
          //   parent_list.remove();
          // }, 700);



          }
        }, 500);



      }
    });
  }else{
    return false;
  }

});

$('body').on('click', '.click-attachment-popup', function() {
    var url = $(this).find('input').val();

    console.log(url);
    if(url){
      var type_url =  url.split('.').pop();
      console.log(type_url);
      var html = "";
      html += '<span class="close">&times;</span>';
      if (type_url == 'pdf') {

        $('.popup-attachment').show();
        html += '<div class="caption">';
        html +=   '<iframe src="'+ url +'" style="width: 71%; height:100%; ">';
        html +=     '<p>Trình duyệt của bạn không hỗ trợ iframe.</p>';
        html +=   '</iframe>';
        html += '</div>';
        $('.popup-attachment').html(html);
      }else{
          $('.popup-attachment').show();
          html += '<img class="modal-content" src="'+ url +'">';
          $('.popup-attachment').html(html);
      }
    }

  })

$('body').on('click', '.close', function() {
  $(this).closest('.popup-attachment').hide();
});

$('body').on('click', '.position-close', function() {
  var hidden = $(this).closest('.wrap-list-user');
  hidden.find('.wrap-button-add').removeClass('active');
  hidden.find('.drop-list-user').hide();
});

