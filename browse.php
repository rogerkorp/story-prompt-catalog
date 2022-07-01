<?php 

include_once 'connect.php';

function redirect_to($otherplace) {
    header("Location: {$otherplace}");
    exit;
  }

if (isset($_SESSION['user'])){
    //logged in
} else {
    //logged out
    redirect_to('login.php');
}

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Prompt Catalog</title>
        <link rel="stylesheet" href="stylesheet.css">
        <link rel="icon" sizes="any" type="image/svg+xml" href="pencil-logo.svg">
    </head>
    <body> 

        <?php

        $use_result = null;
        $search = null;
        $tag_search = null;

        if (isset($_GET['search'])){
            $search = trim( (string) $_GET['search']);
            if (isset($search[0])){
                $use_result = search_catalog_prompts($search);
            };
        };

        function search_catalog_prompts($search){
            global $db_connection;
            $query = "SELECT * FROM catalog_" . $_SESSION['user'] . " WHERE prompt LIKE '%" . $search . "%' ORDER BY id DESC";
            $result = mysqli_query($db_connection, $query);
            if ($result && $result-> num_rows > 0){
                $results = $result;
            } else {
                $results = null;
            }
            return $results;
            mysqli_free_result($result);
        };

        if (isset($_GET['tag-search'])){
            $tag_search = trim( (string) $_GET['tag-search']);
            if (isset($tag_search[0])){
                $use_result = search_catalog_tags($tag_search);
            };
        };

        function search_catalog_tags($tag_search){
            global $db_connection;
            $query = "SELECT * FROM catalog_" . $_SESSION['user'] . " WHERE tag LIKE '%" . $tag_search . "%' ORDER BY id DESC";
            $result = mysqli_query($db_connection, $query);
            if ($result && $result-> num_rows > 0){
                $results = $result;
            } else {
                $results = null;
            }
            return $results;
            mysqli_free_result($result);
        };

        include_once 'header.php';

        ?>

        <main>
            <h2>Browse Catalog</h2>
            <div id="browse-inputs">
                <form class="search-form" action="" method="get">
                    <div class="search-input" id=tag-search-input>
                            <div class="search-icon"><span id="tag-search-icon">#</span></div>
                            <input name="tag-search" class="search-box" id="tag-search-box" placeholder="Filter by tag..." value="<?php echo $tag_search;?>">
                            <div class="search-submit-box">
                            <input type="submit" class="browse-search-submit" name="tag-search-submit" value="Go">
                            </div>
                        </div>
                </form>
                <form class="search-form" action="" method="get">
                    <div class="search-input">
                            <div class="search-icon"><span id="question-search-icon">?</span></div>
                            <input name="search" class="search-box" placeholder="Filter by prompt contents..." value="<?php echo $search;?>">
                            <div class="search-submit-box">
                            <input type="submit" class="browse-search-submit" name="search-submit" value="Go">
                            </div>
                        </div>
                </form>
            </div>
            <?php


            

                $num_query = "SELECT COUNT(id) from `catalog_" . $_SESSION['user'] . "`";
                $num_result = mysqli_query($db_connection, $num_query);
            

            if ($num_result){
                $count_array = mysqli_fetch_array($num_result);
                $count = $count_array[0];

                    echo "<p class='count'>There are currently " . $count . " prompts inside " . $_SESSION['user'] . "'s catalog.</p>";
            };

            if (!$num_result){
                echo 'There are currently no prompts inside your catalog.';
                };


            mysqli_free_result($num_result);

            ?>


            <table id="catalog-listings">


               
            <?php

            
            if($use_result) {
                echo ' <table id="catalog-listings">
                <tr class="header-row">
                    <th class="header-id">ID</th>
                    <th class="header-date">DATE</th>
                    <th class="header-tag">#</th>
                    <th>PROMPT</th>
                </tr>';

                while($row = mysqli_fetch_assoc($use_result)){
                    echo '<tr class="table-row">';
                    echo '<td class="table-id">' . $row['id'] . '</td>';
                    echo '<td class="table-date">' . $row['date'] . '</td>';
                    echo '<td class="table-tag"><div class="tag-fluff">' . $row['tag'] . '</div></td>';
                    echo '<td>' . $row['prompt'] . '</td>';
                    echo '</tr>';
                };
                
            } else if (!$use_result && $search || $tag_search != null) {
                echo '<p id="search-error">No results found.</p>';
            }
                
            else if(!$search) {

            $prompt_query = "SELECT * FROM `catalog_" . $_SESSION['user'].  "` ORDER BY id DESC";
            $prompt_result = mysqli_query($db_connection, $prompt_query);

            echo ' <table id="catalog-listings">
                <tr class="header-row">
                    <th class="header-id">ID</th>
                    <th class="header-date">DATE</th>
                    <th class="header-tag">#</th>
                    <th>PROMPT</th>
                </tr>';
            
            while($row = mysqli_fetch_assoc($prompt_result)){
                echo '<tr class="table-row">';
                echo '<td class="table-id">' . $row['id'] . '</td>';
                echo '<td class="table-date">' . $row['date'] . '</td>';
                echo '<td class="table-tag"><div class="tag-fluff">' . $row['tag'] . '</div></td>';
                echo '<td>' . $row['prompt'] . '</td>';
                echo '</tr>';
            };

            mysqli_free_result($prompt_result);

            };

            ?>
            </table>

        </main>

        <script src="script.js"></script>
       
        <?php include 'footer.php'; ?>

    </body>
</html>
<?php

?>