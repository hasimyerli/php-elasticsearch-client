<!DOCTYPE html>
<html lang="en">
<head>
    <title>Php Elasticsearch Client</title>
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
                                <a class="field-name badge badge-success" data-field=""> All </a>
                                <a class="field-name badge badge-secondary" data-field="title"> Title </a>
                                <a class="field-name badge badge-secondary" data-field="authors"> Authors </a>
                                <a class="field-name badge badge-secondary" data-field="categories"> Categories </a>
                            </div>
                            <div id="message" style="color:#8b8e94;"></div>
                            <input type="text" placeholder="Search..." name="search" id="search" class="form-control text-center m-1" autocomplete="off">
                            <input type="hidden" name="field" value="" id="field">
                        </form>
                    </div>
                    <div class="col-md-4 text-center"></div>
                </div>
                <br>
                <div class="row text-center">
                    <div class="col-8 mx-auto">
                        <table data-vertable="ver1" id="table" style="display: none;">
                            <thead>
                            <tr class="row100 head">
                                <th class="column100 ">Thumbnail</th>
                                <th class="column100 ">Isbn</th>
                                <th class="column100 ">Title</th>
                                <th class="column100 ">Categories</th>
                                <th class="column100 ">Authors</th>
                                <th class="column100 ">Detail</th>
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
</div>

<script src="assets/vendor/jquery/jquery-3.2.1.min.js"></script>
<script src="assets/vendor/bootstrap/js/bootstrap.min.js"></script>

<script>
    $(function() {

        $('.field-name').on('click',function (e) {
            $('.field-name').removeClass('badge-success').addClass('badge-secondary');
            $(this).addClass('badge-success');
            $("#field").val($(this).data('field'));
            $('form').submit();
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

                $('#table-row').html("");

                if (data.data.length === 0) {
                    $('#table').hide();
                } else {
                    $('#table').show();
                }

                $('#message').html(data.message);

                $.each( data.data, function( key, item ) {
                    let thumbnailUrl = item.thumbnailUrl;
                    let row = "";
                    row += '<tr class="row100">';
                    row += '<td class="" data-column=""><img src="'+thumbnailUrl+'" width="60"></td>';
                    row += '<td>'+item.isbn+'</td>';
                    row += '<td>'+item.title+'</td>';
                    row += '<td>'+item.categories+'</td>';
                    row += '<td>'+item.authors+'</td>';
                    row += '<td><a href="'+thumbnailUrl+'" target="_blank" class="btn btn-sm btn-dark">Detail</a></td>';
                    row += '</tr>';
                    $('#table-row').append(row);
                });
            });
        });

    });
</script>
</body>
</html>
