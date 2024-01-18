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

    /******************************************
     * 必須項目の表示切替
    ******************************************/
    if ($('.required').val().length) {
        $('.required').removeClass('bg-danger bg-opacity-25');
    } else {
        $('.required').addClass('bg-danger bg-opacity-25');
    }
    $('.required').on('change', function () {
        if ($(this).val().length) {
            $(this).removeClass('bg-danger bg-opacity-25');
        } else {
            $(this).addClass('bg-danger bg-opacity-25');
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
     * 支店情報の追加・削除
    ******************************************/
    for(let i=2; i<6; i++){
        // 初期化
        $('.branch-info-'+i).css("display", "none");
        // 追加ボタンの処理
        $('#open_branch_info_'+i).on('click', function () {
            $('.branch-info-'+i).css("display", "");
            $(this).css("display", "none");
            $('#close_branch_info_'+(i-1)).css("display", "none");
          });
        // 削除ボタンの処理
        $('#close_branch_info_'+i).on('click', function () {
            $('.branch-info-'+i).css("display", "none");
            $('#open_branch_info_'+i).css("display", "");
            $('#close_branch_info_'+(i-1)).css("display", "");
        });
    }

});
