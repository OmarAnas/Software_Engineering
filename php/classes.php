<?php
require_once "connection.php";

class User {

    public $id;
    public $firstName;
    public $lastName;
    public $email;
    public $password;
    public $dateOfBirth;
    public $telephone;
    public $ssn;
    public $addressId;
    public $userTypeId;
    public $isDeleted;

    public function userData($ID, $FIRSTNAME, $LASTNAME, $EMAIL, $PASSWORD, $DATEOFBIRTH, $TELEPHONE, $SSN, $ADDRESS, $USER) {
        $id          = $ID;
        $firstName   = $FIRSTNAME;
        $lastName    = $LASTNAME;
        $email       = $EMAIL;
        $password    = $PASSWORD;
        $dateOfBirth = $DATEOFBIRTH;
        $telephone   = $TELEPHONE;
        $ssn         = $SSN;
        $addressId   = $ADDRESS;
        $userTypeId  = $USER;
    }

    public function userQuery($id) {
        // $DB = new DbConnection();
        $DB = DbConnection::getInstance();

        $sql    = "SELECT * FROM user WHERE id='" . $id . "'";
        $result = mysqli_query($DB->getdbconnect(), $sql);

        // list($id, $firstName, $lastName, $email, $password, $dateOfBirth, $telephone, $ssn, $addressId, $userTypeId, $isDeleted) = mysqli_fetch_array($result);
        if ($row = mysqli_fetch_array($result)) {

            $this->id          = $row['id'];
            $this->firstName   = $row['firstName'];
            $this->lastName    = $row['lastName'];
            $this->email       = $row['email'];
            $this->password    = $row['password'];
            $this->dateOfBirth = $row['dateOfBirth'];
            $this->telephone   = $row['telephone'];
            $this->ssn         = $row['ssn'];
            $this->addressId   = $row['addressId'];
            $this->userTypeId  = $row['userTypeId'];
            $this->isDeleted   = $row['isDeleted'];

            return true;
        } else {
            echo "ERROR: Could not able to execute $sql. " . mysqli_error($DB->getdbconnect());
            return false;
        }
    }

    public function insertUser($tempUser) {
        // $DB = new DbConnection();
        $DB = DbConnection::getInstance();

        $date = date('Y-m-d H:i:s');

        $query      = "SELECT * FROM user WHERE email='$tempUser->email'";
        $result     = mysqli_query($DB->getdbconnect(), $query);
        $user_count = mysqli_num_rows($result);

        if ($user_count > 0) {
            return false;
        } else {

            $sql = "INSERT INTO `user` (`id`, `firstName`, `lastName`, `email`, `password`, `dateOfBirth`, `addressId`, `userTypeId`, `telephone`, `ssn`, `creationDate`)
            VALUES (NULL,'" . $tempUser->firstName . "','" . $tempUser->lastName . "','" . $tempUser->email . "','" . $tempUser->password . "',
            '" . $tempUser->dateOfBirth . "','" . $tempUser->addressId . "','" . $tempUser->userTypeId . "','" . $tempUser->telephone . "','" . $tempUser->ssn . "','" . $date . "')";

            if ($result = mysqli_query($DB->getdbconnect(), $sql)) {
                return true;
            } else {
                echo "ERROR: Could not able to execute $sql. " . mysqli_error($DB->getdbconnect());
                return false;
            }
        }
    }

    //print the user:

    public function printo() {

        // $DB = new DbConnection();

        // $sql = "SELECT * FROM user WHERE id='".$id."'";
        // $result = mysqli_query($DB->getdbconnect(), $sql);

        // list($id, $firstName, $lastName, $email, $password, $dateOfBirth, $telephone, $ssn, $addressId, $userTypeId, $isDeleted) = mysqli_fetch_array($result);

        echo "id: " . $this->id;
        echo "<br>";
        echo "First Name: " . $this->firstName;
        echo "<br>";
        echo "Last Name: " . $this->lastName;
        echo "<br>";
        echo "Email: " . $this->email;
        echo "<br>";
        echo "Password: " . $this->password;
        echo "<br>";
        echo "dateOfBirth: " . $this->dateOfBirth;
        echo "<br>";
        echo "Telephone: " . $this->telephone;
        echo "<br>";
        echo "SSN: " . $this->ssn;
        echo "<br>";

    }

    public function updateUser($tempUser) {
        // $DB = new DbConnection();
        $DB = DbConnection::getInstance();

        $sql = "UPDATE user SET firstName='$tempUser->firstName', lastName='$tempUser->lastName', email='$tempUser->email',
                        password='$tempUser->password', dateOfBirth='$tempUser->dateOfBirth', telephone='$tempUser->telephone',
                        ssn='$tempUser->ssn', addressId='$tempUser->addressId', userTypeId='$tempUser->userTypeId' WHERE id=$tempUser->id";

        if ($result = mysqli_query($DB->getdbconnect(), $sql)) {
            return true;
        } else {
            echo "ERROR: Could not able to execute $sql. " . mysqli_error($DB->getdbconnect());
            return false;
        }
    }

    public function deleteUser($id) {
        // $DB = new DbConnection();
        $DB = DbConnection::getInstance();

        $sql = "UPDATE user SET isDeleted=1 WHERE id=$id";

        if ($result = mysqli_query($DB->getdbconnect(), $sql)) {
            return true;
        } else {
            echo "ERROR: Could not able to execute $sql. " . mysqli_error($DB->getdbconnect());
            return false;
        }
    }

    public function activateUser($id) {
        // $DB = new DbConnection();
        $DB = DbConnection::getInstance();

        $sql = "UPDATE user SET isDeleted=0 WHERE id=$id";

        if ($result = mysqli_query($DB->getdbconnect(), $sql)) {
            return true;
        } else {
            echo "ERROR: Could not able to execute $sql. " . mysqli_error($DB->getdbconnect());
            return false;
        }
    }

    public function editUserType($id, $newUserType) {
        // $DB = new DbConnection();
        $DB = DbConnection::getInstance();

        $sql = "UPDATE user SET userTypeId=$newUserType WHERE id=$id";

        if ($result = mysqli_query($DB->getdbconnect(), $sql)) {
            return true;
        } else {
            echo "ERROR: Could not able to execute $sql. " . mysqli_error($DB->getdbconnect());
            return false;
        }
    }

    public function logIn($email, $pass) {
        // $DB = new DbConnection();
        $DB = DbConnection::getInstance();

        $sql    = "SELECT * FROM user WHERE email='" . $email . "'";
        $result = mysqli_query($DB->getdbconnect(), $sql);

        if (mysqli_num_rows($result) > 0) {
            $row           = mysqli_fetch_array($result);
            $password_hash = $row['password'];

            if (password_verify($pass, $password_hash) && $row['isDeleted'] == 0) {
                if (session_status() == PHP_SESSION_NONE) {
                    session_start();
                }

                $_SESSION['id']        = $row['id'];
                $_SESSION['email']     = $row['email'];
                $_SESSION['userType']  = $row['userTypeId'];
                $_SESSION['addressID'] = $row['addressId'];

                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function checkData($data) {
        // $DB = new DbConnection();
        $DB = DbConnection::getInstance();

        $data = strip_tags(mysqli_real_escape_string($DB->getdbconnect(), trim($data)));
        $data = stripslashes($data);
        $data = htmlspecialchars($data);

        return $data;
    }

    public function encrypt($password) {
        $password .= "!#$%&'()*+,-./:;<=>?@[\]^_`{|}~";
        $password = sha1($password);
        return $password;
    }

    public static function isSimilar($password, $enteredPassword) {
        $enteredPassword = sha1($enteredPassword . "!#$%&'()*+,-./:;<=>?@[\]^_`{|}~");
        if ($password == $enteredPassword) {
            return true;
        } else {
            return false;
        }
    }

    public function getPrivilege() {
        $DB     = DbConnection::getInstance();
        $sql    = "SELECT * FROM priviliges";
        $result = mysqli_query($DB->getdbconnect(), $sql);
        $array  = array();

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            array_push($array, $row);
        }

        //free the memory is important with large data !!
        mysqli_free_result($result);

        return $array;
    }

    public function getUserTypes() {
        $DB     = DbConnection::getInstance();
        $sql    = "SELECT * FROM usertype";
        $result = mysqli_query($DB->getdbconnect(), $sql);
        $array  = array();

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            array_push($array, $row);
        }

        //free the memory is important with large data !!
        mysqli_free_result($result);

        return $array;
    }

    public function addUserType($name) {
        $DB  = DbConnection::getInstance();
        $sql = "INSERT INTO `usertype` VALUES (NULL,'$name')";

        if ($result = mysqli_query($DB->getdbconnect(), $sql)) {
            return true;
        } else {
            echo "ERROR: Could not able to execute $sql. " . mysqli_error($DB->getdbconnect());
            return false;
        }
    }

    public function displayAllUsers() {
        // $DB = new DbConnection();
        $DB = DbConnection::getInstance();

        $sql          = "SELECT * FROM user";
        $result       = mysqli_query($DB->getdbconnect(), $sql);
        $addAccess    = false;
        $editAccess   = false;
        $deleteAccess = false;

        if (mysqli_num_rows($result) > 0) {
            $userPermission = mysqli_query($DB->getdbconnect(), "SELECT * From usertype_permission WHERE userTypeId='" . $_SESSION["userType"] . "'");
            while ($r2 = mysqli_fetch_array($userPermission)) {
                if ($r2['permissionId'] == 1) {
                    $addAccess = true;
                } else if ($r2['permissionId'] == 2) {
                    $editAccess = true;
                } else if ($r2['permissionId'] == 3) {
                    $deleteAccess = true;
                }
            }
            // echo"<form id='form' name='form' method='post' action=''>";
            // echo "<input type='submit' id='Activate_Account' name='Activate_Account' value='Activate Account'>";
            // echo "<input type='submit' id='Decline_Account' name='Decline_Account' value='Decline Account'>";
            echo "<table id='table' border='1' class='displaytables'>
                    <tr>";
            // <th>#</th>
            echo "<th>ID</th>
                    <th>Email</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Date of Birth</th>
                    <th>Telephone Number</th>
                    <th>SSN</th>
                    <th>Address</th>
                    <th>Type of User</th>";
            if ($editAccess) {
                echo "<th>Edit User Type</th>";
            }
            if ($deleteAccess) {
                echo "<th>Account Status</th>
                        <th>Action</th>";
            }
            echo "<th>Date & Time Joined</th>
                    </tr>";

            while ($row = mysqli_fetch_array($result)) {
                echo "<tr>";
                // echo "<td><input type='checkbox' name='checkbox[]' id='checkbox[]' value=".$row['id']."></td>";
                echo "<td>" . $row['id'] . "</td>";
                echo "<td>" . $row['email'] . "</td>";
                echo "<td>" . $row['firstName'] . "</td>";
                echo "<td>" . $row['lastName'] . "</td>";
                echo "<td>" . $row['dateOfBirth'] . "</td>";
                echo "<td>" . $row['telephone'] . "</td>";
                echo "<td>" . $row['ssn'] . "</td>";
                echo "<td>" . $row['addressId'] . "</td>";
                $userType = mysqli_query($DB->getdbconnect(), "SELECT * FROM usertype WHERE id='" . $row["userTypeId"] . "'");
                if ($r = mysqli_fetch_array($userType)) {
                    echo "<td>" . $r['userTypeName'] . "</td>";
                }

                if ($editAccess && $row['userTypeId'] == 1) {
                    echo "<td>No Actions</td>";
                } else if ($editAccess) {
                    echo '<form action="userController.php" method="POST">';

                    echo "<td><select name='userType'>";
                    echo "<option value=0>Choose</option>";

                    $sqlUserType = mysqli_query($DB->getdbconnect(), "SELECT * FROM usertype");
                    while ($rowUserType = mysqli_fetch_array($sqlUserType)) {
                        $valueId = $rowUserType['id'];
                        $value   = $rowUserType['userTypeName'];
                        echo '<option value="' . $valueId . '">' . $value . '</option>';
                    }
                    echo "</select><br>";

                    echo '<button type="submit" name="editUserButton" value="' . $row['id'] . '">Save</button>'
                        . '</form></td>';
                }

                if ($deleteAccess) {
                    if ($row['isDeleted'] == 0) {
                        echo "<td>Active</td>";
                        echo '<td> <form action="userController.php" method="POST">'
                            . '<button type="submit" name="deleteUserButton" value="' . $row['id'] . '">Delete User</button>'
                            . '</form></td>';
                    } else if ($row['isDeleted']) {
                        echo "<td>Deleted</td>";
                        echo '<td> <form action="activateUser.php" method="POST">'
                            . '<button type="submit" name="activateUserButton" value="' . $row['id'] . '">Activate User</button>'
                            . '</form></td>';
                    }
                }
                echo "<td>" . $row['creationDate'] . "</td>";
                echo "</tr>";
            }
            echo "</table>";
            // echo "</form>";
        }
        if ($addAccess) {
            echo '<a href= "registration.php" class="button">Add User</a><br><br>';
        }
    }
}

?>