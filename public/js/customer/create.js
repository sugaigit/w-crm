$(document).ready(function() {
	/******************************************
	* CSVファイルの選択ボタン
	******************************************/
	if ($("#csv_import").val().length) {
		// ページ読み込み時にファイルが選択されていた場合
		$("#csv_submit").attr("disabled",false);
	} else {
		$("#csv_submit").attr("disabled",true);
	}
	$("#csv_import").change(function(){
		// ファイルが選択されたら
		let uploadedFile=$(this).prop('files')[0];
		let fileType=uploadedFile.type.split("/")[1];
		if (fileType != "csv") {
			// 拡張子のバリデーションにひっかかった場合の処理
			alert('CSVファイルを選択してください');
			$("#csv_submit").attr("disabled",true);
			$(this).val("") // input要素を空にする
		} else {
			// 拡張子のバリデーションをパスした場合の処理
			$("#csv_submit").attr("disabled",false);
		}
   });

});