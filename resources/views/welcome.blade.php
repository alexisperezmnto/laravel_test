<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>CRUD Productos</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/@mdi/font@6.x/css/materialdesignicons.min.css" rel="stylesheet">

        <style>
            body {
                font-family: 'Nunito', sans-serif;
            }
            .background {
                background: #161D31
            }
            .routerLink {
                color: white;
                text-decoration: none;
                margin-right: 30px;
            }

            .router-link-exact-active, .activeLink {
                color: #1976D2;
            }

            .datatable {
                margin-top: 100px
            }

            .search {
                width: 100px
            }
        </style>
    </head>
    <body>
        <div id="app">
            <App />
        </div>

        <script src="{{ mix('/js/app.js') }}"></script>
    </body>
</html>
