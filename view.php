<!DOCTYPE html>
<html>

<head>
<meta content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport">
<meta charset="utf-8">
<title><?= $title ?></title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.1/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<style>
:root {
  --main-body: 120px;
}

html,body {
    height: 100%;
}
#head {
    display: block;
    margin: auto;
    width: 100%;
    height: var(--main-body)!important;
    height: 100%;
}
#content {
    padding: 4px 16px;
    display: block;
    margin: auto;
    width: calc( 100% - 3px );
    height: calc( 100% - var(--main-body) - 2px );
    border: solid 2px #c0c0c0;
    overflow: scroll;
}

td,th {
    cursor: default!important;
    white-space: pre;
}

#tbl {
    user-select: none;
}

.w100 {
    width: 100px;
}

.folder {
    float: right;
}
</style>
<script>
$(function(){

    $("#action_load").on( "click", function(){

        // 既存の表示データを完全クリア
        $("#tbl").html("");

        // FileReader は毎回作成(同時に複数のファイルを扱えない)
        var reader = new FileReader();

        // FileReader にデータが読み込まれた時のイベント
        var rows = "";
        var cols = "";
        var tr = null;
        $(reader).on("load", function () {

            // \r を全て削除
            var data = this.result.replace(/\r/g,"");

            // \n で行を分ける
            rows = this.result.split("\n");
            $.each( rows, function( idx, value ){
                // 空行を無視
                if ( value == "" ) {
                    return;
                }
                cols = value.split(",");
                // 行を作成
                tr = $("<tr></tr>").appendTo("#tbl");
                $.each( cols, function( idx, value ){
                    // TD を追加して、テキストをセット

                    switch( idx ) {
                        case 7:
                        case 8:
                            // 数値項目はカンマ編集で右寄せ
                            $("<td></td>").appendTo(tr)
                                .text(value)
                                .css({"text-align": "right" });
                            break;

                        default:
                            $("<td></td>").appendTo(tr)
                                .text(value);
                    }

                } )
            } )
        });

        reader.readAsText($("#target").get(0).files[0],"shift_jis");
        // reader.readAsText($("#target").get(0).files[0],"utf-8");

    });

});
</Script>
</head>

<body>
<div id="head">
    <h3 class="alert alert-primary">
        <?= $title ?>
        <input id="target" type="file" class="btn btn-primary ms-3">
        <input id="action_load" type="button" value="CSV読み込み" class="btn btn-primary ms-3">
        <a href="." class="btn btn-secondary btn-sm folder me-4">フォルダ</a>
    </h3>
</div>
<div id="content">

        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th class="w100">社員コード</th>
                        <th>氏名</th>
                        <th>フリガナ</th>
                        <th>所属</th>
                        <th>性別</th>
                        <th>作成日</th>
                        <th>更新日</th>
                        <th class="text-end">給与</th>
                        <th class="text-end">手当</th>
                        <th>管理者</th>
                        <th>生年月日</th>
                    </tr>
                </thead>
                <tbody id="tbl">
                    <?= $html ?>
                </tbody>
            </table>
        </div>
</div>
</body>
</html>