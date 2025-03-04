$('.loder-image').hide();
function deleteImage (id ,route) {
    let csrfToken = $('meta[name="csrf-token"]').attr('content');
$.ajax({ url: route, data: {image_id:id}, type: "POST", headers: {'X-CSRF-TOKEN': csrfToken},
success: function () { $('#img-'+id).hide(); swal({icon: 'success', title: 'تمت ازاله الصوره بنجاح' }); }, }); }


function uplodeImage (formData , route) {
    let csrfToken = $('meta[name="csrf-token"]').attr('content');
    $.ajax({
            url: route,
            data: formData,
            type: "POST",
            enctype: 'multipart/form-data',
            processData: false,
            contentType: false,
            headers: {'X-CSRF-TOKEN': csrfToken},
            beforeSend: function() {
                $('.loder-image').show();
                $('.ft-file').hide();
        },
            success: function (data) {
                $('.loder-image').hide();
                $('.ft-file').show();
                $.each(data.images, function (index, image) {
                    var newRow = `<label id="`+image.url+`" class="btn"><p>language `+image.language+` - status :  `+image.status+` </p>
                        <img src="`+image.url+`" class="check img-thumbnail" style="width: 155px;height: 97px;"></label>`;
                    $('.add-image').append(newRow);
                });
                // إعادة تعيين الحقول بعد الرفع
                $('#image').val('');
            },
            error: function (xhr, status, error) {
                console.log(error);
            }
        });
}

function storeForm(formData, url , redirect , nameTbale , type = "POST" , edit = true) {
    let csrfToken = $('meta[name="csrf-token"]').attr('content');
    $.ajax({
        url: url, data: formData, type: type,
        enctype: 'multipart/form-data',
         processData: false,
        contentType: false,
         headers: { 'X-CSRF-TOKEN': csrfToken },
          success: function (data) {
            swal({
                icon: 'success',
                 title:nameTbale,
                  showCancelButton: true,
               confirmButtonText: 'إعادة التوجيه',
                cancelButtonText:nameTbale
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = redirect;
                } else {
                    if (!edit){
                        $('#name_ar').val(''); $('#name_en').val('');
                    }
                }
            });
        },
        error: function (xhr, status, error) { console.log(error); }
    });
}


var subscriptions = [];
// تكوين القاعدة للتحقق من الصحة
$("#subscription-form").validate({
      rules: {
          price: {
              required: true,
              number: true
          },
          duration_days: {
              required: true,
              number: true
          },
          discounted_price: {
              required: true,
              number: true
          },
          // قد تحتاج إلى إضافة قواعد إضافية حسب احتياجاتك
      },
      messages: {
          price: {
              required: "يرجى إدخال السعر",
              number: "الرجاء إدخال رقم صحيح"
          },
          duration_days: {
              required: "يرجى إدخال مدة الاشتراك",
              number: "الرجاء إدخال رقم صحيح"
          },
          discounted_price: {
              required: "يرجى إدخال السعر المخفض",
              number: "الرجاء إدخال رقم صحيح"
          },
          // قد تحتاج إلى إضافة رسائل إضافية حسب احتياجاتك
      }


  });

  function addSubscriptionFields() {
  if ($("#subscription-form").valid()) {
      // استخدم قيم الحقول لإنشاء صف جديد في الجدول
      var newRowData = {
          price: $('#price').val(),
          discounted: $('#discounted').val(),
          duration_days: $('#duration_days').val(),
          discounted_price: $('#discounted_price').val(),
          description_en: $('#description_en').val(),
          description_ar: $('#description_ar').val(),
      };

      // إضافة البيانات إلى مصفوفة subscriptions
      subscriptions.push(newRowData);

      // استدعاء الدالة لتحديث الجدول
      updateTable();

      // مسح الحقول بعد إضافة الصف
      clearFields();
      console.log(subscriptions)
  }
}

function updateTable() {
  // تحديث جدول الاشتراكات باستخدام بيانات المصفوفة subscriptions
  $('#subscription-table-body').empty();
  $.each(subscriptions, function (index, rowData) {
      var newRow = '<tr>' +
          '<td>' + rowData.price + '</td>' +
          '<td>' + (rowData.discounted == 1 ? 'Yes' : 'No') + '</td>' +
          '<td>' + rowData.duration_days + '</td>' +
          '<td>' + rowData.discounted_price + '</td>' +
          '<td>' + rowData.description_en + '</td>' +
          '<td>' + rowData.description_ar + '</td>' +
          '<td><button class="btn btn-danger" onclick="removeRow(' + index + ')">Delete</button></td>' +
          '</tr>';
      $('#subscription-table-body').append(newRow);
  });
}

function removeRow(index) {
  // حذف الصف من المصفوفة
  subscriptions.splice(index, 1);

  // استدعاء الدالة لتحديث الجدول
  updateTable();
}

function clearFields() {
  // مسح قيم الحقول في الاستمارة بعد إضافة الصف
  $('#price').val('');
  $('#discounted').val('1');
  $('#duration_days').val('');
  $('#discounted_price').val('');
  $('#description_en').val('');
  $('#description_ar').val('');
}
