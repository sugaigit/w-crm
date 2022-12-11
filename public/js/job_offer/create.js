$(document).ready(function() { 
  /******************************************
   * 契約形態による人材紹介/紹介予定　採用後条件の表示・非表示の切り替え
   ******************************************/
  $('.afterRecruit').css("display", "none"); // ページ読み込み時の初期化
  $('select[name="type_contract"]').change(function() { 
    const targetItems = ['2', '3']; // 2:紹介予定派遣、3:人材紹介

    if( targetItems.includes($(this).val()) ) {
      $('.afterRecruit').css("display", "");
    } else {
      $('.afterRecruit').css("display", "none");
    }
  });

  /******************************************
   * 請求単価②等の表示・非表示切り替え
   ******************************************/
  $('.billing-2').css("display", "none");
  $('.billing-3').css("display", "none");

  $('#open_billing_2').on('click', function () {
    $('.billing-2').css("display", "");
    $(this).css("display", "none");
  });

  $('#open_billing_3').on('click', function () {
    $('.billing-3').css("display", "");
    $(this).css("display", "none");
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
  
   $('#open_payment_3').on('click', function () {
    $('.payment-3').css("display", "");
    $(this).css("display", "none");
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
  
  $('#open_working_3').on('click', function () {
    $('.working-3').css("display", "");
    $(this).css("display", "none");
  });
  
});
