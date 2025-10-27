<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recherche de Biscuits</title>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
</head>
<body>
    <h2>Recherche de Biscuits</h2>
    <input type="text" id="biscuit" placeholder="Nom du biscuit">
    <script>
    $(function() {
        $('#biscuit').autocomplete({
            source: '{{route("biscuits.search")}',
            select: function(event, ui) {
                window.location.href = '/biscuits/' + ui.item.id;
            }


        }).autocomplete("instance")._renderItem = function(ul, item) {
            return $("<li>")
                .append("<div>" + item.nom_biscuit + " - " + item.nom_saveur + "</div>")
                .appendTo(ul);
        };
    });
    </script>
</body>
</html>