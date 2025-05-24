<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield("title", "TaskManager")</title>
    <link href="{{"assets/css/bootstrap.min.css"}}" rel="stylesheet" >
  </head>
  <body>
    <div>
        @yield("content")
    </div>
    <script src="{{asset("assets/js/bootstrap.min.js")}}"></script>
  </body>
</html>
