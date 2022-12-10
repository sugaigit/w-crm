$(function() {
  /******************************************
   * 事業形態による表示項目の切り替え
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
