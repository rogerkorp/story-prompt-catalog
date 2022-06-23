<?php 

include_once 'connect.php';

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Prompt Catalog</title>
        <link rel="stylesheet" href="stylesheet.css">
        <link rel="icon" sizes="any" type="image/svg+xml" href="pen-nib.svg">
    </head>
    <body> 

        <?php

        if (isset($_GET['search'])){
            $search = $_GET['search'];
            $use_result = search_catalog($search);
        } else {
            $search = null;
            $use_result = null;
        };

        function search_catalog($search){
            global $db_connection;
            $query = "SELECT * FROM catalog WHERE prompt LIKE '%" . $search . "%' ORDER BY id DESC";
            $result = mysqli_query($db_connection, $query);
            if ($result && $result-> num_rows > 0){
                $results = $result;
            } else {
                $results = null;
            }
            return $results;
        };

        ?>

        <main>
        <h1>prompt catalog</h1>
        <h2>by roger korpics</h2>
            <div id="entry-form">
                <form action="enter-prompt.php" method="post" id="prompt-form">
                    <textarea id="prompt" name="prompt" rows="3" maxlength="75" placeholder="Write a short summary of your idea..."></textarea>

                    <div id="tag-input">
                        <div id="tag-icon">#</div>
                        <input list="colors" name="color" id="tag-box"
                        pattern="white|beige|butter|peach|pink|coral|fuchsia|red|scarlet|orange|ocher|yellow|olive|chartreuse|green|avocado|mint|turquoise|lightblue|blue|violet|purple|brown|gray|black"
                        title="Must be a noted color"
                        placeholder="chroma tag"
                        >
                        <datalist id="colors">
                            <option value="white">
                            <option value="beige">
                            <option value="butter">
                            <option value="peach">
                            <option value="pink">
                            <option value="coral">
                            <option value="fuchsia">
                            <option value="red">
                            <option value="scarlet">
                            <option value="orange">
                            <option value="ocher">
                            <option value="yellow">
                            <option value="olive">
                            <option value="chartreuse">
                            <option value="green">
                            <option value="avocado">
                            <option value="mint">
                            <option value="turquoise">
                            <option value="lightblue">
                            <option value="blue">
                            <option value="violet">
                            <option value="purple">
                            <option value="brown">
                            <option value="gray">
                            <option value="black">
                        </datalist>

                    </div>
                    <div id="submit-box">
                        <input type="submit" id="submit" name="submit" value="submit">
                    </div>
                </form>
            </div>
            
            <form id="search-form" action="" method="get">
                <div id="search-input">
                        <div id="search-icon"><img id="search-svg" src="search-magnifying-glass.svg"></div>
                        <input name="search" id="search-box" placeholder="search" value="<?php echo $search;?>">
                        <div id="search-submit-box">
                        <input type="submit" id="search-submit" name="search-submit" value="search">
                        </div>
                    </div>
            </form>

            <table id="catalog-listings">
                <tr>
                    <th>ID</th>
                    <th>date</th>
                    <th>#</th>
                    <th>prompt</th>
                </tr>

            <?php
            
            if($use_result) {
                while($row = mysqli_fetch_assoc($use_result)){
                    echo '<tr>';
                    echo '<td class="table-id">' . $row['id'] . '</td>';
                    echo '<td class="table-date">' . $row['date'] . '</td>';
                    echo '<td class="table-color"><span class="catalog-color" style="background-color:var(--' . $row['color'] . ');">' . $row['color'] . '</span></td>';
                    echo '<td>' . $row['prompt'] . '</td>';
                    echo '</tr>';
                };
                
            } else if(!$search) {

            $prompt_query = "SELECT * FROM catalog ORDER BY id DESC";
            $prompt_result = mysqli_query($db_connection, $prompt_query);
            
            while($row = mysqli_fetch_assoc($prompt_result)){
                echo '<tr>';
                echo '<td class="table-id">' . $row['id'] . '</td>';
                echo '<td class="table-date">' . $row['date'] . '</td>';
                echo '<td class="table-color"><span class="catalog-color" style="background-color:var(--' . $row['color'] . ');">' . $row['color'] . '</span></td>';
                echo '<td>' . $row['prompt'] . '</td>';
                echo '</tr>';
            };

            };
            ?>
            </table>

        </main>

        <script src="script.js"></script>
        <footer>
            <p>created by <b>roger korpics</b>. june 2022.</p>
        </footer>
    </body>
</html>