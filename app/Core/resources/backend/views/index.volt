<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width,initial-scale=1,shrink-to-fit=no">
        <meta name="robots" content="noindex,nofollow,noarchive">
        <meta name="description" content="">
        <meta name="keyword" content="">
        {{ get_title() }}
        {{ assets.outputCss('css') }}
    </head>

    <body class="{{ bodyClass }}">
        {{ content() }}
        {{ assets.outputJs('js') }}
    </body>

</html>