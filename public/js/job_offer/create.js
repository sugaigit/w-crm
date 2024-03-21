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
    // let customer_id = null;
    // // datalistのdata-id属性の値の取得
    // $('#submit-btn').on('change', function () {
    //     customer_id = $("#customer_list option[value='" + $(this).val() + "']").data('customer_id');
    //     $('#customer_input').val(customer_id);
    // });

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
   * 下書き保存ボタンを押下時はhtmlのrequire属性を無効化
   ******************************************/
   $('#draft_create_btn').on('click', function () {
    $('[required]').removeAttr('required');
  });

  /******************************************
   * 顧客名のセレクト要素に検索機能を付与して日本語化
   ******************************************/
  $('.select2').select2({
    language: "ja",
    theme: "bootstrap-5",
    containerCssClass: "bg-danger bg-opacity-25"
  });

  /******************************************
   * 人材紹介/紹介予定の場合、請求情報と支払い情報を非表示にする
  ******************************************/
  $('select[name="type_contract"]').on('change', function () {
    let isJinzaiShokai = $(this).val() == 3 || $(this).val() == 5;
    $('.only-not-introduced').css("display", isJinzaiShokai ? "none" : "");
    $('input[name="invoice_unit_price_1"], select[name="billing_unit_1"], input[name="profit_rate_1"], select[name="employment_insurance"], select[name="social_insurance"], input[name="payment_unit_price_1"], select[name="payment_unit_1"]').prop("required", !isJinzaiShokai);
  }).trigger('change'); // 初期化時にもトリガーする

});
