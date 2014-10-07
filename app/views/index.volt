<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="content-type" content="text/html;charset=UTF-8" />
        <meta name="viewport" content="width=device-width initial-scale=1.0 maximum-scale=1.0 user-scalable=yes" />

        {{ get_title() }}
            <!-- css-->
        <link href='http://fonts.googleapis.com/css?family=PT+Sans&subset=latin,cyrillic-ext' rel='stylesheet' type='text/css'>
        {{ stylesheet_link('css/bootstrap-combined.min.css') }}
        {{ stylesheet_link('css/style.css') }}
        {{ stylesheet_link('css/jquery.mmenu.all.css') }}
        {{ stylesheet_link('css/font-awesome.min.css') }}
        {{ stylesheet_link('css/easydropdown.css') }}
        {{ stylesheet_link('css/zoom.css') }}
        {{ stylesheet_link('css/datepicker.css') }}

        <!-- this page specific styles -->
        {{ assets.outputCss() }}
        <!--end  css-->
          <!--js-->
        {{ javascript_include("js/jquery-1.11.1.min.js")}}
        {{ javascript_include("js/bootstrap.js")}}
        {{ javascript_include("js/bootstrap-datepicker.min.js")}}
        {{ javascript_include("js/underscore-min.js")}}

        {{ javascript_include("js/jquery.slimscroll.min.js")}}




        {{ javascript_include("js/zoom.js")}}
        {{ javascript_include("js/jquery.form.js")}}
        {{ javascript_include("js/typeahead.js")}}
        {{ javascript_include("js/jquery.MultiFile.js")}}
        {{ javascript_include("js/jquery.noty.packaged.min.js")}}
        {{ javascript_include("js/jquery.mmenu.min.all.js")}}
        {{ javascript_include("js/jquery.response.js")}}
        {{ javascript_include("js/jquery-scrolltofixed-min.js")}}
        {{ javascript_include("js/jquery.easydropdown.min.js")}}
        {{ javascript_include("js/filter.js")}}
        {{ javascript_include("js/option.js")}}
        {{ javascript_include("js/jquery.b2r.js")}}
        {{ javascript_include("js/pagination.js")}}


        {{  assets.outputJs()}}
        <!--end js-->



    </head>
    <body scroll="no">
    <div id="page" >
        {{ content() }}


        <script type="text/javascript">
            $(document).ready(function() {

            });
        </script>
    </body>
</html>