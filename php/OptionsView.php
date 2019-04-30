<html>
    <head>
        <link href="../css/temp.css" rel="stylesheet" type="text/css">
    </head>
    <body>
<?php
class optionsView {

    public function __construct() {

    }

    public static function displayOptionsV($data) {
        echo '<table id=pmtable class = "displaytables">';
        echo '<tr>'
            . '<th>Option Name</th>'
            . '<th>Option Type</th>'
            . '<th>Edit Option</th>'
            . '<th>Delete Option</th>'
            . '</tr>';

        for ($i = 0; $i < count($data); $i++) {
            echo '<tr>'
            . '<td>' . $data[$i]->optionsName . '</td>'
            . '<td>' . $data[$i]->optionsType . '</td>'
            . '<td> <form action = "OptionsController.php" method = "POST">'
            . '<button type = "submit" name = "editButton" value = "' . $data[$i]->optionsID . '">Edit</button> </td>'
            . '</form>'
            . '<td> <form action = "OptionsController.php" method = "POST">'
            . '<button class = "button" type = "submit" name = "deleteButton" value = "' . $data[$i]->optionsID . '">Delete</button>'
                . '</form>'
                . '</tr>';
        }
        echo '<tr> <td> <form method=POST> <button type=submit name= "addBtn" class="button"> Add New Option </button> </form> </td> </tr>'
            . '</table>';
    }
    public static function Undisplay() {
        echo '<script>
                    var myNode = document.getElementById("pmtable");
                   while (myNode.firstChild) {
                    myNode.removeChild(myNode.firstChild);
                }
                    </script>';
    }
    public static function addMethodV() {
        echo '<form action = "" method = "POST">
                        <label>Option Name</label>
                        <input type = "text" name = "optionName">
                        <label>Option Type</label>
                        <input type = "text" name = "optionType">
                        <input type = "submit" name = "addOptionSubmit" value = "Add Option">
                        </form>';
    }
    public static function editOptionV($data) {
        echo '<form action = "" method = "POST">
                  <label>Option Name</label>
                  <input type = "text" name = "optionName" value = "' . $data->optionsName . '">';
        echo '<label>Option Type</label>
                 <input type = "text" name = "optionType" value = "' . $data->optionsType . '">';
        echo ' <button type = "submit" name = "editBtnSubmit" value = ' . $data->optionsID . '> Update </button>
                  </form>';
    }
}
?>
    </body>
</html>

