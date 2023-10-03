$(document).ready(function() {
  /******************************************
   * 契約形態による人材紹介/紹介予定　採用後条件の表示・非表示の切り替え
   ******************************************/
  const targetItems = ['2', '3']; // 2:紹介予定派遣、3:人材紹介
  const type_contract = $('select[name="type_contract"]');

  // ページ読み込み時の初期化
  if( targetItems.includes(type_contract.val()) ) {
    $('.afterRecruit').css("display", "");
  } else {
    $('.afterRecruit').css("display", "none");
  }

  type_contract.change(function() {
    if( targetItems.includes($(this).val()) ) {
      $('.afterRecruit').css("display", "");
    } else {
      $('.afterRecruit').css("display", "none");
    }
  });


  if ($('#statusInput').val() == 4) {
    $('.after-closed').css("display", "");
  } else {
    $('.after-closed').css("display", "none");
  }


  /******************************************
  * 請求単価②等の表示・非表示切り替え
  ******************************************/
   $('.billing-2').css("display", "none");
   $('.billing-3').css("display", "none");

   $('#open_billing_2').on('click', function () {
     $('.billing-2').css("display", "");
     $(this).css("display", "none");
   });

   $('#close_billing_2').on('click', function () {
     $('.billing-2').css("display", "none");
     $('#open_billing_2').css("display", "");
     // $(this).css("display", "none");
   });

   $('#open_billing_3').on('click', function () {
     $('.billing-3').css("display", "");
     $(this).css("display", "none");
     $('#close_billing_2').css("display", "none");
   });

   $('#close_billing_3').on('click', function () {
     $('.billing-3').css("display", "none");
     $('#open_billing_3').css("display", "");
     // $(this).css("display", "none");
     $('#close_billing_2').css("display", "");
   });


  /******************************************
  * 支払単価②等の表示・非表示切り替え
  ******************************************/
   $('.payment-2').css("display", "none");
   $('.payment-3').css("display", "none");

   $('#open_payment_2').on('click', function () {
     $('.payment-2').css("display", "");
     $(this).css("display", "none");
   });

   $('#close_payment_2').on('click', function () {
     $('.payment-2').css("display", "none");
     $('#open_payment_2').css("display", "");
     // $(this).css("display", "none");
   });

   $('#open_payment_3').on('click', function () {
     $('.payment-3').css("display", "");
     $(this).css("display", "none");
     $('#close_payment_2').css("display", "none");
   });

   $('#close_payment_3').on('click', function () {
     $('.payment-3').css("display", "none");
     $('#open_payment_3').css("display", "");
     // $(this).css("display", "none");
     $('#close_payment_2').css("display", "");
   });

  /******************************************
  * 勤務時間②等の表示・非表示切り替え
  ******************************************/
   $('.working-2').css("display", "none");
   $('.working-3').css("display", "none");

   $('#open_working_2').on('click', function () {
     $('.working-2').css("display", "");
     $(this).css("display", "none");
   });

   $('#close_working_2').on('click', function () {
     $('.working-2').css("display", "none");
     $('#open_working_2').css("display", "");
     // $(this).css("display", "none");
   });

   $('#open_working_3').on('click', function () {
     $('.working-3').css("display", "");
     $(this).css("display", "none");
     $('#close_working_2').css("display", "none");
   });

   $('#close_working_3').on('click', function () {
     $('.working-3').css("display", "none");
     $('#open_working_3').css("display", "");
     // $(this).css("display", "none");
     $('#close_working_2').css("display", "");
   });

   $('#statusInput').on('change', function () {
    if ($(this).val() == 4) {
      $('.after-closed').css("display", "");
    } else {
      $('.after-closed').css("display", "none");
    }
   });

    /******************************************
     * 下書き必須項目の表示切替
     ******************************************/
    if ($('.draft-require').val().length) {
        $('.draft-require').removeClass('bg-danger text-white');
    } else {
        $('.draft-require').addClass('bg-danger text-white');
    }
    $('.draft-require').on('change', function () {
        if ($(this).val().length) {
            $(this).removeClass('bg-danger text-white');
        } else {
            $(this).addClass('bg-danger text-white');
        }
    });

    /******************************************
     * 必須項目の表示切替
     ******************************************/
    // if ($('.required').val().length) {
    //     $('.required').removeClass('bg-danger bg-opacity-25');
    //     console.log('必須の記述あり');
    // } else {
    //     $('.required').addClass('bg-danger bg-opacity-25');
    //     console.log('必須の記述なし');
    // }
    $('.required').on('change', function () {
        if ($(this).val().length) {
            $(this).removeClass('bg-danger bg-opacity-25');
        } else {
            $(this).addClass('bg-danger bg-opacity-25');
        }
    });
    $(".required").each(function(i) {
        if ($(this).val().length) {
            $(this).removeClass('bg-danger bg-opacity-25');
        } else {
            $(this).addClass('bg-danger bg-opacity-25');
        }
    });
    /******************************************
     * 削除アラート
     ******************************************/
    $('#delete').on('click', function () {
        if(!confirm('本当に削除しますか？')){
            return false;
        }
    });
    
    click(function(){
        if(!confirm('本当に削除しますか？')){
            /* キャンセルの時の処理 */
            return false;
        }
    });

});
