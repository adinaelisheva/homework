<html>
  <head>
    <meta name="viewport" content="width=device-width">
    <link href="styles.css" type="text/css" rel="stylesheet" />
    <script src="script.js" type="text/javascript"></script>
    <link href="https://fonts.googleapis.com/css2?family=Lora:wght@700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Raleway:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <script type="text/javascript" src="../shared/appswidget/appswidget.js"></script>
    <link href="../shared/appswidget/appswidget.css" rel="stylesheet">

    <title>Homework tracking</title>
  </head>
  
  <body>
    <div id="appsWidgetButton" title="Tracking apps shortcut"></div>
    <div class="content">
      <?php
        include("common.php"); 

        $res = mysqli_query($con, "SELECT DISTINCT subject from items ORDER BY subject asc;") or die(mysqli_error($con));
        if(!$res) {
          exit();
        }

        $date = time();
        $datestr = date("Y-m-d 00:00:00.000", $date);
        $nowdate = date("D n/j", $date);
      ?>
      <h2>Homework for <?=$nowdate?></h2>
      <?php

        while($row = mysqli_fetch_array($res)){
          $subject = $row['subject'];
          $query = "SELECT * FROM `items` WHERE (subject = '$subject') AND ((done IS NULL) OR (daily = 1 AND done < '$datestr')) ORDER BY due asc;";
          $res2 = mysqli_query($con, $query) or die(mysqli_error($con));
          if(!$res2) {
            exit();
          }
          ?>
          <div class="subject">
            <h3><?=$subject?></h3>
            <div class="itemslist">
            <?php
              while($row2 = mysqli_fetch_array($res2)){
                $name = $row2['name'];
                $due = $row2['due'];
                if ($row2['daily']) {
                  $duedate = time();
                } else {
                  $duedate = strtotime($due);
                }
                $duesoon = $duedate - time() < 2*60*60*24; // within 2 days
                $duenow = $duedate - time() <= 0; // due today or overdue
                $due = date("D n/j", $duedate);
                $id = $row2['id'];
              ?>
                <div class="item <?=$duenow ? 'now' : ($duesoon? 'soon' : '') ?>">
                  <div class="name"><?=$name?></div>
                  <div class="duedate" duedate="<?=$due?>" nowdate="<?=$nowdate?>"><?=$due?></div>
                  <button class="done" id="<?=$id?>">Done</button>
                  <div class="checkmark hidden" id="<?=$id?>">✓</div>
                </div>
                <?php
              }
              $query2 = "SELECT * FROM `items` WHERE (subject = '$subject') AND (done >= '$datestr') ORDER BY due asc;";
              $res2 = mysqli_query($con, $query2) or die(mysqli_error($con));
              if(!$res2) {
                exit();
              }
              while($row2 = mysqli_fetch_array($res2)){
                $name = $row2['name'];
                $donedate = strtotime($row2['done']);
                $done = date("D n/j", $donedate);
                $id = $row2['id'];
              ?>
                <div class="item done">
                  <div class="name"><?=$name?></div>
                  <div class="duedate" nowdate="<?=$nowdate?>"><?=$done?></div>
                  <button class="done hidden" id="<?=$id?>">Done</button>
                  <div class="checkmark" id="<?=$id?>">✓</div>
                </div>
                <?php
              }
            ?>
            </div>
          </div>
        <?php
        }
      ?>

      <form class="newitem">
        <h3>Add new item</h3>
        <div class="formrow">
          <div class="label">Name:</div> <input type="text" id="name">
        </div>
        <div class="formrow">
          <div class="label">Subject:</div> <input list="subjectnames" type="text" id="subject">
        </div>
        <datalist id="subjectnames"></datalist>
        <div class="formrow">
          <div class="label">Due:</div> <input type="date" id="duedate">
        </div>
        <div class="formrow">
          <div class="label">Daily:</div> <input type="checkbox" id="daily">
        </div>
      </form>
      <div class="hidden invalid">Not all fields filled out!</div>
      <div class="hidden valid">New item added</div>
      <button class="additem">Add new item</button>
    </div>
  </body>
</html>