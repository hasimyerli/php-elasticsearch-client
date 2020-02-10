<!DOCTYPE html>
<html lang="en">
<head>
    <title>Table V03</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="assets/images/icons/favicon.ico"/>
    <link rel="stylesheet" type="text/css" href="assets/vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/util.css">
    <link rel="stylesheet" type="text/css" href="assets/css/main.css">
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">
</head>
<body>
<div class="limiter">
    <div class="container-table100">
        <div class="wrap-table100">
            <div class="table100 ver1 m-b-110">
                <div class="row">
                    <div class="col-md-4 text-center"></div>
                    <div class="col-md-4 text-center">
                        <form action="search.php" method="post" class="">
                            <img src="assets/images/logo.png" alt="" class="logo">
                            <div class="text-center">
                                <button class="field-name badge badge-success" data-field=""> Hepsi </button>
                                <button class="field-name badge badge-secondary" data-field="title"> Ürün Adı </button>
                                <button class="field-name badge badge-secondary" data-field="authors"> Yazar </button>
                                <button class="field-name badge badge-secondary" data-field="categories"> Kategori </button>
                            </div>
                            <div id="message" style="color:#8b8e94;"></div>
                            <input type="text" placeholder="Bir şeyler ara..." name="search" id="search" class="form-control text-center" autocomplete="off">
                            <input type="hidden" name="field" value="" id="field">
                        </form>
                        <div class="row" style="margin-top: 3px;">
                            <div class="col-md-12 text-center">
                                <div id="suggest-area">
                                    <div id="suggest" style="display: none;" class="alert alert-secondary alert-dismissible fade show">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 text-center"></div>
                </div>
                <br>
                <div class="row text-center">
                    <table data-vertable="ver1" id="table" style="display: none;">
                        <thead>
                        <tr class="row100 head">
                            <th class="column100 column1" data-column="column1">Resim</th>
                            <th class="column100 column2" data-column="column2">Skor Puanı</th>
                            <th class="column100 column3" data-column="column3">Isbn</th>
                            <th class="column100 column4" data-column="column4">Ürün Adı</th>
                            <th class="column100 column5" data-column="column5">Kategori</th>
                            <th class="column100 column6" data-column="column6">Yazar</th>
                            <th class="column100 column7" data-column="column7">Detay</th>
                        </tr>
                        </thead>
                        <tbody id="table-row">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="assets/vendor/jquery/jquery-3.2.1.min.js"></script>
<script src="assets/vendor/bootstrap/js/bootstrap.min.js"></script>

<script>
    $(function() {
        const minSearchLength = 3;

        $('.field-name').on('click',function (e) {
            $('.field-name').removeClass('badge-success').addClass('badge-secondary');
            $(this).addClass('badge-success');
            $("#field").val($(this).data('field'));
            let searchInput = $("#search");
            searchInput.focus();
            if (searchInput.val() === "") {
                e.preventDefault();
            }
        });

        $('#suggest-area').delegate('.search-suggest','click',function () {
            let searchInput = $("#search");
            searchInput.focus();
            let words = searchInput.val().toLowerCase();
            let wordList = words.split(" ");
            let suggestName = $(this).data('suggestName');
            let originalName = $(this).data('originalName');
            let index = $.inArray( originalName, wordList );
            wordList[index] = suggestName;
            let wordsJoin = wordList.join(" ");
            searchInput.val(wordsJoin).keyup();
            $('form').submit();
        });

        $("#search").keyup(function(e){
            let searchInput = $(this).val();
            if (searchInput && searchInput.length >= minSearchLength) {
                $('#suggest-area').show();
                $.ajax({
                    method: "POST",
                    url: 'suggest.php',
                    data: {'search' : searchInput}
                }).done(function(result) {
                    let data = $.parseJSON(result);
                    suggest(data.suggest);
                });
            } else {
                $('#suggest').html("").hide();
            }
        });

        $('form').submit(function(e) {
            e.preventDefault();
            let form = $(this);
            $.ajax({
                method: "POST",
                url: form.attr('action'),
                data: form.serialize()
            }).done(function(result) {
                let data = $.parseJSON(result);
                console.log(data);
                $('#table-row').html("");
                if (data.data.length === 0) {
                    $('#table').hide();
                } else {
                    $('#table').show();
                }

                $('#message').html(data.message);

                $.each( data.data, function( key, value ) {
                    let row = "";
                    row += '<tr class="row100">';
                    let thumbnailUrl = value.thumbnailUrl;
                    row += '<td class="column100 column1" data-column="column1"><img src="'+thumbnailUrl+'" width="60"></td>';

                    let score = value._score;
                    row += '<td class="column100 column2" data-column="column2">'+score+'</td>';

                    let isbn = (value.highlight && value.highlight.isbn && value.highlight.isbn[0]) ? value.highlight.isbn[0] : value.isbn;
                    row += '<td class="column100 column3" data-column="column3">'+isbn+'</td>';

                    let title = (value.highlight && value.highlight.title && value.highlight.title[0]) ? value.highlight.title[0] : value.title;
                    row += '<td class="column100 column5" data-column="column5">'+title+'</td>';

                    let categories = (value.highlight && value.highlight.categories && value.highlight.categories[0]) ? value.highlight.categories[0] : value.categories;
                    row += '<td class="column100 column6" data-column="column6">'+categories+'</td>';

                    let authors = (value.highlight && value.highlight.authors && value.highlight.authors[0]) ? value.highlight.authors[0] : value.authors;
                    row += '<td class="column100 column7" data-column="column7">'+authors+'</td>';

                    row += '<td class="column100 column8" data-column="column8"><a href="'+thumbnailUrl+'" target="_blank" class="btn btn-sm btn-dark">İncele</a></td>';
                    row += '</tr>';
                    $('#table-row').append(row);
                });
            });
        });

        function suggest(suggests) {
            let suggestText = "";
            let textList = [];
            let suggestDiv = $('#suggest');
            suggestDiv.html("").show();
            $.each( suggests, function( field, suggest ){
                $.each( suggest, function( key, data ){
                    $.each( data.options, function( key, option ){
                        if ($.inArray(option.text, textList) === -1) {
                            textList.push(option.text);
                            suggestText += '<a href="#" class="search-suggest badge badge-dark m-1" data-field="'+field+'" data-original-name="'+data.text+'" data-suggest-name="'+option.text+'">'+option.text+'</a>';
                        }
                    });
                });
                if (suggestText !== "")
                    suggestDiv.append(suggestText).show();
                suggestText = "";
            });
            if (textList.length === 0)
                suggestDiv.hide()
        }
    });
</script>
</body>
</html>
