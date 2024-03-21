$(document).ready(function() {
  /******************************************
   * 下書き保存ボタンを押下時はhtmlのrequire属性を無効化
   ******************************************/
  $('#draft_update_btn').on('click', function () {
    $('[required]').removeAttr('required');
  });

  /******************************************
   * 人材紹介/紹介予定の場合、請求情報と支払い情報を非表示にする
  ******************************************/
  $('select[name="type_contract"]').on('change', function () {
    let isJinzaiShokai = $(this).val() == 3;
    console.log(isJinzaiShokai);
    $('.only-not-introduced').css("display", isJinzaiShokai ? "none" : "");
    $('input[name="invoice_unit_price_1"], select[name="billing_unit_1"], input[name="profit_rate_1"], select[name="employment_insurance"], select[name="social_insurance"], input[name="payment_unit_price_1"], select[name="payment_unit_1"]').prop("required", !isJinzaiShokai);
  }).trigger('change'); // 初期化時にもトリガーする

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
   * 顧客名のセレクト要素に検索機能を付与して日本語化
   ******************************************/
    $('#select-field').select2({
      language: "ja",
      dropdownCssClass: 'form-control'
    });


  /******************************************
  * 請求単価②等の表示・非表示切り替え
  ******************************************/
  $('.billing-2').css("display", "none");
  $('.billing-3').css("display", "none");

  function openBilling2() {
    $('.billing-2').css("display", "");
    $('#open_billing_2').css("display", "none");
  }

  var openBilling2Vals = $('input[name="invoice_unit_price_2"]').val()
    + $('[name="billing_unit_2"]').val()
    + $('input[name="profit_rate_2"]').val()
    + $('input[name="billing_information_2"]').val();

  if (openBilling2Vals.length) {
    openBilling2();
  }
  $('#open_billing_2').click(openBilling2);

  $('#close_billing_2').click(function () {
    $('.billing-2').css("display", "none");
    $('#open_billing_2').css("display", "");
  });

  function openBilling3() {
    $('.billing-3').css("display", "");
    $('#open_billing_3').css("display", "none");
    $('#close_billing_2').css("display", "none");
  }

  var openBilling3Vals = $('input[name="invoice_unit_price_3"]').val()
    + $('[name="billing_unit_3"]').val()
    + $('input[name="profit_rate_3"]').val()
    + $('input[name="billing_information_3"]').val();

  if (openBilling3Vals.length) {
    openBilling3();
  }
  $('#open_billing_3').click(openBilling3);

  $('#close_billing_3').on('click', function () {
    $('.billing-3').css("display", "none");
    $('#open_billing_3').css("display", "");
    $('#close_billing_2').css("display", "");
  });


  /******************************************
  * 支払単価②等の表示・非表示切り替え
  ******************************************/
  $('.payment-2').css("display", "none");
  $('.payment-3').css("display", "none");

  function openPayment2() {
    $('.payment-2').css("display", "");
    $('#open_payment_2').css("display", "none");
  }

  var openPayment2Vals = $('[name="employment_insurance_2"]').val()
    + $('[name="social_insurance_2"]').val()
    + $('input[name="payment_unit_price_2"]').val()
    + $('[name="payment_unit_2"]').val()
    + $('input[name="carfare_2"]').val()
    + $('[name="carfare_payment_2"]').val()
    + $('input[name="carfare_payment_remarks_2"]').val();

  if (openPayment2Vals.length) {
    openPayment2();
  }
  $('#open_payment_2').click(openPayment2);

  $('#close_payment_2').on('click', function () {
    $('.payment-2').css("display", "none");
    $('#open_payment_2').css("display", "");
  });

  function openPayment3() {
    $('.payment-3').css("display", "");
    $('#open_payment_3').css("display", "none");
    $('#close_payment_2').css("display", "none");
  }

  var openPayment3Vals = $('[name="employment_insurance_3"]').val()
    + $('[name="social_insurance_3"]').val()
    + $('input[name="payment_unit_price_3"]').val();
    + $('input[name="payment_unit_3"]').val()
    + $('input[name="carfare_3"]').val()
    + $('[name="carfare_payment_3"]').val()
    + $('input[name="carfare_payment_remarks_3"]').val();

  if (openPayment3Vals.length) {
    openPayment3();
  }
  $('#open_payment_3').click(openPayment3);

  $('#close_payment_3').on('click', function () {
    $('.payment-3').css("display", "none");
    $('#open_payment_3').css("display", "");
    $('#close_payment_2').css("display", "");
  });

  /******************************************
  * 勤務時間②等の表示・非表示切り替え
  ******************************************/
  $('.working-2').css("display", "none");
  $('.working-3').css("display", "none");

  function openWorking2() {
    $('.working-2').css("display", "");
    $('#open_working_2').css("display", "none");
  }

  var openWorking2Vals = $('input[name="working_hours_2"]').val()
    + $('input[name="actual_working_hours_2"]').val()
    + $('input[name="break_time_2"]').val();

  if (openWorking2Vals.length) {
    openWorking2();
  }
  $('#open_working_2').click(openWorking2);

  $('#close_working_2').on('click', function () {
    $('.working-2').css("display", "none");
    $('#open_working_2').css("display", "");
  });


  function openWorking3() {
    $('.working-3').css("display", "");
    $('#open_working_3').css("display", "none");
    $('#close_working_2').css("display", "none");
  }

  var openWorking3Vals = $('input[name="working_hours_3"]').val()
    + $('input[name="actual_working_hours_3"]').val()
    + $('input[name="break_time_3"]').val();

  if (openWorking3Vals.length) {
    openWorking3();
  }
  $('#open_working_3').click(openWorking3);

  $('#close_working_3').on('click', function () {
    $('.working-3').css("display", "none");
    $('#open_working_3').css("display", "");
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

  // select2への対応
  if ($('#customerId').val().length) {
    $('.select2').select2({
      language: "ja",
      theme: "bootstrap-5"
    });
  } else {
    $('#customerId').select2({
      language: "ja",
      theme: "bootstrap-5",
      containerCssClass: "bg-danger bg-opacity-25"
    });
  }
  $('#customerId').on('change', function () {
    if ($(this).val().length) {
      $('.select2').select2({
        language: "ja",
        theme: "bootstrap-5"
      });
    } else {
      $('.select2').select2({
        language: "ja",
        theme: "bootstrap-5",
        containerCssClass: "bg-danger bg-opacity-25"
      });
    }
  });

  /******************************************
   * 人材紹介/紹介予定 採用ご条件の表示切替
  ******************************************/
  if ($('.conditions').val().length) {
      $('.conditions').removeClass('bg-info bg-opacity-25');
  } else {
      $('.conditions').addClass('bg-info bg-opacity-25');
  }
  $('.conditions').on('change', function () {
      if ($(this).val().length) {
          $(this).removeClass('bg-info bg-opacity-25');
      } else {
          $(this).addClass('bg-info bg-opacity-25');
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

  $('#delete-activity-record').on('click', function () {
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
