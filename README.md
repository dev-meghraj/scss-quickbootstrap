scss-quickbootstrap
===================

This is simple and easy to use scss in any php project,
just to make sure that you have install ruby and sass on your local system,


To Install Sass
------------------

For Windows.

    go to http://rubyinstaller.org/ and install ruby on your system, then open cmd and type gem install sass, thats it.

For Linux and others

    please refer to http://sass-lang.com/



Usages
---------------
  ```php
    <?php
      require_one "scss/index.php";
    ?>
    <html>
      <head>
        <link rel="stylesheet" href="<?php letScssBoom('src/style.scss');?>"/>
      </head>
      <boty>

      </body>
    </html>
  ```
  Mostly used configuation in available in first two line of index.php
  whenever you make changes in your scss, scss will automatically compiled to css


Its Not Ultimate
----------------

it was made to quickly get started with scss in any project. and content some usefull libs, customize as you want

[![Bitdeli Badge](https://d2weczhvl823v0.cloudfront.net/dev-meghraj/scss-quickbootstrap/trend.png)](https://bitdeli.com/free "Bitdeli Badge")

