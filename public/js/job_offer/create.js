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
  
});
