<!-- This file defined the overall structure of the HTML document.
    It requires the head section from 'html_head.html.php'.
    The body section contains the main content based on the 'route' value from the global variables -->
<!DOCTYPE html>
<html>
  <?php require_view("layout/html_head") ?>
  <body>
    <?php require_view(g("route")) ?>
  </body>
</html>