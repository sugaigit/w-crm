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

});