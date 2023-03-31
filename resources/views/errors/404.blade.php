<html>
  <head>
    <title>{{ config('backpack.base.project_name') }} Error 404</title>

    <link href='//fonts.googleapis.com/css?family=Lato:100' rel='stylesheet' type='text/css'>

    <style>
      body {
        margin: 0;
        padding: 0;
        width: 100%;
        height: 100%;
        color: orange;
        display: table;
        font-weight: 100;
        font-family: 'Lato';
      }

      .container {
        text-align: center;
        display: table-cell;
        vertical-align: middle;
      }

      .content {
        text-align: center;
        display: inline-block;
      }

      .title {
        font-size: 156px;
      }

      .quote {
        font-size: 36px;
      }

      .explanation {
        font-size: 24px;
      }
    </style>
  </head>
  <body>
    <div class="container">
      <div class="content">
        <div class="title">
        <img width="300" height="300"  src="data:image/gif;base64,{{ base64_encode( file_get_contents( storage_path('/app/public/files/1/404-drib23.gif' ) ))}}">
        </div>
        <div class="quote"><b>Page not found.</b></div>
        <div class="explanation">
          <br>
          <small>
            <?php
              $default_error_message = "<b>Please return to <a href='".url('')."'>our homepage</a>.</b>";
            ?>
            {!! isset($exception)? ($exception->getMessage()?$exception->getMessage():$default_error_message): $default_error_message !!}
         </small>
       </div>
      </div>
    </div>
  </body>
</html>
