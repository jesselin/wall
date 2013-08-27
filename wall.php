<?php
	require("connection.php");
	session_start();

  if(!isset($_SESSION['logged_in']))
  {
    header("Location: index.php");
  }

?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8" content="">
    <title>Wallify - Wall</title>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
    <script src="js/bootstrap-tab.js"></script>
    <link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.7.2/themes/ui-lightness/jquery-ui.css" type="text/css" media="all" />
    <link rel="stylesheet" type="text/css" href="css/bootstrap.css">
    <link href="css/style.css" type="text/css" rel="stylesheet">  
    <script type="text/javascript">
      $(document).ready(function(){


      });  //on document ready, do these jquery things
    </script>
  </head>
  <body>
    <div id="topdiv">
      <div class="wrapper">
      	<div id="logo">
        	<h1>Wallify</h1>
        </div>
        <div id="welcome_logout">
        	<h6>Welcome <?php echo $_SESSION['user']['first_name'] . " " . $_SESSION['user']['last_name'] ?>!</h6>
        	<div class="control-group">
            <!-- Button -->
            <div class="controls">
              <form method="POST" action="process.php">
                <input type="submit" value="Logout" class="btn btn-alert">
                <input type="hidden" name="action" value="logout" />
              </form>
            </div> 
          </div>
        </div> <!-- end welcome and logout -->
        <div class="clear"></div>
      </div> <!-- end top wrapper -->
    </div> <!-- end top div -->
 
    <!-- POST A NEW MESSAGE -->

    <div class="wrapper">
      <div class="col-12">
      	<h2>Post a message on the wall!</h2>
  	    <div class="span well">
  		    <form accept-charset="UTF-8" action="process.php" method="POST">
  		        <input type="hidden" name="action" value="post_message" />
              <textarea class="input-large" id="new_message" name="new_message"
  		        placeholder="Type in your message" rows="3"></textarea>
  		        <!-- <h6 class="pull-right">320 characters remaining</h6> -->
  		        <button class="btn btn-info" type="submit">Post New Message</button>
  		    </form>
        </div>
      </div> <!-- end 12 across -->
    </div> <!-- end wrapper for post new message -->


    <?php
      $queryallmessages = "SELECT * FROM messages LEFT JOIN users ON messages.user_id = users.user_id ORDER BY messages.created_at DESC;";
      $db_messages = fetch_all($queryallmessages);

      foreach($db_messages as $wall_message)
      {
        // var_dump($wall_message);
        echo '
        <div class="wrapper">
          <div class="posted_message">
            <div class="col-10">
              <div class="span well">
                <h4>Message posted by <b><i>' . $wall_message["first_name"] . ' ' . $wall_message["last_name"] . '</b></i> at ' . $wall_message["created_at"] . '</h4>
                <div class="posted_message">
                  <p>' . $wall_message["content"] . '</p>
                </div>
                ';
                if($wall_message["user_id"] == $_SESSION['user']['id'])
                  {
                    echo '
                      <form accept-charset="UTF-8" action="process.php" method="POST">
                        <input type="hidden" name="action" value="delete_message" />
                        <input type="hidden" name="delete_message_id" value="' . $wall_message["message_id"] . '" />
                        <button class="btn-mini btn-danger" type="submit">Delete Message</button>
                      </form>
                    ';
                  }
                echo '
              </div>
            </div>
          </div>
        </div>';

        $queryallcomments = "SELECT comments.*, users.first_name, users.last_name FROM comments LEFT JOIN users ON users.user_id = comments.user_id WHERE comments.message_id = {$wall_message['message_id']} ORDER BY comments.created_at ASC";
        $db_comments = fetch_all($queryallcomments);

        foreach($db_comments as $wall_comment)
        {
          echo '
          <div class="wrapper">
            <div class="posted_comment">
              <div class="col-offset-2 col-10">
                <div class="span well">
                  <h4>Comment posted by <b><i>' . $wall_comment["first_name"] . ' ' . $wall_comment["last_name"] . '</b></i> at ' . $wall_comment["created_at"] . '</h4>
                  <p>' . $wall_comment["content"] . '</p>
                </div>
              </div>
            <div class="clear"></div> 
          </div>';
        }

        echo '
        <div class="wrapper">
          <div class="comment_box">
            <div class="col-offset-2 col-10">
              <div class="span well">
                <form accept-charset="UTF-8" action="process.php" method="POST">
                    <input type="hidden" name="action" value="post_comment" />
                    <textarea class="input-large" id="new_comment" name="new_comment"
                    placeholder="Type in your comment" rows="2"></textarea>
                    <button class="btn btn-success" type="submit">Post Reply Comment</button>
                </form>
              </div>
            </div>
          </div>
          <div class="clear"></div> 
        </div>';
      }
    ?>
  </body>
</html>