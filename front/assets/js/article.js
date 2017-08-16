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
$(document).ready(function () {
    const path_assets = '..';

    const get_id = findGetParameter('article');

    if (get_id === null) {
        window.location = '/';
    }
    const url = 'http://localhost:8000/api/articles?id=' + get_id;
    $.ajax({

        url: url,
        success: function (result) {
            console.log(result);
            if (result.success == 'true') {


            } else {
                // page don't exist

                alert(result.error);

            }
        }
    });

});