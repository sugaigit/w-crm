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

/******************************************
 * 勤務時間②等の表示・非表示切り替え
 ******************************************/
 var csvFile = $('input[type=file]');
 csvFile.change(function (e) {
    var result = e.target.files[0];

    //FileReaderのインスタンスを作成する
    var reader = new FileReader();

    //読み込んだファイルの中身を取得する
    reader.readAsText( result );

    //ファイルの中身を取得後に処理を行う
    reader.addEventListener('load', function() {

        //ファイルの中身をtextarea内に表示する
        console.log(reader.result.split(/\r\n|\n/));
    })
 });

 /******************************************
 * 顧客名のdatalistで顧客名ではなく顧客IDを送信する
 ******************************************/
  let customer_id = null;
  // datalistのdata-id属性の値の取得
  $('#customer_input').on('change', function () {
    customer_id = $("#customer_list option[value='" + $(this).val() + "']").data('customer_id');
    $('#customer_id').val(customer_id)
  });
  

});
