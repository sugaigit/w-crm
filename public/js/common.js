$(function (){
    $(".delete-btn").click(function(){
        if(confirm("本当に非表示にしますか？")){
            // そのままsubmit処理を実行（※削除）
        }else{
            // キャンセル
            return false;
        }
    });
});

