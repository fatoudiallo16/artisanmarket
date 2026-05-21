<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Test Alpine</title>

    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>

<body>

    <div x-data="{ open: false }" style="padding: 40px;">

        <button
            @click="open = !open"
            style="
                background: orange;
                color: white;
                padding: 10px 20px;
                border: none;
                border-radius: 8px;
                cursor: pointer;
            "
        >
            Ouvrir le menu
        </button>

        <div
            x-show="open"
            style="
                margin-top: 20px;
                padding: 20px;
                background: #f3f3f3;
                border-radius: 10px;
            "
        >
            Bienvenue sur ArtisanMarket 🚀
        </div>

    </div>

</body>
</html>