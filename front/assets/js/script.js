function findGetParameter(parameterName) {
    var result = null,
        tmp = [];
    var items = location.search.substr(1).split("&");
    for (var index = 0; index < items.length; index++) {
        tmp = items[index].split("=");
        if (tmp[0] === parameterName) result = decodeURIComponent(tmp[1]);
    }
    return result;
}

function articlesLoad(articles, selector, path_assets) {
    $('#' + selector).html('');

    // forEach
    for (let i = 0; i < articles.length; i++) {

        // ' + i % 2 === 0 ? " col-lg-offset-2 col-md-offset-2 col-sm-offset-2 " : "" + '
        const classes = i % 2 !== 0 ? '' : 'col-lg-offset-2 col-md-offset-2 col-sm-offset-2';
        const article = ' <div class="col-lg-4 col-md-4  col-sm-4 ' + classes +
            ' " >' +
            ' <div class="thumbnail">' +
            '<img class="img-thumbnail img-responsive" src="' + path_assets + articles[i]['featuredimage'] + '">' +
            '<div class="caption"> ' +
            ' <h3>' + articles[i]['title'] + '</h3> ' +
            ' <p></p> ' +
            ' <a class="text-uppercase text-success" href="article.html?article=' + articles[i]['id'] + '">' +
            '    <button class="btn btn-default btn-block" type="button">Read more</button>' +
            '</a>' +
            '  </div>' +

            '  </div>';
        $('#' + selector).append(article);

    }
}

function paginationLoad(next, prev, current_page, last, selector, page_limit) {
    var data = '';
    if (current_page > 1) {
        data += '<li><a aria-label="Previous" href="index.html?limit='+ page_limit +'&&page=1"><span aria-hidden="true">«</span></a></li>';
    }
    for (var i = 0; i < prev.length; i++) {
        data += '<li><a href="index.html?limit='+ page_limit +'&&page=' + prev[i] +'">' + prev[i] + '</a></li>';


    }
    data += '<li class="active"><a href="">' + current_page + '</a></li>';

    for (var i = 0; i < next.length; i++) {
        data += '<li><a href="index.html?limit='+ page_limit +'&&page=' + next[i] +'">' + next[i] + '</a></li>';
    }
    if(current_page != last){
       data += '<li><a aria-label="Next" href="index.html?limit='+ page_limit + '&&page='+ last +'"><span aria-hidden="true">»</span></a></li>';
    }
    $('#' + selector).html(data);


}
$(document).ready(function () {
    const path_assets = '..';

    const get_page = findGetParameter('page');
    const get_limit = findGetParameter('limit');
    const page_number = get_page !== null ? get_page : 1;
    const page_limit = get_limit !== null ? get_limit : 8;
    const url = 'http://localhost:8000/home?limit=' + page_limit + '&page=' + page_number;
    $.ajax({

        url: url,
        success: function (result) {
            if (result.success == 'true') {
                // page exist
                articlesLoad(result.data, 'articles_container', path_assets);

                console.log(result.next);
                paginationLoad(result.next, result.previous, page_number, result.last, 'pagination', page_limit)

            } else {
                // page don't exist

            }
        }
    });

});